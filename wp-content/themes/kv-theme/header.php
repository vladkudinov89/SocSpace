<?php
$urls = GetTemplatePath(); ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SocSpace</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png" />


    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">-->




    <link rel="stylesheet" href="<?php echo $urls['template']; ?>/dist/css/styles.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->



    <!-- Google Font -->
    <!--<link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->



</head>


<?php
$current_user = wp_get_current_user();
$user_account_image = get_user_meta($current_user->ID ,'user_image_account');
/*var_dump($current_user);*/
if (0 == $current_user->ID ) { ?>
    <body class="hold-transition skin-blue sidebar-mini">

    <!-- Navigation start -->
    <header class="header">

        <nav class="navbar navbar-custom" role="navigation">

            <div class="container">


                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#custom-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo $urls['home'];?>/autorize">
                        <span class="logo-lg"><b>Soc</b>Space</span>
                    </a>

                </div>

                <div class="collapse navbar-collapse" id="custom-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo $urls['home'];?>/registration">Регистрация</a></li>
                    </ul>
                </div>

            </div><!-- .container -->

        </nav>

    </header>

<?php }
else { ?>
    <div id="preloader"></div>

     <body class="hold-transition skin-blue sidebar-mini layout-boxed">

    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo $urls['home'];?>/profile" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><i class="fa fa-id-badge" aria-hidden="true"></i></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Soc </b><i class="fa fa-rocket" aria-hidden="true"></i> Space</span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">


                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="<?php echo GetMainAvatar($current_user,'thumbnail'); ?>" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs"><?php
                                    if($current_user->first_name){
                                        echo $current_user->first_name;
                                    } else {
                                        echo $current_user->display_name;
                                    } ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="<?php echo GetMainAvatar($current_user,'thumbnail'); ?>" class="img-circle" alt="User Image">

                                    <p>
                                        <?= $current_user->first_name?> <?= $current_user->last_name ?>

                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <a href="<?php echo $urls['home'];?>/messages">Сообщения</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="<?php echo $urls['home'];?>/gallery">Фото</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="<?php echo $urls['home'];?>/friends">Друзья</a>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo $urls['home'];?>/profile" class="btn btn-default btn-flat">Профиль</a>
                                    </div>
                                    <div class="pull-right">
                                        <!--<a href="logout.php" class="btn btn-default btn-flat">Выйти</a>-->
                                        <a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-default btn-flat">Выйти</a>

                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>



<?php }
