<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\LoanItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $input = $request->input('email');
        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $input,
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user->role == 'admin') {
                return redirect()->intended('/dashboard/book-management')->withSuccess('Signed in');
            }
            return redirect()->intended('/member/dashboard')->withSuccess('Signed in');
        }

        return redirect("/")->with('error', 'Incorrect credentials');
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        // dd($check);

        return redirect("/login")->withSuccess('Success register');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'phone' => $data['phone']
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard/book-management');
            }
            return redirect('/member/dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }

    public function notFound()
    {
        return view('auth.404');
    }

    public function notFoundAdmin()
    {
        return view('admin.404');
    }

    public function welcome()
    {
        $books = Book::orderBy('title', 'ASC')->paginate(8);
        $mostLoanedBook = LoanItem::select('loans_items.book_id', 'books.title', 'books.cover_image', \DB::raw('COUNT(loans_items.loan_id) as loan_count'))
            ->join('books', 'loans_items.book_id', '=', 'books.id')
            ->groupBy('loans_items.book_id', 'books.title', 'books.cover_image')
            ->orderByDesc('loan_count')
            ->take(3)
            ->get();

        $newBooks = LoanItem::select('loans_items.book_id', 'books.title', 'books.cover_image', 'books.created_at', \DB::raw('COUNT(loans_items.loan_id) as loan_count'))
            ->join('books', 'loans_items.book_id', '=', 'books.id')
            ->groupBy('loans_items.book_id', 'books.title', 'books.cover_image', 'books.created_at')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('welcome', compact('books', 'mostLoanedBook', 'newBooks'));
    }

    public function getDetail(Request $request)
    {
        $title = $request->title;

        $books = Book::where('title', '=', $title)->get();

        return view('book-detail', compact('books'));
    }
}
