<?php

namespace App\Controllers;
// use AllowDynamicProperties;
// use Bcrypt\Bcrypt;
class Auth extends BaseController
{
  protected $session;
    public function __construct()
  {

    $this->session = \Config\Services::session();
  }
    public function checkAdmin(){
        if (null !== $this->session->get('auth')) {

        }else{
            header('HTTP/1.1 403 Access denied');
            header('Content-Type: application/json; charset=UTF-8');
            
            header('Location: '.base_url('/login'));
        exit();
        }
    }


}
