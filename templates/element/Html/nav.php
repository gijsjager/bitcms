<nav class="navbar mai-sub-header">
    <div class="container">
        <!-- Mega Menu structure-->
        <nav class="navbar navbar-toggleable-sm">
            <button type="button" data-toggle="collapse" data-target="#mai-navbar-collapse" aria-controls="#mai-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler hidden-md-up collapsed">
                <div class="icon-bar"><span></span><span></span><span></span></div>
            </button>
            <div id="mai-navbar-collapse" class="navbar-collapse collapse mai-nav-tabs">
                <ul class="nav navbar-nav">
                    <li class="nav-item parent <?= ($this->request->getParam('controller') == 'Dashboard') ? 'open' : '' ?>">
                        <?= $this->Html->link('<span class="icon s7-home"></span><span>'.__('Home').'</span>', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'nav-link', 'escape' => false, 'role' => 'button']); ?>
                    </li>

                    <?php
                    if(!empty($bitcms['modules'])){
                        foreach($bitcms['modules'] as $module){ ?>
                            <li class="nav-item parent <?= ($this->request->getParam('controller') == $module['controller']) ? 'open' : '' ?>">
                                <?= $this->Html->link(
                                    '<span class="icon s7-'.$module['icon'].'"></span><span>'.$module['title'].'</span>',
                                    ['controller' => $module['controller'], 'action' => 'index'],
                                    ['class' => 'nav-link', 'escape' => false, 'role' => 'button']); ?>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </nav>
        <!--Search input-->
        <?= $this->Form->create(null, ['type' => 'get']); ?>
        <div class="search">
            <input type="text" placeholder="<?= __('Search...'); ?>" value="<?= $this->request->getQuery('q'); ?>" name="q"><span class="s7-search"></span>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</nav>
