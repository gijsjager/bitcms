<?= $this->Element('Bitcms.Html/html_head'); ?>
<body>
    <?= $this->fetch('content'); ?>
    <?= $this->Html->script([
        'Bitcms.../lib/jquery/jquery.min',
        'Bitcms.../lib/tether/js/tether.min',
        'Bitcms.../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min',
        'Bitcms.../lib/bootstrap/dist/js/bootstrap.min',
    ]); ?>
    <?= $this->fetch('script'); ?>
</body>
</html>
