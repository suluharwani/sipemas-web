<?php

namespace App\Controllers;

use App\Libraries\FirebaseClient;

class Admin extends BaseController
{
    public function index()
    {
        $firebase = new FirebaseClient();
        $admins = $firebase->getAdmins();

        return view('admin', ['admins' => $admins]);
    }
}
