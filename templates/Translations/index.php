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
            <br/><br/>
            <?php
            echo $this->Html->link(__('Add new translation'), ['action' => 'add'], ['class' => 'btn btn-secondary']);
            ?>
        </div>
    </div>

    <div class="panel panel-default mt-5">
        <table class="table table-hover table-condensed">
            <thead>
            <tr>
                <th style="width: 100px;"><?= __('Template key') ?></th>
                <?php
                foreach ($allLanguages as $language) {
                    echo '<th>' . $language->name . '</th>';
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($translations)) {
                foreach ($translations as $key => $group) {
                    ?>
                    <tr>
                        <td style="width: 100px; overflow: hidden;">
                            <?php
                            if ($authUser->email === 'gijsjager@gmail.com') {
                                echo $this->Form->create(null, ['url' => ['action' => 'delete'], 'type' => 'post']);
                                echo $this->Form->control('template_key', ['value' => $key, 'type' => 'hidden']);
                                echo $this->Form->button('<i class="icon s7-trash"></i>', ['class' => 'btn btn-xs btn-danger', 'escapeTitle' => false]);
                                echo $this->Form->end();
                            }
                            ?>

                            <code class="text-truncate overflow-hidden w-100" title="<?= strip_tags($key) ?>">
                                <?= $this->Text->Truncate(strip_tags($key), 30) ?>
                            </code>


                        </td>
                        <?php
                        foreach ($allLanguages as $language) {
                            $found = false;
                            foreach($group as $t){
                                if($t->locale === $language->locale){
                                    $found = $t;
                                    break;
                                }
                            }
                            ?>
                            <td>
                                <?= $this->Form->control('translation_' . strip_tags($key) . '_' . $language->locale, [
                                    'label' => false,
                                    'type' => 'textarea',
                                    'rows' => 1,
                                    'placeholder' => $language->name . ' not yet translated',
                                    'value' => !empty($found) ? $found->content : '',
                                    'onkeyup' => "submitTranslation(event, '{$key}', this)",
                                    'data-locale' => $language->locale,
                                    'onblur' => "store('{$key}', this)",
                                    'templates' => [
                                        'inputContainer' => '{{content}}',
                                    ]
                                ]) ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td><div class="alert alert-info">' . __('Wow no translations found yet.') . '</div></td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->append('script', $this->Html->script([
    'Bitcms.Controllers/translations'
])); ?>
