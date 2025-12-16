<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.master.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('admin.master.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required'
        ]);

        Jurusan::create($request->all());
        return redirect()->route('admin.master.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::find($id);
        return view('admin.master.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required'
        ]);

        Jurusan::find($id)->update($request->all());
        return redirect()->route('admin.master.jurusan.index')->with('success', 'Jurusan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Jurusan::find($id)->delete();
        return redirect()->route('admin.master.jurusan.index')->with('success', 'Jurusan berhasil dihapus');
    }
}
