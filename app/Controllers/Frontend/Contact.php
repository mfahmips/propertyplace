<?php

namespace App\Controllers\Frontend;
use App\Controllers\BaseController;

class Contact extends BaseController
{
    public function index()
    {
        return view('frontend/layouts/header')
            . view('frontend/contact')
            . view('frontend/layouts/footer');
    }
}