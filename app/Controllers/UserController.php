<?php

namespace App\Controllers;

use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class UserController extends BaseController
{
    public function index()
    {
        // Melakukan operasi CRUD untuk mendapatkan data admin
        $firebase = new FirebaseClient();

        $admins = $firebase->getAllUser();

        // Mengembalikan respons dengan kode HTTP 200 (OK) jika berhasil
        if ($admins) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_OK);
            $response->setJSON([
                'status' => 'success',
                'message' => 'Laporan retrieved successfully',
                'data' => $admins,
            ]);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika tidak ada admin
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'No admins found',
            ]);
        }

        return $response;
    }
    function getUser($email){
        $firebase = new FirebaseClient();
        return $firebase->getUser($email);
    }
    public function create($req = null)
    {
            $data = $req;
        // Melakukan operasi CRUD untuk membuat admin
        $firebase = new FirebaseClient();
        $userId = $firebase->createUser($data);
        
        // Mengembalikan respons dengan kode HTTP 201 (Created) jika berhasil
        if ($userId) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_CREATED);
            $response->setJSON([
                'status' => 'success',
                'message' => 'User created successfully',
                'admin_id' => $userId,
            ]);
        } else {
            // Mengembalikan respons dengan kode HTTP 500 (Internal Server Error) jika gagal
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Failed to create user',
            ]);
        }

        return $response;
    }

    // Implementasi fungsi update dan delete tetap sama seperti sebelumnya

    

       public function update($id)
    {
        // Mengambil data input dari form
        $firstName = $this->request->getPost('firstName');
        $lastName = $this->request->getPost('lastName');
        $email = $this->request->getPost('email');

        // Membuat data admin yang akan diperbarui
        $data = [
            'firstName' => $firstName,
            'email' => $email,
            'lastName' => $lastName,
        ];

        // Melakukan operasi CRUD untuk memperbarui admin
        $firebase = new FirebaseClient();
        $updated = $firebase->updateUser($id, $data);

        // Mengembalikan respons dengan kode HTTP 200 (OK) jika berhasil
        if ($updated) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_OK);
            $response->setJSON([
                'status' => 'success',
                'message' => 'User updated successfully',
            ]);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika User tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }

        return $response;
    }

    public function delete($id)
    {
        // Melakukan operasi CRUD untuk menghapus admin
        $firebase = new FirebaseClient();
        $deleted = $firebase->deleteUser($id);

        // Mengembalikan respons dengan kode HTTP 204 (No Content) jika berhasil
        if ($deleted) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }

        return $response;
    }


public function getUserDatatables()
{
    $firebase = new FirebaseClient();
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $searchValue = $_POST['search']['value'];
    return $firebase->getUserDatatables($draw,$start,$length,$searchValue);
}
public function deleteUser(){
    $firebase = new FirebaseClient();
    $uid = $_POST['uid'];

    $deleted = $firebase->deleteUser($uid);


 if ($deleted) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Gagal dihapus',
            ]);
        }

        return $response;


}
}
