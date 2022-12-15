<div class="main-content container">
    <div class="row">
        <div class="col-md-7">

            <div class="widget">
                <div class="widget-head">
                    <span class="title"><?= __('Last added pages'); ?></span>
                </div>

                <div class="widget-body ">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?= __('Page') ?></th>
                                <th class="text-right"><?= __('Action') ?> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pages as $page){ ?>
                            <tr>
                                <td><?= $page->title ?></td>
                                <td class="text-right"><?= $this->Html->link(__('Edit'), ['controller' => 'Pages', 'action' => 'edit', $page->id]); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            if($this->elementExists('dashboard/wide')){
                echo $this->element('dashboard/wide');
            }
            ?>
        </div>

        <div class="col-md-5">

            <!-- Numbers -->
            <div class="widget-indicators">
                <div class="indicator-item">
                    <div class="indicator-item-icon">
                        <div class="icon"><span class="s7-graph1"></span></div>
                    </div>
                    <div class="indicator-item-value">
                        <span data-toggle="counter" data-end="<?= $visitors ?>" class="indicator-value-counter">0</span>
                        <div class="indicator-value-title"><?= __('Total visitors'); ?></div>
                    </div>
                </div>
                <div class="indicator-item">
                    <div class="indicator-item-icon">
                        <div class="icon"><span class="s7-graph"></span></div>
                    </div>
                    <div class="indicator-item-value">
                        <span data-toggle="counter" data-end="<?= $mails ?>" class="indicator-value-counter">0</span>
                        <div class="indicator-value-title"><?= __('Mails received'); ?></div>
                    </div>
                </div>
                <div class="indicator-item">
                    <div class="indicator-item-icon">
                        <div class="icon"><span class="s7-graph3"></span></div>
                    </div>
                    <div class="indicator-item-value">
                        <span data-toggle="counter" data-end="<?= $images ?>" class="indicator-value-counter">0</span>
                        <div class="indicator-value-title">Media on website</div>
                    </div>
                </div>
            </div>
            <!-- ./End Numbers -->

            <!-- Dir size -->
            <div class="usage usage-dark">
                <div class="usage-head"><span class="usage-head-title"><?= __('MB Used'); ?></span>
                </div>
                <div class="usage-resume">
                    <div class="usage-data">
                        <span data-toggle="counter" data-end="<?= $dirsize / 1024 / 1024; ?>" data-decimals="1" data-suffix="MB" class="usage-counter"><?= $this->Number->toReadableSize($dirsize); ?></span>
                        <span class="usage-title"><?= __('Disk space'); ?></span>
                    </div>
                    <div class="usage-icon"><span class="icon s7-timer"></span></div>
                </div>
            </div><!-- ./End Dir size -->


            <?php
            if($this->elementExists('dashboard/small')){
                echo $this->element('dashboard/small');
            }
            ?>
        </div>
    </div>
</div>

<?php $this->assign('script', $this->Html->script([
    'Bitcms.../lib/countup/countUp.min',
    'Bitcms.../js/Controllers/dashboard'
])); ?>
