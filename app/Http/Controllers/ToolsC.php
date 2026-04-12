<?php

namespace App\Http\Controllers;

use App\Models\BundleTools;
use App\Models\Category;
use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ToolsC extends Controller
{
  public function index()
  {
    $tools = Tools::with(['units.conditions', 'units.tool', 'category'])->get();
    $singleTools = Tools::where('item_type', 'single')->get(['id', 'name']);
    $categories = Category::all();

    return view('management-alat.tabel', compact('tools', 'singleTools', 'categories'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'category_id' => 'required|exists:categories,id',
      'item_type' => 'required|in:single,bundle',
      'code_prefix' => 'required|string|max:20',
      'description' => 'nullable|string',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Validasi bundle items hanya jika tipe bundle
    if ($request->item_type === 'bundle') {
      $request->validate([
        'bundle_items' => 'required|array|min:1',
        'bundle_items.*.tool_id' => 'required|exists:tools,id',
        'bundle_items.*.qty' => 'required|integer|min:1',
      ]);
    }

    // Upload Foto
    $photoPath = null;
    if ($request->hasFile('photo')) {
      $file = $request->file('photo');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('assets/tools'), $filename);
      $photoPath = 'assets/tools/' . $filename;
    }

    // Simpan Tool
    $tool = Tools::create([
      'name' => $request->name,
      'category_id' => $request->category_id,
      'item_type' => $request->item_type,
      'description' => $request->description,
      'code_slug' => strtoupper($request->code_prefix),
      'photo_path' => $photoPath,
    ]);

    // Simpan Bundle Items jika tipe bundle
    if ($request->item_type === 'bundle' && $request->bundle_items) {
      foreach ($request->bundle_items as $item) {
        if (!empty($item['tool_id'])) {
          BundleTools::create([
            'bundle_id' => $tool->id,
            'tool_id' => $item['tool_id'],
            'qty' => $item['qty'] ?? 1,
          ]);
        }
      }
    }

    return redirect()->back()->with('success', 'Alat berhasil ditambahkan');
  }

  public function update(Request $request, $id)
  {
    $tool = Tools::findOrFail($id);

    //Validasi
    $request->validate([
      'name' => 'required|string|max:255',
      'category_id' => 'required|exists:categories,id',
      'item_type' => 'required|in:single,bundle',
      'description' => 'nullable|string',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $photoPath = $tool->photo_path; // default pakai foto lama

    // Jika upload foto baru
    if ($request->hasFile('photo')) {

      // hapus foto lama kalau ada
      if ($tool->photo_path && file_exists(public_path($tool->photo_path))) {
        unlink(public_path($tool->photo_path));
      }

      $file = $request->file('photo');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('assets/tools'), $filename);

      $photoPath = 'assets/tools/' . $filename;
    }

    // Update data
    $tool->update([
      'name' => $request->name,
      'category_id' => $request->category_id,
      'item_type' => $request->item_type,
      'description' => $request->description,
      'photo_path' => $photoPath,
    ]);

    return redirect()->back()->with('success', 'Alat berhasil diupdate');
  }

  public function delete($id)
  {
    $tool = Tools::with('units')->findOrFail($id);

    //Cek apakah masih ada unit
    if ($tool->units()->count() > 0) {
      return redirect()->back()->with('error', 'Alat tidak bisa dihapus karena masih memiliki unit!');
    }

    //hapus file foto jika ada
    if ($tool->photo_path && file_exists(public_path($tool->photo_path))) {
      unlink(public_path($tool->photo_path));
    }

    //hapus data
    $tool->delete();

    return redirect()->back()->with('success', 'Alat berhasil dihapus');
  }
}
