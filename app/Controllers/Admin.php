<?php

namespace App\Controllers;
use App\Controllers\PageDashboard;
use App\Libraries\FirebaseClient;
class Admin extends BaseController
{
    public function index()
    {
        $page = new PageDashboard();

        return view('admin/index',$page->getData());
    }
    public function profile($segment = null){
        $page = new PageProfile();
        return view('admin/index',$page->getData());
    }
    public function layanan($segment = null){
        $page = new PageLayanan();
        return view('admin/index',$page->getData());
    }
    public function kontak($segment = null){
        $page = new PageKontak();
        return view('admin/index',$page->getData());
    }
    public function evaluasi($segment = null){
        $page = new PageEvaluasi();
        return view('admin/index',$page->getData());
    }

}
