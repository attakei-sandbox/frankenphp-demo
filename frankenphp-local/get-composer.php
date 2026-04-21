<?php

if (count($argv) < 1) {
  // TODO: Display error.
  exit(1);
}
$installDir = $argv[1];
$composerPath = join(DIRECTORY_SEPARATOR, [$installDir, 'composer.phar']);
$installerPath = join(DIRECTORY_SEPARATOR, [$installDir, 'composer-setup.php']);

if (file_exists($composerPath)) {
  return;
}
copy('https://getcomposer.org/installer', $installerPath);

if (
  hash_file('sha384', $installerPath)
  ===
  'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47'
) {
  echo 'Installer verified'.PHP_EOL;
} else {
  echo 'Installer corrupt'.PHP_EOL;
  unlink($installerPath);
  return;
}
exec(join(' ', [
  'frankenphp',
  'php-cli',
  $installerPath,
  "--install-dir={$installDir}",
]));
unlink($installerPath);
