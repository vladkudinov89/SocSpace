<?php


class AjaxAPI
{

    public static function DeleteFotoFromGallery()
    {

        $result = array();
        $current_user = wp_get_current_user();
        $uplDir = wp_upload_dir();

        $btnDelFoto = filter_input(INPUT_POST, 'btnDelFoto', FILTER_SANITIZE_STRING);

        $photoArray = array();

        $my_post = array();

        $posts = get_posts(array(
            'author' => $current_user->ID,
            'post_type' => 'flats',
            'post_status' => 'publish',
        ));

        /*print_r($posts);*/


        foreach ($posts as $post) {

        }


        $ids = get_posts(
            array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_status' => 'inherit',
                'posts_per_page' => -1,
                'fields' => 'ids',
                /*'ID  '         => array(50),*/
                'author' => $current_user->ID,

            )
        );


        //получаем массив ids gallery
        foreach ($ids as $id) {
            $photoArray[] = $id;
        }


        array_splice($photoArray, array_search($btnDelFoto, $photoArray), 1);

        rsort($photoArray);

        $photoArrayToString = implode(",", $photoArray);

        $my_post['ID'] = $post->ID;
        $my_post['post_content'] = '[gallery size="large" ids="' . $photoArrayToString . '"]';

        wp_delete_attachment($btnDelFoto, true);

// Обновляем данные в БД
        wp_update_post(wp_slash($my_post));

        $result['message'] = $post->ID;
        $result['arrayids'] = $photoArray;

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//DeleteFotoFromGallery

    public static function AddFotoToProfile()
    {
        $result = array();
        $current_user = wp_get_current_user();
        $uplDir = wp_upload_dir();

        $photoID = filter_input(INPUT_POST, 'photoID', FILTER_SANITIZE_STRING);


        $photoArray = array();

        $my_post = array();


        $ids = get_posts(
            array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_status' => 'inherit',
                'posts_per_page' => -1,
                'fields' => 'ids',
                /*'ID  '         => array(50),*/
                'author' => $current_user->ID,

            )
        );


        //получаем массив ids gallery
        foreach ($ids as $id) {
            $photoArray[] = $id;
        }

        if (empty($_FILES)) {
            $result['status'] = 101;
            self::echoDataWithHeader(array(
                'fields' => $result,
                'header' => 'json'
            ));
            exit();
        }


        foreach ($_FILES as $file) {

            if (empty($file)) {
                $result['status'] = 102;
                self::echoDataWithHeader(array(
                    'fields' => $result,
                    'header' => 'json'
                ));
                exit();
            } else {
                $imageType = $file['type'];

                $imageName = $file['name'];

                //$test = array_search($imageName, $)
                if ($imageName) {

                }

                if ($imageType == 'image/jpg' || $imageType == 'image/jpeg' || $imageType == 'image/png') {
                    $saveto = $uplDir['basedir'] . "/photoalbum/photoalbum-$current_user->nickname/" . $file['name'];
                    $viewFoto = $uplDir['baseurl'] . "/photoalbum/photoalbum-$current_user->nickname/" . $file['name'];

                    move_uploaded_file($file['tmp_name'], $saveto);


                    // файл должен находиться в директории загрузок WP.
                    $filename = $saveto;

                    // ID поста, к которому прикрепим вложение.
                    $parent_post_id = $photoID;

                    $mimes = array(
                        'gif' => 'image/gif',
                        'png' => 'image/png',
                        'jpg|jpeg|jpe' => 'image/jpeg'
                    );

                    // Проверим тип поста, который мы будем использовать в поле 'post_mime_type'.
                    $filetype = wp_check_filetype(basename($filename), $mimes);

                    if ($filetype['ext']) {

                        // Получим путь до директории загрузок.
                        $wp_upload_dir = wp_upload_dir();

                        // Подготовим массив с необходимыми данными для вложения.
                        $attachment = array(
                            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
                            'post_mime_type' => $filetype['type'],
                            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );

                        // Вставляем запись в базу данных.
                        $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

                        // Подключим нужный файл, если он еще не подключен
                        // wp_generate_attachment_metadata() зависит от этого файла.
                        require_once(ABSPATH . 'wp-admin/includes/image.php');

                        // Создадим метаданные для вложения и обновим запись в базе данных.
                        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
                        wp_update_attachment_metadata($attach_id, $attach_data);

                        $photoArray[] = $attach_id;

                        rsort($photoArray);

                        $photoArrayToString = implode(",", $photoArray);

                        $my_post['ID'] = $photoID;
                        $my_post['post_content'] = '[gallery size="large" ids="' . $photoArrayToString . '"]';

                        // Обновляем данные в БД
                        wp_update_post(wp_slash($my_post));
                    }


                }//if

                else {
                    $result['status'] = 100;
                    self::echoDataWithHeader(array(
                        'fields' => $result,
                        'header' => 'json'
                    ));
                    exit();
                }
            }


        }//foreach


        $result['result'] = $photoArray;
        $result['name'] = $imageName;

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));


    }//AddFotoToProfile

    public static function EditAvatar()
    {

        $current_user = wp_get_current_user();

        $result = array();

        $PostID = filter_input(INPUT_POST, 'PostID', FILTER_SANITIZE_STRING);

        $uplDir = wp_upload_dir();

        if (isset($_FILES['photo'])) {

            $image = $_FILES['photo'];

            if ($image['size'] > 2000000) {

                $result['status'] = 501;
                $result['message'] = 'Слишком большой размер фото';

                self::echoDataWithHeader(array(
                    'fields' => $result,
                    'header' => 'json'
                ));

                exit();

            } else {

                // Сохраняем тип изображения в переменную
                $imageType = $image['type'];

                if ($imageType == 'image/jpg' || $imageType == 'image/jpeg' || $imageType == 'image/png') {

                    $saveto = $uplDir['basedir'] . "/imageUsers/$current_user->nickname.jpg";
                    $viewFoto = $uplDir['baseurl'] . "/imageUsers/$current_user->nickname.jpg";

                    /*move_uploaded_file($image['tmp_name'], $saveto);

                    update_user_meta($current_user->ID, 'user_image_account', $viewFoto);*/

                    move_uploaded_file($image['tmp_name'], $saveto);


                    // файл должен находиться в директории загрузок WP.
                    $filename = $saveto;

                    // ID поста, к которому прикрепим вложение.
                    $parent_post_id = $PostID;

                    // Проверим тип поста, который мы будем использовать в поле 'post_mime_type'.
                    $filetype = wp_check_filetype(basename($filename), null);

                    // Получим путь до директории загрузок.
                    $wp_upload_dir = wp_upload_dir();

                    // Подготовим массив с необходимыми данными для вложения.
                    $attachment = array(
                        'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
                        'post_mime_type' => $filetype['type'],
                        'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );

                    // Вставляем запись в базу данных.
                    $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

                    // Подключим нужный файл, если он еще не подключен
                    // wp_generate_attachment_metadata() зависит от этого файла.
                    require_once(ABSPATH . 'wp-admin/includes/image.php');

                    // Создадим метаданные для вложения и обновим запись в базе данных.
                    $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
                    wp_update_attachment_metadata($attach_id, $attach_data);

                    set_post_thumbnail($parent_post_id, $attach_id);

                    $result['status'] = 200;
                    /*$result['message'] = 'Фото успешно добалена';*/
                    $result['message'] = 'success';
                }//if

                else {
                    $result['status'] = 204;
                    self::echoDataWithHeader(array(
                        'fields' => $result,
                        'header' => 'json'
                    ));
                    exit();

                }//else

            }//else
        }//if
        else {
            $result['status'] = 500;
            /*$result['message'] = 'Все плохо';*/
            $result['message'] = 'error';
        }

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//EditAvatar

    public static function GetMoreMessages()
    {

        $offset = intval($_POST['offset']);
        $limit = intval($_POST['limit']);
        $uss = filter_input(INPUT_POST, 'userLogin', FILTER_SANITIZE_STRING);


        $current_user = wp_get_current_user();

        $currentUserMessages = get_user_by('login', $uss);

        $args = array(
            'author__in' => array($current_user->ID, $currentUserMessages->ID),
            'order' => 'DESC',
            'number' => $limit,
            'offset' => $offset,
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


        $test = "$currentUserMessages->user_firstname $currentUserMessages->user_lastname";

        foreach ($comments as &$comment) {

            if ($comment->user_id == $current_user->ID) {
                $comment->itsMe = 'yes';
            } else {
                $comment->itsMe = 'no';
                $comment->comment_author = $test;
            }

        }//foreach


        $result['result'] = $comments;
        $result['currentUser'] = $current_user->user_login;
        $result['$currentUserMessages'] = $currentUserMessages->user_firstname;


        $JSONProducts = json_encode($result);

        print_r($JSONProducts);
        exit();

    }//GetMoreMessages

    public static function UserRegistration()
    {
        $result = array();
        $arrayUser = array();
        $uplDir = wp_upload_dir();

        $userLogin = filter_input(INPUT_POST, 'nameRegistr', FILTER_SANITIZE_STRING);
        $user_firstName = filter_input(INPUT_POST, 'firstnameRegistr', FILTER_SANITIZE_STRING);
        $user_secondName = filter_input(INPUT_POST, 'lastnameRegistr', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'emailRegistr', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'passRegistr', FILTER_SANITIZE_STRING);

        if (mb_strlen($user_firstName) > 14) {
            $result['status'] = 5;
            $result['message'] = 'Слишком длинное имя';
            echo json_encode($result);
            exit();
        }

        if (mb_strlen($user_secondName) > 15) {
            $result['status'] = 6;
            $result['message'] = 'Слишком длинная фамилия';
            echo json_encode($result);
            exit();
        }

        function checkEmail($email)
        {
            if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
                return true;
            }
            return false;
        }

        if (checkEmail($email) == false) {
            $result['status'] = 100;
            $result['message'] = 'Некорректный email';
        } else {
            if (!empty($userLogin) && !empty($email) && !empty($password)) {

                //Проверяем есть ли еще такой пользователь
                $user_login = username_exists($userLogin);
                $user_email = email_exists($email);


                //Если совпадений нет
                if ($user_login == null && $user_email == null) {

                    /*update_user_meta($current_user->ID, 'first_name', "$user_edit_name");*/

                    $user_login = wp_create_user($userLogin, $password, $email);

                    update_user_meta($user_login, 'first_name', "$user_firstName");
                    update_user_meta($user_login, 'last_name', "$user_secondName");

                    add_user_meta($user_login, 'user_image_account', $uplDir['baseurl'] . "/imageUsers/no_image.jpg");
                    add_user_meta($user_login, 'user_friends', $arrayUser, false);
                    add_user_meta($user_login, 'user_followers', $arrayUser, false);
                    add_user_meta($user_login, 'user_following', $arrayUser, false);

                    //Date of Birth User
                    add_user_meta($user_login, 'user_dayBirth', '', false);
                    add_user_meta($user_login, 'user_monthBirth', '', false);
                    add_user_meta($user_login, 'user_yearBirth', '', false);

                    add_user_meta($user_login, 'user_country', '', false);
                    add_user_meta($user_login, 'user_city', '', false);

                    //Создаем папку Фотогаллереи в uplode для текущего профиля
                    wp_mkdir_p($uplDir['basedir'] . "/photoalbum/photoalbum-$userLogin/");

                    //Создаем пост с фотогаллерей текущего пользователя
                    $argInsertPost = array(
                        'post_status' => 'publish',
                        'post_type' => 'flats',
                        'post_author' => $user_login,
                        'post_title' => "Галерея пользователя $user_firstName $user_secondName"

                    );
                    $post_id = wp_insert_post($argInsertPost);

                    //Устанавливаем начальное фото для пользователя
                    set_post_thumbnail($post_id, 64);

                    /*
                                        //Создаем пост с записями на стене текущего пользователя
                                        $argInsertPostWall = array(
                                            'post_status' => 'publish',
                                            'post_type' => 'user-wall',
                                            'post_author' => $user_login,
                                            'post_title' => "Записи со стены $user_firstName $user_secondName"

                                        );
                                        $post_wall = wp_insert_post($argInsertPostWall);*/


                    //Если есть ошибки при проверки user_id
                    if (is_wp_error($user_login)) {
                        $result['status'] = 300;
                        $result['message'] = $user_login->get_error_message();
                        $result['code'] = $user_login->get_error_code();


                    }//if
                    else {
                        $result['status'] = 200;
                        $result['message'] = 'Пользователь успешно добален';
                    }//else

                }//if
                else {
                    $result['status'] = 500;
                    if ($user_login) {
                        $result['message'] = 'Пользователь с таким логином уже существует.';
                        $result['user_login'] = 1;
                    } else {
                        $result['message'] = 'Пользователь с такой почтой уже существует.';
                        $result['user_email'] = 1;
                    }

                    /*$result['code_email'] = $email->get_error_code();*/
                }//else


            }//if
            else {

                if (empty($password)) {
                    $result['status'] = 600;
                    $result['message'] = 'Пароль не заполнен';
                }

                if (empty($userLogin)) {
                    $result['status'] = 700;
                    $result['message'] = 'Логин не заполнен';
                }

                if (empty($email)) {
                    $result['status'] = 800;
                    $result['message'] = 'Email не заполнен';
                }


                /* $result['status'] = 400;
                 $result['message'] = 'Одно из полей не заполненное';*/
            }//else
        }


        echo json_encode($result);
        exit();

    }//UserRegistration

    public static function UserAuthorize()
    {
        $result = array();

        $creds = array();

        $creds['user_login'] = filter_input(INPUT_POST, 'nameAuthorize', FILTER_SANITIZE_STRING);
        $creds['user_password'] = filter_input(INPUT_POST, 'passAuthorize', FILTER_SANITIZE_STRING);

        if (!empty($creds['user_login']) && !empty($creds['user_password'])) {

            $user = wp_signon($creds, false);

            if (is_wp_error($user)) {
                $result['status'] = 300;
                $result['message'] = $user->get_error_message();
                $result['code'] = $user->get_error_code();
            }//if
            else {
                $result['status'] = 200;
                $result['message'] = 'Вы успешно авторизировались';
            }//else

        }//if
        else {

            if (empty($creds['user_login'])) {
                $result['status'] = 401;
                $result['message'] = 'Заполните Имя';
                echo json_encode($result);
                exit();
            }
            if (empty($creds['user_password'])) {
                $result['status'] = 402;
                $result['message'] = 'Заполните пароль';
                echo json_encode($result);
                exit();
            }

        }//else


        echo json_encode($result);
        exit();

    }//UserAuthorize

    public static function DeleteUserProfile()
    {

        $result = array();

        $current_user = wp_get_current_user();


        $del = wp_delete_user($current_user->ID);


        if ($del) {
            $result['status'] = 200;
            $result['message'] = "Пользователь удален";
        } else {
            $result['status'] = 300;
            $result['message'] = "Пользователь не удален";
        }

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

        /*echo json_encode($result);
        exit();*/

    }//DeleteUserProfile

    public static function UserEditProfile()
    {

        $current_user = wp_get_current_user();

        $result = array();

        $user_edit_name = filter_input(INPUT_POST, 'user_edit_name', FILTER_SANITIZE_STRING);
        $user_edit_secondName = filter_input(INPUT_POST, 'user_edit_secondName', FILTER_SANITIZE_STRING);
        $edit_textAbout = filter_input(INPUT_POST, 'edit_textAbout', FILTER_SANITIZE_STRING);

        $day = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_STRING);
        $month = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_STRING);
        $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_STRING);

        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);

        update_user_meta($current_user->ID, 'first_name', "$user_edit_name");
        update_user_meta($current_user->ID, 'last_name', "$user_edit_secondName");
        update_user_meta($current_user->ID, 'description', "$edit_textAbout");

        update_user_meta($current_user->ID, 'user_dayBirth', $day);
        update_user_meta($current_user->ID, 'user_monthBirth', $month);
        update_user_meta($current_user->ID, 'user_yearBirth', $year);

        update_user_meta($current_user->ID, 'user_country', $country);
        update_user_meta($current_user->ID, 'user_city', $city);

        $result['status'] = 200;
        $result['message'] = 'Данные успешно обновились';

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//UserEditProfile

    public static function SearchUser()
    {

        $result = array();

        $searchFriend = filter_input(INPUT_POST, 'searchFriend', FILTER_SANITIZE_STRING);

        $result['search'] = $searchFriend;

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));
    }//SearchUser

    public static function GetAllFriends()
    {

        $result = array();

        $allFriends = get_users();

        $JSONProducts = json_encode($allFriends);

        if ($JSONProducts) {
            $result['status'] = 200;
            $result['message'] = 'Данные успешно обновились';
        } else {
            $result['status'] = 500;
            $result['message'] = 'Данные не обновились';
        }

        self::echoDataWithHeader(array(
            'fields' => $JSONProducts,
            'header' => 'json'
        ));


    }//GetAllFriends


    //добавление пользователя в свои подписки
    public static function AddToFollowing()
    {

        $result = array();

        $AddUserToFollowing = filter_input(INPUT_POST, 'AddUserToFollowing', FILTER_SANITIZE_STRING);

        $current_user = wp_get_current_user();
        $userFollowing = $current_user->user_following;

        $userOperation = get_user_by('login', $AddUserToFollowing);
        $userActionFollowers = $userOperation->user_followers;

        $userFollowing[] = $AddUserToFollowing;
        $userActionFollowers[] = $current_user->user_login;

        //добавляем пользователя в following у текущего пользователя
        update_user_meta($current_user->ID, 'user_following', $userFollowing);

        //добавляем текущего пользователя у пользователя в followers
        update_user_meta($userOperation->ID, 'user_followers', $userActionFollowers);

        $result['status'] = 200;
        $result['following'] = $AddUserToFollowing;

        $result['following_firstName'] = $userOperation->first_name;
        $result['following_lastName'] = $userOperation->user_lastname;


        $result['message'] = 'Данные успешно обновились';

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//AddToFollowing

    public static function RefuseUserFollowing()
    {

        $result = array();

        $RefuseUserFollowing = filter_input(INPUT_POST, 'RefuseFollowing', FILTER_SANITIZE_STRING);

        $current_user = wp_get_current_user();
        $userFollowing = $current_user->user_following;

        $userOperation = get_user_by('login', $RefuseUserFollowing);
        $userActionFollowers = $userOperation->user_followers;

        //удаляем пользователя в following у текущего пользователя
        if (in_array($RefuseUserFollowing, $userFollowing)) {

            array_splice($userFollowing, array_search($RefuseUserFollowing, $userFollowing), 1);
            update_user_meta($current_user->ID, 'user_following', $userFollowing);

        }//if

        //удаляем текущего пользователя у пользователя в followers
        if (in_array($current_user->user_login, $userActionFollowers)) {

            array_splice($userActionFollowers, array_search($current_user->user_login, $userActionFollowers), 1);
            update_user_meta($userOperation->ID, 'user_followers', $userActionFollowers);

        }//if

        $result['status'] = 200;
        $result['following'] = $RefuseUserFollowing;

        $result['followingRef_firstName'] = $userOperation->first_name;
        $result['followingRef_lastName'] = $userOperation->user_lastname;

        $result['message'] = 'Данные успешно обновились';

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//RefuseUserFollowing

    //Подтвеждаю переход из подписчика в ДРУЗЬЯ
    public static function ConfirmFriend()
    {

        $result = array();

        $AddFriend = filter_input(INPUT_POST, 'addUserToFriend', FILTER_SANITIZE_STRING);

        $current_user = wp_get_current_user();

        $userOperation = get_user_by('login', $AddFriend);
        $userOperationID = $userOperation->ID;
        $userOperationLogin = $userOperation->user_login;

        //meta текущего пользователя
        $userFriends = $current_user->user_friends;
        $userFollowers = $current_user->user_followers;

        //meta пользователя с которым происходят события
        $userActionFriends = $userOperation->user_friends;
        $userActionFollowers = $userOperation->user_followers;
        $userActionFollowing = $userOperation->user_following;

        $userFriends[] = $AddFriend;
        $userActionFriends[] = $current_user->user_login;

        //я подтверждаю добавление друга из своего подписчика
        if (update_user_meta($current_user->ID, 'user_friends', $userFriends)) {

            //Убираю пользователя из follower-ов текущего пользователя
            if (in_array($AddFriend, $userFollowers)) {

                array_splice($userFollowers, array_search($AddFriend, $userFollowers), 1);
                update_user_meta($current_user->ID, 'user_followers', $userFollowers);

            }//if

            //удаляю из following себя у пользователя,которого добавляю
            if (in_array($current_user->user_login, $userActionFollowing)) {

                array_splice($userActionFollowing, array_search($current_user->user_login, $userActionFollowing), 1);
                update_user_meta($userOperationID, 'user_following', $userActionFollowing);

            }//if

            //добаляю текущего пользователя в друзья у моего подписчика
            update_user_meta($userOperationID, 'user_friends', $userActionFriends);


            $result['status'] = 200;
            $result['friend_firstName'] = $userOperation->first_name;
            $result['friend_lastName'] = $userOperation->user_lastname;
            $result['array'] = $userOperation->user_login;
            $result['message'] = 'Данные успешно обновились';
        } else {
            $result['status'] = 500;
            $result['message'] = 'Данные не обновились';
        }


        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));


    }//ConfirmFriend

    //Удаление ДРУГА
    public static function DeleteFromUser()
    {

        $result = array();

        $DeleteFromFriend = filter_input(INPUT_POST, 'deleteUserFromFriend', FILTER_SANITIZE_STRING);

        $current_user = wp_get_current_user();

        $userOperation = get_user_by('login', $DeleteFromFriend);

        //meta текущего пользователя
        $userFriends = $current_user->user_friends;

        //meta пользователя с которым происходят события
        $userActionFriends = $userOperation->user_friends;

        //необходимо удалить пользователя из друзей у текущего пользователя
        if (in_array($userOperation->user_login, $userFriends)) {

            array_splice($userFriends, array_search($userOperation->user_login, $userFriends), 1);
            update_user_meta($current_user->ID, 'user_friends', $userFriends);

        }//if

        //необходимо удалить текущего пользователя из друзей у пользователя
        if (in_array($current_user->user_login, $userActionFriends)) {

            array_splice($userActionFriends, array_search($current_user->user_login, $userActionFriends), 1);
            update_user_meta($userOperation->ID, 'user_friends', $userActionFriends);

        }//if

        $result['status'] = 200;
        $result['deleteFriend_firstName'] = $userOperation->user_firstname;
        $result['deleteFriend_secondName'] = $userOperation->last_name;
        $result['deleteFriend'] = $userOperation->user_login;
        $result['message'] = 'Данные успешно обновились';


        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));
    }//DeleteFromUser

    public static function AddToFriend()
    {

        $result = array();

        $AddFriend = filter_input(INPUT_POST, 'addUserToFriend', FILTER_SANITIZE_STRING);

        $current_user = wp_get_current_user();

        $userFriends = $current_user->user_friends;
        $userFollowers = $current_user->user_followers;

        $userFriends[] = $AddFriend;

        if (update_user_meta($current_user->ID, 'user_friends', $userFriends)) {

            if (in_array($AddFriend, $userFollowers)) {

                array_splice($userFollowers, array_search($AddFriend, $userFollowers), 1);
                update_user_meta($current_user->ID, 'user_followers', $userFollowers);

                /* $result['answ'] = "я есть в мете!!!";*/

            }//if

            $result['status'] = 200;
            $result['friend'] = $AddFriend;
            /*$result['array'] = $userFollowers;*/
            $result['message'] = 'Данные успешно обновились';
        } else {
            $result['status'] = 500;
            $result['message'] = 'Данные не обновились';
        }


        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));


    }//AddToFriend

    public static function AddMessageWall()
    {
        $result = array();

        $current_user = wp_get_current_user();

        $inputRecipientWall = filter_input(INPUT_POST, 'inputRecipientWall', FILTER_SANITIZE_STRING);
        $messageWall = filter_input(INPUT_POST, 'wallMessage', FILTER_SANITIZE_STRING);

        $newMessageWallID = wp_insert_comment(array(

            'comment_author' => $current_user->user_login,
            'comment_content' => $messageWall,
            'comment_karma' => 1,
            'user_id' => $current_user->ID,
            'comment_meta' => array(
                'recipientWall' => $inputRecipientWall
            )

        ));

        if ($newMessageWallID === 0) {
            $result['status'] = 500;
            $result['message'] = 'Проблемы с отправкой сообщения!!!';
        } else {
            $result['status'] = 200;
            $result['message'] = 'Сообщение отправлено';
        }

        echo json_encode($result);
        exit();

    }//AddMessage

    public static function AddMessage()
    {
        $result = array();

        $current_user = wp_get_current_user();

        $inputRecipient = filter_input(INPUT_POST, 'inputRecipient', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'inputMessage', FILTER_SANITIZE_STRING);

        $newMessageID = wp_insert_comment(array(

            'comment_author' => $current_user->user_login,
            'comment_content' => $message,
            'comment_karma' => 1,
            'user_id' => $current_user->ID,
            'comment_meta' => array(
                'recipient' => $inputRecipient
            )

        ));

        if ($newMessageID === 0) {
            $result['status'] = 500;
            $result['message'] = 'Проблемы с отправкой сообщения!!!';
        } else {
            $result['status'] = 200;
            $result['message'] = 'Сообщение отправлено';
        }

        echo json_encode($result);
        exit();

    }//AddMessage

    public static function countMessages(){

        $result = array();

        $promResultCount = array();
        $resultCount = array();

        $current_user = wp_get_current_user();

        $argAllMessageIns = array(
            'order' => 'DESC',
            'meta_key' => 'recipient',
            'meta_value' => $current_user->user_login,
        );

        $resAllMessageIns = get_comments($argAllMessageIns);

        foreach ($resAllMessageIns as $resAllMessageIn) {
            $promResultCount[] = $resAllMessageIn->comment_author;

        }

        $resultCountUserMes = array_unique($promResultCount);

        $result['message'] = $resultCountUserMes;

        foreach ($resultCountUserMes as $res2) {

            $userDialog = get_user_by('login', $res2);

            $argsCount = array(
                'number' => 1,
                'author__in' => $userDialog->ID,
                'karma' => 1,
                'order' => 'DESC',
                'meta_key' => 'recipient',
                'meta_value' => $current_user->user_login,
            );

            $commentsCount = get_comments($argsCount);

            foreach ($commentsCount as $commentCount){
                $resultCount[] = $commentCount->comment_karma == 1;
                //$result['message'] = $test;
            }

        }

        if (!empty($resultCount)) {
            $result['status'] = 200;
            $result['count'] = count($resultCount);
            //$result['count'] = $commentsCount;

            //$result['comments'] = $comments2;
            //$result['user'] = intval($idRecToUpdateMes);
        }
        else{
            $result['status'] = 300;
            $result['count'] = 0;
        }





        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//countMessages

    public static function updateMessage()
    {

        $result = array();

        $countMessage = array();

        $idRecToUpdateMes = filter_input(INPUT_POST, 'idRecToUpdateMes', FILTER_SANITIZE_STRING);

        $current_user = wp_get_current_user();

        $args2 = array(
            'author__in' => intval($idRecToUpdateMes),
            'karma' => 1,
            'order' => 'DESC',
            'meta_key' => 'recipient',
            'meta_value' => $current_user->user_login,
        );

        $comments2 = get_comments($args2);

        /*foreach ($comments2 as $countMes){
            $countMessage[] = ;
        }*/

        /*$result['user'] = intval($idRecToUpdateMes);*/

        if (!empty($comments2)) {
            $result['status'] = 200;
            $result['message'] = 'Перезагрузить надо страницу';
            //$result['comments'] = $comments2;
            //$result['user'] = intval($idRecToUpdateMes);
        }

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//updateMessage

    public static function GoToFriendMessage()
    {
        $result = array();

        $messageFriend = filter_input(INPUT_POST, 'messageFriend', FILTER_SANITIZE_STRING);

        $current_user = wp_get_current_user();

        $userDialog = get_user_by('login', $messageFriend);

        $argsMes = array(
            'author__in' => $userDialog->ID,
            'order' => 'DESC',
            'comment_karma' => 1,
            'meta_key' => 'recipient',
            'meta_value' => $current_user->user_login,
        );

        $getNewMessage = get_comments($argsMes);

        $commentarr = array();

        foreach ($getNewMessage as $test) {
            $commentarr['comment_ID'] = $test->comment_ID;
            $commentarr['comment_karma'] = 0;
            wp_update_comment($commentarr);
        }

        $result['status'] = 200;
        $result['message'] = 'Сообщение прочитано';
        $result['friend'] = $messageFriend;

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//GoToFriendMessage

    public static function DeleteMsgFromWall()
    {

        $result = array();

        $deleteMsgWall = filter_input(INPUT_POST, 'deleteMsgWall', FILTER_SANITIZE_STRING);
        /* $a = intval($deleteMsg);*/
        $test = wp_delete_comment($deleteMsgWall);

        if ($test) {
            $result['status'] = 200;
            $result['delMessage'] = $deleteMsgWall;
            $result['message'] = 'Успешно удалено';
        } else {
            $result['status'] = 500;
            $result['message'] = 'Сообщение не удалено';
        }

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//DeleteMsgFromWall

    public static function DeleteMsgFromChat()
    {

        $result = array();

        $deleteMsg = filter_input(INPUT_POST, 'deleteMsg', FILTER_SANITIZE_STRING);
        /* $a = intval($deleteMsg);*/
        $test = wp_delete_comment($deleteMsg);

        if ($test) {
            $result['status'] = 200;
            $result['delMessage'] = $deleteMsg;
            $result['message'] = 'Успешно удалено';
        } else {
            $result['status'] = 500;
            $result['message'] = 'Сообщение не удалено';
        }

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//DeleteMsgFromChat

    public
    static function AddFeedback()
    {
        $result = array();
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

        $newPostID = wp_insert_post(array(

            'post_title' => $name,
            'post_type' => 'feedback',
            'post_content' => $phone,
            'post_author' => 1,
            'post_status' => 'publish'

        ));

        if ($newPostID === 0) {
            $result['status'] = 500;
            $result['message'] = 'Не возможно оставить заявку';
        } else {
            $result['status'] = 200;
            $result['message'] = 'Заявка успешно получена';
        }

        echo json_encode($result);
        exit();

    }//AddFeedback

    public
    static function echoDataWithHeader($data)
    {

        header("Content-Type: application/json");

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Allow-Headers: application/json');

        if (isset($data['fields']) && isset($data['header']) && $data['header'] == 'json') {
            echo json_encode($data['fields']);
        }//if
        else if (isset($data['fields'])) {
            echo $data['fields'];
        }//else
        else {
            echo json_encode(array());
        }//else


        exit();

    }

    public
    static function RegisterApiAction($action)
    {
        add_action("wp_ajax_$action", array('AjaxAPI', $action));
        add_action("wp_ajax_nopriv_$action", array('AjaxAPI', $action));
    }//RegisterApiAction


    public
    static function GetMenu()
    {

        $args = array(
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'output' => ARRAY_A,
            'output_key' => 'menu_order',
            'update_post_term_cache' => false,
        );

        $items = wp_get_nav_menu_items('Главное меню', $args);

        $menu = array();

        foreach ($items as $itemMenu) {

            $menu[] = array(
                'id' => $itemMenu->ID,
                'title' => $itemMenu->title
            );

        }//foreach

        $result = array();

        $result['status'] = 200;
        $result['menuItems'] = $menu;

        self::echoDataWithHeader(array(
            'fields' => $result,
            'header' => 'json'
        ));

    }//GetMenu


}