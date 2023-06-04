<?php

namespace App\Controllers;
use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class PageLayanan extends BaseController
{
    public function getData()
    {
        $firebase = new FirebaseClient();
        $data['admins'] = $firebase->getAdmins();
        $data['judul'] = 'Layanan';
        $data['content'] = view('admin/content/layanan');
        return $data;
    }
}
