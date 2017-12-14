<?php
/**
 *
 * plugin name: otdelkovo
 * author     : Web-16-3d
 */

require_once 'AjaxAPI.php';

add_action('init', 'register_post_types');

AjaxAPI::RegisterApiAction('AddFeedback');
AjaxAPI::RegisterApiAction('GetFlats');
AjaxAPI::RegisterApiAction('GetMenu');
AjaxAPI::RegisterApiAction('UserRegistration');
AjaxAPI::RegisterApiAction('UserAuthorize');
AjaxAPI::RegisterApiAction('UserEditProfile');
AjaxAPI::RegisterApiAction('EditAvatar');
AjaxAPI::RegisterApiAction('ConfirmFriend');
AjaxAPI::RegisterApiAction('DeleteFromUser');
AjaxAPI::RegisterApiAction('AddToFollowing');
AjaxAPI::RegisterApiAction('RefuseUserFollowing');
AjaxAPI::RegisterApiAction('SearchUser');
AjaxAPI::RegisterApiAction('AddMessage');
AjaxAPI::RegisterApiAction('GoToFriendMessage');
AjaxAPI::RegisterApiAction('DeleteMsgFromChat');
AjaxAPI::RegisterApiAction('GetMoreMessages');
AjaxAPI::RegisterApiAction('AddFotoToProfile');
AjaxAPI::RegisterApiAction('updateMessage');
AjaxAPI::RegisterApiAction('DeleteUserProfile');
AjaxAPI::RegisterApiAction('DeleteFotoFromGallery');
AjaxAPI::RegisterApiAction('AddMessageWall');
AjaxAPI::RegisterApiAction('DeleteMsgFromWall');
AjaxAPI::RegisterApiAction('countMessages');




function register_post_types(){

    register_post_type('feedback', array(
        'label'  => 'flats',
        'labels' => array(
            'name'               => 'feedback', // основное название для типа записи
            'singular_name'      => 'feedback', // название для одной записи этого типа
            'add_new'            => 'Добавить', // для добавления новой записи
            'add_new_item'       => 'Добавление', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование', // для редактирования типа записи
            'new_item'           => 'Новое ____', // текст новой записи
            'view_item'          => 'Смотреть страницу', // для просмотра записи этого типа.
            'search_items'       => 'Искать ____', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Обратная связь', // название меню
        ),
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => null,
        'exclude_from_search' => null,
        'show_ui'             => true,
        'show_in_menu'        => true, // показывать ли в меню адмнки
        'show_in_admin_bar'   => true, // по умолчанию значение show_in_menu
        'show_in_nav_menus'   => null,
        'show_in_rest'        => null, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array(),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ) );

    register_post_type('flats', array(
        'label'  => 'flats',
        'labels' => array(
            'name'               => 'flats', // основное название для типа записи
            'singular_name'      => 'flat', // название для одной записи этого типа
            'add_new'            => 'Добавить фото', // для добавления новой записи
            'add_new_item'       => 'Добавление фото', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование фото', // для редактирования типа записи
            'new_item'           => 'Новое ____', // текст новой записи
            'view_item'          => 'Смотреть страницу', // для просмотра записи этого типа.
            'search_items'       => 'Искать ____', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Фотогаллерея', // название меню
        ),
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => null,
        'exclude_from_search' => null,
        'show_ui'             => true,
        'show_in_menu'        => true, // показывать ли в меню адмнки
        'show_in_admin_bar'   => true, // по умолчанию значение show_in_menu
        'show_in_nav_menus'   => null,
        'show_in_rest'        => null, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array(),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ) );

    add_theme_support( 'post-thumbnails', array( 'flats' ) );

}//register_post_types