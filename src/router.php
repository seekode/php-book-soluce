<?php
require 'utils/utils.php';
require 'utils/splAutoload.php';
session_start();

$path = $_SERVER['REDIRECT_URL'];


if ($path == '/') {
  require 'controllers/indexCtrl.php';
} else {
  $path = explode('/', $path)[1];

  $controlleur = 'controllers/' . $path . 'Ctrl.php';

  if (file_exists($controlleur)) {
    require $controlleur;
  } else {
    require 'views/404.php';
  }
}
