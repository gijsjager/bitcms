<nav class="navbar navbar-full navbar-inverse navbar-fixed-top mai-top-header">
    <div class="container">
        <a href="#" class="navbar-brand">
            <?= $this->Html->image('Bitcms.logo-inv.svg', ['height' => 30]); ?>
        </a>
        <!--Left Menu-->
        <ul class="nav navbar-nav mai-top-nav">
            <li class="nav-item"><?= $this->Html->link('Dashboard', ['controller' => 'Dashboard', 'action' => 'index', 'plugin' => 'Bitcms', 'prefix' => false], ['class' => 'nav-link']); ?></li>
            <li class="nav-item"><?= $this->Html->link(__('My website'), '/', ['class' => 'nav-link']); ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Support'), 'mailto:support@dotbits.nl', ['class' => 'nav-link']); ?></li>
            <li class="nav-item"><?= $this->Html->link(__('SEO'), ['controller' => 'Seo', 'action' => 'index', 'plugin' => 'Bitcms', 'prefix' => false], ['class' => 'nav-link']); ?></li>
        </ul>

        <!--User Menu-->
        <ul class="nav navbar-nav float-lg-right mai-user-nav">
            <li class="dropdown nav-item">
                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle nav-link">
                    <?php
                    if( file_exists( WWW_ROOT . DS . 'uploads' . DS . 'users' . DS . 'user_' . $authUser->id . '.jpg' ) ){
                        echo $this->Html->image('/uploads/users/user_' . $authUser->id . '.jpg');
                    } else {
                        echo $this->Html->image('Bitcms.avatars/img4.jpg');
                    } ?>
                    <span class="user-name"><?= $authUser->fullname; ?></span>
                    <span class="angle-down s7-angle-down"></span>
                </a>
                <div role="menu" class="dropdown-menu">
                    <?= $this->Html->link('<span class="icon s7-user"> </span> ' . __('My Account'), ['controller' => 'Users', 'action' => 'edit', $authUser->id, 'plugin' => 'Bitcms', 'prefix' => false], ['escape' => false, 'class' => 'dropdown-item']); ?>
                    <?php
                    if( $authUser->role == 'admin' ){
                        echo $this->Html->link('<span class="icon s7-users"> </span> ' . __('List users'), ['controller' => 'Users', 'action' => 'index', 'plugin' => 'Bitcms', 'prefix' => false], ['escape' => false, 'class' => 'dropdown-item']);
                        echo $this->Html->link('<span class="icon s7-server"> </span> ' . __('Blueprints'), ['controller' => 'Blueprints', 'action' => 'index', 'plugin' => 'Bitcms', 'prefix' => false], ['escape' => false, 'class' => 'dropdown-item']);
                    }
                    ?>
                    <?= $this->Html->link('<span class="icon s7-trash"> </span> ' . __('Clear cache'), ['controller' => 'Dashboard', 'action' => 'clearCache', 'plugin' => 'Bitcms', 'prefix' => false], ['escape' => false, 'class' => 'dropdown-item']); ?>
                    <?= $this->Html->link('<span class="icon s7-tools"> </span> ' . __('Settings'), ['controller' => 'Settings', 'action' => 'index', 'plugin' => 'Bitcms', 'prefix' => false], ['escape' => false, 'class' => 'dropdown-item']); ?>
                    <?= $this->Html->link('<span class="icon s7-flag"> </span> ' . __('Site texts'), ['controller' => 'Translations', 'action' => 'index', 'plugin' => 'Bitcms', 'prefix' => false], ['escape' => false, 'class' => 'dropdown-item']); ?>
                    <?= $this->Html->link('<span class="icon s7-power"> </span> ' . __('Log out'), ['controller' => 'Users', 'action' => 'logout', 'plugin' => 'Bitcms', 'prefix' => false], ['escape' => false, 'class' => 'dropdown-item']); ?>
                </div>
            </li>
        </ul>
    </div>
</nav>
