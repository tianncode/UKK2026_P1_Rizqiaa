<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tools;
use App\Models\ToolUnits;

class UnitsC extends Controller
{
  public function store(Request $request)
  {
    // 🔍 Validasi
    $request->validate([
      'tool_id' => 'required|exists:tools,id',
      'status' => 'required|in:available,borrowed,maintenance,damaged',
      'notes' => 'nullable|string'
    ]);

    // 🔹 Ambil data tool
    $tool = Tools::findOrFail($request->tool_id);

    // 🔹 Prefix dari tool
    $prefix = $tool->code_slug;

    // 🔹 Cari unit terakhir
    $lastUnit = ToolUnits::where('tool_id', $tool->id)
      ->orderBy('code', 'desc')
      ->first();

    if ($lastUnit) {

      // ambil nomor terakhir
      $lastNumber = (int) substr($lastUnit->code, -3);

      $newNumber = $lastNumber + 1;
    } else {

      $newNumber = 1;
    }

    // 🔹 Format nomor 001
    $number = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    $code = $prefix . '-' . $number;

    // 🔹 Simpan unit
    ToolUnits::create([
      'tool_id' => $tool->id,
      'code' => $code,
      'status' => $request->status,
      'notes' => $request->notes,
    ]);

    return redirect()->back()->with('success', 'Unit berhasil ditambahkan');
  }
}
