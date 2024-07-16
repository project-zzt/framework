#!/usr/bin/php -q
<?php

/**
* Listen to file changes and display all chirps
* 
* @author Cristian Cornea <contact@corneascorner.dev>
*/
$file = 'chirp_log.txt';

if (!file_exists($file)) {
  echo "Log file doen't exist";
  return 0;
}
$currentTime = null;
$lastUpdate = filemtime($file);

// Print present chirps
$log = fopen($file, 'r');
while (!feof($log)) {
  echo fread($log, filesize($file));
}
fclose($log);

// Listen for incoming chirps
$exit = false;
while (!$exit) {
  // simple fps limit to not go overkill
  sleep(1);
  clearstatcache();

  if ($currentTime = filemtime($file) <= $lastUpdate) {
    continue;
  }
  $lastUpdate = $currentTime;

  $log = fopen($file, 'a+');
  echo fread($log, filesize($file));
  fclose($log);
}

function print_line()
{
}
