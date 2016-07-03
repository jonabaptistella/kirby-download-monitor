<?php

/* Ref 1. http://stackoverflow.com/a/8485963 */
/* Ref 2. http://stackoverflow.com/a/32092523 */

  $path = "../content/downloads/";
  $file = filter_input(INPUT_GET, "id", FILTER_SANITIZE_URL);
  $down = $path . $file;

/* Check if file exists at all */

  if (!file_exists($down)) {

    header("HTTP/1.1 404 Not Found");
    header("Location: /");
    exit();

  } else {

/* Check if download-list exists (also multi-langual, like 'downloads.en.txt' */

    $check = 0;

      foreach (glob($path . "downloads*.txt") as $list) {

        $list = file_get_contents($list);

        if (strpos($list, $file) !== false) {
          $check++;
        }

      }

/* No entries found */

    if ($check < 1) {

      header("HTTP/1.1 404 Not Found");
      header("Location: /");
      exit();

    }

  }

/* All is okay, continue to download */

  $quoted = sprintf("\"%s\"", addcslashes(basename($down), "\"\\"));
  $size = filesize($down);
  $finfo = finfo_open(FILEINFO_MIME_ENCODING);

  header("Content-Description: File Transfer");
  header("Content-Transfer-Encoding: " . finfo_file($finfo, $down));
  header("Connection: Keep-Alive");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Pragma: public");
  header("Content-Length: " . $size);
  header("Content-disposition: attachment; filename=" . $quoted);
  readfile($down);

  exit();

?>