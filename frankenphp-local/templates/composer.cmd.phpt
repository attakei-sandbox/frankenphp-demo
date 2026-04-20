@echo off
frankenphp php-cli <?= $c->workDir->baseDir ?><?= DIRECTORY_SEPARATOR ?>composer.phar %*
