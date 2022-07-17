<?php

namespace App\Models;

use CodeIgniter\Model;

class UserUtamaModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['email', 'fullname', 'password_hash', 'updated_at', 'user_image', 'key_diary'];

    public function getUserByRole($id)
    {
        $this->db->table('users');
        $this->select('users.id as user_id, username, email, name, fullname, user_image, key_diary');
        $this->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->where('users.id', $id);
        return $this->get();
    }

    public function getRowEmailById(int $id)
    {
        $this->db->table('users');
        $this->select('email');
        $this->where('id', $id);
        return $this->get();
    }

    // public function getAuthLoginsByUserId(int $id)
    // {
    //     $this->db->table('auth_logins as al');
    //     $this->select('*');
    //     $this->join('users as u', 'u.id = al.user_id');
    //     $this->where('al.user_id', $id);
    //     return $this->get();
    // }

    // public function updateAuthLoginsEmailByUserID($data)
    // {
    //     $this->db->table('auth_logins');
    //     $this->set('auth_logins.email');
    //     $this->where('user_id', $id);
    //     $this->update($data);
    // }
}
