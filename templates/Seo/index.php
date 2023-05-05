<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Seo'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>


<div class="main-content container">
    <div class="text-center">
        <h1><?= __('SEO'); ?></h1>
        <p>
            <?= __('Manage / start some awesome SEO tools'); ?>
        </p>

    </div>


    <div class="row mt-5">

        <div class="col-sm-6">
            <!-- Languages -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= __('Images'); ?>
                    <?= $this->Html->link(__('Set alt text'), ['action' => 'images'], ['class' => 'btn btn-secondary', 'style' => 'float: right']); ?>
                </div>
                <div class="panel-body">
                    <?= __('There are <b>{0} image(s)</b> without alt-text', [$this->Number->format($images)]); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <!-- Languages -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= __('Pages'); ?>
                    <?= $this->Html->link(__('Set page titles'), ['action' => 'pages'], ['class' => 'btn btn-secondary', 'style' => 'float: right']); ?>
                </div>
                <div class="panel-body">
                    <?= __('There are <b>{0} page(s)</b> without SEO title or description', [$this->Number->format($pages)]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
