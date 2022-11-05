<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<div role="alert" class="alert alert-success alert-dismissible">
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
        <span aria-hidden="true" class="s7-close"></span>
    </button>
    <span class="icon s7-check"></span>
    <strong><?= __('Allrighty!'); ?></strong> <?= $message ?>
</div>
