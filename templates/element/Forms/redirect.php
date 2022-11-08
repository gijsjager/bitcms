<?php
echo $this->Form->create($redirect);
echo $this->Form->control('from_url');
echo $this->Form->control('to_url');
echo $this->Form->control('type', ['options' => [301 => '301 - moved permanent', 302 => '302 - moved temporarily']]);
echo $this->Form->button(__('Submit'));
echo $this->Form->end();