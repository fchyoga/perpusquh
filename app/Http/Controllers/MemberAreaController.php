<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberAreaController extends Controller
{
    public function dashboard(Request $request)
    {
        $keyword = $request->keyword;
        $books = Book::orderBy('title', 'ASC')->paginate(8);

        if ($keyword) {
            $books = Book::where('title', 'LIKE', "%" . $keyword . "%")
                ->orWhere('author', 'LIKE', "%" . $keyword . "%")
                ->orWhere('publisher', 'LIKE', "%" . $keyword . "%")
                ->paginate(8);
        }

        return view('member.dashboard', compact('books'));
    }

    public function requestLoan($book_id)
    {
        // ... (this method can be kept as fallback or removed if fully replaced by modal, keeping for now)
    }

    public function storeLoan(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:loan_date',
        ]);

        $book = Book::find($request->book_id);

        if ($book->stock < 1) {
            return redirect()->back()->with('error', 'Stok buku habis');
        }

        // Create Loan with status 'requested'
        $loan = Loan::create([
            'user_id' => Auth::id(),
            'status' => 'Menunggu Persetujuan',
            'note' => 'Peminjaman via Website',
            'loan_date' => $request->loan_date,
            'return_date' => $request->return_date,
            'returned_date' => null,
            'penalty_price' => 0
        ]);

        LoanItem::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'book_title' => $book->title,
            'loan_id' => $loan->id,
            'quantity' => 1
        ]);

        // Decrease stock
        $book->update(['stock' => $book->stock - 1]);

        return redirect('/member/history')->with('success', 'Permintaan peminjaman berhasil dikirim');
    }

    public function history()
    {
        $loans = Loan::with('loan_items')->where('user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(10);
        return view('member.history', compact('loans'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('member.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

        if (isset($input['password']) && $input['password'] != "") {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $user->update($input);
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function readBook($book_id)
    {
        $book = Book::find($book_id);
        if (!$book->file_path) {
            return redirect()->back()->with('error', 'E-book tidak tersedia');
        }
        return view('member.read', compact('book'));
    }
}
