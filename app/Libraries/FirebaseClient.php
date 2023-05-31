<?php

namespace App\Libraries;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Core\ServiceBuilder;

class FirebaseClient
{
    protected $firestore;

    public function __construct()
    {
        $config = [
            'keyFilePath' => APPPATH . 'Libraries/service-account.json',
        ];

        $serviceBuilder = new ServiceBuilder($config);
        $this->firestore = $serviceBuilder->firestore();
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
}
