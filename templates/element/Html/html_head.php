<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitCMS ✮ <?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <meta name="robots" content="noindex,nofollow" />

    <?= $this->fetch('css'); ?>
    <?= $this->Html->css([
        'Bitcms.../lib/stroke-7/style',
        'Bitcms.../lib/perfect-scrollbar/css/perfect-scrollbar.min',
        'Bitcms.../lib/dropzone/dist/min/dropzone.min',
        'Bitcms.../lib/dropzone/dist/min/basic.min',
        'Bitcms.../lib/jquery.gritter/css/jquery.gritter',
        'Bitcms.../lib/summernote/summernote.min',
        'Bitcms.animate.min',
        'Bitcms.app.min',
        'Bitcms.themes/blue-sky.min',
        'Bitcms.extension.min',
        'Bitcms.bitcms',
    ]); ?>
    <script>
        var d = '<?= $this->Url->build('/bitcms', ['fullBase' => true]); ?>';
        var locale = '<?= $language->locale; ?>';
    </script>

    <?php
    echo $this->Html->scriptBlock(sprintf(
        'var csrfToken = %s;',
        json_encode($this->request->getAttribute('csrfToken'))
    ));
    ?>

</head>
