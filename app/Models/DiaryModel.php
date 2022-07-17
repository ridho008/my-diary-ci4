<?php

namespace App\Models;

use CodeIgniter\Model;

class DiaryModel extends Model
{
    protected $table            = 'diaries';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['title', 'user_id', 'description', 'created_at', 'updated_at'];

    public function getAllDiaryJoinUser()
    {
        $this->db->table('diaries');
        $this->select('title, diaries.id, username, diaries.user_id');
        $this->join('users', 'users.id = diaries.user_id');
        return $this->get();
    }

    public function getWhereDiaryJoinUser($id)
    {
        $this->db->table('diaries');
        $this->select('title, diaries.id, username, diaries.user_id, diaries.created_at, diaries.updated_at, diaries.description');
        $this->join('users', 'users.id = diaries.user_id');
        $this->where('diaries.user_id', $id);
        return $this->get();
    }

    public function getUserById($id)
    {
        $this->db->table('users');
        $this->select('*');
        $this->where('id', $id);
        $this->get()->getRowArray();
    }
}
