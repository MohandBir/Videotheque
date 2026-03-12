<?php

namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;
use Cine\App\Service\Tmdb\Tmdb;

class VthequeController 
{
    public function index()
    {
      $genreRepo = new GenreRepository;
      $genres = $genreRepo->findAll();
 
      $filmRepo = new FilmRepository;
      $films = $filmRepo->findAll();
      
      require __DIR__ . '/../View/index.phtml';
    }

    public function sort() 
    {
      if (isset($_POST['all'])) {
        header('location: /index.php');
        exit;
      }
      if (isset($_POST['genre'])) {       
        $genreId =($_POST['genre'] !== '') ? (int)$_POST['genre'] : NULL;
        $filmRepo = new FilmRepository;
        $films = $filmRepo->findAllByGenreId($genreId);
        $message = (empty($films)) ? '🚫 Aucun film pour cette Categorie !':'';
      }   
      if (isset($_POST['sortWatched'])) {
        $isWatched = (int)$_POST['sortWatched'];
        $filmRepo = new FilmRepository;
        $films = $filmRepo->findAllByIsWatched($isWatched);
      } 
   
      $genreRepo = new GenreRepository;
      $genres = $genreRepo->findAll();

      require __DIR__ . '/../View/index.phtml';
    }

    public function show() 
    { 
      $id = (int) (($_GET['id'])) ?? null;
      if ($_GET['genreId'] !== '') {
        $genreId = (int) $_GET['genreId'];
        $genreRepo = new GenreRepository;
        $genreShow = $genreRepo->findById($genreId)->getName();
      } else {
        $genreShow = 'n/c';
      }

      $filmRepo = new FilmRepository;
      $film = $filmRepo->findById($id);

      require __DIR__ . '/../View/show.phtml';
    }
      
}
