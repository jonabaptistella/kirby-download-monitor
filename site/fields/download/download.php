<?php

class DownloadField extends BaseField {

  static public $assets = array(
    "css" => array("download.css"),
    "js" => array("download.js")
  );

  public function content() {
    $kirby = kirby();
    $site  = $kirby->site();
    return "<script data-field=\"downloadfield\">var download_base = \"" . $site->url() . "/downloads/?id=\";</script>";
  }

  public function element() {
    $element = parent::element();
    $element->addClass("field-download");
    return $element;
  }
}

?>