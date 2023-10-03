<?php
echo $this->Form->create($language);

echo $this->Form->control('active', ['class' => 'custom-control-input']);

echo '<div title="'.__('Only the site builder is alowed to change this value. Otherwise the website will break.').'" style="opacity: 0.25">';
echo $this->Form->control('is_default', [
    'class' => 'custom-control-input',
    'disabled' => true,
]);
echo '</div>';
echo '<br/><br/>';
echo $this->Form->control('name');
echo $this->Form->control('abbreviation', ['label' => __('Abbreviation (example: nl)')]);
echo $this->Form->control('locale', ['options' => $locales, 'empty' => __('Choose the correct locale'), 'class' => 'select2']);

echo $this->Form->submit(__('Submit'));
echo $this->Form->end();

$this->prepend('css', $this->Html->css(['Bitcms.../lib/select2/css/select2.min']));
$this->append('script', $this->Html->script(['Bitcms.../lib/select2/js/select2.min', 'Bitcms.../lib/select2/js/select2.full.min']));

