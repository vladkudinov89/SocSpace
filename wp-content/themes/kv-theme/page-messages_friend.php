<?php
$urls = GetTemplatePath();

if (is_user_logged_in()) {
    if (isset($_GET['message_friend'])) {
        $message_friend = $_GET['message_friend'];
    }
    get_header();


    $currentUserMessages = get_user_by('login', $message_friend);

    $argsMesFromWin = array(
        'author__in' => $currentUserMessages->ID,
        'order' => 'DESC',
        'karma' => 1,
        'meta_key' => 'recipient',
        'meta_value' => $current_user->user_login,
    );

    $UpdateNewMessage = get_comments($argsMesFromWin);

    //Перевод сообщения в прочитанные

    $commentarr = array();

    foreach ($UpdateNewMessage as $newMess) {
        $commentarr['comment_ID'] = $newMess->comment_ID;
        $commentarr['comment_karma'] = 0;
        wp_update_comment($commentarr);
    }


    $page = "page-messages";
    require_once 'left-menu.php';

    $args = array(
        'author__in' => array($current_user->ID, $currentUserMessages->ID),
        'order' => 'DESC',
        'number' => 10,
        'offset' => 0,
        'meta_query' => array(
            array(
                'key' => 'recipient',
                'value' => array(
                    $current_user->user_login, $currentUserMessages->user_login
                )
            )
        )
    );

    $comments = get_comments($args);


    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Чат с <?php echo "$currentUserMessages->first_name $currentUserMessages->user_lastname" ?>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->

            <div class="col-md-8 msgEnter">

                <input type="hidden" id="updateMessOnline" data-rec="<?= $currentUserMessages->ID ?>">
                <input class="inputMessage" type="text" id="inputMessage">
                <div class="empty_message">Напишите сообщение</div>
                <button class="btn btn-primary btn-sm btn-sendMessage" type="submit" data-recipient="<?= $message_friend ?>"
                        id="messageSubmit">
                    Отправить сообщение <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                </button>

            </div>

            <div>
                <ul class="col-md-8 messagesChat">
                    <?php
                    if ($comments) {
                        foreach ($comments as $comment) { ?>

                            <li class="form-group bg-gray-light message-item">

                    <span class="text-bold dialog_name_fz">
                        <?php
                        if ($comment->comment_author == $current_user->user_login) { ?>
                            Вы:
                        <?php } else {
                            echo "$currentUserMessages->user_firstname $currentUserMessages->user_lastname:";
                        } ?>
                    </span>
                                <div class="message-date"><?= $comment->comment_date ?></div>
                                <div>
                                    <p class="dialog_content_pad">
                                        <?= $comment->comment_content; ?>
                                    </p>

                                </div>
                                <div class="message_delete" data-tooltip="Удалить"
                                     data-dlt_msg_id="<?= $comment->comment_ID ?>">
                                    <i class="fa fa-times " aria-hidden="true"></i>
                                </div>


                            </li>


                        <?php }


                        ?>
                    <?php } else { ?>
                        <li>
                            <p>
                                У вас нет сообщений
                            </p>
                        </li>
                    <?php } ?>


                </ul>
            </div>
            <div class="col-md-6 col-md-offset-3">
                <input id="LoadMore" type="hidden" value="<?= $message_friend ?>"
                       class="btn btn-default btn-lg btn-block">

            </div>

            <div id="preloader2"></div>

            <!-- Modal -->
            <div class="modal fade" id="delFromChatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Удалить сообщение</h4>
                        </div>
                        <div class="modal-body">
                            <div>
                                Вы действительно хотите удалить сообщение?
                            </div>
                            <div>
                                Отменить это действие будет невозможно.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-sm btn-primary del_msg_from_chat">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="EndMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Нет сообщений</h4>
                </div>
                <div class="modal-body">

                    <div>
                        Больше нет сообщений
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->


    <?php get_footer();

} else {
    wp_redirect($urls['home'] . '/autorize');
}



