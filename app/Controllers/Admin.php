<?php

namespace App\Controllers;

class Admin extends BaseController
{
    protected $db;
    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $builder = $this->db->table('users');
        $builder->select('users.id as user_id, username, email, name');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $builder->get();
        $data = [
            'title' => 'User List',
            'users' => $query->getResultArray(),
        ];

        return view('admin/index', $data);
    }

    public function details(int $id)
    {
        $builder = $this->db->table('users');
        $builder->select('users.id as user_id, username, email, name, fullname, user_image');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $builder->where('users.id', $id);
        $query = $builder->get();

        $queryRow = $query->getRowArray();

        $data = [
            'title' => 'Details | ' . $queryRow['username'],
            'users' => $queryRow,
        ];

        return view('admin/details', $data);
    }

    public function addView()
    {
        $data = [
            'title' => 'Add New User',
        ];
        return view('admin/create', $data);
    }

    public function deleteUser(int $id) {
        // mengambil tables yang saling berkaitan, sehingga di table auth_logins akan terhapus ketika data usernya dihapus juga.
        $builder = $this->db->table('auth_logins');
        $builderUser = $this->db->table('users');
        $builder->select('*');
        $builder->join('users', 'users.id = auth_logins.user_id');
        $builder->where('auth_logins.user_id', $id);
        $builder->get();

        // mengambil data user berdasarkan id
        $builderUser->select('username');
        $builderUser->where('id', $id);
        $userById = $builderUser->get()->getRowArray();

        if(!empty($builder)) {
            $builderUser->delete(['id' => $id]);
            $builder->delete(['user_id' => $id]);
        } else {
            $builderUser->delete(['id' => $id]);
        }

        session()->setFlashdata('success', 'User ' . $userById['username'] . ' Succesfully deleted data.');
        return redirect()->back();
    }

    public function editUser(int $id)
    {
        $builder = $this->db->table('users');
        $builder->select('fullname, email, user_image, username, id');
        $builder->where('id', $id);
        $query = $builder->get();

        $queryRow = $query->getRowArray();

        $data = [
            'title' => 'Edit User | ' . $queryRow['username'],
            'user' => $queryRow,
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/edit', $data);
    }

    public function updateUser(int $id)
    {
        // get email by id
        $builder = $this->db->table('users');
        $builder->select('email');
        $builder->where('id', $id);
        $query = $builder->get();
        $rowEmail = $query->getRowArray();

        // mengambil rows user_id by id
        $builder_auth_logins = $this->db->table('auth_logins');
        $builder_auth_logins->select('*');
        $builder_auth_logins->join('users', 'users.id = auth_logins.user_id');
        $builder_auth_logins->where('auth_logins.user_id', $id);
        $builder_auth_logins->get();

        // jika emailnya tidak di update, jangan ganti
        if($rowEmail['email'] == $this->request->getPost('email')) {
            $ruleEmail = 'required';
        } else {
            $ruleEmail = 'required|is_unique[users.email]|valid_email';
        }

        // validation form
        if (! $this->validate(
        [
            'email' => $ruleEmail,
            'password'     => 'required',
            'pass_confirm' => 'required|matches[password]',
        ]
        )) {
            return redirect()->to('/admin/edit/' . $id)->withInput();
        }

        $password = $this->request->getPost('password');
        $hash = \Myth\Auth\Password::hash($password);

        $dataTbUser = [
            'email' => $this->request->getPost('email'),
            'password_hash' => $hash,
            'updated_at' => date('Y-m-d h:m:s'),
        ];

        $dataTbAuthLogins = [
            'email' => $this->request->getPost('email'),
        ];

        // mengambil data user berdasarkan id
        $builder->select('username');
        $builder->where('id', $id);
        $userById = $builder->get()->getRowArray();

        if(!empty($builder_auth_logins)) {
            // setelah mendapatkan user_id, update
            $builder_auth_logins->set('auth_logins.email');
            $builder_auth_logins->where('user_id', $id);
            $builder_auth_logins->update($dataTbAuthLogins);
        }

        $builder->set('email', 'password_hash');
        $builder->where('id', $id);
        $builder->update($dataTbUser);

        session()->setFlashdata('success', 'User ' . $userById['username'] . ' Succesfully updated data');
        return redirect()->to('/admin');
    }
}
