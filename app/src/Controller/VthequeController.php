<?php

namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;

class VthequeController 
{
    public function index()
    {
      $genreRepo = new GenreRepository;
      $genres = $genreRepo->findGenres();

      $filmsRepo = new FilmRepository;
      $films = $filmsRepo->findFilms();
      
      require __DIR__ . '/../View/index.phtml';
    }
}
