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
                    <li class="nav-item parent <?= ($this->request->getParam('controller') == 'Pages') ? 'open' : '' ?>">
                        <?= $this->Html->link('<span class="icon s7-portfolio"></span><span>'.__('Pages').'</span>', ['controller' => 'Pages', 'action' => 'index'], ['class' => 'nav-link', 'escape' => false, 'role' => 'button']); ?>
                    </li>
                    <li class="nav-item parent <?= ($this->request->getParam('controller') == 'Items') ? 'open' : '' ?>">
                        <?= $this->Html->link('<span class="icon s7-shopbag"></span><span>'.__('Items').'</span>', ['controller' => 'Items', 'action' => 'index'], ['class' => 'nav-link', 'escape' => false, 'role' => 'button']); ?>
                    </li>
                    <li class="nav-item parent <?= ($this->request->getParam('controller') == 'Images') ? 'open' : '' ?>">
                        <?= $this->Html->link('<span class="icon s7-photo-gallery"></span><span>'.__('Media').'</span>', ['controller' => 'Images', 'action' => 'index'], ['class' => 'nav-link', 'escape' => false, 'role' => 'button']); ?>
                    </li>
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