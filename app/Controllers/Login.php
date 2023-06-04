<?php

namespace App\Controllers;

//untuk dynamic properties php 8.2 ke atas uncomment kode di bawah ini
// use AllowDynamicProperties;
use App\Libraries\FirebaseClient;
use App\Controllers\AdminController;

use Bcrypt\Bcrypt;

class Login extends BaseController
{
  protected $bcrypt;
  protected $userValidation;
  protected $changelog;
  protected $bcrypt_version;
  protected $session;
  protected $db;
  protected $uri;
  protected $form_validation;
  protected $adminController;
  public function __construct()
  {
    $this->adminController = new AdminController();
    $this->db = \Config\Database::connect();
    $this->session = session();
    $this->bcrypt = new Bcrypt();
    $this->bcrypt_version = '2a';
    $this->uri = service('uri');
    $this->form_validation = \Config\Services::validation();
    $this->userValidation = new \App\Controllers\LoginValidation();
    // $this->changelog = new \App\Controllers\Changelog();
    helper('form');
  }
  public function index()
  {
    // $userModel = new \App\Models\MdlUser();
    $firebase = new FirebaseClient();

    $admins = $firebase->getAdmins();
    
    $banyak_user = 0;
    $data['title'] = "Login";
    //login dengan input
    //Register
    if ($this->request->getPost("submit") == "submit") {

 
        // validation ok

        $this->form_validation->setRules(
          [
            'email' => [
              'label' => 'Email',
              'rules' => 'required|min_length[4]|max_length[39]'
            ],
            'nama_depan' => [
              'label' => 'Nama Depan',
              'rules' => 'required|min_length[4]|max_length[39]'
            ],
            'nama_belakang' => [
              'label' => 'Nama Belakang',
              'rules' => 'required|min_length[4]|max_length[39]'
            ],
            'password' => [
              'label' => 'Password',
              'rules' => 'required|min_length[4]|max_length[39]'
            ]
          ]
        );
        if ($this->form_validation->withRequest($this->request)->run()) {
          $newUserData =  array(
                                'email'=>$_POST['email'],
                                'nama_depan'=>$_POST['nama_depan'],
                                'nama_belakang'=>$_POST['nama_belakang'],
                                'level'=>1,
                                'status'=>1,
                                'password'=>$this->bcrypt->encrypt($_POST['password'] , $this->bcrypt_version)
                              );
          // $userModel->insert($newUserData);
          
      if ($this->adminController->create($newUserData)) {
        return Redirect()->to(base_url('login'));
      }
      
      } else {
        //  validation recaptcha not ok

        $this->session->setFlashdata('login_error',  array('recaptcha' => "Recaptcha not valid" ));

      }
    }
    //end register
    //login
    if ($this->request->getPost("submit") == "login") {
      
      $token_generate = $this->request->getPost("token_generate");
      if ($this->userValidation->recaptchaValidation($token_generate)->success) {
        // validation ok
        //password
        
        $this->form_validation->setRules(
          [
            'email' => [
              'label' => 'Email',
              'rules' => 'required|min_length[4]|max_length[39]'
            ],
            'password' => [
              'label' => 'Password',
              'rules' => 'required|min_length[4]|max_length[39]'
            ]
          ]
        );
        if ($this->form_validation->withRequest($this->request)->run()) {
          $email = $_POST['email'];
          $password = $_POST['password'];
          $user = $userModel->get_cipherpass($email);

          if ($user >0 && $user['status'] == 1) {
            if ($user['level'] >= 2) {
              $this->session->setFlashdata('login_error', array("not_admin"=>"Anda bukan Administrator, silakan hubungi Administrator untuk meminta halaman login"));
            }
            if ($user['password'] != NULL || $user['password'] != '' ) {


              if ($this->bcrypt->verify($password, $user['password'])) {

                $data_user = [
                  'id' => $user['id'],
                  'nama_depan'=> $user['nama_depan'],
                  'level'=> $user['level'],
                  'nama_belakang'=> $user['nama_belakang'],
                  'name'=> $user['nama_depan']." ".$user['nama_belakang'],
                  'email'=> $user['email'],
                  'picture'=> $user['profile_picture'],
                ];
    
                $userModel->where("email", $email);
                $profile = $userModel->get()->getResultArray();
                $this->session->set('profile', $profile);
                $this->session->set('logged', true);
                $this->session->set('auth', $data_user);

                return redirect()->to('/admin');
              }else{
                $this->session->setFlashdata('login_error',  array("failed"=>"Login Failed: Incorrect username or password"));
              }
            }else{
              $this->session->setFlashdata('login_error', array("failed"=>"Password tidak ada: Silakan login dengan google account"));
            }
          }else{
            $this->session->setFlashdata('login_error', array("notActive"=>"User tidak ada/tidakaktif, silakan hubungi Administrator"));
          }
        } else {
          //  validation not ok
          $this->session->setFlashdata('login_error', $this->form_validation->getErrors());
        }

      } else {
        //  validation recaptcha not ok

        $this->session->setFlashdata('login_error',  array('recaptcha' => "Recaptcha not valid, silakan login lagi!" ));

      }
    }
    //end login
 
    if (count($admins) === 0) {
      return view('register/index', $data);
    } else {
      return view('login/index', $data);

    }


  }

  function logout()
  {
    Session()->destroy();
    return Redirect()->to(base_url('admin'));
  }



}