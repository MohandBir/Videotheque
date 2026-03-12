<?php
namespace Cine\App\public;

use Cine\App\Controller\VthequeController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../.env.php';

if (isset($_GET['route'])) {
    $route = $_GET['route'];
} else {
    $route = 'index';
}
 
$vtheque = new VthequeController();


if ($route === 'index') {
    $vtheque->index();
} elseif ($route === 'sort') {
    $vtheque->sort();
}