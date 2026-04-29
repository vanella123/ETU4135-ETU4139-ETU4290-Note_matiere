<?php

namespace App\Controllers;

class LoginController extends BaseController
{
    public function index(): string
    {
        return view('login');
    }
}
