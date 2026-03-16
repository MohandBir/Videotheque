<?php

namespace Cine\App\Controller;

use Cine\App\Service\Tmdb\Tmdb;


class TmdbController 
{
    public function search()
    {
        if (!empty($_POST)) {
            $word = $_POST['word'];
            $tmdb = new Tmdb;
            $films = $tmdb->getFilmByTmdbSearch($word);
             
        }
        require __DIR__ . '/../View/tmdb/search.phtml';
    }
}