<?php

namespace App\Controllers;

use App\Models\UserUtamaModel;
use App\Controllers\Cipher;

class User extends BaseController
{
    protected $userModel;
    protected $db;
    public function __construct() {
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();
        $this->userUtamaModel = new UserUtamaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'My Profile'
        ];

        return view('user/index', $data);
    }

    // --------- Menu My Profile ----------

    public function editProfile()
    {
        $user = $this->userUtamaModel->getUserByRole(user()->id)->getRowArray();

        if(in_groups('user')) {
        $valiKeyDiary = $user['key_diary'];
        $key_diary = $user['key_diary'] ? $user['key_diary'] : '';
        $decrypt=base64_decode($key_diary);
        }

        if(in_groups('admin')) {
        $valiKeyDiary = $user['key_diary'];
        }
        $data = [
            'title' => 'Edit My Profile',
            'validation' => \Config\Services::validation(),
            'user' => $user,
            'valiKeyDiary' => $valiKeyDiary,
            'plain_text' => (in_groups('user') ? $decrypt : ''),
        ];
        
        return view('user/profile/index', $data);
    }

    public function updateMyProfile(int $id)
    {
        $rowByEmail = $this->userUtamaModel->getRowEmailById(user()->id)->getRowArray();
        // mengambil rows user_id by id
        $builder_auth_logins = $this->db->table('auth_logins');
        $builder_auth_logins->select('*');
        $builder_auth_logins->join('users', 'users.id = auth_logins.user_id');
        $builder_auth_logins->where('auth_logins.user_id', $id);
        $builder_auth_logins->get();

        // jika emailnya tidak di update, jangan ganti
        if($rowByEmail['email'] == $this->request->getPost('email')) {
            $ruleEmail = 'required';
        } else {
            $ruleEmail = 'required|is_unique[users.email]|valid_email';
        }

        // validation form
        if (! $this->validate(
        [
            'email' => $ruleEmail,
            'fullname' => 'required',
            'user_image_old' => 'required',
            'password'     => 'required',
            'pass_confirm' => 'required|matches[password]',
            'user_image' => 'max_size[user_image,2024]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]'
        ]
        )) {
            return redirect()->to('/user/edit')->withInput();
        }

        $dataTbAuthLogins = [
            'email' => $this->request->getPost('email'),
        ];

        if(!empty($builder_auth_logins)) {
            // setelah mendapatkan user_id, update
            $builder_auth_logins->set('auth_logins.email');
            $builder_auth_logins->where('user_id', $id);
            $builder_auth_logins->update($dataTbAuthLogins);
        }

        // ambil field name photo
        $user_image = $this->request->getFile('user_image');
        if($user_image->getError() == 4) {
            $image = $this->request->getPost('user_image_old');
        } else {
            $user = $this->userUtamaModel->find($id);

            if($user['user_image'] != 'default.svg') {
                unlink('img/' . $user['user_image']);
            }

            // generate namaSampul random
            $image = $user_image->getRandomName();
            $user_image->move('img', $image);
        }

        $password = $this->request->getPost('password');
        $hash = \Myth\Auth\Password::hash($password);

        // Insert ke DB users
        $this->userUtamaModel->save([
            'id' => $id,
            'email' => $this->request->getPost('email'),
            'fullname' => $this->request->getPost('fullname'),
            'password_hash' => $hash,
            'user_image' => $image,
            'updated_at' => date('Y-m-d h:m:s'),
        ]);

        session()->setFlashdata('success', 'Succesfully updated my profile');
        return redirect()->to('/user/edit');

    }

    public function generateKeyAES(int $id)
    {
        if (! $this->validate(
        [
            'key' => 'required',
        ]
        )) {
            return redirect()->to('/user/edit')->withInput();
        }

        $string = $this->request->getPost('key');
        // $diacak ="c2VtYnVueWlrYW4gYWt1IHlh";
         
        $encrypt=base64_encode($string);
        // $decrypt=base64_decode($diacak);
        // dd($encrypt);
         
        // echo "Kata Yang di Enkripsi : ".$string."<br>";
        // echo "Hasil Enkrispi : ".$encrypt."<br>";
        // echo "Hasil Dekripsi : ".$decrypt."<br>";

        $this->userUtamaModel->save([
            'id' => $id,
            'key_diary' => $encrypt,
            'updated_at' => date('Y-m-d h:m:s'),
        ]);

        session()->setFlashdata('success', 'Succesfully updated your key');
        return redirect()->to('/user/edit');
    }
}
