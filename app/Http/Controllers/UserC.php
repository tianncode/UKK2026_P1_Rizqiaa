<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserC extends Controller
{
  public function index()
  {
    $users = User::with('detail')->get();
    $singleTools = Tools::where('item_type', 'single')->get();
    return view('management-user.tabel', compact('users', 'singleTools'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'nik' => 'required|max:16|unique:user_details,nik',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6|same:confirm_password',
      'role' => 'required|in:admin,employee,user',
    ]);

    DB::beginTransaction();

    try {
      // ✅ simpan user
      $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role, // 🔥 ini penting
        'penalty_points' => $request->penalty_points ?? 0,
        'is_restricted' => $request->has('is_restricted'),
      ]);

      // ✅ simpan detail
      UserDetail::create([
        'user_id' => $user->id,
        'name' => $request->name,
        'nik' => $request->nik,
        'no_hp' => $request->no_hp,
        'address' => $request->address,
        'birth_date' => $request->birth_date,
      ]);

      DB::commit();

      return back()->with('success', 'User berhasil ditambahkan');
    } catch (\Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    $user = User::with('detail')->findOrFail($id);

    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email,' . $id,
      'password' => 'nullable|min:6|same:confirm_password',
      'role' => 'required|in:admin,employee,user',
      'no_hp' => 'nullable',
      'address' => 'nullable',
      'birth_date' => 'nullable|date',
    ]);

    DB::beginTransaction();

    try {
      // ✅ update users table
      $user->update([
        'email' => $request->email,
        'role' => $request->role,
        'penalty_points' => $request->penalty_points ?? 0,
        'is_restricted' => $request->has('is_restricted'),
      ]);

      // ✅ update password (kalau diisi)
      if ($request->filled('password')) {
        $user->update([
          'password' => Hash::make($request->password)
        ]);
      }

      // ✅ update detail
      $user->detail->update([
        'name' => $request->name,
        'no_hp' => $request->no_hp,
        'address' => $request->address,
        'birth_date' => $request->birth_date,
      ]);

      DB::commit();

      return back()->with('success', 'User berhasil diupdate');
    } catch (\Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }

  public function delete($id)
  {
    $user = User::findOrFail($id);

    DB::beginTransaction();

    try {
      $user->detail()->delete(); // hapus detail dulu
      $user->delete();           // baru hapus user

      DB::commit();

      return back()->with('success', 'User berhasil dihapus');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', $e->getMessage());
    }
  }
}
