<?php

$urls = GetTemplatePath();
if (is_user_logged_in()) {
    get_header();


//Просмотр профиля друга
    if (isset($_GET['view'])) {

        require_once 'page-profile_friend.php';

    } elseif (isset($_GET['search'])) {
        require_once 'page-search_friend.php';
    } else {
        $page = "page-all_friends";
        require_once 'left-menu.php';
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
                <!-- search form (Optional) -->
                <div class="aside-form">
                    <span class="empty_dataSearch">Укажите данные для поиска</span>
                    <div class="input-group">
                        <input type="text" id="searchFriend" class="form-control searchFriend"
                               placeholder="Найти пользователя...">
                        <span class="input-group-btn">
                          <button name="search" id="search_friend" class="btn btn-flat btn-search">
                              <i class="fa fa-search"></i>
                          </button>
                        </span>
                    </div>
                </div>
                <!-- /.search form -->
                <ul class="ul-friends">
                    <?php

                    $args = array(
                        'exclude' => array($current_user->ID, $adminRole[0]->ID)
                    );

                    $blogusers = get_users($args);

                    $userFriends = $current_user->user_friends;
                    $userFollowers = $current_user->user_followers;
                    $userFollowing = $current_user->user_following;

                    foreach ($blogusers as $user) {

                        $isFriend = in_array($user->user_login, $userFriends);
                        $isFollower = in_array($user->user_login, $userFollowers);
                        $isFollowing = in_array($user->user_login, $userFollowing);
                        ?>


                        <li class="media form-group col-md-7 bg-gray-light">
                            <?php

                            $filename = GetAvatar($user)[0]; ?>
                            <a class="pull-left" href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $user->ID ?>">
                                <img class="media-object img-circle search_img" src="<?php echo GetMainAvatar($user,'thumbnail'); ?>" >
                            </a>
                            <div class="media-body">
                                <a href="<?php echo $urls['home']; ?>/all_friends/?view=<?= $user->ID ?>" class="media-heading members_name"> <?php echo "$user->last_name $user->first_name" ?></a>
                                <div>

                                    <div>
                                        <h5 class="members-h3">Статус: </h5>
                                        <?php

                                        if ($isFriend) { ?>
                                            <h5>Друг</h5>
                                        <?php } elseif ($isFollower) {
                                            ?>
                                            <h5>Подписчик</h5>
                                        <?php } elseif ($isFollowing) { ?>
                                            <h5>Вы подписаны</h5>
                                        <?php } else { ?>
                                            <h5>Пользователь</h5>
                                        <?php }

                                        ?>
                                    </div>

                                    <div>
                                        <?php


                                        //Если нет в базе у текущег пользователя записи
                                        if (!$isFriend && !$isFollower && !$isFollowing) {
                                            $follow = "подписаться на пользователя";
                                            ?>
                                            <div class="members-a">

                                                <a data-add-to-following="<?= $user->nickname ?>"
                                                   class="btn btn-success btn-sm addToFollowing">
                                                    <?= $follow ?>
                                                </a>

                                            </div>
                                        <?php }//if

                                        //Если мои подписчики могут добавить в друзья
                                        elseif ($isFollower) {
                                            $follow = "подтвердить друга"; ?>
                                        <div class="members-a">
                                            <a data-add-to-friend="<?= $user->nickname ?>"
                                               class="btn btn-warning btn-sm addToFriends"><?= $follow ?></a>
                                        </div>
                                        <?php } //Если Я подписчик то могу отписаться
                                        elseif ($isFollowing) {
                                            $follow = "отписаться от пользователя"; ?>
                                        <div class="members-a">
                                            <a data-refuse-following="<?= $user->nickname ?>"
                                               class="btn btn-primary btn-sm refuseUserFollowing"><?= $follow ?></a>
                                        </div>
                                        <?php } //Если мы состоим в друзьях,то могу удалить из друзей
                                        elseif ($isFriend) {
                                            $follow = "Удалить из друзей";
                                            ?>
                                            <div class="members-a">
                                                <a class="btn btn-danger btn-sm deleteFromFriends"
                                                   data-delete-from-friend="<?= $user->nickname ?>">
                                                    <?= $follow ?>
                                                </a>
                                            </div>
                                        <?php }//elseif ?>
                                    </div>

                                </div>
                            </div>
                        </li>

                        <li class="clearfix"></li>
                    <?php }//foreach ?>
                </ul>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="confirmFriendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title" id="statusWindowMembers"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="statusUser">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal -->

        <?php get_footer();

    }//else


} else {
    wp_redirect($urls['home'] . '/autorize');
}
