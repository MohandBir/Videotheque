<?php

namespace Cine\App\Controller;

use Cine\App\Entity\Film;
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

    public function show()
    {
        if (isset($_POST['redirect'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $id = ((int)($_GET['id'])) ?? null;

        $tmdb = new Tmdb;
        $filmTmdb = $tmdb->getFilmByTmdbId($id); 

        $film = new Film;
        $film->setPoster_path($filmTmdb['backdrop_path'])
        ->setTitle($filmTmdb['title'])
        ->setRelease_date($filmTmdb['release_date'])
        ->setRuntime($filmTmdb['runtime'])
        ->setOverview($filmTmdb['overview'])
        ->setVote_average($filmTmdb['vote_average'])
        ->setVote_count($filmTmdb['vote_average'])
        ;
        foreach ($filmTmdb['genres'] as $genre) {
            $film->setGenres($genre['name']);
        }
    
        require __DIR__ . '/../View/tmdb/show-tmdb.phtml';
    }
}