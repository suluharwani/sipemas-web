<?php

namespace Config;

class Firebase
{
    public static function getConfig()
    {
        return [
            'credentialFilePath' => WRITEPATH . 'sipemas-7ef4b-firebase-adminsdk-tkvr0-beaa3f8891.json',
            'databaseUrl' => 'https://puskesmas-5d663-default-rtdb.asia-southeast1.firebasedatabase.app',
        ];
    }
}
