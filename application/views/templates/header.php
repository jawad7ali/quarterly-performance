<!DOCTYPE html> 
	<head>
    <meta name="google" content="notranslate">
		<title>QPE | <?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/flatly.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/timepicker//jquery-ui-timepicker-addon.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/redmond/jquery-ui.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/evaluate/css/vendors-v1bcbd.css?vx=2'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/evaluate/css/16p-all-v3ae52.css?v=5'); ?>"> -->
    <!-- <script src="http://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script> -->
    
  </head>
  <style>
      .mtitle:hover{
          color: #fff !important;
      }
      .nav li a:hover{
          color: #fff !important;
      }
  </style>
	<body>
  <header>
  	<nav class="navbar navbar-default" style="    background-color: #4ca3fb;">
        <div class="container">
          <div class="navbar-header">
              <a href="<?php echo base_url(); ?>">
              <img class="navbar-brand" src="<?php echo base_url() ?>assets/W-150.png" style="float: left; height: 59px; padding: 9.5px 9px;">
              </a>
            <a class="navbar-brand mtitle" href="<?php echo base_url(); ?>"> Quarterly Assessment</a>
          </div>
          <div id="navbar">
            <ul class="nav navbar-nav">
              <?php if($this->session->userdata('user_type') == 'Admin'){ ?>
              <li><a href="<?php echo base_url(); ?>dashboard">Dashboard</a></li>
              <li class="dropdown">
                <a href="javascript:;">
                <span>View Member Evalution</span></a>
                <div class="dropdown-content">
                  <?php 
                  $all_departments_menu = $this->user_model->all_departments_for_dashboard();
                  foreach ($all_departments_menu as $row) {
                  ?>
                    <a href="<?php echo base_url(); ?>evaluation/department/<?php echo $row['id']; ?>"><?php echo $row['dept_name']; ?></a>
                  <?php }?>
                  <!-- <a href="<?php echo base_url(); ?>preferences/designation">Designations</a>
                  <a href="<?php echo base_url(); ?>preferences/manage_users">Users</a> -->
                </div>
              </li>

              <li class="dropdown">
                <a href="">
                <span>Preferences</span></a>
                <div class="dropdown-content">
                  <!-- <a href="<?php echo base_url(); ?>preferences/manage_users">Projects</a> -->
                  <a href="<?php echo base_url(); ?>preferences/department">Departments</a>
                  <a href="<?php echo base_url(); ?>preferences/designation">Designations</a>
                  <a href="<?php echo base_url(); ?>preferences/manage_users">Users</a>
                  <!-- <a href="<?php echo base_url(); ?>preferences/manage_users">Users</a> -->
                </div>
              </li>
              <li class="dropdown">
                <a href="">
                <span>Factors</span></a>
                <div class="dropdown-content">
                  <a href="<?php echo base_url(); ?>factors/listing/mtl">Member To Lead</a>
                  <a href="<?php echo base_url(); ?>factors/listing/mtm">Member To Member</a>
                  <a href="<?php echo base_url(); ?>factors/listing/ltm">Lead To Member</a>
                  <a href="<?php echo base_url(); ?>factors/listing/lthr">HR To Member</a>
                  <a href="<?php echo base_url(); ?>factors/listing/ttm">Trainer To Member</a>
                  <a href="<?php echo base_url(); ?>factors/listing/stl">Site Lead / HR To Lead</a>
                                  </div>
              </li>
            <?php } ?>
            </ul>
           <!--  <ul class="nav navbar-nav">
              <?php if($this->session->userdata('logged_in')) : ?>
              <li><a href="<?php echo base_url(); ?>users/admin">Admin</a></li>
              <?php endif; ?>
            </ul> -->
            <ul class="nav navbar-nav navbar-right">
            <!-- <?php if(!$this->session->userdata('logged_in')) : ?>
              <li><a href="<?php echo base_url(); ?>login">Login</a></li>
              <li><a href="<?php echo base_url(); ?>register">Register</a></li>
            <?php endif; ?> -->
            <?php if($this->session->userdata('logged_in')) : ?>
              <?php if($this->session->userdata('user_type') != 'Admin'){ ?>
              <li><a href="javascript:;">Welcome <?php echo $this->session->userdata('username'); ?></a></li>
            <?php } ?>
              <li><a href="<?php echo base_url(); ?>login/logout">Logout</a></li>
            <?php endif; ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="container main-container">
      <!-- Flash messages -->
      <?php if($this->session->flashdata('success')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('success').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('error')): ?>
        <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('error').'</p>'; ?>
      <?php endif; ?>

      <!-- <?php if($this->session->flashdata('user_loggedin')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedin').'</p>'; ?>
      <?php endif; ?>

       <?php if($this->session->flashdata('user_loggedout')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedout').'</p>'; ?>
      <?php endif; ?> -->
      