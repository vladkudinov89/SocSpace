<?php
$urls = GetTemplatePath(); ?>

<!--Left side column . contains the logo and sidebar-->
<aside class="main-sidebar">

    <!--sidebar: style can be found in sidebar . less-->
    <section class="sidebar">

        <!--Sidebar user panel(optional)-->
        <div class="user-panel user-data">
            <div class="pull-left image">
                <img src="<?php echo GetMainAvatar($current_user,'thumbnail'); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $current_user->first_name?> <?= $current_user->last_name ?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <div class="aside-form">
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Поиск...">
                    <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
                </div>
            </form>
        </div>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- Optionally, you can add icons to the links -->
            <li <?= ($page == 'page-profile') ? "class='active'" : "";  ?>><a href="<?php echo $urls['home'];?>/profile"><i class="fa  fa-address-card-o"></i> <span>Профиль</span></a></li>
            <li <?= ($page == 'page-messages') ? "class='active'" : "";  ?> ><a href="<?php echo $urls['home'];?>/messages"><i class="fa fa-envelope"></i>
                    <span>Сообщения</span>
                </a>
            </li>
            <li <?= ($page == 'page-gallery') ? "class='active'" : "";  ?> >
                <a gallery href="<?php echo $urls['home'];?>/gallery"><i class="fa fa-camera" aria-hidden="true"></i> <span>Фотографии</span></a>
            </li>
            <li <?= ($page == 'page-friends' || $page == 'page-all_friends') ? "class='active'" : "";  ?>  class="treeview">
                <a href="#"><i class="fa fa-user-o"></i> <span>Друзья</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    <li <?= ($page == 'page-all_friends') ? "class='active'" : "";  ?> ><a href="<?php echo $urls['home'];?>/all_friends">Все пользователи</a></li>
                    <li <?= ($page == 'page-friends') ? "class='active'" : "";  ?> ><a href="<?php echo $urls['home'];?>/friends">Мои друзья</a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

