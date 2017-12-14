<?php

$urls = GetTemplatePath();

if (is_user_logged_in()) {
    get_header();

    ?>

    <?php

    $userFollowers = $current_user->user_followers;

    ?>

    <?php $page = "page-profile";
    require_once 'left-menu.php';
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Ваш Профиль
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <?php
            $posts = get_posts(array(
                'author' => $current_user->ID,
                'post_type' => 'flats',
                'post_status' => 'publish',
            ));


            foreach ($posts as $post) {
                $post->post_content = strip_shortcodes($post->post_content);

                $gallery = get_post_gallery($post->ID, false);
            }

            //print_r($gallery);



            $pieces = explode(',', $gallery['ids']);



            /*print_r($pieces);*/

            /* echo count($pieces);*/

            /*print_r($pieces);*/

            ?>

            <!--------------------------
              | Your Page Content Here |
              -------------------------->
            <div class="col-md-3 page_block margin-right">


                <div class="form-group mar-top  clearfix">
                    <img src="<?php echo GetMainAvatar($current_user,'medium'); ?>" class="message-img-left img-width"
                         alt="User Image">
                </div>
                <div class="form-group">
                    <a class="btn-block btn btn-sm btn-primary" href="<?php echo $urls['home']; ?>/edit_profile">Редактировать
                        профиль</a>
                </div>
                <div class="form-group">
                    <a class="btn-block btn btn-sm btn-primary" href="<?php echo $urls['home']; ?>/messages">Мои
                        сообщения</a>
                </div>

            </div>

            <div class="col-md-8">
                <div class="page_block">
                    <div class="page_block_wrap">
                        <h4 class="text-bold border-info"><?php echo $current_user->first_name; ?>
                            &#160;<?php echo $current_user->last_name; ?></h4>


                        <div class="profile_info_d">

                            <?php
                            if (
                                $current_user->user_dayBirth == '' ||
                                $current_user->user_monthBirth == '' ||
                                $current_user->user_yearBirth == ''
                            ) {

                            } else { ?>
                                <div class="profile_info_row">
                                    <div class="profile_info fl_l">День рождения:</div>
                                    <div class="profile_info_data"><?php echo $current_user->user_dayBirth; ?>
                                        &#160;<?php getMonth($current_user->user_monthBirth); ?>
                                        <?php echo $current_user->user_yearBirth; ?> г.
                                    </div>
                                </div>
                            <?php }
                            ?>

                            <?php
                            if (
                                $current_user->user_country == ''
                            ) {

                            } else { ?>
                                <div class="profile_info_row">
                                    <div class="profile_info fl_l">Страна:</div>
                                    <div class="profile_info_data"><?php echo $current_user->user_country; ?></div>
                                </div>
                            <?php }
                            ?>

                            <?php
                            if (
                                $current_user->user_city == ''
                            ) {

                            } else { ?>
                                <div class="profile_info_row">
                                    <div class="profile_info fl_l">Город:</div>
                                    <div class="profile_info_data"><?php echo $current_user->user_city; ?></div>
                                </div>
                            <?php }
                            ?>

                        </div>

                        <div class="counts_module">
                            <a href="<?php echo $urls['home']; ?>/friends" class="page_counter">
                                <div class="count_label"><?php echo count($userFollowers); ?></div>
                                <div class="count_desc">подписчик</div>
                            </a>
                            <a href="<?php echo $urls['home']; ?>/gallery" class="page_counter">
                                <div class="count_label"><?php echo count($pieces); ?></div>
                                <div class="count_desc">фото</div>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="page_block">
                    <div class="page_block_wrap">

                        <h4 class="text-bold border-info">
                            Фотографии <a href="<?php echo $urls['home']; ?>/gallery" class="view_all_foto"><span>все фото</span></a>
                        </h4>


                        <div class="popup-gallery text-center">
                            <?php

                            if ($gallery) {
                                $i = 0;
                                foreach ($gallery['src'] as $image) {
                                    if (++$i > 3) break;
                                    ?>
                                    <a href="<?php echo $image; ?>">
                                        <img class="popup-gallery-size attachment-thumbnail size-thumbnail" src="<?php echo $image; ?>" alt="">
                                    </a>

                                <?php  }
                            } ?>

                        </div>


                    </div>
                </div>

                <div class="page_block">
                    <div class="page_block_wrap">

                        <h4 class="text-bold border-info">
                            Что нового?
                        </h4>

                        <div class="">

                            <input class="inputMessage wall_msg_inp" type="text" id="wallMessage" placeholder="Добавить запись...">

                            <div class="empty_message">Напишите сообщение</div>
                            <button class="btn btn-primary btn-sm btn-sendWallMessage" type="submit"
                                    data-recipientwall="<?= $current_user->user_login ?>"
                                    id="messageWallSubmit">
                                Оставить запись <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                            </button>

                        </div>


                    </div>
                </div>

                <div class="page_block">
                    <div class="page_block_wrap">

                        <h4 class="text-bold border-info">
                            Стена
                        </h4>


                        <div class="">
                            <?php
                            $argsWall = array(
                                'number' => 10,
                                /*'author__in' => $current_user->ID,*/
                                'order' => 'DESC',
                                /*'comment_karma' => 1,*/
                                'meta_key' => 'recipientWall',
                                'meta_value' => $current_user->user_login,
                            );

                            $commentsWall = get_comments($argsWall);

                            //print_r($commentsWall);

                            foreach ($commentsWall as $commentWall) {
                                $user_profile = get_user_by('login', $commentWall->comment_author);
                                $user_anothProf_image = get_user_meta($user_profile->ID, 'user_image_account');
                                ?>
                                <div class="form-group bg-gray-light commentWall-item border-info">

                                    <div class="user-panel user-data bg-blue-gradient">
                                        <div class="pull-left image">
                                            <a class="pull-left" href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $user_profile->ID ?>">
                                            <img src="<?php echo GetMainAvatar($user_profile,'thumbnail'); ?>" class="img-circle img_wall"
                                                 alt="User Image">
                                            </a>
                                        </div>
                                        <div class="pull-left info">
                                            <p><?= $user_profile->first_name ?> <?= $user_profile->last_name ?></p>
                                            <!-- Status -->
                                            <div class="messageWall-date"><?= $commentWall->comment_date ?></div>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="wall-comment">
                                            <?php echo $commentWall->comment_content; ?>
                                        </p>
                                    </div>

                                    <div class="messageWall_delete" data-tooltip="Удалить"
                                         data-dlt_msgwall="<?= $commentWall->comment_ID ?>">
                                        <i class="fa fa-times " aria-hidden="true"></i>
                                    </div>
                                </div>

                            <?php } ?>


                        </div>

                    </div>
                </div>


            </div>
            <div class="clearfix"></div>

            <!-- Modal -->
            <div class="modal fade" id="delFromWallModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Удалить запись</h4>
                        </div>
                        <div class="modal-body">
                            <div>
                                Вы действительно хотите удалить запись?
                            </div>
                            <div>
                                Отменить это действие будет невозможно.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-sm btn-primary del_msg_from_wall">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <?php get_footer();

} else {
    wp_redirect($urls['home'] . '/autorize');
}







