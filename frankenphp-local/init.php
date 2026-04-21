<?php
/**
 * Initialize workspace.
 */
if (count($argv) < 3) {
  // TODO: Display error.
  exit(1);
}

$frankenphp = FrankenPHP::forAqua();
$settings = include(join(DIRECTORY_SEPARATOR, [getcwd(), $argv[2]]));
$workDir = new WorkDir(join(DIRECTORY_SEPARATOR, [getcwd(), $argv[1]]), $frankenphp, $settings);

$workDir->create();


class WorkDir
{
  public string $baseDir;
  public FrankenPHP $frankenphp;
  public stdClass $settings;

  public function __construct(string $baseDir, FrankenPHP $frankenphp, stdClass $settings)
  {
    $this->baseDir = $baseDir;
    $this->frankenphp = $frankenphp;
    $this->settings= $settings;
    if (!file_exists($this->baseDir)) mkdir($this->baseDir, 0777, true);
  }

  public function create()
  {
    // Generate dotenv.
    $_DS = DIRECTORY_SEPARATOR;
    writeTemplate('templates/.env.phpt', join($_DS, [$this->baseDir, '.env']), ['workDir' => $this]);
    // Generate php.ini
    writeTemplate(
      'templates/php.ini.phpt',
      join($_DS, [$this->baseDir, 'php.ini']),
      ['workDir' => $this, 'settings' => $this->settings, 'frankenphp' => $this->frankenphp],
    );
    // Composer executable
    writeTemplate(
      'templates/composer.cmd.phpt',
      join($_DS, [$this->baseDir, '..', 'composer.cmd']),
      ['workDir' => $this],
    );
  }
}


/**
 * FrankenPHPが実在する場所。
 */
class FrankenPHP
{
  protected string $baseDir;

  public static function forAqua(): FrankenPHP
  {
    $binPath = exec('aqua which frankenphp');
    $obj = new static;
    $obj->baseDir = dirname($binPath);
    return $obj;
  }

  public function extensionDir(): string
  {
    return $this->baseDir . DIRECTORY_SEPARATOR . "ext";
  }

  public function getExtensions(): array
  {
    $files = glob($this->extensionDir() . DIRECTORY_SEPARATOR . '*');
    $files = array_map('basename', $files);
    $files = array_map(fn($f) => explode('.', $f)[0], $files);
    return $files;
  }
}

function writeTemplate(string $templatePath, string $outputPath, array $context)
{
  ob_start();
  $c = (object)$context;
  include($templatePath);
  $content = ob_get_contents();
  ob_end_clean();
  file_put_contents($outputPath, $content);
}
