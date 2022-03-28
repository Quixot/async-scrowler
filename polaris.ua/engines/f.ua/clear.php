<?php
/**
 * Удаляет файлы из папки content
 */
  if (file_exists('/var/www/polaris.ua/engines/f.ua/content/')) {
    foreach (glob('/var/www/polaris.ua/engines/f.ua/content/*') as $file) {
      unlink($file);
    }
  }
