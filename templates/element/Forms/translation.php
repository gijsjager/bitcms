<?php
echo $this->Form->create($translation);
echo $this->Form->control('template_key');
echo $this->Form->control(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']);
echo $this->Form->end();
