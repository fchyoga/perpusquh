<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.master.semester.index', compact('semesters'));
    }

    public function create()
    {
        return view('admin.master.semester.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_semester' => 'required'
        ]);

        Semester::create($request->all());
        return redirect()->route('admin.master.semester.index')->with('success', 'Semester berhasil ditambahkan');
    }

    public function edit($id)
    {
        $semester = Semester::find($id);
        return view('admin.master.semester.edit', compact('semester'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_semester' => 'required'
        ]);

        Semester::find($id)->update($request->all());
        return redirect()->route('admin.master.semester.index')->with('success', 'Semester berhasil diperbarui');
    }

    public function destroy($id)
    {
        Semester::find($id)->delete();
        return redirect()->route('admin.master.semester.index')->with('success', 'Semester berhasil dihapus');
    }
}
