<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (!empty($seo_title)) ? $seo_title : $this->fetch('title') ?></title>

    <?php
    if (!empty($seo_description)) {
        $this->Html->meta('description', $seo_description);
    } ?>

    <!-- Favicon -->
    <?= $this->Html->meta('icon') ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $this->Url->build('/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $this->Url->build('/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $this->Url->build('/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?php echo $this->Url->build('/site.webmanifest'); ?>">
    <link rel="mask-icon" href="<?php echo $this->Url->build('/safari-pinned-tab.svg'); ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#d5ffff">
    <meta name="theme-color" content="#68b3de">
    <!-- ./End Favicon -->

    <?= $this->Html->meta('author', 'Dotbits') ?>
    <?= $this->Html->meta('robots', (strpos($_SERVER['HTTP_HOST'], 'dev') === false) ? 'index, follow' : 'noindex, nofollow') ?>

    <?= $this->Html->css([
        'bootstrap.min',
        '../js/libs/slick/slick.min',
        '../js/libs/fancybox/jquery.fancybox.min',
        'main'
    ]); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="<?= strtolower($this->getRequest()->getParam('controller')) ?> <?= strtolower($this->getRequest()->getParam('action')) ?> <?= 'page-' . ((!empty($page->id)) ? $page->id : 0) ?>">

<div class="cover"></div>
<?= $this->Element('nav') ?>
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<?= $this->Element('footer') ?>


<script>var d = '<?= $this->Url->build('/', ['fullBase' => true]); ?>';</script>
<?php
echo $this->Html->script([
'vendor/jquery-1.11.2.min.js',
'vendor/bootstrap.min.js',
'vendor/classie.js',
'vendor/pace.min.js',
'vendor/isotope.pkgd.min.js',
'vendor/jquery.velocity.min.js',
'vendor/textslide.js',
'vendor/imagesloaded.pkgd.min.js',
'vendor/jquery.kenburnsy.min.js',
'vendor/tabs.js',
'vendor/ef-slider.js',
'vendor/owl.carousel.min.js',
'vendor/jquery.magnific-popup.min.js',
'vendor/jquery.social-buttons.min.js',
'vendor/wow.min.js',
'main',
])
?>
</body>
</html>
