

<?= $this->extend('layouts/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
     <div class="row">
        <div class="col-md-8">
              <?= view('Myth\Auth\Views\_message_block') ?>
              <form action="<?= route_to('register') ?>" method="post" class="user">
          <?= csrf_field() ?>
                  <div class="form-group">
                      <input type="text" autofocus="on" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" id="exampleFirstName"
                              placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>">
                  </div>
                  <div class="form-group">
                      <input type="email" name="email" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" id="exampleInputEmail"
                          placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
                  </div>
                  <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                          <input type="password" name="password" class="form-control  <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Password" autocomplete="off">
                      </div>
                      <div class="col-sm-6">
                          <input type="password" name="pass_confirm" class="form-control  <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" autocomplete="off" placeholder="Repeat Password">
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <button type="submit" class="btn btn-primary btn-block">
                          Add Data
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