<?php

namespace App\Http\Controllers;

use App\Models\ToolUnits;
use App\Models\UnitConditions;
use Illuminate\Http\Request;

class UnitConditionsC extends Controller
{
  public function store(Request $request)
  {
    $validated = $request->validate([
      'unit_code' => 'required|exists:tool_units,code',
      'conditions' => 'required|in:good,maintenance,broken',
      'return_id' => 'nullable|exists:returns,id',
      'notes' => 'nullable|string',
      'recorded_at' => 'required|date',
    ]);

    // simpan kondisi
    $condition = UnitConditions::create($validated);

    // mapping kondisi -> status unit
    $statusMap = [
      'good' => 'available',
      'maintenance' => 'maintenance',
      'broken' => 'broken',
    ];

    // update status unit
    ToolUnits::where('code', $validated['unit_code'])
      ->update([
        'status' => $statusMap[$validated['conditions']] ?? 'available'
      ]);

    return redirect()->back()->with('success', 'Kondisi unit berhasil dicatat!');
  }

  public function delete($id)
  {
    $condition = UnitConditions::findOrFail($id);
    $condition->delete();

    return redirect()->back()->with('success', 'Kondisi unit berhasil dihapus!');
  }
}
