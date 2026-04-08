<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetugasC extends Controller
{
  public function index()
  {
    return view('management-user.petugas');
  }
}
