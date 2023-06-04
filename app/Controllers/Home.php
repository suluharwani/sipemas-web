<?php

namespace App\Controllers;
use App\Libraries\FirebaseClient;

class Home extends BaseController
{
    public function index()
    {
        $firebase = new FirebaseClient();
        $admins = $firebase->getAdmins();
        $laporan = $firebase->getAllLaporan();
        // print_r($admins);
        return view('admin', ['admins' => $admins, 'laporan'=>$laporan]);
    }


  public function content()
    {
        // Tampilkan view untuk membuat konten
        return view('content');
    }

}