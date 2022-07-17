<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'My Diary',
        ];
        return view('welcome_message', $data);
    }
}
