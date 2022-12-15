<?= $this->Element('Bitcms.Html/html_head'); ?>
<body>
    <?= $this->Element('Bitcms.Html/topnav'); ?>
    <?= $this->Element('Bitcms.Html/nav'); ?>

    <div class="mai-wrapper">
        <?= $this->fetch('content'); ?>
    </div>

    <?= $this->Element('Bitcms.Html/translations'); ?>
    <?= $this->Html->script([
        'Bitcms.../lib/jquery/jquery.min',
        'Bitcms.../lib/jquery-ui/jquery-ui.min',
        'Bitcms.../lib/tether/js/tether.min',
        'Bitcms.../lib/bootstrap/dist/js/bootstrap.min',
        'Bitcms.../lib/jquery.niftymodals/dist/jquery.niftymodals',
        'Bitcms.../lib/jquery.confirm/jquery.confirm.min',
        'https://cdn.tiny.cloud/1/cw4bbpeug2opvjev9470zihvyoqr9pmn9figavyuvzsz2cu3/tinymce/6/tinymce.min.js',
        'Bitcms.../lib/summernote/dist/summernote.min',
        'Bitcms.../lib/summernote/dist/lang/summernote-' . str_replace('_', '-', $language->locale),
        'Bitcms.../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min',
        'Bitcms.../lib/dropzone/dist/min/dropzone.min',
        'Bitcms.bitcms',

    ]); ?>
    <?= $this->fetch('script'); ?>
    <script>
        var maxUploadSize = <?= $maxUploadSize ?>;
        BitCMS.init();
    </script>
</body>
</html>
