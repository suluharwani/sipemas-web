<?php

namespace App\Controllers;
use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class PageKontak extends BaseController
{
    public function getData()
    {
        $firebase = new FirebaseClient();
        $data['admins'] = $firebase->getAdmins();
        $data['judul'] = 'Kontak';
        $data['content'] = view('admin/content/kontak');
        return $data;
    }
}
