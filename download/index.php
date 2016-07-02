<?php

/* Ref 1. http://stackoverflow.com/a/8485963 */
/* Ref 2. http://stackoverflow.com/a/32092523 */

  $path = "../content/downloads/";
  $file = filter_input(INPUT_GET, "id", FILTER_SANITIZE_URL);
  $down = $path . $file;

if (!file_exists($down)) {

  header("HTTP/1.1 404 Not Found");
  header("Location: /");
  exit();

} else {

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

}

?>