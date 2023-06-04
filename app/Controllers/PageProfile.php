<?php

namespace App\Controllers;
use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class PageProfile extends BaseController
{
    public function getData()
    {
        $firebase = new FirebaseClient();
        $data['admins'] = $firebase->getAdmins();
        $data['judul'] = 'Profile';
        $data['content'] = view('admin/content/profile');
        return $data;
    }
}
