<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanItem;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user', 'loan_items')->orderBy('updated_at', 'DESC')->paginate(8);

        foreach ($loans as $loan) {
            $currentTimestamp = time();
            $createdTimestamp = strtotime($loan['return_date']);
            $timeDifference = $createdTimestamp - $currentTimestamp;

            if ($loan['status'] == 'Sedang Dipinjam') {
                $days = floor($timeDifference / 86400);
                $timeDifference = $days . " hari ";
                if ($days < 0) {
                    $timeDifference = "Telat " . $days . " hari ";
                }

                $loan['selisih'] = $timeDifference;

                if ($loan['status'] == 'Telah Dikembalikan') {
                    $loan['selisih'] = '-';
                }

                if ($days < 0) {
                    $loan['denda'] = "Rp. " . number_format(abs($days) * count($loan['loan_items']) * $loan['penalty_per_day'], 0, ',', '.');
                }
            } else {
                $createdTimestamp = strtotime($loan['returned_date']);
                $timeDifference = $createdTimestamp - $currentTimestamp;
                $days = floor($timeDifference / 86400);
                $timeDifference = $days . " hari ";
                if ($days < 0) {
                    $timeDifference = "Telat " . $days . " hari ";
                }

                $loan['selisih'] = $timeDifference;

                if ($days < 0 && $loan['penalty_price']) {
                    $loan['denda'] = "Rp. " . $loan['penalty_price'];
                } else {
                    $loan['selisih'] = "";
                }
            }

            // if ($loan['selisih'] == '-') {
            //     $loan['denda'] = 'Rp. 0';
            // }
        }

        return view('admin.loans.list', compact('loans'));
    }

    public function destroy(Request $request)
    {
        $student_id = $request->student_id;

        User::find($student_id)->delete();
        return redirect('/dashboard/student-management');
    }

    public function create()
    {
        $students = User::where('role', 'member')->orderBy('name', 'ASC')->get();
        $books = Book::where('stock', '>', '0')->orderBy('title', 'ASC')->get();

        return view('admin.loans.create', compact('students', 'books'));
    }

    public function store(Request $request)
    {
        $loan = Loan::Create([
            'user_id' => $request->student_id, // Form still sends student_id probably, need to check view
            'status' => 'Sedang Dipinjam',
            'note' => $request->note,
            'return_date' => $request->return_date,
            'returned_date' => $request->return_date,
            'penalty_price' => "0",
            'penalty_per_day' => $request->penalty_per_day ?? 20000
        ]);

        for ($i = 0; $i < count($request->book_id); $i++) {
            $book = Book::where('id', '=', $request->book_id[$i])->first();
            $loan_items = LoanItem::Create([
                'user_id' => $request->student_id,
                'book_id' => $request->book_id[$i],
                'book_title' => $book->title,
                'loan_id' => $loan->id,
                'quantity' => '1'
            ]);


            Book::find($request->book_id[$i])->update([
                'stock' => $book->stock - 1
            ]);
        }

        return redirect('/dashboard/loan-management');
    }

    public function edit(Request $request)
    {
        $loan_id = $request->loan_id;
        $loans = Loan::with('user')->where('id', '=', $loan_id)->first();
        $loan_items = LoanItem::with('book')->where('loan_id', '=', $loan_id)->get();

        return view('admin.loans.edit', compact('loans', 'loan_items'));
    }

    public function update(Request $request)
    {
        $student_id = $request->student_id;
        $input = $request->all();

        User::find($student_id)->update($input);
        return redirect("/dashboard/student-management");
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $loans = Loan::with('user', 'loan_items')->paginate(8);
        $users = User::where('role', 'member')->orderBy('created_at', 'DESC')->where('name', 'LIKE', "%" . $keyword . "%")->get();
        $user_id = array();

        foreach ($users as $user) {
            array_push($user_id, $user->id);
        }

        if ($keyword) {
            $loans = Loan::whereIn('user_id', $user_id)->with('user', 'loan_items')->paginate(8);
            foreach ($loans as $loan) {
                $currentTimestamp = time();
                $createdTimestamp = strtotime($loan['return_date']);
                $timeDifference = $createdTimestamp - $currentTimestamp;

                $days = floor($timeDifference / 86400);
                $timeDifference = $days . " hari ";
                if ($days < 0) {
                    $timeDifference = "Telat " . $days . " hari ";
                }

                $loan['selisih'] = $timeDifference;

                if ($loan['status'] == 'Telah Dikembalikan') {
                    $loan['selisih'] = '-';
                }
            }
        }
        return view('admin.loans.list', compact('loans'));
    }

    public function accept($loan_id)
    {
        $loan = Loan::find($loan_id);
        $loan->update(['status' => 'Sedang Dipinjam']);
        return redirect()->back()->with('success', 'Peminjaman disetujui');
    }

    public function reject($loan_id)
    {
        $loan = Loan::find($loan_id);
        $loan_items = LoanItem::where('loan_id', $loan_id)->get();

        // Restore stock
        foreach ($loan_items as $item) {
            $book = Book::find($item->book_id);
            if ($book) {
                $book->update(['stock' => $book->stock + 1]);
            }
        }

        $loan->update(['status' => 'Ditolak']);
        return redirect()->back()->with('success', 'Peminjaman ditolak');
    }

    public function approve(Request $request)
    {
        $loan_id = $request->loan_id;
        $loans = Loan::where('id', '=', $loan_id)->get();
        $loan_items = LoanItem::where('loan_id', '=', $loan_id)->get();

        foreach ($loan_items as $loan_item) {
            $book = Book::where('id', '=', $loan_item->book_id)->first();

            Book::find($loan_item->book_id)->update([
                'stock' => $book->stock + 1
            ]);
        }

        $currentTimestamp = time();
        $createdTimestamp = strtotime($loans[0]['return_date']);
        $timeDifference = $createdTimestamp - $currentTimestamp;

        $days = floor($timeDifference / 86400);
        $denda = 0;

        if ($days < 0) {
            $denda = abs($days) * count($loan_items) * $loans[0]['penalty_per_day'];
        }

        $update = Loan::find($loan_id)->update([
            'status' => 'Telah Dikembalikan',
            'updated_at' => now(),
            'returned_date' => now(),
            'penalty_price' => $denda
        ]);

        // dd($update, $loans[0]['denda']);

        return redirect('/dashboard/loan-management');
    }

    public function download()
    {
        $data = Loan::with('user', 'loan_items')->orderBy('updated_at', 'DESC')->get();
        foreach ($data as $loan) {
            $currentTimestamp = time();
            $createdTimestamp = strtotime($loan['return_date']);
            $timeDifference = $createdTimestamp - $currentTimestamp;

            $days = floor($timeDifference / 86400);
            $timeDifference = $days . " hari ";
            if ($days < 0) {
                $timeDifference = "Telat " . $days . " hari ";
            }

            $loan['selisih'] = $timeDifference;

            if ($loan['status'] == 'Telah Dikembalikan') {
                $loan['selisih'] = '-';
            }
        }

        $list = array();
        for ($i = 0; $i < count($data); $i++) {
            $ids = [];

            foreach ($data[$i]['loan_items'] as $item) {
                $ids[] = $item['book_title'];
            }

            array_push($list, [
                'id' => $data[$i]['id'],
                'nama peminjam' => $data[$i]['user']['name'],
                'buku yang dipinjam' => implode(', ', $ids),
                'nim' => $data[$i]['user']['nim'],
                'status' => $data[$i]['status'],
                'jangka waktu' => $data[$i]['selisih'],
                'tanggal pengembalian' => $data[$i]['return_date']
            ]);
        }
        return (new FastExcel($list))->download('report.xlsx');

    }
}
