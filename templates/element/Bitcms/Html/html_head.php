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
        '../dotbits/lib/stroke-7/style',
        '../dotbits/lib/perfect-scrollbar/css/perfect-scrollbar.min',
        '../dotbits/lib/dropzone/dist/min/dropzone.min',
        '../dotbits/lib/dropzone/dist/min/basic.min',
        '../dotbits/lib/summernote/dist/summernote',
        '../dotbits/css/animate.min',
        '../dotbits/css/app.min',
        '../dotbits/css/themes/blue-sky.min',
        '../dotbits/css/extension.min',
    ]); ?>
    <script>
        var d = '<?= $this->Url->build('/bitcms', ['fullBase' => true]); ?>';
        var locale = '<?= $language->locale; ?>';
    </script>

</head>