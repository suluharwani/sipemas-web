<?php

namespace App\Controllers;
// use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class PageDashboard extends BaseController
{
    public function getData()
    {
        // $firebase = new FirebaseClient();
        // $list['admins'] = $firebase->getAdmins();
        // $list['AllLaporan'] = $firebase->getAllLaporan();
        // $list['AllContent'] = $firebase->getAllContent();
        // $list['AllUser'] = $firebase->getAllUser();
        $list['judul'] = 'Dashboard';
        $data['content'] = view('admin/content/content',$list);
        return $data;
    }
}
