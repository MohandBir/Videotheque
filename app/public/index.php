<?php
// namespace Cine\App\public;

use Cine\App\Controller\VthequeController;
use Cine\App\Controller\TmdbController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../.env.php';

if (isset($_GET['route'])) {
    $route = $_GET['route'];
} else {
    $route = 'index';
}
 
$vtheque = new VthequeController();
$tmdb = new TmdbController();


if ($route === 'index') {
    $vtheque->index();
} elseif ($route === 'sort') {
    $vtheque->sort();
} elseif ($route === 'show') {
    $vtheque->show();
} elseif ($route === 'delete') {
    $vtheque->delete();
} elseif ($route === 'update') {
    $vtheque->update();
} elseif ($route === 'search') {
   $tmdb->search();
} elseif ($route === 'showTmdb') {
   $tmdb->show();
} elseif ($route === 'add') {
   $tmdb->add();
}