<?php

namespace App\Controllers;

use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
class ContentController extends BaseController
{
    public function index()
    {
        // Melakukan operasi CRUD untuk mendapatkan data admin
        $firebase = new FirebaseClient();
        $content = $firebase->getContent();

        // Mengembalikan respons dengan kode HTTP 200 (OK) jika berhasil
        if ($content) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_OK);
            $response->setJSON([
                'status' => 'success',
                'message' => 'Laporan retrieved successfully',
                'data' => $content,
            ]);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika tidak ada admin
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'No content found',
            ]);
        }

        return $response;
    }

    public function create()
    {
        // Mengambil data input dari form
        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        // Membuat data admin
        $data = [
            'title' => $title,
            'content' => $content,
        ];

        // Melakukan operasi CRUD untuk membuat admin
        $firebase = new FirebaseClient();
        $adminId = $firebase->createContent($data);

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
                'message' => 'Failed to create admin',
            ]);
        }

        return $response;
    }

    // Implementasi fungsi update dan delete tetap sama seperti sebelumnya

    

       public function update($id)
    {
        // Mengambil data input dari form
        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        // Membuat data admin yang akan diperbarui
        $data = [
            'title' => $title,
            'content' => $content,
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

}
