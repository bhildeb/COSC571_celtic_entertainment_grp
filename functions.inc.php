<?php

function getCurrentPage() {
  return $_SERVER['SCRIPT_NAME'];
}

function isPage($page) {
  if (strpos(getCurrentPage(), $page) !== false) {
    return true;
  }
}

?>
