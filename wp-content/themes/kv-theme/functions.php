<?php


function GetTemplatePath()
{
    return array(
        'template' => get_template_directory_uri(),
        'home' => get_home_url()

    );
}//GetTemplatePath

function GetAvatar($current_user)
{
    return $user_account_image = get_user_meta($current_user->ID, 'user_image_account');
}//GetAvatar

function GetCurrentUser($current_user)
{
    return $user_account_image = get_user_meta($current_user->ID, 'user_image_account');
}//GetCurrentUser

function GetMainAvatar($current_user, $size)
{
    $thumb_id1 = "";
    $postsAva = get_posts(array(
        'author' => $current_user->ID,
        'post_type' => 'flats',
        'post_status' => 'publish',
    ));

    foreach ($postsAva as $post1) {
        $thumb_id1 = get_the_post_thumbnail_url($post1->ID, $size);
        //echo $thumb_id1;
    }
    return $thumb_id1;
}//GetAvatar

function getPostID($current_user)
{

    $idPost = 0;
    $postsAva = get_posts(array(
        'author' => $current_user->ID,
        'post_type' => 'flats',
        'post_status' => 'publish',
    ));

    foreach ($postsAva as $postID) {
        $idPost = $postID->ID;
    }
    return $idPost;
}//getPostID


$argAdmin = array(
    'role' => 'administrator'
);

$adminRole = get_users($argAdmin);

$current_user = wp_get_current_user();
$user_account_image = get_user_meta($current_user->ID, 'user_image_account');


function getMonth($month)
{
    switch ($month) {
        case 1:
            echo "января";
            break;
        case 2:
            echo "февраля";
            break;
        case 3:
            echo "марта";
            break;
        case 4:
            echo "апреля";
            break;
        case 5:
            echo "мая";
            break;
        case 6:
            echo "июня";
            break;
        case 7:
            echo "июля";
            break;
        case 8:
            echo "августа";
            break;
        case 9:
            echo "сентября";
            break;
        case 10:
            echo "октября";
            break;
        case 11:
            echo "ноября";
            break;
        case 12:
            echo "декабря";
            break;
    }
}

