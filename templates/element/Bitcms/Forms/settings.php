<?php
echo $this->Form->create($setting);
echo $this->Form->control('title');
echo $this->Form->control('value');
echo $this->Form->control('info');
echo $this->Form->button(__('Submit'));
echo $this->Form->end();