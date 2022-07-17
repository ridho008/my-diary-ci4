<?php  
$db = \Config\Database::connect();
$user = $db->table('users')->select('id, key_diary')->where('id', user()->id)->get()->getRowArray();
// dd($user);

?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">My Diary <sup>We</sup></div>
            </a>

            <?php if(in_groups('admin')) : ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                User Management
            </div>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>User List</span></a>
            </li>

            <?php endif; ?>

            <hr class="sidebar-divider">


            <!-- Nav Item - Dashboard -->
            <?php if(in_groups('admin')) : ?>
            <div class="sidebar-heading">
                Diary Management
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/diary') ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Diary List</span></a>
            </li>
            <?php endif; ?>

            <?php if(in_groups('user')) : ?>
            <div class="sidebar-heading">
                My Diary
            </div>    
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user/diary') ?>"  data-toggle="modal" data-target="#keyDiaryModal">
                    <i class="fas fa-fw fa-user"></i>
                    <span>My Diary</span></a>
            </li>
            <?php endif; ?>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                User Profile
            </div>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user') ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User Profile</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user/edit') ?>">
                    <i class="fas fa-fw fa-user-edit"></i>
                    <span>Edit Profile</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('logout') ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>