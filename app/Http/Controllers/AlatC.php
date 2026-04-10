<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlatC extends Controller
{
  public function index()
  {
    return view('management-alat.tabel');
  }
}
