<?php

namespace App\Http\Controllers\Template;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordBasic extends Controller
{
  public function index()
  {
    return view('template.auth-forgot-password-basic');
  }
}
