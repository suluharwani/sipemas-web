<?php

namespace App\Controllers;

use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class AdminController extends BaseController
{
    public function index()
    {
        // Melakukan operasi CRUD untuk mendapatkan data admin
        $firebase = new FirebaseClient();
        
        $admins = $firebase->getAdmins();

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
    function getAdmin($email){
        $firebase = new FirebaseClient();
        return $firebase->getAdmin($email);
    }
    public function create($req = null)
    {
        if ($req ==null ) {
            $email = $this->request->getPost('email');
            $nama_depan = $this->request->getPost('nama_depan');
            $nama_belakang = $this->request->getPost('nama_belakang');
            $level = 1;
            $status = 1;
            $password = $this->request->getPost('password');
            // $password = $this->request->getPost('password');
            
            // Membuat data admin
            $data = [
                'email' => $email,
                'nama_depan'=>$nama_depan,
                'nama_belakang' => $nama_belakang,
                'level' => $level,
                'status' => $status,
                'password' => $password,
            ];
        }else{
            $data = $req;
        }
        
        
        // Melakukan operasi CRUD untuk membuat admin
        $firebase = new FirebaseClient();
        $adminId = $firebase->createAdmin($data);
        
        // Mengembalikan respons dengan kode HTTP 201 (Created) jika berhasil
        if ($adminId) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_CREATED);
            $response->setJSON([
                'status' => 'success',
                'message' => 'Admin created successfully',
                'admin_id' => $adminId,
            ]);
        } else {
            // Mengembalikan respons dengan kode HTTP 500 (Internal Server Error) jika gagal
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Gagal create admin, email sudah dipakai',
            ]);
        }

        return $response;
    }

    // Implementasi fungsi update dan delete tetap sama seperti sebelumnya

    

       public function update($id)
    {
        // Mengambil data input dari form
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Membuat data admin yang akan diperbarui
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ];

        // Melakukan operasi CRUD untuk memperbarui admin
        $firebase = new FirebaseClient();
        $updated = $firebase->updateAdmin($id, $data);

        // Mengembalikan respons dengan kode HTTP 200 (OK) jika berhasil
        if ($updated) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_OK);
            $response->setJSON([
                'status' => 'success',
                'message' => 'Admin updated successfully',
            ]);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Admin not found',
            ]);
        }

        return $response;
    }

    public function delete($id)
    {
        // Melakukan operasi CRUD untuk menghapus admin
        $firebase = new FirebaseClient();
        $deleted = $firebase->deleteAdmin($id);

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
                'message' => 'Admin not found',
            ]);
        }

        return $response;
    }
public function getAdminDatatables()
{
    $firebase = new FirebaseClient();
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $searchValue = $_POST['search']['value'];
    return $firebase->getAdminDatatables($draw,$start,$length,$searchValue);
}
public function deleteAdmin(){
    $firebase = new FirebaseClient();
    $uid = $_POST['uid'];

    $deleted = $firebase->deleteAdmin($uid);


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

public function nonaktifkanAdmin(){
    $firebase = new FirebaseClient();
    $uid = $_POST['uid'];

    $dataAdmin = $firebase->getAdminById($uid);

    // $KirimBalasan = $firebase->kirimBalasan($dataLaporan);
 if ($dataAdmin) {
            $data = $dataAdmin;
            $data['status'] = 0;
            $firebase->updateAdmin($uid, $data);
            // $firebase->deleteBalasan($uid);
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Gagal dinonaktifkan',
            ]);
        }

        return $response;
}
public function aktifkanAdmin(){
    $firebase = new FirebaseClient();
    $uid = $_POST['uid'];

    $dataAdmin = $firebase->getAdminById($uid);

    // $KirimBalasan = $firebase->kirimBalasan($dataLaporan);
 if ($dataAdmin) {
            $data = $dataAdmin;
            $data['status'] = 1;
            $firebase->updateAdmin($uid, $data);
            // $firebase->deleteBalasan($uid);
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Gagal diaktifkan',
            ]);
        }

        return $response;
}
}
