<?php
namespace App\Models;

use CodeIgniter\Model;

class Mdladminfirebase extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'firstname', 'lastname', 'email', 'profilepicture'];

    public function getAll()
    {
        $firebase = \Config\Services::firebase();
        $collection = $firebase->collection('admin');
        $documents = $collection->documents();

        $allAdmin = [];
        foreach ($documents as $document) {
            $admin = $document->data();
            $admin['id'] = $document->id();
            $allAdmin[] = $admin;
        }

        return $allAdmin;
    }

    public function getAdmin($id)
    {
        $firebase = \Config\Services::firebase();
        $collection = $firebase->collection('admin');
        $document = $collection->document($id)->snapshot();

        if ($document->exists()) {
            $admin = $document->data();
            $admin['id'] = $document->id();
            return $admin;
        } else {
            return null;
        }
    }

    public function createAdmin($data)
    {
        $firebase = \Config\Services::firebase();
        $collection = $firebase->collection('admin');
        $document = $collection->newDocument();
        $document->set($data);

        return $document->id();
    }

    public function updateAdmin($id, $data)
    {
        $firebase = \Config\Services::firebase();
        $collection = $firebase->collection('admin');
        $document = $collection->document($id);
        $document->set($data);

        return $document->id();
    }

    public function deleteAdmin($id)
    {
        $firebase = \Config\Services::firebase();
        $collection = $firebase->collection('admin');
        $document = $collection->document($id);
        $document->delete();

        return $document->id();
    }
}
