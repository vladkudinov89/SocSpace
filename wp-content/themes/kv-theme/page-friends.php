<?php get_header();

$urls = GetTemplatePath();

if (is_user_logged_in()) {
    $page = "page-friends";
    require_once 'left-menu.php';

    $current_user = wp_get_current_user();

    $userFriends = $current_user->user_friends;
    $userFollowers = $current_user->user_followers;
    $userFollowing = $current_user->user_following;


    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Все пользователи
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->

            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-margin">
                <li class="active"><a href="#friends" data-toggle="tab">Друзья</a></li>
                <li><a href="#followers" data-toggle="tab">Ваши подписчики</a></li>
                <li><a href="#following" data-toggle="tab">Вы подписаны</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">


                <div class="tab-pane fade in active" id="friends">
                    <ul class="tabe-pane-u clearfix">
                        <?php

                        if (empty($userFriends)) { ?>
                            <li class="form-group bg-gray clearfix">
                                <h3>У вас пока нет друзей</h3>
                            </li>
                        <?php }//if empty array
                        else {
                            $args = array(
                                'meta_value' => $userFriends
                            );

                            $users = get_users($args);

                            foreach ($users as $friend) {

                                ?>
                                <li class="media form-group bg-gray clearfix">

                                    <a class="pull-left"
                                       href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $friend->ID ?>">
                                        <img class="media-object img-circle search_img" src="<?php echo GetMainAvatar($friend,'thumbnail'); ?>">
                                    </a>
                                    <div class="media-body">
                                        <a href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $friend->ID ?>"
                                           class="media-heading">
                                            <?php echo "$friend->last_name $friend->first_name" ?>
                                        </a>
                                        <div class="members-a">
                                            <a
                                                    class="btn btn-sm btn-primary"
                                                    href="<?php echo $urls['home']; ?>/messages/?message_friend=<?= $following->user_login ?>">
                                                Написать сообщение
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php }//foreach
                        }//else ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="followers">
                    <ul class="tabe-pane-u clearfix">
                        <?php
                        if (empty($userFollowers)) { ?>
                            <li class="form-group bg-gray clearfix">
                                <h3>У вас пока нет подписчиков</h3>
                            </li>
                        <?php }//if empty array
                        else {

                            $args = array(
                                'meta_value' => $userFollowers
                            );

                            $users = get_users($args);

                            foreach ($users as $followers) {

                                ?>
                                <li class="media form-group bg-gray clearfix">

                                    <a class="pull-left"
                                       href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $followers->ID ?>">
                                        <img class="media-object img-circle search_img" src="<?php echo GetMainAvatar($followers,'thumbnail'); ?>">
                                    </a>
                                    <div class="media-body">
                                        <a href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $followers->ID ?>"
                                           class="media-heading">
                                            <?php echo "$followers->last_name $followers->first_name" ?>
                                        </a>
                                        <div class="members-a">
                                            <a
                                                    class="btn btn-sm btn-primary"
                                                    href="<?php echo $urls['home']; ?>/messages/?message_friend=<?= $following->user_login ?>">
                                                Написать сообщение
                                            </a>
                                        </div>

                                    </div>
                                </li>
                            <?php }//foreach
                        }//else ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="following">
                    <ul class="tabe-pane-u clearfix">
                        <?php
                        if (empty($userFollowing)) { ?>
                            <li class="form-group bg-gray clearfix">
                                <h3>Вы не подписаны ни на кого</h3>
                            </li>
                        <?php }//if empty array
                        else {


                            $args = array(
                                'meta_value' => $userFollowing
                            );

                            $users = get_users($args);

                            foreach ($users as $following) {

                                ?>
                                <li class="media form-group bg-gray clearfix col-md-7">

                                    <a class="pull-left"
                                       href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $following->ID ?>">
                                        <img class="media-object img-circle search_img" src="<?php echo GetMainAvatar($following,'thumbnail'); ?>">
                                    </a>
                                    <div class="media-body">
                                        <a href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $following->ID ?>"
                                           class="media-heading">
                                            <?php echo "$following->last_name $following->first_name" ?>
                                        </a>
                                        <div class="members-a">
                                            <a
                                                    class="btn btn-sm btn-primary"
                                                    href="<?php echo $urls['home']; ?>/messages/?message_friend=<?= $following->user_login ?>">
                                                Написать сообщение
                                            </a>
                                        </div>

                                    </div>

                                </li>
                            <?php }//foreach
                        }//else ?>
                    </ul>
                </div>


            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <?php get_footer();
} else {
    wp_redirect($urls['home'] . '/autorize');
}
