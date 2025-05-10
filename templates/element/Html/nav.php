<nav class="navbar mai-sub-header">
    <div class="container">
        <!-- Mega Menu structure-->
        <nav class="navbar navbar-toggleable-sm">
            <button type="button" data-toggle="collapse" data-target="#mai-navbar-collapse"
                    aria-controls="#mai-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler hidden-md-up collapsed">
                <div class="icon-bar"><span></span><span></span><span></span></div>
            </button>
            <div id="mai-navbar-collapse" class="navbar-collapse collapse mai-nav-tabs">
                <ul class="nav navbar-nav">
                    <li class="nav-item parent <?= ($this->request->getParam('controller') == 'Dashboard') ? 'open' : '' ?>">
                        <?= $this->Html->link(
                            '<span class="icon s7-home"></span><span>' . __('Home') . '</span>',
                            ['controller' => 'Dashboard', 'action' => 'index', 'plugin' => 'Bitcms', 'prefix' => false],
                            ['class' => 'nav-link', 'escape' => false, 'role' => 'button']); ?>
                    </li>

                    <?php
                    if (!empty($bitcms['modules'])) {
                        foreach ($bitcms['modules'] as $module) {
                            if (!empty($module['subItems'])){
                                $isActive = false;
                                foreach($module['subItems'] as $subItem) {
                                    // for blueprints we also need to check the id
                                    if ($this->request->getParam('controller') == $subItem['route']['controller']) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            } elseif (!empty($module['route']['controller'])) {
                                $isActive = $this->request->getParam('controller') === $module['route']['controller'];
                            }
                            ?>
                            <li class="nav-item parent <?= $isActive ? 'open' : '' ?>">
                                <?= $this->Html->link(
                                    '<span class="icon s7-' . $module['icon'] . '"></span><span>' . $module['title'] . '</span>',
                                    !empty($module['subItems']) ? $module['subItems'][0]['route'] : $module['route'],
                                    ['class' => 'nav-link', 'escape' => false, 'role' => 'button']); ?>

                                <?php
                                if (!empty($module['subItems'])) {
                                    ?>
                                    <ul class="mai-nav-tabs-sub mai-sub-nav nav">
                                        <?php
                                        foreach ($module['subItems'] as $subItem) {
                                            if (!empty($subItem['route']['controller']) && $subItem['route']['controller'] === 'Items'){
                                                $isActive = $this->request->getParam('controller') == $subItem['route']['controller'] && $this->request->getParam('action') == 'index' && $this->request->getParam('pass')[0] == $subItem['route'][0];
                                            } else {
                                                $isActive = $this->request->getParam('controller') == $subItem['route']['controller'] && $this->request->getParam('action') == $subItem['route']['action'];
                                            }
                                            ?>
                                            <li class="nav-item <?= $isActive ? 'active' : '' ?>">
                                                <?= $this->Html->link(
                                                    '<span class="icon s7-' . $subItem['icon'] . '" style="font-size: 1.5rem"></span><span class="name">' . $subItem['title'] . '</span>',
                                                    $subItem['route'],
                                                    ['class' => 'nav-link ' . ($isActive ? 'active' : ''), 'escape' => false, 'role' => 'button']
                                                ); ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                    <?php
                                }
                                ?>

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
            <input type="text" placeholder="<?= __('Search...'); ?>" value="<?= $this->request->getQuery('q'); ?>"
                   name="q"><span class="s7-search"></span>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</nav>
