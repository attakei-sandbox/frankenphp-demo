<?php
/*
 * Generate php.ini for installed FrankenPHP env.
 */

class FrankenPHP {
  const array ENABLE_EXTENSIONS = [
    "openssl",
  ];

  protected string $baseDir;

  public static function forAqua(): FrankenPHP {
    $binPath = exec('aqua which frankenphp');
    $obj = new static;
    $obj->baseDir = dirname($binPath);
    return $obj;
  }

  public function extensionDir(): string {
    return $this->baseDir . DIRECTORY_SEPARATOR . "ext";
  }

  public function getExtensions(): array {
    $files = glob($this->extensionDir() . DIRECTORY_SEPARATOR . '*');
    $files = array_map('basename', $files);
    $filter = function($filename) {
      return array_any($this::ENABLE_EXTENSIONS, fn($ext) => str_contains($filename, $ext));
    };
    return array_combine($files, array_map($filter, $files));
  }
}

function createIniContent(string $templatePath, FrankenPHP $franken): string {
  ob_start();
  include($templatePath);
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}

$options = array_slice($argv, 1);
$franken = FrankenPHP::forAqua();
file_put_contents($options[0], createIniContent("generate-ini.template", $franken));
