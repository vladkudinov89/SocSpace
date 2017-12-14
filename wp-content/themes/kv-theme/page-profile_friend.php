<?php
if (true) {
    if (isset($_GET['view'])) {
        $view = $_GET['view'];
    }
    get_header();

    $page = "page-all_friends";
    require_once 'left-menu.php';

    /*$user_profile = get_user_meta($view,'');*/
    $user_profile = get_user_by('id', $view);

    $imageProfile = GetAvatar($user_profile)[0];

    //print_r($user_profile);

    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->

            <div class="col-md-3 page_block margin-right">


                <div class="form-group mar-top clearfix">
                    <img src="<?php echo GetMainAvatar($user_profile, 'medium'); ?>" class="message-img-left img-width"
                         alt="User Image">
                </div>
                <div class="form-group">
                    <a
                            class="btn-block btn btn-sm btn-primary"
                            href="<?php echo $urls['home']; ?>/messages/?message_friend=<?= $user_profile->user_login ?>">
                        Написать сообщение
                    </a>
                </div>

            </div>

            <div class="col-md-8">
                <div class="page_block">
                    <div class="page_block_wrap">
                        <h4 class="text-bold border-info"><?php echo $user_profile->first_name; ?>
                            &#160;<?php echo $user_profile->last_name; ?></h4>


                        <div class="profile_info_d">

                            <?php
                            if (
                                $user_profile->user_dayBirth == '' ||
                                $user_profile->user_monthBirth == '' ||
                                $user_profile->user_yearBirth == ''
                            ) {

                            } else { ?>
                                <div class="profile_info_row">
                                    <div class="profile_info fl_l">День рождения:</div>
                                    <div class="profile_info_data"><?php echo $user_profile->user_dayBirth; ?>
                                        &#160;<?php getMonth($user_profile->user_monthBirth); ?>
                                        <?php echo $user_profile->user_yearBirth; ?> г.
                                    </div>
                                </div>
                            <?php }
                            ?>

                            <?php
                            if (
                                $user_profile->user_country == ''
                            ) {

                            } else { ?>
                                <div class="profile_info_row">
                                    <div class="profile_info fl_l">Страна:</div>
                                    <div class="profile_info_data"><?php echo $user_profile->user_country; ?></div>
                                </div>
                            <?php }
                            ?>

                            <?php
                            if (
                                $user_profile->user_city == ''
                            ) {

                            } else { ?>
                                <div class="profile_info_row">
                                    <div class="profile_info fl_l">Город:</div>
                                    <div class="profile_info_data"><?php echo $user_profile->user_city; ?></div>
                                </div>
                            <?php }
                            ?>

                        </div>


                    </div>
                </div>

                <div class="page_block">
                    <div class="page_block_wrap">

                        <h4 class="text-bold border-info">
                            Фотографии
                        </h4>


                        <div class="popup-gallery text-center">
                            <?php

                            $gallery = get_post_gallery(getPostID($user_profile), false);


                            if ($gallery) {
                                $i = 0;
                                foreach ($gallery['src'] as $image) {
                                    if (++$i > 3) break;
                                    ?>
                                    <a href="<?php echo $image; ?>">
                                        <img class="popup-gallery-size" src="<?php echo $image; ?>" alt="">
                                    </a>

                                <?php }
                            } ?>

                        </div>


                    </div>
                </div>

                <div class="page_block">
                    <div class="page_block_wrap">

                        <h4 class="text-bold border-info">
                            Добавить запись
                        </h4>

                        <div class="">

                            <input class="inputMessage wall_msg_inp" type="text" id="wallMessage"
                                   placeholder="Добавить запись...">

                            <div class="empty_message">Напишите сообщение</div>
                            <button class="btn btn-primary btn-sm btn-sendWallMessage" type="submit"
                                    data-recipientwall="<?= $user_profile->user_login ?>"
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
                                'meta_value' => $user_profile->user_login,
                            );

                            $commentsWall = get_comments($argsWall);

                            //print_r($commentsWall);

                            foreach ($commentsWall as $commentWall) {
                                $user_profile_wall = get_user_by('login', $commentWall->comment_author);
                                //$user_wall_image = get_user_meta($user_profile_wall->ID, 'user_image_account');
                                //echo $user_profile->ID;
                                //$av = GetAvatar($user_profile)[0];
                                ?>

                                <div class="form-group bg-gray-light commentWall-item border-info">

                                    <div class="user-panel user-data bg-blue-gradient">

                                        <div class=" image">
                                            <a class="pull-left"
                                               href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $user_profile_wall->ID ?>">
                                                <img src="<?php echo GetMainAvatar($user_profile_wall,'thumbnail'); ?>"
                                                     class="img-circle img_wall"
                                                     alt="User Image">
                                            </a>
                                        </div>

                                        <div class="pull-left info">
                                            <p><?= $user_profile_wall->first_name ?> <?= $user_profile_wall->last_name ?></p>
                                            <!-- Status -->
                                            <div class="messageWall-date"><?= $commentWall->comment_date ?></div>
                                        </div>
                                    </div>


                                    <div>
                                        <p class="wall-comment">
                                            <?php echo $commentWall->comment_content; ?>
                                        </p>
                                    </div>

                                    <?php
                                    if ($current_user->user_login == $commentWall->comment_author) { ?>
                                        <div class="messageWall_delete" data-tooltip="Удалить"
                                             data-dlt_msgwall="<?= $commentWall->comment_ID ?>">
                                            <i class="fa fa-times " aria-hidden="true"></i>
                                        </div>
                                    <?php } else { ?>

                                    <?php }
                                    ?>


                                </div>

                            <?php } ?>


                        </div>


                    </div>
                </div>


            </div>
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
            <div class="clearfix"></div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <?php get_footer();

} else {
    wp_redirect($urls['home'] . '/autorize');
}


