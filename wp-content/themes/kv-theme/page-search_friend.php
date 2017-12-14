<?php
$urls = GetTemplatePath();

if ( is_user_logged_in() ) {
    if (isset($_GET['search'])) {
        $searchFriend = $_GET['search'];
    }
    get_header();

    $page = "page-all_friends";
    require_once 'left-menu.php';


    $args = array(
        'meta_value' => $searchFriend,
        'exclude' => array($current_user->ID, $adminRole[0]->ID)
    );

    $users = get_users($args);

    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Найденные пользователи
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->
            <ul class="media-list ">
            <?php

            if ($users) {

                foreach ($users as $findUser) {
                    ?>
                        <li class="media form-group col-md-7 bg-gray-light">
                            <a class="pull-left" href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $findUser->ID ?>">
                                <img class="media-object img-circle search_img" src="<?php echo GetMainAvatar($findUser,'thumbnail'); ?>" >
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"> <?php echo "$findUser->last_name $findUser->first_name" ?></h4>
                               <!-- <a href="<?php /*echo $urls['home']; */?>/all_friends/?view=<?/*= $findUser->ID */?>"
                                   class="media-heading">
                                    <?php /*echo "$findUser->last_name $findUser->first_name" */?>
                                </a>-->

                                <a href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $findUser->ID ?>"
                                   class="button btn-4 btn-4a icon-arrow-right  wow zoomIn"
                                   data-wow-delay=".8s">К профилю
                                </a>
                            </div>
                        </li>
                    <li class="clearfix"></li>



                    <?php

                }//foreach ?>
                </ul>
            <?php } else {
                echo "По вашему запросу ничего не найдено. Повторите поиск"; ?>
                <div>
                    <a href="<?php echo $urls['home']; ?>/all_friends">Назад</a>
                </div>
            <?php }

            ?>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <?php get_footer();
}

else{
    wp_redirect( $urls['home'] . '/autorize');
}


