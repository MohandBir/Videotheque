<?php

namespace Cine\App\Controller;

use Cine\App\Entity\Film;
use Cine\App\Repository\FilmRepository;
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
        $id = ((int)($_GET['id'])) ?? null;

        $tmdb = new Tmdb;
        $filmTmdb = $tmdb->getFilmByTmdbId($id); 
        
        $film = new Film;
        $film->setId($id)
        ->setGenre_id($filmTmdb['id'])
        ->setPoster_path($filmTmdb['backdrop_path'])
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
    
    public function add()
    {
        $id = ($_GET['id']) ?? null;
        
        
        $tmdb = new Tmdb;
        $filmTmdb = $tmdb->getFilmByTmdbId($id); 

        $filmRepo = new FilmRepository;
        $filmCheck =$filmRepo->fintByTmdbId($id);
        if ($filmCheck) {
            header('location: index.php?route=showTmdb&id=' .$id. '&exist=1');
            exit;
        }
        $film = new Film;
        $film->setTmdb_id($filmTmdb['id'])
        ->setPoster_path($filmTmdb['backdrop_path'])
        ->setTitle($filmTmdb['title'])
        ->setRelease_date(substr($filmTmdb['release_date'],0,4))
        ->setRuntime($filmTmdb['runtime'])
        ->setOverview($filmTmdb['overview'])
        ;
        foreach ($filmTmdb['genres'][0] as $genre) {
           if ($genre === 'Action') {
               $film->setGenre_id(1);
           } elseif ($genre === 'Comédie') {
               $film->setGenre_id(2);
           } elseif ($genre === 'Drame') {
               $film->setGenre_id(3);
           } elseif ($genre === 'Horreur') {
               $film->setGenre_id(4);
           } elseif ($genre === 'Fantastique') {
               $film->setGenre_id(5);
           } elseif ($genre === 'Aventure') {
               $film->setGenre_id(6);
           } elseif ($genre === 'Science-Fiction') {
               $film->setGenre_id(7);
           } else {
                $film->setGenre_id(null);
           }
        }
        $filmRepo = new FilmRepository;
        $filmRepo->add($film);

        $redirectFilm = $filmRepo->fintByTmdbId($film->getTmdb_id());
        
        header('location: index.php?route=update&id='.$redirectFilm->getId().'&genreId='.$redirectFilm->getGenre_id().'&add=1');
        exit;
    }
}
