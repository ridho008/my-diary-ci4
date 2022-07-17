

<?= $this->extend('layouts/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
     <div class="row">
        <div class="col-md-12">
         <a href="<?= base_url('user/diary/create'); ?>" class="btn btn-primary mb-4"><i class="fas fa-plus-square"></i> Add Data</a>
         <div class="row">
         <?php foreach($diary as $d) : ?>
          <div class="col-md-4">
             <div class="card">
                <div class="card-body">
                  <h5 class="card-title"><?= $d['title'] ?></h5>
                  <p class="card-text text-muted">Published <?= date('Y-m-d', strtotime($d['created_at'])) ?></p>
                  <a href="#" data-toggle="modal" data-target="#detailDiaryModal<?= $d['id'] ?>" class="btn btn-primary">Details</a>
                </div>
              </div>
          </div>
          <?php endforeach; ?>
          </div>
        </div>
     </div>

 </div>

<!-- Modal My Diary User Button Detail -->
<?php foreach($diary as $d) : ?>
<div class="modal fade" id="detailDiaryModal<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $d['title'] ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                  <p class="text-muted">Published <?= date('Y-m-d', strtotime($d['created_at'])) ?></p>
                  <hr>
                   <p>
                      <?= $d['description'] ?>
                   </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-info" href="<?= base_url('user/diary/edit/' . $d['id']) ?>">Edit !</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection(); ?>