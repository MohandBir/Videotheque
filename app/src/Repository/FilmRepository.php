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



}
