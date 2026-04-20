[php]
extension_dir = <?= $c->frankenphp->extensionDir(); ?>


<?php foreach ($c->frankenphp->getExtensions() as $name) { ?>
<?= in_array($name, $c->settings->extensions) ? '' : '; ' ?>extension = <?= $name ?>

<?php } ?>
