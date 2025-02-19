<?php

namespace App\Http\Controllers;

use App\Models\detail_sales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('module.user.index', compact('users'));
    }

    public function create()
    {
        return view('module.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required'
        ]);

        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email sudah digunakan.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
    
        return redirect()->route('user.list')->with('success', 'Berhasil Menambah User');
    }
    
    public function edit($id)
    {
        try {
            $item = User::findOrFail($id);
            return view('module.user.edit', compact('item'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.list')->with('error', 'User tidak ditemukan!');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
    
        $user = User::findOrFail($id);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
    
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
    
        $user->update($data);

        // dd($user);
        return redirect()->route('user.list')->with('success', 'User berhasil diperbarui!');
    }


    public function destroy(User $User, $id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('user.list')->with('success', 'Berhasil Hapus User');
    }
}
