<?php

  global $download_id;
  global $download_valid;
  global $err;

/* ------------------------------------------------------------- */
/* Check if download-ID is available */
/* ------------------------------------------------------------- */

  if (filter_input(INPUT_GET, "id", FILTER_SANITIZE_URL)) {

    $download_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_URL);
    $download_valid = 0;

    $downloads = yaml($page->downloads());

/* ------------------------------------------------------------- */
/* See if download-ID matches any available download */
/* ------------------------------------------------------------- */

    foreach($downloads as $download):

/* ------------------------------------------------------------- */
/* When the download-ID matches an existing asset */
/* ------------------------------------------------------------- */

    if ($download["download_id"] === $download_id) {

        $download_uri = "content/downloads/" . $download["download_source"];
        $download_uid = $download["download_id"];
        $download_src = $download["download_source"];
        $download_valid = 1;
        $download_force = $download["download_link"];
        $download_log = $download["download_log"];
      }

    endforeach;

/* ------------------------------------------------------------- */
/* Download-ID is available, but not correct */
/* ------------------------------------------------------------- */

    if ($download_valid !== 1) {

      $err = "<h1 class=\"error\">Error - no <span>valid</span> download #ID (<b>02</b>).</h1>";

    } else {

/* ------------------------------------------------------------- */
/* Download-ID is available and correct, but the asset isn't */
/* ------------------------------------------------------------- */

      if (!file_exists($download_uri)) {

        $err = "<h1 class=\"error\">Error - file <span>does not</span> exist (<b>03</b>).</h1>";

      } else {

/* ------------------------------------------------------------- */
/* Both download-ID and assets are available, */
/* ------------------------------------------------------------- */

/* Log the hits */

      if($download_log == 1) {

        $logfile = "content/downloads/stats/" . $download_uid . ".log.txt";

          if (!file_exists($logfile)) {

            fopen($logfile, "w");

          } else {

            $logdata = file_get_contents($logfile);
          }

          $fp = fopen($logfile, "r+");

            while(!flock($fp, LOCK_EX)) {
            }

          include_once("site/fields/download/inc/blueprint.php");

          $logdata = $blueprint . $logdata;

          ftruncate($fp, 0);
          fwrite($fp, $logdata);
          fflush($fp);
          flock($fp, LOCK_UN);
          fclose($fp);

      }

/* Count the hits */

      $counter = "content/downloads/stats/" . $download_uid . ".cnt.txt";

        if (!file_exists($counter)) {

          $count = 0;
          fopen($counter, "w");

        } else {

          $count = file_get_contents($counter);
        }

      $fp = fopen($counter, "r+");

        while(!flock($fp, LOCK_EX)) {
        }

      $count++;

      ftruncate($fp, 0);
      fwrite($fp, $count);
      fflush($fp);
      flock($fp, LOCK_UN);
      fclose($fp);

/* Don't force download */

        if ($download_force !== 1) {

            header("Location: " . "../content/downloads/" . $download_src);
            exit();

        } else {

/* Force download */
/* Ref. https://forum.getkirby.com/t/4581 */

          header("Location: ../download/?id=" . $download_src);
          exit();
        }

      }

    }

    } else {

/* ------------------------------------------------------------- */
/* No download-ID is available at all */
/* ------------------------------------------------------------- */

    $err = "<h1 class=\"error\">Error - no download #ID (<b>01</b>).</h1>";

  }

?>