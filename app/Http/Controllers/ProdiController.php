<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.master.prodi.index', compact('prodis'));
    }

    public function create()
    {
        return view('admin.master.prodi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required'
        ]);

        Prodi::create($request->all());
        return redirect()->route('admin.master.prodi.index')->with('success', 'Prodi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $prodi = Prodi::find($id);
        return view('admin.master.prodi.edit', compact('prodi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prodi' => 'required'
        ]);

        Prodi::find($id)->update($request->all());
        return redirect()->route('admin.master.prodi.index')->with('success', 'Prodi berhasil diperbarui');
    }

    public function destroy($id)
    {
        Prodi::find($id)->delete();
        return redirect()->route('admin.master.prodi.index')->with('success', 'Prodi berhasil dihapus');
    }
}
