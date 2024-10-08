<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $page_title; ?> | MCE Campus Portal</title>

    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/favicon.png">

    <!-- App css -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/theme.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
</head>

<!-- Begin page -->
<div id="layout-wrapper">

    <div class="main-content">

        <header id="page-topbar">
            <div class="navbar-header">
                <!-- LOGO -->
                <div class="navbar-brand-box d-flex align-items-left">
                    <a href="index.html" class="logo">
                        <span>
                            MCE CAMPUS
                        </span>
                    </a>

                    <button type="button"
                        class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light"
                        data-toggle="collapse" data-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown d-inline-block ml-2">
                        <button type="button" class="btn header-item noti-icon waves-effect waves-light"
                            id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Recipient's username">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="dropdown d-inline-block ml-2">
                        <button type="button" class="btn header-item waves-effect waves-light"
                            id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="<?php echo base_url(); ?>assets/images/avatar.png" alt="Avatar">
                            <span class="d-none d-sm-inline-block ml-1">Welcome <?= $student_name; ?></span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="<?php echo base_url(); ?>student/profile">
                                <span>My Profile</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="<?php echo base_url(); ?>student/logout">
                                <span>Log Out</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>student/dashboard">
                                    <i class="mdi mdi-view-dashboard mr-2"></i>Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>student/fees">
                                   <i class="nav-icon fas fa-receipt mr-2"></i>Fees
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>student/profile">
                                   <i class="nav-icon fas fa-user mr-2"></i>My Profile
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>student/changePassword">
                                    <i class="nav-icon fas fa-fingerprint mr-2"></i>Change Password
                                </a>
                            </li>



                        </ul>
                    </div>
                </nav>
            </div>
        </div>