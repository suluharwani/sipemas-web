<?php

namespace App\Controllers;
use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class PageDashboard extends BaseController
{
    public function getData()
    {
        $firebase = new FirebaseClient();
        $data['admins'] = $firebase->getAdmins();
        $data['judul'] = 'Dashboard';
        $data['content'] = view('admin/content/content');
        return $data;
    }
}
