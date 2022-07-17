<?php

namespace App\Controllers;
use App\Models\DiaryModel;

class Diary extends BaseController
{
    protected $diaryModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();
        $this->diaryModel = new DiaryModel();
    }

    public function index()
    {
        $diaries = $this->diaryModel->getAllDiaryJoinUser()->getResultArray();
        // dd($diaries);
        $data = [
            'title' => 'Diary List',
            'diaries' => $diaries,
        ];
        return view('admin/diary/index', $data);
    }

    public function editDiary(int $id)
    {
        $builderUser = $this->db->table('users');
        $builderUser->select('username');
        $builderUser->where('id', $id);

        $userById = $builderUser->get()->getRowArray();
        $diary = $this->diaryModel->find($id);

        $data = [
            'title' => 'Edit Diary | ' . $userById['username'],
            'diary' => $diary,
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/diary/edit', $data);
    }

    public function updateDiary(int $id)
    {
        $builderUser = $this->db->table('users');
        $builderUser->select('username');
        $builderUser->where('id', $id);

        $userById = $builderUser->get()->getRowArray();

        if (! $this->validate(
        [
            'title' => 'required',
            'editor1'     => 'required',
        ]
        )) {
            return redirect()->to('/admin/diary/edit/' . $id)->withInput();
        }

        $this->diaryModel->save([
            'id' => $id,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('editor1'),
            'updated_at' => date('Y-m-d h:m:s'),
        ]);

        session()->setFlashdata('success', 'Succesfully updated diaries ' . $userById['username']);
        return redirect()->to('/admin/diary');
    }

    public function deleteDiary(int $id)
    {
        $builderUser = $this->db->table('users');
        $builderUser->select('username');
        $builderUser->where('id', $id);

        $userById = $builderUser->get()->getRowArray();

        $this->diaryModel->delete($id);
        session()->setFlashdata('success', 'User ' . $userById['username'] . ' Succesfully deleted data the diaries.');
        return redirect()->back();
    }

    // -------- User ------------
    public function diaryIndex()
    {
        $diary = $this->diaryModel->getWhereDiaryJoinUser(user()->id)->getResultArray();
        $data = [
            'title' => 'My Diary List',
            'diary' => $diary,
        ];
        return view('user/diary/index', $data);
    }

    public function editDiaryUser(int $id)
    {
        $diary = $this->diaryModel->find($id);

        $data = [
            'title' => 'Edit My Diary',
            'diary' => $diary,
            'validation' => \Config\Services::validation(),
        ];
        return view('user/diary/edit', $data);
    }

    public function updateDiaryUser(int $id)
    {
        if (! $this->validate(
        [
            'title' => 'required',
            'editor1'     => 'required',
        ]
        )) {
            return redirect()->to('/user/diary/edit/' . $id)->withInput();
        }

        $this->diaryModel->save([
            'id' => $id,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('editor1'),
            'updated_at' => date('Y-m-d h:m:s'),
        ]);

        session()->setFlashdata('success', 'Succesfully updated diaries');
        return redirect()->to('/user/diary');
    }

    public function verifyKey(int $id)
    {
        if (!$this->validate(
        [
            'key_diary' => 'required',
        ]
        )) {
            return redirect()->to('/user/edit')->withInput();
        }

        $user = $this->db->table('users')->select('*')->where('id', $id)->get()->getRowArray();
        // $userok = $this->diaryModel->find(user()->id);
        $key_diary = $user['key_diary'];
        // dd($key_diary);
        $key = $this->request->getPost('key_diary');
        if($key == $key_diary) {
            return redirect()->to('user/diary');
        } else {
            if($key_diary == null) {
                session()->setFlashdata('danger', 'You havent filled in the diary key');
                return redirect()->to('user/edit')->withInput();
            }
        }
    }

    public function createDiary()
    {
        $data = [
            'title' => 'Create My Diary',
            'validation' => \Config\Services::validation(),
        ];
        return view('user/diary/create', $data);
    }

    public function insertDiary()
    {
        $id = user()->id;
        if (! $this->validate(
        [
            'title' => 'required',
            'editor1'     => 'required',
        ]
        )) {
            return redirect()->to('/user/diary/create/' . $id)->withInput();
        }

        $this->diaryModel->save([
            'user_id' => $id,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('editor1'),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s'),
        ]);

        session()->setFlashdata('success', 'Succesfully created my diaries');
        return redirect()->to('/user/diary');
    }
}
