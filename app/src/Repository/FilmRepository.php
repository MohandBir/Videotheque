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

        header('location: index.php?route=show&id='.$film->getId().'&genreId='.$film->getGenre_id().'&success=1');
        exit;
    }



}
