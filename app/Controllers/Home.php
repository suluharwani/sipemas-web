<?php

namespace App\Controllers;
use App\Libraries\FirebaseClient;

class Home extends BaseController
{
    public function index()
    {

    }


  public function content()
    {
        // Tampilkan view untuk membuat konten
        return view('content');
    }

}