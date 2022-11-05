<?php
echo $this->Form->create($language);

echo $this->Form->control('active', ['class' => 'custom-control-input']);
echo '<br/><br/>';
echo $this->Form->control('name');
echo $this->Form->control('abbreviation', ['label' => __('Abbreviation (example: nl)')]);
echo $this->Form->control('locale', ['options' => $locales, 'empty' => __('Choose the correct locale'), 'class' => 'select2']);

echo $this->Form->submit(__('Submit'));
echo $this->Form->end();

echo $this->prepend('css', $this->Html->css(['../dotbits/lib/select2/css/select2.min']));
echo $this->append('script', $this->Html->script(['../dotbits/lib/select2/js/select2.min', '../dotbits/lib/select2/js/select2.full.min']));
?>