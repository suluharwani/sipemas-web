<?php

namespace App\Libraries;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Firestore\FirestoreClient;
use CodeIgniter\HTTP\ResponseInterface;
use Google\Cloud\Core\ServiceBuilder;
class FirebaseClient
{
    protected $firestore;
    protected $storage;

        public function __construct()
    {
        
        $config = [
            'keyFilePath' => APPPATH . 'Libraries/service-account.json',
        ];

        $serviceBuilder = new ServiceBuilder($config);
        $this->firestore = $serviceBuilder->firestore();
            // storage
        $serviceAccountPath = APPPATH . 'Libraries/service-account.json';

        $serviceAccount = ServiceAccount::fromValue($serviceAccountPath);

        $factory = (new Factory())
            ->withServiceAccount($serviceAccount);

        // $this->firestore = $factory->createFirestore();
        $this->storage = new StorageClient(['keyFilePath' => $serviceAccountPath]);
    }

    public function getFirestore()
    {
        return $this->firestore;
    }
    public function getStorage()
    {
        return $this->storage;
    }
    public function getAdmins()
    {
        $admins = [];
        $collection = $this->firestore->collection('admin');
        $documents = $collection->documents();
        
        foreach ($documents as $document) {
            $adminData = $document->data();
            $adminData['id'] = $document->id();
            $admins[] = $adminData;
        }
        
        return $admins;
    }
    
    public function getAdmin($email)
    {
        $adminRef = $this->firestore->collection('admin')->where('email', '=', $email)->limit(1);
        $snapshot = $adminRef->documents();
    
        if (!$snapshot->isEmpty()) {
            foreach ($snapshot as $document) {
                $adminData = $document->data();
                $adminData['id'] = $document->id();
    
                return $adminData;
            }
        }
    
        return null;
    }
     public function getAdminById($id)
    {
      // $adminRef = $this->firestore->collection('admin');
      //   $snapshot = $adminRef->documents($id);
        $document = $this->firestore->collection('admin')->document($id)->snapshot();
        $snapshot = $document->data();
        
        if ($snapshot) {
            return $snapshot;
        } else {
            return null;
        }
    
        return null;
    }
    public function getAdminDatatables($draw=null,$start=null,$length=null,$searchValue=null)
{
    

    $collection = $this->firestore->collection('admin');
    // $query = $collection->where('status', '=', 1);
    $documents = $collection->documents();

    $dataAdmin = [];

    foreach ($documents as $document) {
        $data = $document->data();
        $data['uid'] = $document->id(); // Menambahkan UID ke data Laporan
        $dataAdmin[] = $data;
    }

    // Filtering data berdasarkan search value
    $filteredData = [];
    if (!empty($searchValue)) {
        foreach ($dataAdmin as $data) {
            if (stripos($data['email'], $searchValue) !== false ||
                stripos($data['nama_depan'], $searchValue) !== false ||
                stripos($data['nama_belakang'], $searchValue) !== false) {
                $filteredData[] = $data;
            }
        }
    } else {
        $filteredData = $dataAdmin;
    }

    $totalRecords = count($filteredData);

    // Mengurutkan data berdasarkan UID secara ascending
    usort($filteredData, function ($a, $b) {
        return $a['uid'] <=> $b['uid'];
    });

    // Membatasi jumlah data yang ditampilkan sesuai dengan start dan length
    $pagedData = array_slice($filteredData, $start, $length);

    $response = [
        'draw' => intval($draw),
        'recordsTotal' => count($dataAdmin),
        'recordsFiltered' => $totalRecords,
        'data' => $pagedData,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
    public function createAdmin($data)
    {
        if ($this->getAdmin($data['email']) == null) {
        $newAdminRef = $this->firestore->collection('admin')->newDocument();
        $newAdminRef->set($data);
        
        return $newAdminRef->id();
        }else{
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            $response->setJSON([
                'status' => 'error',
                'message' => 'Gagal create admin, email sudah dipakai',
            ]);
        }
        
    }
    public function deleteAdmin($id)
    {
        return $this->firestore->collection('admin')->document($id)->delete();
    }
    public function updateAdmin($id, $data)
    {
        $this->firestore->collection('admin')->document($id)->set($data);
    }
    public function aktifkanAdmin($id){

    }


    // Laporan
    public function getAllLaporanOnly()
    {
        // $AllLaporan = [];
        $collection = $this->firestore->collection('Laporan');
        $documents = $collection->documents();



        return $documents;
    }

        public function getAllLaporan()
    {
        $AllLaporan = [];
            $documents = $this->getAllLaporanOnly();


        foreach ($documents as $document) {
            $laporanData = $document->data();
            $laporanData['id'] = $document->id();
            $AllLaporan[] = $laporanData;
        }

        return $AllLaporan;
    }
    
    
    public function getLaporan($id)
    {
        $document = $this->firestore->collection('Laporan')->document($id)->snapshot();
        $laporanData = $document->data();

        if ($laporanData) {
            $laporanData['id'] = $id;
            return $laporanData;
        } else {
            return null;
        }
    }
    public function getBalasanLaporan($id)
    {
      $adminRef = $this->firestore->collection('Balasan')->where('idlaporan', '=', $id)->limit(1);
        $snapshot = $adminRef->documents();
    
        if (!$snapshot->isEmpty()) {
            foreach ($snapshot as $document) {
                $adminData = $document->data();
                $adminData['id'] = $document->id();
    
                return $adminData;
            }
        }
    
        return null;
    }
    public function deleteBalasan($id){
        $this->firestore->collection('Balasan')->document($id)->delete();

    }
    public function countLaporanPerBulan($tahun)
{
    // $collection = $this->firestore->collection('Laporan');
    $documents = $this->getAllLaporanOnly();

    $dataPerBulan = [];

    // Looping untuk menghitung jumlah laporan per bulan
    foreach ($documents as $document) {
        $data = $document->data();

        // Mengambil nilai tanggal dan mengubahnya menjadi bulan
        $timestamp = $data['tanggal'] / 1000;
        $bulan = date('n', $timestamp);
        $tahunLaporan = date('Y', $timestamp);

        // Memeriksa apakah laporan berada pada tahun yang sesuai
        if ($tahunLaporan == $tahun) {
            // Jika bulan belum ada dalam array $dataPerBulan, inisialisasi dengan jumlah 0
            if (!isset($dataPerBulan[$bulan])) {
                $dataPerBulan[$bulan] = 0;
            }

            // Menambahkan 1 pada jumlah laporan per bulan
            $dataPerBulan[$bulan]++;
        }
    }

    // Menghasilkan array hasil per bulan
    $result = [];
    for ($i = 1; $i <= 12; $i++) {
        $jumlah = isset($dataPerBulan[$i]) ? $dataPerBulan[$i] : 0;
        $result[] = $jumlah;
    }

    return $result;
}
public function getLaporanData($draw=null,$start=null,$length=null,$searchValue=null)
{
    

    $collection = $this->firestore->collection('Laporan');
    $query = $collection->where('status', '=', '0');
    $documents = $query->documents();

    $dataLaporan = [];

    foreach ($documents as $document) {
        $data = $document->data();
        $data['uid'] = $document->id(); // Menambahkan UID ke data Laporan
        $dataLaporan[] = $data;
    }

    // Filtering data berdasarkan search value
    $filteredData = [];
    if (!empty($searchValue)) {
        foreach ($dataLaporan as $data) {
            if (stripos($data['nama'], $searchValue) !== false ||
                stripos($data['kategori'], $searchValue) !== false ||
                stripos($data['subkategori'], $searchValue) !== false) {
                $filteredData[] = $data;
            }
        }
    } else {
        $filteredData = $dataLaporan;
    }

    $totalRecords = count($filteredData);

    // Mengurutkan data berdasarkan UID secara ascending
    usort($filteredData, function ($a, $b) {
        return $a['uid'] <=> $b['uid'];
    });

    // Membatasi jumlah data yang ditampilkan sesuai dengan start dan length
    $pagedData = array_slice($filteredData, $start, $length);

    $response = [
        'draw' => intval($draw),
        'recordsTotal' => count($dataLaporan),
        'recordsFiltered' => $totalRecords,
        'data' => $pagedData,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
public function getLaporanDataDibalas($draw=null,$start=null,$length=null,$searchValue=null)
{
    

    $collection = $this->firestore->collection('Laporan');
    $query = $collection->where('status', '=', '2');
    $documents = $query->documents();

    $dataLaporan = [];

    foreach ($documents as $document) {
        $data = $document->data();
        $data['uid'] = $document->id(); // Menambahkan UID ke data Laporan
        $dataLaporan[] = $data;
    }

    // Filtering data berdasarkan search value
    $filteredData = [];
    if (!empty($searchValue)) {
        foreach ($dataLaporan as $data) {
            if (stripos($data['nama'], $searchValue) !== false ||
                stripos($data['kategori'], $searchValue) !== false ||
                stripos($data['subkategori'], $searchValue) !== false) {
                $filteredData[] = $data;
            }
        }
    } else {
        $filteredData = $dataLaporan;
    }

    $totalRecords = count($filteredData);

    // Mengurutkan data berdasarkan UID secara ascending
    usort($filteredData, function ($a, $b) {
        return $a['uid'] <=> $b['uid'];
    });

    // Membatasi jumlah data yang ditampilkan sesuai dengan start dan length
    $pagedData = array_slice($filteredData, $start, $length);

    $response = [
        'draw' => intval($draw),
        'recordsTotal' => count($dataLaporan),
        'recordsFiltered' => $totalRecords,
        'data' => $pagedData,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
public function getLaporanDataDibaca($draw=null,$start=null,$length=null,$searchValue=null)
{
    

    $collection = $this->firestore->collection('Laporan');
    $query = $collection->where('status', '=', '1');
    $documents = $query->documents();

    $dataLaporan = [];

    foreach ($documents as $document) {
        $data = $document->data();
        $data['uid'] = $document->id(); // Menambahkan UID ke data Laporan
        $dataLaporan[] = $data;
    }

    // Filtering data berdasarkan search value
    $filteredData = [];
    if (!empty($searchValue)) {
        foreach ($dataLaporan as $data) {
            if (stripos($data['nama'], $searchValue) !== false ||
                stripos($data['kategori'], $searchValue) !== false ||
                stripos($data['subkategori'], $searchValue) !== false) {
                $filteredData[] = $data;
            }
        }
    } else {
        $filteredData = $dataLaporan;
    }

    $totalRecords = count($filteredData);

    // Mengurutkan data berdasarkan UID secara ascending
    usort($filteredData, function ($a, $b) {
        return $a['uid'] <=> $b['uid'];
    });

    // Membatasi jumlah data yang ditampilkan sesuai dengan start dan length
    $pagedData = array_slice($filteredData, $start, $length);

    $response = [
        'draw' => intval($draw),
        'recordsTotal' => count($dataLaporan),
        'recordsFiltered' => $totalRecords,
        'data' => $pagedData,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
public function countLaporanByRating($tahun)
{
    // $collection = $this->firestore->collection('Laporan');
    $documents =     $documents = $this->getAllLaporanOnly();


    $dataRating = [];
    $ratingCategories = ['Sangat Tidak Berkualitas', 'Tidak Berkualitas', 'Cukup Berkualitas', 'Berkualitas', 'Sangat Berkualitas'];

    // Looping untuk menghitung jumlah laporan per rating
    foreach ($documents as $document) {
        $data = $document->data();

        // Mengambil nilai tanggal dan mengubahnya menjadi bulan
        $timestamp = $data['tanggal'] / 1000;
        $tahunLaporan = date('Y', $timestamp);

        // Memeriksa apakah laporan berada pada tahun yang sesuai
        if ($tahunLaporan == $tahun) {
            // Mengambil nilai rating dan memeriksa apakah termasuk dalam 5 kategori rating yang ditentukan
            $rating = $data['rating'];
            if (in_array($rating, $ratingCategories)) {
                // Jika rating belum ada dalam array $dataRating, inisialisasi dengan jumlah 0
                if (!isset($dataRating[$rating])) {
                    $dataRating[$rating] = 0;
                }

                // Menambahkan 1 pada jumlah rating
                $dataRating[$rating]++;
            }
        }
    }

    // Menghasilkan array hasil per rating
    $resultRating = [];
    foreach ($ratingCategories as $ratingCategory) {
        $jumlahRating = isset($dataRating[$ratingCategory]) ? $dataRating[$ratingCategory] : 0;
        $resultRating[] = $jumlahRating;
    }

    return $resultRating;
}
public function downloadLaporan($startTimestamp,$endTimestamp){
    $laporan = [];

    $collection = $this->firestore->collection('Laporan');
    $documents = $collection->where('tanggal', '>=', $startTimestamp)
                        ->where('tanggal', '<=', $endTimestamp)
                        ->documents();
    foreach ($documents as $document) {
            $contentData = $document->data();
            $contentData['id'] = $document->id();
            $laporan[] = $contentData;
        }

        return $laporan;
}
    public function createLaporan($data)
    {
        $newLaporanRef = $this->firestore->collection('Laporan')->newDocument();
        $newLaporanRef->set($data);

        return $newLaporanRef->id();
    }
   public function kirimBalasan($dataLaporan){
    $newBalasanRef = $this->firestore->collection('Balasan')->newDocument();
        $newBalasanRef->set($dataLaporan);

        return $newBalasanRef->id();
   }
    public function updateLaporan($id, $data)
    {
        $this->firestore->collection('Laporan')->document($id)->set($data);
    }

    public function deleteLaporan($id)
    {
        $this->firestore->collection('Laporan')->document($id)->delete();
    }
     
     public function getAllContent()
    {
        $contents = [];
        $collection = $this->firestore->collection('content');
        $documents = $collection->documents();

        foreach ($documents as $document) {
            $contentData = $document->data();
            $contentData['id'] = $document->id();
            $contents[] = $contentData;
        }

        return $contents;
    }

    public function getContent($id)
    {
        $document = $this->firestore->collection('content')->document($id)->snapshot();
        $contentData = $document->data();

        if ($contentData) {
            $contentData['id'] = $id;
            return $contentData;
        } else {
            return null;
        }
    }

    public function createContent($data)
    {
        $newContentRef = $this->firestore->collection('content')->newDocument();
        $newContentRef->set($data);

        return $newContentRef->id();
    }

    public function updateContent($id, $data)
    {
        $this->firestore->collection('content')->document($id)->set($data);
    }

    public function deleteContent($id)
    {
        $this->firestore->collection('content')->document($id)->delete();
    }
    public function getAllUser()
    {
        $users = [];
        $collection = $this->firestore->collection('users');
        $documents = $collection->documents();
        
        foreach ($documents as $document) {
            $contentData = $document->data();
            $contentData['id'] = $document->id();
            $users[] = $contentData;
        }
        
        return $users;
    }

    public function getUser($email)
    {
        $userRef = $this->firestore->collection('users')->where('email', '=', $email)->limit(1);
        $snapshot = $userRef->documents();
    
        if (!$snapshot->isEmpty()) {
            foreach ($snapshot as $document) {
                $userData = $document->data();
                $userData['id'] = $document->id();
    
                return $userData;
            }
        }
    
        return null;
    }

    public function createUser($data)
    {
        $newUserRef = $this->firestore->collection('users')->newDocument();
        $newUserRef->set($data);

        return $newUserRef->id();
    }

    public function updateUser($id, $data)
    {
        $this->firestore->collection('users')->document($id)->set($data);
    }

    public function deleteUser($id)
    {
        $this->firestore->collection('users')->document($id)->delete();
    }
}
