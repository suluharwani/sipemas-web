<?php

namespace App\Controllers;
use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class PageEvaluasi extends BaseController
{
    public function getData()
    {
        $firebase = new FirebaseClient();
        $data['admins'] = $firebase->getAdmins();
        $data['judul'] = 'Evaluasi';
        $data['content'] = view('admin/content/evaluasi');
        return $data;
    }
}
