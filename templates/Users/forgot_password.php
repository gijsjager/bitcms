<div class="mai-wrapper mai-forgot-password">
    <div class="main-content container">
        <div class="splash-container row">
            <div class="col-sm-6 user-message"><span class="splash-message text-right"><?= __('Oops!<br> this will take<br> just a moment.'); ?></span></div>
            <div class="col-sm-6 form-message">
                <?= $this->Html->image('Bitcms.logo-inv.svg', ['alt' => 'Dotbits logo', 'style' => 'fill: white; height: 50px;', 'class' => 'logo-img mb-2']); ?>
                <span class="splash-description text-center mt-5 mb-5"><?= __('Don\'t worry, we\'ll send you an email to reset your password.'); ?></span>

                <?php
                echo $this->Form->create();
                echo $this->Form->control('email', ['type' => 'email', 'label' => false, 'placeholder' => __('Email'), 'prepend' => '<i class="icon s7-mail"></i>']);
                echo '<p class="contact mt-4">'.__('Don\'t remember your email?').' ' . $this->Html->link(__('Contact support'), 'support@dotbits.nl') . '.</p>';

                echo $this->Form->submit(__('Reset password'), ['class' => 'btn btn-lg btn-primary btn-block mb-4']);

                echo $this->Flash->render();
                ?>

                <div class="out-links"><a href="#">© <?= date('Y'); ?> DotBits</a></div>
            </div>
        </div>
    </div>
</div>
