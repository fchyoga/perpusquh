<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\User;
use App\Models\Loan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalBooks = Book::count();
        $totalMembers = User::where('role', 'member')->count();
        $activeLoans = Loan::where('status', 'Sedang Dipinjam')->count();

        return view('admin.dashboard', compact('totalBooks', 'totalMembers', 'activeLoans'));
    }
}
