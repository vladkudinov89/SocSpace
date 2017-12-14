<?php

$urls = GetTemplatePath();

if (is_user_logged_in()) {
    get_header();

    ?>

    <?php $page = "page-gallery";
    require_once 'left-menu.php';
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Ваши фотографии
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->


            <?php


            $posts = get_posts(array(
                'author' => $current_user->ID,
                'post_type' => 'flats',
                'post_status' => 'publish',
            ));

            //print_r($posts);


            foreach ($posts as $post) {

                $post->post_content = strip_shortcodes($post->post_content);

                $gallery = get_post_gallery($post->ID, false);

                //print_r($gallery);

                $piece = explode(",", $gallery['ids']);

                //print_r($piece);


                ?>

                <h4>Добавить фото</h4>
                <button data-postid="<?= $post->ID ?>" id="open_btn" class="btn btn-sm btn-primary">Выберите файлы <i
                            class="fa fa-plus" aria-hidden="true"></i></button>

                <?php
            } ?>


            <div class="popup-gallery gallery-m-top">
                <?php

                if ($gallery) {
                    $i = 0;

                foreach ($gallery['src'] as $image) { ?>
                    <div  class="col-xs-12 col-sm-6 col-md-4 gallery-user-img" >

                        <div class="foto_delete" data-id="<?php echo $piece[$i] ?>">
                            <i class="fa fa-times " aria-hidden="true"></i>
                        </div>

                        <a href="<?php echo $image; ?>" class="thumbnail">
                            <img src="<?php echo $image; ?>" class="" style="height: 150px;">
                        </a>

                    </div>

                <?php $i++; }//gallery['src'] ?>
            </div>
        <?php }//gallery ?>

            <!-- Modal -->
            <div class="modal fade" id="delFotoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Удалить фото</h4>
                        </div>
                        <div class="modal-body">
                            <div>
                                Вы действительно хотите удалить фото?
                            </div>
                            <div>
                                Отменить это действие будет невозможно.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-sm btn-primary del_foto_from_gallery">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->


    </section>
    <!-- /.content -->

    </div>

    <!-- Modal -->
    <div class="modal fade" id="successAddFoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Фото добавлены</h4>
                </div>
                <div class="modal-body">
                    <div>
                        Фото успешно добавлены!
                    </div>
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Ok</button>
                </div>-->
            </div>
        </div>
    </div>
    <!-- END Modal -->

    <!-- Modal -->
    <div class="modal fade" id="errorAddFoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Ошибка добавления фото</h4>
                </div>
                <div class="modal-body">
                    <div>
                        Загружаемые файлы неверного формата
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->

    <!-- Modal -->
    <div class="modal fade" id="emptyAddFoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Ошибка добавления фото</h4>
                </div>
                <div class="modal-body">
                    <div>
                        Выберите фото для загрузки
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->


    <?php get_footer();

} else {
    wp_redirect($urls['home'] . '/autorize');
}
