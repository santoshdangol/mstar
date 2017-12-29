<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title><?php echo isset($title) ?  ucfirst($title) . " | " : null;?>M.Star</title>
    <link href="<?php echo base_url(); ?>css/grid.css" rel="stylesheet" type="text/css" >
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" >
    <link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet" type="text/css" >

<!--	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
    <script src="<?php echo base_url();?>js/jquery.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>js/script.js"></script>
     <script src="<?php echo base_url(); ?>js/autoloadjs.js"></script>
    <script src="<?php echo base_url(); ?>js/accmodal.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.steps.js"></script>
    <script src="<?php echo base_url(); ?>js/multi-form.js"></script>
    <script src="<?php echo base_url(); ?>js/progress_bar.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
</head>
<body>
	<header>
        <div class="container">
        	<div class="grid grid8_12" id="site_name">
            	<a href="<?php echo base_url(); ?>">
                    <span><h1><img src="<?php  echo base_url(); ?>images/logo/mstar.jpg">M.Star</h1></span>
                    <small>Capital & Investment</small>
                </a>
            </div>

            <div class="grid grid4_12 no_padding">

            <?php if($userdata = $this->session->userdata('logged_in')): ?>

            	<div class="grid grid12_12" style="text-align:right">
                	<span>Welcome  &nbsp;!&nbsp;<span class="typicons-user"></span>&nbsp;<strong><?php echo $userdata['firstname']." ".$userdata['lastname']; ?></strong> <?php echo anchor('logout', 'Logout' , 'class="ac_link"'); ?></span><br>

                    <span><?php echo "Today is  &nbsp&nbsp".  $this->session->userdata['todaydate'] ; ?></span>

                </div>



            <?php else: ?>

            	<?php if($this->uri->segment(1)!="admin"): ?>


            	<div class="grid grid4_12"  "style="text-align: left;">

                	<!--<a href="login" class="ac_link"><span class="typicons-group"></span>&nbsp;Login</a>-->
                    <?php echo anchor('login', '<span class="typicons-user"></span>&nbsp;Login', 'class="ac_link"'); ?>

                </div>
                <div class="grid grid8_12 no_gutter register"  style="text-align: left;">

                	<small><em>No Account?</em></small>
                    &nbsp;
                    <!--<a href="register" class="ac_link"><span class="typicons-write"></span>Register</a>-->
                    <?php echo anchor('register', '<span class="typicons-write"></span>&nbsp;Register', 'class="ac_link"'); ?>

                </div>


            	<?php endif; ?>

            <?php endif; ?>

            </div>
            <!--<div class="grid grid4_12" style="text-align: right;">
            	<span class="typicons-user"></span>&nbsp;Welcome&nbsp;!&nbsp;
                <div class="drop_down">
                	<?php //echo anchor('#', 'Sunil Maharjan', 'class="ac_link"'); ?>
                </div>

            </div>-->

        </div>
    </header>

    <div class="body-content">
