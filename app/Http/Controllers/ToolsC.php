<?php

namespace App\Http\Controllers;

use App\Models\BundleTools;
use App\Models\Category;
use App\Models\Returns;
use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ToolsC extends Controller
{
  public function index()
  {
    $tools = Tools::with(['units.conditions', 'units.tool', 'category', 'bundleItems'])
      ->where('item_type', '!=', 'bundle_tools')
      ->get();
    $singleTools = Tools::where('item_type', 'single')->get(['id', 'name']);
    $categories = Category::all();
    $returns = Returns::all();

    return view('management-alat.tabel', compact('tools', 'singleTools', 'categories', 'returns'));
  }

  public function store(Request $request)
  {
    // Validasi utama
    $request->validate([
      'name'        => 'required|string|max:255',
      'category_id' => 'required|exists:categories,id',
      'item_type'   => 'required|in:single,bundle',
      'code_prefix' => 'required|string|max:20',
      'price'       => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Validasi bundle items hanya jika tipe bundle
    if ($request->item_type === 'bundle') {
      $request->validate([
        'bundle_items'          => 'required|array|min:1',
        'bundle_items.*.name'   => 'required|string|max:255',
        'bundle_items.*.qty'    => 'required|integer|min:1',
        'bundle_items.*.price' => 'nullable|numeric|min:0',
      ]);
    }

    // Upload Foto
    $photoPath = null;
    if ($request->hasFile('photo')) {
      $file     = $request->file('photo');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('assets/tools'), $filename);
      $photoPath = 'assets/tools/' . $filename;
    }

    // Simpan Tool utama
    // Jika tipe = bundle, item_type di tabel = 'bundle'
    $tool = Tools::create([
      'name'        => $request->name,
      'category_id' => $request->category_id,
      'item_type'   => $request->item_type, // 'single' atau 'bundle'
      'price'       => $request->price,
      'description' => $request->description,
      'code_slug'   => $request->item_type === 'bundle' ? 'BDL-' . strtoupper($request->code_prefix) : strtoupper($request->code_prefix),
      'photo_path'  => $photoPath,
    ]);

    // Simpan komponen bundle sebagai item_type = 'bundle_tools'
    // Setiap komponen disimpan sebagai record Tools tersendiri
    // dengan item_type = 'bundle_tools', lalu di-relasikan via BundleTools
    if ($request->item_type === 'bundle' && $request->bundle_items) {
      foreach ($request->bundle_items as $item) {
        if (empty($item['name'])) continue;

        // Buat tool komponen dengan item_type = 'bundle_tools'
        $component = Tools::create([
          'name'        => $item['name'],
          'category_id' => $request->category_id,
          'item_type'   => 'bundle_tools',
          'price' => $item['price'] ?? 0,
          'code_slug'   => strtoupper($request->code_prefix) . '[COMP]',
          'description' => null,
          'photo_path'  => null,
        ]);

        // Relasikan komponen ke bundle induk
        BundleTools::create([
          'bundle_id' => $tool->id,
          'tool_id'   => $component->id,
          'qty'       => $item['qty'] ?? 1,
        ]);
      }
    }

    return redirect()->back()->with('success', 'Alat berhasil ditambahkan');
  }

  public function update(Request $request, $id)
  {
    // Validasi utama
    $request->validate([
      'name'        => 'required|string|max:255',
      'category_id' => 'required|exists:categories,id',
      'item_type'   => 'required|in:single,bundle',
      'code_prefix' => 'required|string|max:20',
      'price'       => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Validasi bundle items hanya jika tipe bundle
    if ($request->item_type === 'bundle') {
      $request->validate([
        'bundle_items'        => 'required|array|min:1',
        'bundle_items.*.name' => 'required|string|max:255',
        'bundle_items.*.qty'  => 'required|integer|min:1',
        'bundle_items.*.price' => 'nullable|numeric|min:0',
      ]);
    }

    $tool = Tools::findOrFail($id);

    // Upload Foto baru (jika ada)
    $photoPath = $tool->photo_path; // default pakai foto lama
    if ($request->hasFile('photo')) {
      // Hapus foto lama jika ada
      if ($tool->photo_path && file_exists(public_path($tool->photo_path))) {
        unlink(public_path($tool->photo_path));
      }
      $file      = $request->file('photo');
      $filename  = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('assets/tools'), $filename);
      $photoPath = 'assets/tools/' . $filename;
    }

    // Update Tool utama
    $prefix = strtoupper($request->code_prefix);
    $prefix = str_replace(['BDL-', '[COMP]'], '', $prefix);

    $tool->update([
      'name'        => $request->name,
      'category_id' => $request->category_id,
      'item_type'   => $request->item_type,
      'price'       => $request->price,
      'description' => $request->description,
      'code_slug'   => $request->item_type === 'bundle'
        ? 'BDL-' . $prefix
        : $prefix,
      'photo_path'  => $photoPath,
    ]);

    // Sync Bundle Items
    if ($request->item_type === 'bundle' && $request->bundle_items) {

      // Kumpulkan ID bundle item yang dikirim dari form
      $submittedIds = collect($request->bundle_items)
        ->pluck('id')
        ->filter()
        ->values();

      // Hapus komponen yang tidak ada di form (dihapus user)
      $existingBundles = BundleTools::where('bundle_id', $tool->id)->get();

      foreach ($existingBundles as $existing) {
        if (!$submittedIds->contains($existing->id)) {
          // Hapus tool komponen & relasinya
          Tools::find($existing->tool_id)?->delete();
          $existing->delete();
        }
      }

      // Update atau buat komponen
      foreach ($request->bundle_items as $item) {
        if (empty($item['name'])) continue;

        if (!empty($item['id'])) {
          // Update komponen yang sudah ada
          $bundleRow = BundleTools::find($item['id']);

          if ($bundleRow) {
            // Update tool komponen
            Tools::where('id', $bundleRow->tool_id)->update([
              'name'  => $item['name'],
              'price' => $item['price'] ?? 0,
            ]);

            // Update qty di pivot
            $bundleRow->update([
              'qty' => $item['qty'] ?? 1,
            ]);
          }
        } else {
          // Buat komponen baru
          $component = Tools::create([
            'name'        => $item['name'],
            'category_id' => $request->category_id,
            'item_type'   => 'bundle_tools',
            'price'       => $item['price'] ?? 0,
            'code_slug'   => strtoupper($request->code_prefix) . '[COMP]',
            'description' => null,
            'photo_path'  => null,
          ]);

          BundleTools::create([
            'bundle_id' => $tool->id,
            'tool_id'   => $component->id,
            'qty'       => $item['qty'] ?? 1,
          ]);
        }
      }
    } elseif ($request->item_type === 'single') {
      // Jika diubah dari bundle ke single, hapus semua komponen
      $existingBundles = BundleTools::where('bundle_id', $tool->id)->get();
      foreach ($existingBundles as $existing) {
        Tools::find($existing->tool_id)?->delete();
        $existing->delete();
      }
    }

    return redirect()->back()->with('success', 'Alat berhasil diperbarui');
  }

  public function delete($id)
  {
    $tool = Tools::with('units')->findOrFail($id);

    // Cek apakah masih ada unit
    if ($tool->units()->count() > 0) {
      return redirect()->back()->with('error', 'Alat tidak bisa dihapus karena masih memiliki unit!');
    }

    // Jika tool adalah bundle
    if ($tool->item_type === 'bundle') {

      $bundleItems = BundleTools::where('bundle_id', $tool->id)->get();

      foreach ($bundleItems as $item) {
        // hapus tool komponen
        Tools::where('id', $item->tool_id)->delete();
      }

      // hapus relasi bundle
      BundleTools::where('bundle_id', $tool->id)->delete();
    }

    // hapus file foto jika ada
    if ($tool->photo_path && file_exists(public_path($tool->photo_path))) {
      unlink(public_path($tool->photo_path));
    }

    // hapus tool utama
    $tool->delete();

    return redirect()->back()->with('success', 'Alat berhasil dihapus');
  }

  public function detail($id)
  {
    $tool = Tools::with(['units.conditions', 'units.tool', 'category', 'bundleItems.tools'])
      ->findOrFail($id);
    $singleTools = Tools::where('item_type', 'single')->get(['id', 'name']);
    $categories = Category::all();
    $returns = Returns::all();

    // Pass $tool as a single object — no need to loop over it
    return view('management-alat.detail', compact('tool', 'singleTools', 'categories', 'returns'));
  }

  public function daftar()
  {
    $tools = Tools::with(['units.conditions', 'units.tool', 'category'])
      ->where('item_type', '!=', 'bundle_tools')
      ->paginate(15);
    $categories = Category::orderBy('name')->get();

    return view('management-alat.daftar', compact('tools', 'categories'));
  }

  public function checkAvailability(Request $request, Tools $tool)
  {
    $request->validate([
      'borrow_date' => 'required|date|after_or_equal:today',
      'return_date' => 'required|date|after:borrow_date',
    ]);

    $borrowDate = $request->borrow_date;
    $returnDate = $request->return_date;

    $takenUnitCodes = DB::table('loans')
      ->whereIn('status', ['pending', 'approved', 'borrowed'])
      ->where('loan_date', '<=', $returnDate)
      ->where('due_date',  '>=', $borrowDate)
      ->pluck('unit_code')
      ->toArray();

    // Ambil SEMUA unit, bukan hanya yang available
    $allUnits = $tool->units()->get();

    $units = $allUnits->map(fn($u) => [
      'id'        => $u->id,
      'code'      => $u->code,
      'condition' => $u->condition ?? 'Baik',
      // Status efektif: kalau unit available tapi sedang dipinjam di rentang ini → borrowed
      'status'    => ($u->status === 'available' && !in_array($u->code, $takenUnitCodes))
        ? 'available'
        : ($u->status === 'available' ? 'borrowed' : $u->status),
    ])->values();

    $availableCount = $units->where('status', 'available')->count();

    return response()->json([
      'available' => $availableCount > 0,
      'count'     => $availableCount,
      'units'     => $units,
    ]);
  }
}
