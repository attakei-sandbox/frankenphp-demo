<?php

return (object)[
  /** 有効にするPHP拡張 */
  'extensions' => [
    // Composerに必要
    'php_openssl',
    // Laravelのセットアップに必要
    'php_fileinfo',
    'php_curl',
    'php_mbstring',
    'php_sqlite3',
  ],
];
