<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    // Menampilkan daftar akun siswa
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('siswa')) {
            // Siswa hanya bisa melihat data dirinya sendiri
            $siswa = Siswa::where('id_user', $user->id)->get();
        } else {
            // Admin dan Guru BK bisa melihat semua data siswa
            $siswa = Siswa::all();
        }
        
        return view('siswa.index', compact('siswa'));
    }

    // Menampilkan detail siswa
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = auth()->user();
        
        // Validasi akses: siswa hanya bisa melihat data dirinya sendiri
        if ($user->hasRole('siswa') && $siswa->id_user != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke data siswa ini.');
        }
        
        return view('siswa.show', compact('siswa'));
    }

    // Menampilkan form tambah akun siswa
    public function create()
    {
        return view('siswa.create');
    }

    // Menyimpan akun siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|max:255',
            'nama' => 'required|max:255',
            'email' => 'required|max:255',
            'kelas' => 'required|max:255',
            'jurusan' => 'required|max:255',
            'jenis_kelamin' => 'required|max:25',
            'no_tlp' => 'required|max:255',
            'alamat' => 'required|max:255',
        ]);

        $user = new User();
        $user->name = $request['nama'];
        $user->email = $request['email'];
        $user->password = Hash::make('password');
        $user->save();

        // dd($user);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_tlp' => $request->no_tlp,
            'alamat' => $request->alamat,
            'id_user' => $user->id,
        ]);

        $user->assignRole('siswa');

        $notification = [
            'message' => 'Data Siswa berhasil disimpan',
            'alert-type' => 'success'
        ];

        return redirect()->route('siswa.index')->with($notification);
    }

    public function edit(string $id)
    {
        $siswas = Siswa::findOrFail($id);
        return view('siswa.edit', $siswas);
    }

    public function update(Request $request, string $id)
    {
        // Validate the incoming request
        $validate = $request->validate([
            'nis' => 'required|max:255',
            'nama' => 'required|max:150',
            'kelas' => 'required|max:20',
            'jurusan' => 'required|max:20',
            'jenis_kelamin' => 'required|max:20',
            'no_tlp' => 'required|max:50',
            'alamat' => 'required|max:50',
            'email' => 'required|email|max:255',
        ]);

        // Find the Siswa record by ID
        $siswa = Siswa::findOrFail($id);

        // Check if the user exists
        $user = User::find($siswa->id_user);

        if (!$user) {
            return redirect()->route('siswa.index')->with('error', 'User terkait tidak ditemukan.');
        }

        // Update the user's information
        $user->name = $request['nama'];
        $user->email = $request['email'];
        // Only update password if needed, otherwise keep the existing one
        // $user->password = Hash::make('password');
        $user->save();

        // Update the Siswa information
        $siswa->update([
            'nis' => $validate['nis'],
            'nama' => $validate['nama'],
            'kelas' => $validate['kelas'],
            'jurusan' => $validate['jurusan'],
            'jenis_kelamin' => $validate['jenis_kelamin'],
            'no_tlp' => $validate['no_tlp'],
            'alamat' => $validate['alamat'],
        ]);

        $notification = [
            'message' => 'Data Siswa berhasil diperbaharui',
            'alert-type' => 'success'
        ];

        return redirect()->route('siswa.index')->with($notification);
    }
        public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        $notification = array(
            'message' => 'Data siswa berhasil dihapus',
            'alert-type' => 'success',
        );
        

        return redirect()->route('siswa.index')->with($notification);
    }
}
