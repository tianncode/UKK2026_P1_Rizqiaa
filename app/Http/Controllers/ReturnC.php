<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Tools;
use App\Models\User;

class ReturnC extends Controller
{
  public function index()
  {
    $loans = Loans::with(['tool', 'user'])
      ->latest()
      ->first();

    // hanya tool single
    $singleTools = Tools::where('item_type', 'single')
      ->with('units')
      ->get();

    // data user
    $users = User::all();

    return view('management-return.create', compact(
      'loans',
      'singleTools',
      'users'
    ));
  }
}
