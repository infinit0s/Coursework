<!DOCTYPE html>
<html>
<head>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js">\x3C/script>');</script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" type="text/css" media="screen"/>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo base_url('index.php') ?>">Employees Manager</a>
            <div class="nav-collapse collapse">
                <?php if ($user): ?>
                <p class="navbar-text pull-right">Logged in as: <?php echo $user->login ?>, role: <?php echo $user->role_name ?> <a class="" href="<?php echo base_url('index.php/auth/logout') ?>">(logout)</a></p>
                <?php endif; ?>
                <ul class="nav">
                    <li <?php if ($controllerName == 'find'): ?> class="active" <?php endif ?>><a href="<?php echo base_url('index.php/find/findemp') ?>"><i class="icon-search icon-white"></i> Search</p></a></li>
                    <li <?php if ($controllerName == 'employee'): ?> class="active" <?php endif ?>><a href="<?php echo base_url('index.php/employee/all') ?>">Employees</a></li>
                    <li <?php if ($controllerName == 'salaries'): ?> class="active" <?php endif ?>><a href="<?php echo base_url('index.php/salaries/all') ?>">Salaries</a></li>
                    <li <?php if ($controllerName == 'departments'): ?> class="active" <?php endif ?>><a href="<?php echo base_url('index.php/departments/all') ?>">Departments</a> </li>
                    <li <?php if ($controllerName == 'titles'): ?> class="active" <?php endif ?>><a href="<?php echo base_url('index.php/titles/all') ?>">Titles</a></li>
                </ul>
            </div><!--/.nav-collapse-->
        </div>
    </div>
</div>
<div class="container">
    <?php if (isset($error) && !is_null($error)): ?>
    <div class="alert alert-block alert-error"><?php echo $error ?></div>
    <?php endif; ?>
    <?php if (isset($info) && !is_null($info)): ?>
    <div class="alert alert-block alert-info"><?php echo $info ?></div>
    <?php endif; ?>
