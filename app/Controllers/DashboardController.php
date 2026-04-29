<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index(): string
    {
        helper('url');

        $html = file_get_contents(ROOTPATH . 'app/Views/dashboard.html');

        $replacements = [
            'href="style.css"' => 'href="' . base_url('css/style.css') . '"',
            'href="login.html"' => 'href="' . base_url('/') . '"',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $html);
    }
}