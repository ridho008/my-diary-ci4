

<?= $this->extend('layouts/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
     <div class="row">
        <div class="col-md-8">
              <form action="<?= base_url('/admin/update/' . $user['id']) ?>" method="post" class="user">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                  <?= csrf_field() ?>
                  <div class="form-group">
                      <input type="text" class="form-control" value="<?= $user['username']; ?>" disabled>
                  </div>
                  <div class="form-group">
                      <input type="email" name="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ' ' ?>" id="exampleInputEmail" value="<?= $user['email']; ?>" placeholder="Email address">
                      <div class="invalid-feedback">
                        <?= $validation->getError('email'); ?>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                          <input type="password" name="password" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : ' ' ?>" placeholder="Password" autocomplete="off">
                          <div class="invalid-feedback">
                            <?= $validation->getError('password'); ?>
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <input type="password" name="pass_confirm" class="form-control  <?= ($validation->hasError('pass_confirm')) ? 'is-invalid' : ' ' ?>" autocomplete="off" placeholder="Repeat Password">
                          <div class="invalid-feedback">
                            <?= $validation->getError('pass_confirm'); ?>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <button type="submit" class="btn btn-primary btn-block">
                          Update Data
                      </button>
                    </div>
                    <div class="col-md-6">
                      <a href="<?= base_url('admin') ?>" class="btn btn-dark btn-block">Back</a>
                    </div>
                  </div>
                  
              </form>
        </div>
     </div>

 </div>


<?= $this->endSection(); ?>