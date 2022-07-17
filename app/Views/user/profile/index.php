

<?= $this->extend('layouts/index'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
     <?php if($user['name'] == 'admin') : ?>
     <span class="badge badge-info mb-1">You Are <?= $user['name'] ?></span>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')) : ?>
       <div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong><?= session()->getFlashdata('success'); ?></strong>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
    <?php endif ?>
     <div class="row">
           <div class="col-md-8">
                 <form action="<?= base_url('/user/update/' . user()->id) ?>" method="post" class="user" enctype="multipart/form-data">
                     <?= csrf_field() ?>
                     <div class="form-group">
                         <input type="text" class="form-control" value="<?= $user['username']; ?>" disabled>
                     </div>
                     <div class="form-group">
                         <input type="text" name="fullname" class="form-control <?= ($validation->hasError('fullname')) ? 'is-invalid' : ' ' ?>" value="<?= $user['fullname']; ?>" placeholder="Fullname">
                     </div>
                     <div class="form-group">
                         <input type="email" name="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ' ' ?>" id="exampleInputEmail" value="<?= ($user['email'] ? $user['email'] : old('email') ) ?>" placeholder="Email address">
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
                     <div class="row mb-1">
                       <div class="col-md-6">
                         <div class="form-group">
                             <input type="file" name="user_image" class="form-control <?= ($validation->hasError('user_image')) ? 'is-invalid' : ' ' ?>" id="exampleInputEmail">
                             <input type="hidden" value="<?= $user['user_image']; ?>" name="user_image_old" class="form-control <?= ($validation->hasError('user_image_old')) ? 'is-invalid' : ' ' ?>" id="exampleInputEmail">
                             <div class="invalid-feedback">
                               <?= $validation->getError('user_image'); ?>
                             </div>
                         </div>
                       </div>
                       <div class="col-md-6">
                         <img src="<?= base_url('img/' . $user['user_image']) ?>" alt="<?= $user['user_image'] ?>" width="100">
                       </div>
                     </div>
                     <div class="row">
                       <div class="col-md-6">
                         <button type="submit" class="btn btn-primary btn-block">
                             Update Data
                         </button>
                       </div>
                     </div>
                     
                 </form>
           </div>
           <?php if(in_groups('user')) : ?>
           <div class="col-md-4">
            <h1 class="h3 mb-4 text-gray-800">Generate My Diary Key</h1>
            <?php if($valiKeyDiary == null) : ?>
              <div class="alert alert-warning" role="alert">
                please, input your <strong>diary key</strong>. if you want to keep a diary
              </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('danger')) : ?>
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong><?= session()->getFlashdata('danger'); ?></strong>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
            <?php endif ?>
             <form action="<?= base_url('/user/generate/' . user()->id) ?>" method="post" class="user">
                <?= csrf_field() ?>
                <div class="form-group">
                  <label for="">Your Key : <?= $user['key_diary'] ?></label><br>
                  <?php if($user['key_diary'] != null) : ?>
                  <label for="">Plain Text : <?= $plain_text ?></label>
                  <?php endif; ?>
                </div>
                <div class="form-group">
                    <input type="text" name="key" class="form-control <?= ($validation->hasError('key')) ? 'is-invalid' : ' ' ?>" value="" placeholder="Input your key">
                    <div class="invalid-feedback">
                      <?= $validation->getError('key'); ?>
                    </div>
                    <span class="">Example : hello bro</span>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block">
                      Generate
                  </button>
                </div>
              </form>
           </div>
         <?php endif; ?>
          </div>

 </div>


<?= $this->endSection(); ?>