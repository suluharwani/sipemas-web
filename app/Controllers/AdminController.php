<?php

namespace App\Controllers;

use App\Libraries\FirebaseClient;

class AdminController extends BaseController
{
    public function index()
    {
        $firebaseClient = new FirebaseClient();
        $admins = $firebaseClient->getAdmins();

        // ...
        // ...
        // Gunakan data $admins yang diperoleh untuk ditampilkan atau digunakan sesuai kebutuhan Anda
        // ...
    }

    public function show($id = null)
    {
        $firebaseClient = new FirebaseClient();
        $admin = $firebaseClient->getAdmin($id);

        if ($admin) {
            // ...
            // Lakukan aksi jika admin dengan ID yang diberikan ditemukan
            // ...
        } else {
            // ...
            // Lakukan aksi jika admin dengan ID yang diberikan tidak ditemukan
            // ...
        }
    }

    public function create()
    {
        $firebaseClient = new FirebaseClient();

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'email' => $this->request->getPost('email'),
        ];

        $newAdminId = $firebaseClient->createAdmin($data);

        // ...
        // Lakukan aksi setelah membuat admin baru, seperti mengarahkan pengguna ke halaman tertentu
        // ...
    }

    public function update($id = null)
    {
        $firebaseClient = new FirebaseClient();

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'email' => $this->request->getPost('email'),
        ];

        $firebaseClient->updateAdmin($id, $data);

        // ...
        // Lakukan aksi setelah mengupdate admin, seperti mengarahkan pengguna ke halaman tertentu
        // ...
    }

    public function delete($id = null)
    {
        $firebaseClient = new FirebaseClient();

        $firebaseClient->deleteAdmin($id);

        // ...
        // Lakukan aksi setelah menghapus admin, seperti mengarahkan pengguna ke halaman tertentu
        // ...
    }
}
