<?php

namespace App\Controllers;
use App\Controllers\PageDashboard;
use App\Controllers\Auth;
use App\Libraries\FirebaseClient;
class Admin extends BaseController
{
    protected $auth;
    public function __construct()
    {
        $this->auth = new Auth();
    
    }
    public function index()
    {
        $this->auth->checkAdmin();
        $page = new PageDashboard();
        return view('admin/index',$page->getData());
    }
    public function profile($segment = null){
        $this->auth->checkAdmin();
        $page = new PageProfile();
        return view('admin/index',$page->getData());
    }
    public function layanan($segment = null){
        $this->auth->checkAdmin();
        $page = new PageLayanan();
        return view('admin/index',$page->getData());
    }
    public function kontak($segment = null){
        $this->auth->checkAdmin();
        $page = new PageKontak();
        return view('admin/index',$page->getData());
    }
    public function evaluasi($segment = null){
        $this->auth->checkAdmin();
        $page = new PageEvaluasi();
        return view('admin/index',$page->getData());
    }

}
