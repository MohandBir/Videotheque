<?php

namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;

class VthequeController 
{
    public function index()
    {
      $genreRepo = new GenreRepository;
      $genres = $genreRepo->findAll();

      $filmsRepo = new FilmRepository;
      $films = $filmsRepo->findAll();
      
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
        $filmsRepo = new FilmRepository;
        $films = $filmsRepo->findAllByGenreId($genreId);
      }   
      if (isset($_POST['sort'])) {
        $isWatched = (int)$_POST['sort'];
        $filmsRepo = new FilmRepository;
        $films = $filmsRepo->findAllByIsWatched($isWatched);
      } 
   
      $genreRepo = new GenreRepository;
      $genres = $genreRepo->findAll();

      require __DIR__ . '/../View/index.phtml';
    }
      
}
