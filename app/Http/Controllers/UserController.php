<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua User. (READ - Index)
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('admin.master.user.index', compact('users'));
    }

    /**
     * Menyimpan User baru ke database. (CREATE - Store)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $messages = [
            'image.image' => 'Field image harus berupa file gambar.',
            'image.mimes' => 'Field image hanya boleh berupa file dengan format: jpeg, jpg, atau png.',
            'image.max' => 'Ukuran file pada field image tidak boleh lebih dari 1 MB.',
            'email.required' => 'Field email wajib diisi.',
            'email.email' => 'Field email harus berisi alamat email yang valid.',
            'email.max' => 'Field email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Field email sudah terdaftar. Silakan gunakan email lain.',
            'nama.required' => 'Field nama wajib diisi.',
            'alamat.required' => 'Field alamat wajib diisi.',
            'role_id.required' => 'Field role wajib diisi.',
        ];
        
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'nama' => 'required|string|max:255', 
            'alamat' => 'required|string|max:255',
            'role_id' => 'required|in:1,2', 
            'email' => 'required|email|max:255|unique:users'
        ], $messages);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profil-pic', 'public');
        } else {
            $imagePath = 'profil-pic/default.jpg';
        }

        $data = $request->only(['nama', 'alamat', 'email', 'role_id']);
        $data['image'] = $imagePath;
        $data['password'] = Hash::make('password');
        $data['is_active'] = 1; 
        
        User::create($data);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }
    
    /**
     * Menampilkan data User tertentu dalam format JSON. (READ - Show)
     */
    public function show(User $user)
    {
        return response()->json($user);
    }
    
    /**
     * Tampilkan form untuk mengedit User tertentu. (UPDATE - Form)
     */
    public function edit(User $user)
    {
        return view('admin.master.user.edit', compact('user')); 
    }

    /**
     * Perbarui User tertentu di database. (UPDATE - Update)
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $messages = [
            'image.image' => 'Field image harus berupa file gambar.',
            'image.mimes' => 'Field image hanya boleh berupa file dengan format: jpeg, jpg, atau png.',
            'image.max' => 'Ukuran file pada field image tidak boleh lebih dari 1 MB.',
            'nama.required' => 'Field nama wajib diisi.',
            'alamat.required' => 'Field alamat wajib diisi.',
            'role_id.required' => 'Field role wajib diisi.',
            'status.required' => 'Field status wajib diisi.',
        ];

        $rules = [
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'role_id' => 'required|in:1,2',
            'status' => 'required|in:0,1',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, 
        ];

        $request->validate($rules, $messages);

        $data = $request->only(['nama', 'alamat', 'email', 'role_id']);
        $data['is_active'] = $request->status;

        if ($request->hasFile('image')) {
            if ($user->image && $user->image !== 'profil-pic/default.jpg') {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('profil-pic', 'public');
            $data['image'] = $imagePath;
        } 
        
        $user->update($data);
        
        return redirect()->route('admin.master.user.index')->with('success', 'User berhasil diupdate!');
    }
    
    /**
     * Hapus User tertentu dari database. (DELETE - Destroy)
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // 1. Hapus file gambar terkait (jika ada dan bukan gambar default)
        if ($user->image && $user->image !== 'profil-pic/default.jpg') {
            Storage::disk('public')->delete($user->image);
        }

        // 2. Hapus data user dari database
        $user->delete(); 

        // 3. Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    /**
     * Reset password user ke nilai default (misalnya 'password').
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(User $user)
    {
        // Mengupdate kolom password dengan nilai default yang di-hash
        $user->update([
             'password' => Hash::make('password')
        ]);
        
        return redirect()->route('admin.master.user.index')->with('success', 'Password berhasil direset.');
    }
}