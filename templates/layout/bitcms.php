<?= $this->Element('Bitcms/Html/html_head'); ?>
<body>
    <?= $this->Element('Bitcms/Html/topnav'); ?>
    <?= $this->Element('Bitcms/Html/nav'); ?>

    <div class="mai-wrapper">
        <?= $this->fetch('content'); ?>
    </div>

    <?= $this->Element('Bitcms/Html/translations'); ?>
    <?= $this->Html->script([
        '../dotbits/lib/jquery/jquery.min',
        '../dotbits/lib/jquery-ui/jquery-ui.min',
        '../dotbits/lib/tether/js/tether.min',
        '../dotbits/lib/bootstrap/dist/js/bootstrap.min',
        '../dotbits/lib/jquery.niftymodals/dist/jquery.niftymodals',
        '../dotbits/lib/jquery.confirm/jquery.confirm.min',
        '../dotbits/lib/summernote/dist/summernote.min',
        '../dotbits/lib/summernote/dist/lang/summernote-' . str_replace('_', '-', $language->locale),
        '../dotbits/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min',
        '../dotbits/lib/dropzone/dist/min/dropzone.min',
        '../dotbits/js/bitcms',

    ]); ?>
    <?= $this->fetch('script'); ?>
    <script>
        var maxUploadSize = <?= $maxUploadSize ?>;
        BitCMS.init();
    </script>
</body>
</html>