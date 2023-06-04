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

    public function getAdmin($id)
    {
        $document = $this->firestore->collection('admin')->document($id)->snapshot();
        $adminData = $document->data();

        if ($adminData) {
            $adminData['id'] = $id;
            return $adminData;
        } else {
            return null;
        }
    }

    public function createAdmin($data)
    {
        $newAdminRef = $this->firestore->collection('admin')->newDocument();
        $newAdminRef->set($data);

        return $newAdminRef->id();
    }

    public function updateAdmin($id, $data)
    {
        $this->firestore->collection('admin')->document($id)->set($data);
    }

    public function deleteAdmin($id)
    {
        $this->firestore->collection('admin')->document($id)->delete();
    }

    // Laporan
        public function getAllLaporan()
    {
        $AllLaporan = [];
        $collection = $this->firestore->collection('Laporan');
        $documents = $collection->documents();

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

    public function createLaporan($data)
    {
        $newLaporanRef = $this->firestore->collection('Laporan')->newDocument();
        $newLaporanRef->set($data);

        return $newLaporanRef->id();
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
}
