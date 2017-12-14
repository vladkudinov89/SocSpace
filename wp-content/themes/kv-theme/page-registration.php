<?php get_header();

$urls = GetTemplatePath(); ?>


    <!-- Main content -->
    <section class="content container-fluid">

        <!--<div class="col-md-3 text-center">

                <div class='form-group text-bold'>Логин</div>
                <div class="form-group">
                    <input type='text' maxlength='16' id='nameRegistr' name="nameRegistr">
                </div>

                <div class='form-group text-bold'>Email</div>
                <div class="form-group">
                    <input type='text' maxlength='30' id='emailRegistr' name="emailRegistr">
                </div>

                <div class='form-group text-bold'>Пароль</div>
                <div class="form-group">
                    <input type='password' maxlength='16' id='passRegistr' name="passRegistr">
                </div>
                <div class="form-group">
                    <input type='submit' id="registrUser" class="btn btn-primary" value='Зарегистрироваться'>
                </div>


        </div>-->

        <div class="col-sm-offset-3 col-sm-6">

            <div class="form-box">
                <div class="form-top">
                    <div class="form-top-left">
                        <h3>Регистрация пользователя</h3>
                        <p>Заполните поля для регистрации пользователя</p>
                    </div>
                    <div class="form-top-right">
                        <i class="fa fa-pencil"></i>
                    </div>
                </div>
                <div class="form-bottom">
                    <div role="form" class="registration-form">
                        <div class="form-group">
                            <span class="empty_loginReg">Заполните логин</span>
                            <span class="error_loginReg">Логин уже занят</span>

                            <label class="sr-only"  for="form-login">Логин</label>
                            <input type="text" required  name="form-login" placeholder="Логин..."
                                   class="form-first-name form-control" id="nameRegistr">
                        </div>
                        <div class="form-group">
                            <span class="empty_firstNameReg">Заполните Имя</span>
                            <label class="sr-only" for="form-firstname">Имя</label>
                            <input type="text" required  name="form-firstname" placeholder="Имя..."
                                   class="form-last-name form-control" id="firstnameRegistr">
                        </div>
                        <div class="form-group">
                            <span class="empty_secondNameReg">Заполните Фамилию</span>
                            <label class="sr-only" for="form-lastname">Фамилия</label>
                            <input type="text" required  name="form-lastname" placeholder="Фамилия..."
                                   class="form-last-name form-control" id="lastnameRegistr">
                        </div>
                        <div class="form-group">
                            <span class="empty_emailReg">Заполните Email</span>
                            <span class="error_emailReg">Email уже занят</span>
                            <span class="invalid_emailReg">Некорректный формат Email</span>

                            <label class="sr-only" for="form-email">Email</label>
                            <input type="text" required  name="form-email" placeholder="Email..." class="form-email form-control"
                                   id="emailRegistr">
                        </div>
                        <div class="form-group">
                            <span class="empty_passwordReg">Заполните Пароль</span>
                            <label class="sr-only" for="form-email">Пароль</label>
                            <input type="password" required  name="form-email" placeholder="Пароль..."
                                   class="form-email form-control" id="passRegistr">
                        </div>

                        <button type="submit" id="registrUser" class="btn btn-registration">Зарегистрироваться</button>
                        <a style="margin-top: 10px;" href="<?php echo $urls['template'];?>/autorize" class="btn btn-authorization">Авторизация</a>
                    </div>
                </div>
            </div>

        </div>


    </section>

    <!-- Modal ErrorLongNameModal-->
    <div class="modal fade" id="ErrorLongNameModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Ошибка регистрации</h4>
                </div>
                <div class="modal-body">
                    <div>
                        Извините, но Ваше Имя должно быть не более 14 символов
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">ОК</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->

    <!-- Modal ErrorLongSecondNameModal-->
    <div class="modal fade" id="ErrorLongSecondNameModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Ошибка регистрации</h4>
                </div>
                <div class="modal-body">
                    <div>
                        Извините, но Ваша Фамилия должна быть не более 15 символов
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">ОК</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->


<?php

get_footer(); ?>