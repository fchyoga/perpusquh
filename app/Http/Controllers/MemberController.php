<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'member')->orderBy('name', 'ASC')->paginate(8);

        return view('admin.students.list', compact('students'));
    }

    public function destroy(Request $request)
    {
        $student_id = $request->student_id;

        User::find($student_id)->delete();
        return redirect('/dashboard/student-management');
    }

    public function create()
    {
        $prodis = \App\Models\Prodi::all();
        $jurusans = \App\Models\Jurusan::all();
        $semesters = \App\Models\Semester::all();
        return view('admin.students.create', compact('prodis', 'jurusans', 'semesters'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['role'] = 'member';

        // Handle Password
        if (isset($input['password']) && !empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = Hash::make($input['nim']); // Default password is NIM
        }

        $input['username'] = $input['nim']; // Default username is NIM

        // Handle Email
        if (!isset($input['email']) || empty($input['email'])) {
            $input['email'] = $input['nim'] . '@student.com'; // Generate dummy email
        }

        User::create($input);
        return redirect('/dashboard/student-management');
    }

    public function edit(Request $request)
    {
        $student_id = $request->student_id;
        $student = User::where('id', '=', $student_id)->first();
        $prodis = \App\Models\Prodi::all();
        $jurusans = \App\Models\Jurusan::all();
        $semesters = \App\Models\Semester::all();

        return view('admin.students.edit', compact('student', 'prodis', 'jurusans', 'semesters'));
    }

    public function update(Request $request)
    {
        $student_id = $request->student_id;
        $input = $request->all();

        if (isset($input['password']) && $input['password'] != "") {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        User::find($student_id)->update($input);
        return redirect("/dashboard/student-management");
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $students = User::where('role', 'member')->paginate(8);

        if ($keyword) {
            $students = User::where('role', 'member')
                ->where(function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%" . $keyword . "%")
                        ->orWhere('nim', 'LIKE', "%" . $keyword . "%");
                })->paginate(8);
        }

        return view('admin.students.list', compact('students'));
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        // dd($file->getClientOriginalName());
        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_siswa', $nama_file);

        $users = (new FastExcel)->import(public_path('/file_siswa/' . $nama_file), function ($line) {
            return User::create([
                'name' => $line['nama'],
                'nim' => $line['nim'],
                'prodi' => $line['prodi'],
                'jurusan' => $line['jurusan'],
                'semester' => $line['semester'],
                'role' => 'member',
                'username' => $line['nim'],
                'password' => Hash::make($line['nim']), // Default password
                'email' => $line['nim'] . '@student.com', // Dummy email if not provided
            ]);
        });

        return redirect("/dashboard/student-management");
    }
}
