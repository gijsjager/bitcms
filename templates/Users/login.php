<div class="mai-wrapper mai-login">
    <div class="main-content container">
        <div class="splash-container row">
            <div class="col-sm-6 user-message"><span class="splash-message text-right"><?= __('Hello!<br> is good to<br> see you again'); ?></span></div>
            <div class="col-sm-6 form-message">
                <?= $this->Html->image('Bitcms.logo-inv.svg', ['alt' => 'Dotbits logo', 'style' => 'fill: white; height: 50px;', 'class' => 'logo-img mb-2']); ?>
                <span class="splash-description text-center mt-5 mb-5"><?= __('Login to your account'); ?></span>

                <?php
                echo $this->Form->create();
                echo $this->Form->control('username', ['autocomplete' => 'off', 'label' => false, 'placeholder' => __('Username'), 'prepend' => '<i class="icon s7-user"></i>']);
                echo $this->Form->control('password', ['autocomplete' => 'off', 'label' => false, 'placeholder' => __('Password'), 'prepend' => '<i class="icon s7-lock"></i>']);
                echo $this->Form->submit('Login', ['class' => 'btn btn-primary btn-lg btn-block mb-40']);
                ?>

                <div class="form-group row login-tools mt-3">
                    <div class="col-6 login-remember">
                        <label class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" name="remember" class="custom-control-input"><span class="custom-control-indicator"></span><span class="custom-control-description">Remember me</span>
                        </label>
                    </div>
                    <div class="col-6 pt-2 text-right login-forgot-password">
                        <?= $this->Html->link(__('Forgot password?'), ['action' => 'forgotPassword']); ?>
                    </div>
                </div>
                <?php
                echo $this->Form->end();
                echo $this->Flash->render();
                ?>

                <div class="out-links"><a href="#">© <?= date('Y') ?> DotBits</a></div>
            </div>
        </div>
    </div>
</div>
