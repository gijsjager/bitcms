<?php
echo $this->Form->create($user);

echo $this->Form->control('role', ['options' => [
    'user' => __('User'),
    'admin' => __('Admin')
]]);


echo $this->Form->control('username');
echo $this->Form->control('fullname');
echo $this->Form->control('email');

echo '<br/>';
echo $this->Form->control('new_password', ['type' => 'password']);
echo $this->Form->control('repeat_new_password', ['type' => 'password']);

echo $this->Form->submit(__('Submit'));
echo $this->Form->end();
?>