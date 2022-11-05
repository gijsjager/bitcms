<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Users'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">

    <div class="text-center">
        <h1><?= __('Users') ?></h1>
        <p>
            <?= __('Manage all users that have access to this BitCMS.'); ?>
        </P>

        <?= $this->Html->link('<span class="icon s7-plus"></span> ' . __('Add new user'), ['action' => 'add'], [
            'class' => 'btn btn-lg btn-secondary',
            'escape' => false,
        ]); ?>
    </div>

    <div class="panel panel-default mt-5">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('Name') ?></th>
                <th style="width: 350px; text-align: center"><?= __('Actions'); ?></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user){ ?>
                    <tr>
                        <td><?= $user->fullname ?></td>
                        <td><?= $this->Html->link('<span class="icon s7-tools"></span> ' . __('Edit'), ['action' => 'edit', $user->id], ['class' => 'pull-right btn-space btn btn-primary', 'escape' => false]); ?></td>
                    </tr>
                <?php } //endforeach ?>
            </tbody>
        </table>
    </div>
</div>
