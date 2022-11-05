<?= $this->Element('Bitcms/Html/html_head'); ?>
<body>
    <?= $this->fetch('content'); ?>
    <?= $this->Html->script([
        '../dotbits/lib/jquery/jquery.min',
        '../dotbits/lib/tether/js/tether.min',
        '../dotbits/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min',
        '../dotbits/lib/bootstrap/dist/js/bootstrap.min',
    ]); ?>
    <?= $this->fetch('script'); ?>
</body>
</html>