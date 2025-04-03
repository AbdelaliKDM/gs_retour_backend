<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiscError extends Controller
{
  public function index()
  {
    return view('template.pages-misc-error');
  }
}
