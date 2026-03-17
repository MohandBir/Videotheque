<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Film;
use PDO;


class FilmRepository extends Repository
{
    public function findAll()
    {
        $sql = "SELECT * FROM film";
        $request = $this->pdo->prepare($sql);
        $request->execute();
        $films = $request->fetchAll(PDO::FETCH_CLASS, Film::class);

        return $films;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM film WHERE id=:id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['id' => $id]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
        $film = $request->fetch();

        return $film;
    }
   
    public function findAllByGenreId($genreId)
    {
        if ($genreId === null) {
            $sql = "SELECT * FROM film Where genre_id is :genreId";
            $request = $this->pdo->prepare($sql);
            $request->execute(['genreId' => $genreId]);
            $films = $request->fetchAll(PDO::FETCH_CLASS, Film::class);
        } else {
            $sql = "SELECT * FROM film Where genre_id=:genreId";
            $request = $this->pdo->prepare($sql);
            $request->execute(['genreId' => $genreId]);
            $films = $request->fetchAll(PDO::FETCH_CLASS, Film::class);
        }
     

        return $films;
    }

    public function findAllByIsWatched($isWatched)
    {
        $sql = "SELECT * FROM film Where isWatched=:isWatched";
        $request = $this->pdo->prepare($sql);
        $request->execute(['isWatched' => $isWatched]);
        $films = $request->fetchAll(PDO::FETCH_CLASS, Film::class);

        return $films;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM film Where id=:id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['id' => $id]);

        header('location: index.php');
        exit;
    }

    public function update($film)
    {
        $sql = "UPDATE film SET genre_id=:genreId, isWatched=:isWatched, description=:description WHERE id=:id";
        if ($film->getGenre_id() === 0) {
            $film->setGenre_id(null);
        } 
        $request = $this->pdo->prepare($sql);
        $request->execute([
            'genreId' => $film->getGenre_id(),
            'isWatched' => $film->getIsWatched(),
            'description' => $film->getDescription(),
            'id' => $film->getId(),
            ]);

    }

    public function add($film)
    {
        $sql = "INSERT INTO film( tmdb_id, title, poster_path, release_date, runtime, overview, genre_id) 
        VALUES 
        (:tmdb_id, :title, :poster_path, :release_date, :runtime, :overview, :genre_id)";
        $request = $this->pdo->prepare($sql);
        $request->execute([
            'tmdb_id' => $film->getTmdb_id(),
            'title' => $film->getTitle(),
            'poster_path' => $film->getPoster_path(),
            'release_date' => $film->getRelease_date(),
            'runtime' => $film->getRuntime(),
            'overview' => $film->getOverview(),
            'genre_id' => $film->getGenre_id(),
        ]);
    }

    public function fintByTmdbId($id) 
    {
        $sql = "SELECT * FROM film WHERE tmdb_id=:tmdbId";
        $request = $this->pdo->prepare($sql);
        $request->execute(['tmdbId' => $id]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
        $film = $request->fetch();

        return $film;
    }



}
