<?php get_header();

$urls = GetTemplatePath(); ?>

            <!-- Main content -->
            <section class="content container ">


                <div class="col-sm-offset-3 col-sm-6">

                    <div class="form-box">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Авторизация пользователя</h3>
                                <p>Введите логин и пароль для входа</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div role="form" class="authorize-form">
                                <div class="form-group">
                                    <span class="empty_loginInput">Введите логин</span>
                                    <span class="empty_loginAuth">Неверный логин</span>
                                    <span class="empty_emailAuth">Неверный email</span>

                                    <label class="sr-only" for="form-username">Логин</label>
                                    <input type="text" name="form-username" placeholder="Логин пользователя..." class="form-username form-control" id="nameAuthorize">

                                </div>
                                <div class="form-group">
                                    <span class="empty_passInput">Введите пароль</span>
                                    <span class="empty_passAuth">Неверный пароль</span>

                                    <label class="sr-only" for="form-password">Пароль</label>
                                    <input type="password" name="form-password" placeholder="Пароль..." class="form-password form-control" id="passAuthorize">
                                </div>
                                <button type="submit" id="autorizeUser" class="btn btn-authorization">Войти</button>
                                <a href="<?php echo $urls['template'];?>/registration" class="btn btn-registration">Регистрация</a>
                            </div>
                        </div>
                    </div>


                </div>


            </section>
            <!-- /.content -->









<?php get_footer(); ?>