<?php
$urls = GetTemplatePath();

if (is_user_logged_in()) {
    get_header();

    if (isset($_GET['message_friend'])) {

        require_once 'page-messages_friend.php';

    } else {


        $page = "page-messages";
        require_once 'left-menu.php';

        /* $argUsers = array(
             'role' => 'administrator'
         );

         $usersAuthor = get_users($argUsers);*/


        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Ваши сообщения
                </h1>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">

                <!--------------------------
                  | Your Page Content Here |
                  -------------------------->


                <div class="col-md-7">
                    <?php

                    $result = array();

                    $args = array(
                        'order' => 'DESC',
                        'meta_key' => 'recipient',
                        'meta_value' => $current_user->user_login,
                    );

                    $comments = get_comments($args);

                    if (empty($comments)) { ?>
                        <h4>У вас пока нет сообщений</h4>
                    <?php } else {
                        foreach ($comments as $comment) {
                            $result[] = $comment->comment_author;
                        }

                        $result1 = array_unique($result);
                        /*print_r($result1);*/
                        ?>
                        <ul class="message-items">
                            <?php foreach ($result1 as $res1) {

                                $userDialog = get_user_by('login', $res1);

                                $args1 = array(
                                    'number' => 1,
                                    'author__in' => $userDialog->ID,
                                    'order' => 'DESC',
                                    /*'comment_karma' => 1,*/
                                    'meta_key' => 'recipient',
                                    'meta_value' => $current_user->user_login,
                                );

                                $comments1 = get_comments($args1);

                                foreach ($comments1 as $comment1) { ?>

                                    <?php
                                    $filename = get_user_meta($comment1->user_id, 'user_image_account');
                                    $userData = get_user_by('login', $comment1->comment_author);
                                    ?>
                                    <li data-test="<?= $comment1->comment_ID ?>"
                                        class="form-group
                             <?php
                                        if ($comment1->comment_karma == 1) { ?>
                                bg-gray
                            <?php } else { ?>
                                   bg-gray-light
                            <?php }
                                        ?>
                              dialogs_friend clearfix" id="view_message_friend">

                                        <!--<div>
                                    <?php /*echo $comment1->comment_author; */ ?>
                                    <?php /*echo $userDialog->ID; */ ?>
                                </div>-->

                                        <div class="pull-left dialog-img-margin">
                                            <img src="<?php echo GetMainAvatar($userData,'thumbnail'); ?>" class="img-circle"
                                                 alt="User Image">
                                        </div>
                                        <div class="messages-from-friend text-bold">
                                            <p>
                                                <?= $userData->user_firstname ?> <?= $userData->user_lastname ?>
                                            </p>
                                            <?php if ($comment1->comment_karma){ ?>

                                            <p>
                                                <span class="text-blue">новое сообщение</span>
                                                <?php } else { ?>
                                                    <span class="text-blue">
                                                    Сообщение:
                                                </span>
                                                <?php } ?>
                                            </p>
                                        </div>

                                        <div class="dialog_friend_message">


                                            <p>
                                                <?php echo mb_strimwidth($comment1->comment_content, 0, 20, '...'); ?>
                                            </p>
                                        </div>
                                        <div>
                                            <a href="<?php echo $urls['home']; ?>/messages/?message_friend=<?= $comment1->comment_author ?>"
                                               class="btn btn-sm btn-primary dialogs_friend_read"
                                               data-message-friend="<?= $comment1->comment_author ?>">
                                                Читать сообщение
                                            </a>
                                        </div>
                                        <div class="dialog_delete" data-tooltip="Удалить"
                                             data-delete_dialog="<?= $comment1->comment_ID ?>">
                                            <i class="fa fa-times " aria-hidden="true"></i>
                                        </div>


                                    </li>

                                <?php }
                                ?>

                            <?php } ?>

                        </ul>
                    <?php } ?>


                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Удалить все сообщения</h4>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        Вы действительно хотите удалить всю переписку с данным пользователем?
                                    </div>
                                    <div>
                                        Отменить это действие будет невозможно.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Отмена
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary delete_test">Удалить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Modal -->


                    <?php ?>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php get_footer();
    }

} else {
    wp_redirect($urls['home'] . '/autorize');
}


