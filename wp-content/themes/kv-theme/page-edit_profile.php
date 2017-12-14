<?php

$urls = GetTemplatePath();

if (is_user_logged_in()) {
    get_header();

    ?>

    <?php $page = "page-profile";
    require_once 'left-menu.php';

    $current_user = wp_get_current_user();




    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Редактирование профиля
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->


            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-margin">
                <li class="active"><a href="#mainUserData" data-toggle="tab">Основное</a></li>
                <li><a href="#editAvatar" data-toggle="tab">Аватарка</a></li>
                <li><a href="#security" data-toggle="tab">Безопасность</a></li>
            </ul><!--/.nav-tabs-->

            <div class="tab-content">

                <div class="tab-pane fade in active" id="mainUserData">


                    <div class="form-group">
                        <div class="text-bold">Ваше Имя:</div>
                        <input type="text" required name="user_edit_name" id="user_edit_name"
                               value="<?= $current_user->first_name ?>">
                    </div>
                    <div class="form-group">
                        <div class="text-bold">Ваша Фамилия:</div>
                        <input type="text" name="user_edit_secondName" id="user_edit_secondName"
                               value="<?= $current_user->last_name ?>">
                    </div>

                    <div class="form-group">

                        <div class="text-bold">Дата рождения:</div>
                        <select name="day" id="day"></select>
                        <select name="month" id="month" ></select>
                        <select name="year" id="year" ></select>
                        <input type="hidden" name="hour" size="2" value="" >
                        <input type="hidden" name="minute" size="2" value="" >

                    </div>

                    <div class="form-group">
                        <div class="text-bold">Страна:</div>
                        <input type="text" id="country" placeholder="Страна" value="<?php echo $current_user->user_country?>">
                    </div>

                    <div class="form-group">
                        <div class="text-bold">Город:</div>
                        <input type="text" id="city" placeholder="Город" value="<?php echo $current_user->user_city ?>">
                    </div>

                    <div class="form-group">
                        <div class="text-bold">О себе:</div>
                        <textarea class="about-me" name='text' id="edit_textAbout" cols='50'
                                  rows='3'><?= $current_user->description ?></textarea>
                    </div>


                    <div class="form-group">
                        <input class="btn btn-success" id="edit-profile" value='Сохранить'>
                    </div>


                </div>

                <div class="tab-pane fade" id="editAvatar">

                    <div class="col-md-4">


                        <div class="">

                            <img src="<?php echo GetMainAvatar($current_user,'medium'); ?>"
                                 class="message-img-left img-width img-bordered" alt="User Image" >
                        </div>

                        <div class="text-bold ">Выбрать изображение:</div>
                        <div class="file-upload form-group">
                            <!--<div class="text-bold">Выбрать изображение:</div>-->
                            <label>
                                <input type="file" id="edit_image_profile">
                                <span>Выберите файл</span>
                            </label>


                        </div>


                    </div>

                </div>

                <div class="tab-pane fade" id="security">

                    <div class="margin-bottom">
                        <h3>Удалить профиль</h3>
                        <button class="btn btn-danger btn-sm" id="deleteProfileButton">Удалить профиль</button>
                    </div>
                    <div>
                        <h3>Сменить пароль</h3>
                        <div>
                            <input type="text">
                        </div>
                        <br>
                        <br>
                        <div>
                            <input type="text">
                        </div>

                    </div>
                </div>

            </div><!--/.tab-content-->


            <!-- Modal -->
            <div class="modal fade" id="editUserAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close clear_avatar" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Редактирование Аватарки</h4>
                        </div>
                        <div class="modal-body">

                            <div id="progressbar-5">
                                <div class="progress-label">
                                    Загрузка фото...
                                </div>
                            </div>

                            <div class="image-preview">
                                <img class="img-thumbnail img_preview" id="preview" src="" alt="">
                            </div>
                        </div>
                        <div id="result">
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="edit_avatar" data-avaidpost="<?php echo getPostID($current_user);?>"
                                    class="btn btn-sm btn-primary disabled">Сменить
                                аватарку
                            </button>
                            <button type="button" class="btn btn-sm btn-danger clear_avatar" data-dismiss="modal">
                                Отменить
                            </button>

                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->

            <!-- Modal -->
            <div class="modal fade" id="successEditUserData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close clear_avatar" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Успешно сохранено</h4>
                        </div>
                        <div class="modal-body">

                            <h3>Данные успешно обновились!</h3>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                                ОК
                            </button>

                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->

            <!-- Modal -->
            <div class="modal fade" id="deleteUserAction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close clear_avatar" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Удаление профиля</h4>
                        </div>
                        <div class="modal-body">

                            <h4>Вы действительно хотите удалить пользователя?</h4>


                        </div>

                        <div class="modal-footer">
                            <button type="button" id="delete_userProfile" class="btn btn-sm btn-danger">Удалить
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                                Отменить
                            </button>

                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->

            <!-- Modal -->
            <div class="modal fade" id="ErrorAvtrFormat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close clear_avatar" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Ошибка Фото</h4>
                        </div>
                        <div class="modal-body">

                            <h4>Неверный формат фото. Попробуйте еще раз</h4>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                                ОК
                            </button>

                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->

            <!-- Modal -->
            <div class="modal fade" id="ErrorBigAvtr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <button type="button" class="close clear_avatar" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Ошибка Фото</h4>
                        </div>
                        <div class="modal-body">

                            <h4>Размер фото должен быть меньше 2мб</h4>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                                ОК
                            </button>

                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>-->
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

