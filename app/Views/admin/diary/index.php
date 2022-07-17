

<?= $this->extend('layouts/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
     <div class="row">
        <div class="col-md-6">
           <!-- Pesan Success -->
           <?php if (session()->getFlashdata('success')) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?= session()->getFlashdata('success'); ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
           <?php endif ?>
        </div>
     </div>
     <div class="row">
        <div class="col-md-8">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Title</th>
                  <th scope="col">User</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                 <?php $no = 1; foreach($diaries as $d) : ?>
                  <tr>
                     <td><?= $no++; ?></td>
                     <td><?= $d['title'] ?></td>
                     <td><?= $d['username'] ?></td>
                     <td>
                        <a href="<?= base_url('admin/diary/edit/' . $d['id']) ?>" class="btn btn-primary" title="Update"><i class="fas fa-pen-square"></i></a>
                        <a href="<?= base_url('admin/diary/delete/' . $d['id']) ?>" class="btn btn-danger" title="Delete"  data-toggle="modal" data-target="#deleteUserAdminModal<?= $d['id'] ?>"><i class="fa fa-trash-alt"></i></a>
                     </td>
                  </tr>
                 <?php endforeach; ?>
              </tbody>
            </table>
        </div>
     </div>

 </div>

<?php foreach($diaries as $d) : ?>
<!-- Detele User By Admin Modal-->
    <div class="modal fade" id="deleteUserAdminModal<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are You Sure ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">You will delete the diaries <p class="badge badge-danger"><?= $d['username'] ?></p></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="<?= base_url('admin/diary/delete/' . $d['id']) ?>">Deleted !</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection(); ?>