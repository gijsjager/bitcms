<div class="header">
    <div class="container">
        <div class="logo">
            <?= $this->Html->link($this->Html->image('logo.svg', ['style' => 'height: 30px; width: auto;', 'alt' => 'Dotbits logo']), '/', ['escape' => false]); ?>
        </div>

        <!-- Menu Hamburger (Default) -->
        <button class="main-menu-indicator" id="open-button">
            <span class="line"></span>
        </button>

        <div class="menu-wrap" style="background-image: url('<?= $this->Url->build('img/nav_bg.jpg')?>')">
            <div class="menu-content">
                <div class="navigation">
                    <span class="pe-7s-close close-menu" id="close-button"></span>
                </div>
                <nav class="menu">
                    <div class="menu-list">
                        <ul>
                        <?php foreach ($menu as $menuItem) { ?>
                            <li class="menu-item <?php if( !empty($menuItem->child_pages) ) echo 'has-submenu'; ?>">
                                <?= $this->Html->link($menuItem->title, $menuItem->slug, ['class' => 'main-nav-item' . (!empty($menuItem->child_pages)) ? ' has-submenu' : '']); ?>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                </nav>

                <div class="hidden-xs">
                    <div class="menu-social-media">
                        <ul>
                            <li><a href="https://www.facebook.com/gijsjager13"><i class="iconmoon-facebook"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/gijsjager/"><i class="iconmoon-linkedin2"></i></a></li>
                        </ul>
                    </div>

                    <div class="menu-information">
                        <ul>
                            <li><span>E:</span> mail@dotbits.nl</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Menu Hamburger (Default) -->

    </div>
</div>


