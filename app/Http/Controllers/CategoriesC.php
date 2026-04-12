<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CategoriesC extends Controller
{
  public function index()
  {
    $categories = Category::all();
    $singleTools = Tools::where('item_type', 'single')->get();
    return view('management-categories.tabel', compact('categories', 'singleTools'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string'
    ]);

    Category::create([
      'name' => $request->name,
      'description' => $request->description
    ]);

    return redirect()->route('categories.index')
      ->with('success', 'Kategori berhasil ditambahkan');
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required'
    ]);

    DB::table('categories')->where('id', $id)->update([
      'name' => $request->name,
      'description' => $request->description,
      'updated_at' => now()
    ]);

    return redirect()->route('categories.index')
      ->with('success', 'Kategori berhasil diupdate');
  }

  public function delete($id)
  {
    // cek data ada atau tidak
    $category = DB::table('categories')->where('id', $id)->first();

    if (!$category) {
      return redirect()->route('categories.index')
        ->with('error', 'Kategori tidak ditemukan');
    }

    // cegah hapus jika masih dipakai
    $used = DB::table('tools')->where('category_id', $id)->count();

    if ($used > 0) {
      return redirect()->route('categories.index')
        ->with('error', 'Kategori masih digunakan di data alat!');
    }

    // hapus
    DB::table('categories')->where('id', $id)->delete();

    return redirect()->route('categories.index')
      ->with('success', 'Kategori berhasil dihapus');
  }
}
