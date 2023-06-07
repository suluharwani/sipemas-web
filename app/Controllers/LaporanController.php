<?php

namespace App\Controllers;

use App\Libraries\FirebaseClient;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
class LaporanController extends BaseController
{
    public function index()
    {
        // Melakukan operasi CRUD untuk mendapatkan data admin
        $firebase = new FirebaseClient();
        $laporan = $firebase->getAllLaporan();

        // Mengembalikan respons dengan kode HTTP 200 (OK) jika berhasil
        if ($laporan) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_OK);
            $response->setJSON([
                'status' => 'success',
                'message' => 'Semua Laporan retrieved successfully',
                'data' => $laporan,
            ]);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika tidak ada admin
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'No laporan found',
            ]);
        }

        return $response;
    }
    public function countchart(){
        // echo "string";
        $firebase = new FirebaseClient();
        $laporan = $firebase->countLaporanPerBulan(date("Y"));    
        if ($laporan) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_OK);
            $response->setJSON(array($laporan));
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika tidak ada admin
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'No laporan found',
            ]);
        }

        return $response;
    }
    public function countrating(){
        // echo "string";
        $firebase = new FirebaseClient();
        $laporan = $firebase->countLaporanByRating(date("Y"));    
        if ($laporan) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_OK);
            $response->setJSON(array($laporan));
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika tidak ada admin
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'No laporan found',
            ]);
        }

        return $response;
    }
    
    public function create()
    {
        // Mengambil data input dari form
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Membuat data admin
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ];

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
                'message' => 'Failed to create admin',
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
    public function getLaporanData()
{
    $firebase = new FirebaseClient();
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $searchValue = $_POST['search']['value'];
    return $firebase->getLaporanData($draw,$start,$length,$searchValue);
}
public function getLaporanDataDibaca()
{
    $firebase = new FirebaseClient();
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $searchValue = $_POST['search']['value'];
    return $firebase->getLaporanDataDibaca($draw,$start,$length,$searchValue);
}
public function getLaporanDataDibalas()
{
    $firebase = new FirebaseClient();
    $draw = $_POST['draw'];
    $start = $_POST['start'];
    $length = $_POST['length'];
    $searchValue = $_POST['search']['value'];
    return $firebase->getLaporanDataDibalas($draw,$start,$length,$searchValue);
}
public function getLaporanById(){
    $firebase = new FirebaseClient();
    $uid = $_POST['uid'];

    return json_encode($firebase->getLaporan($uid));

}
public function getBalasanLaporanById(){
        $firebase = new FirebaseClient();
    $uid = $_POST['uid'];

    return json_encode($firebase->getBalasanLaporan($uid));

}
public function KirimBalasan(){
    $firebase = new FirebaseClient();
    $uid = $_POST['uid'];

    $dataLap = $firebase->getLaporan($uid);
    $dataLaporan['iduser'] = $dataLap['iduser'];
    $dataLaporan['idlaporan'] =  $uid;
    $dataLaporan['jenis_kelamin'] = $dataLap['jenis_kelamin'];
    $dataLaporan['kategori'] = $dataLap['kategori'];
    $dataLaporan['nama'] = $dataLap['nama'];
    $dataLaporan['pengaduan'] = $dataLap['pengaduan'];
    $dataLaporan['rating'] = $dataLap['rating'];
    $dataLaporan['status'] = "2";
    $dataLaporan['subkategori'] = $dataLap['subkategori'];
    $dataLaporan['tanggal'] = round(microtime(true) * 1000);
    $dataLaporan['balasan'] = $_POST['balasan'];

    $KirimBalasan = $firebase->kirimBalasan($dataLaporan);
 if ($KirimBalasan) {
            $data = $dataLap;
            $data['status'] = "2";
            $firebase->updateLaporan($uid, $data);
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Laporan tidak ada',
            ]);
        }

        return $response;

}
public function TandaiDibaca(){
$firebase = new FirebaseClient();
    $uid = $_POST['uid'];
    $dataLap = $firebase->getLaporan($uid);

    // $KirimBalasan = $firebase->kirimBalasan($dataLaporan);
 if ($dataLap) {
            $data = $dataLap;
            $data['status'] = "1";
            $firebase->updateLaporan($uid, $data);
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Laporan tidak ada',
            ]);
        }

        return $response;
}
public function TandaiBelumDibaca(){
$firebase = new FirebaseClient();
    $uid = $_POST['uid'];
    $dataLap = $firebase->getLaporan($uid);

    // $KirimBalasan = $firebase->kirimBalasan($dataLaporan);
 if ($dataLap) {
            $data = $dataLap;
            $data['status'] = "0";
            $firebase->updateLaporan($uid, $data);
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Laporan tidak ada',
            ]);
        }

        return $response;
}
public function HapusBalasLaporan(){
    $firebase = new FirebaseClient();
    $uid = $_POST['uid'];

    $dataBalasan = $firebase->getBalasanLaporan($uid);
    $idlaporan = $dataBalasan['idlaporan'];
    $dataLap = $firebase->getLaporan($idlaporan);

    // $KirimBalasan = $firebase->kirimBalasan($dataLaporan);
 if ($dataBalasan) {
            $data = $dataLap;
            $data['status'] = "1";
            $firebase->updateLaporan($idlaporan, $data);
            $firebase->deleteBalasan($uid);
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } else {
            // Mengembalikan respons dengan kode HTTP 404 (Not Found) jika admin tidak ditemukan
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Laporan tidak ada',
            ]);
        }

        return $response;


}
public function downloadLaporan()
{   

    $startTimestamp = strtotime($_POST['startTimestamp'])*1000;
    $endTimestamp = strtotime($_POST['endTimestamp'])*1000;
    $firebase = new FirebaseClient();

    $laporanData = $firebase->downloadLaporan($startTimestamp,$endTimestamp);
    // var_dump($query);
    // die();
    // $laporanData = [];
    // foreach ($query as $document) {
    //     $laporanData[] = $document->data();
    // }

    // Membuat HTML laporan
    $html = '<h1>Laporan</h1>';
    $html .= '<table>';
    $html .= '<tr><th>Tanggal</th><th>Judul</th><th>Keterangan</th></tr>';
    foreach ($laporanData as $laporan) {
        $tanggal = date('d-m-Y', $laporan['tanggal']);
        $nama = $laporan['nama'];
        $pengaduan = $laporan['pengaduan'];
        $html .= "<tr><td>$tanggal</td><td>$nama</td><td>$pengaduan</td></tr>";
    }
    $html .= '</table>';

    // Menginisialisasi objek Dompdf
    $dompdfOptions = new Options();
    $dompdfOptions->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($dompdfOptions);

    // Memuat HTML ke Dompdf
    $dompdf->loadHtml($html);

    // Merender HTML menjadi PDF
    $dompdf->render();

    // Menghasilkan nama file unik untuk laporan PDF
    $fileName = 'laporan_' . date('YmdHis') . '.pdf';

    // Mengunduh laporan PDF
    $dompdf->stream($fileName, ['Attachment' => true]);
    // Mengirim laporan PDF sebagai respons
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="laporan.pdf"');
    // echo $pdf->Output('S'); // Mengembalikan laporan PDF sebagai string
    exit();
}
}
