<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\FileModel;

class FileController extends Controller
{
    public function index() {

        $files = FileModel::all();

        Log::debug('Data file :', ['file' => $files]);

        return view('gambar.index', compact('files'));

    }

    public function create(){
        return view('gambar.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required',
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);
    
        Log::debug('Request file data:', ['file' => $request->file('file')]);

        $filePath = $request->file('file')->store('uploads', 'public');

        FileModel::create([
            'nama' => $request->nama,
            'file_path' => $filePath
        ]);

        Log::debug('File save:', ['nama' => $request->nama, 'file_path' => $filePath]);

        return redirect()->route('gambar.index')->with('succes', 'File berhasil diunggah');
    }

    public function destroy($id)
    {
        $file = FileModel::findOrFail($id);

        Log::debug('Deleting file:', ['file' => $file]);

        unlink(public_path('storage/' . $file->file_path));

        $file->delete();

        $files = FileModel::all();
        
        foreach ($files as $index => $file) {
            $file->id = $index + 1;
        }
        
        Log::debug('Remaining files:', ['files' => $files]);
        
        return redirect()->route('gambar.index')->with('success', 'File berhasil dihapus');
    }

    public function edit($id){

        $file = FileModel::findOrFail('$id');

        Log::debug('Edit data file:', ['file' => $file]);

        return view('gambar.edit', compact('file'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'nama' => 'required',
            'file' => 'nullable|file|mimes:jpg,png,pdf|max:2048'
        ]);
    
        $file = FileModel::findOrFail($id);

        Log::debug('Updating file :', ['file' => $file]);
        
        if ($request->hasFile('file')){
            if ($file->file_path){
                unlink(public_path('storage/' . $file->file_path));
            }

            $filePath = $request->file('file')->store('uploads', 'public');

            $file->file_path = $filePath;
            Log::debug('Update File Path:', ['file_path' => $filePath]);
        }

        $file->nama = $request->nama;
        $file->save();

        Log::debug('File Update', ['file' => $file]);

        return redirect()->route('gambar.index')->with('succes', 'File berhasil diperbarui');

    }
}
