<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Site texts'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>


<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Site text'); ?></h1>
        <p>
            <?= __('Here you find the static site text. You can translate them! How cool is that!'); ?>
        </p>

        <p>
            <?= __('You are editing this page for the language "<strong class="text-primary">{0}</strong>"', [$language->name]); ?>
        </p>
        <div class="change-language" style="position: relative; display: inline-block">
            <?php
            if (count($languages) > 0) {

                echo $this->Form->button(__('Change language'), ['type' => 'button', 'data-target' => 'langmenu', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true']);
                ?>
                <div class="dropdown-menu" role="menu" id="langmenu">
                    <?php foreach ($languages as $language) {
                        echo $this->Html->link($language->name, [
                            'action' => 'index',
                            '?' => ['language' => $language->abbreviation]
                        ], ['class' => 'dropdown-item']);
                    } ?>
                </div>
                <?php
                echo '</span>';
            }
            ?>
            <br/><br/>
            <?php
            echo $this->Html->link(__('Scan site for translations'), ['action' => 'scan'], ['class' => 'btn btn-secondary']);
            ?>
        </div>
    </div>

    <?php
    if ($is_default) {
        ?>
        <div class="alert alert-info mt-5">
            <?= __('You are viewing the default language. That don\'t need translation does it? Let\'s switch to another language and start translation!') ?>
        </div>
        <?php
    } else {
        ?>
        <div class="panel panel-default mt-5">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th><?= __('Original content') ?></th>
                    <th><?= __('Translated content') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!$translations->all()->isEmpty()) {
                    foreach ($translations as $translation) {
                        ?>
                        <tr>
                            <td class="w-50"><?= $translation->original ?></td>
                            <td><?= $this->Form->control('translations.' . $translation->id . '.content', [
                                    'label' => false,
                                    'placeholder' => __('Place your translation'),
                                    'value' => $translation->content,
                                    'onkeyup' => "submitTranslation(event, $translation->id, this)",
                                    'onblur' => 'store(' . $translation->id . ', this)'
                                ]) ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="2"><div class="alert alert-info">' . __('Wow no translations found yet.') . '</div></td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>

<?php $this->append('script', $this->Html->script([
    'Bitcms.Controllers/translations'
])); ?>
