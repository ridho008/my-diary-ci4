

<?= $this->extend('layouts/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800">Details User</h1>
     <div class="row">
        <div class="col-md-8">
            <div class="card mb-3" style="max-width: 540px;">
              <div class="row no-gutters">
                <div class="col-md-4">
                  <img src="<?= base_url('/img/' . $users['user_image']) ?>" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title"><?= $users['username']; ?></h5>
                    <?php if($users['fullname']) : ?>
                    <p class="card-text"><?= $users['fullname']; ?></p>
                     <?php endif; ?>
                    <p class="card-text"><small class="text-muted"><?= $users['email']; ?></small></p>
                    <p class="card-text"><small class="text-muted font-weight-bold"><?= $users['name']; ?></p>
                     <a href="<?= base_url('admin') ?>">&laquo; back to user list</a>
                  </div>
                </div>
              </div>
            </div>
        </div>
     </div>

 </div>


<?= $this->endSection(); ?>