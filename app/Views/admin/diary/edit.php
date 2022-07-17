

<?= $this->extend('layouts/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
     <div class="row">
        <div class="col-md-8">
              <form action="<?= base_url('/admin/diary/update/' . $diary['id']) ?>" method="post" class="user">
                  <?= csrf_field() ?>
                  <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" name="title" class="form-control <?= ($validation->hasError('title')) ? 'is-invalid' : ' ' ?>" value="<?= $diary['title']; ?>">
                      <div class="invalid-feedback">
                        <?= $validation->getError('title'); ?>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="">Diaries</label>
                    <textarea name="editor1" id="editor1" rows="10" cols="80" class="<?= ($validation->hasError('description')) ? 'is-invalid' : ' ' ?>" placeholder="Description..."><?= $diary['description']; ?></textarea>
                      <div class="invalid-feedback">
                        <?= $validation->getError('description'); ?>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <button type="submit" class="btn btn-primary btn-block">
                          Update Data
                      </button>
                    </div>
                    <div class="col-md-6">
                      <a href="<?= base_url('admin/diary') ?>" class="btn btn-dark btn-block">Back</a>
                    </div>
                  </div>
                  
              </form>
        </div>
     </div>

 </div>



<?= $this->endSection(); ?>