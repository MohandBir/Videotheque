<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Genre;
use PDO;

class GenreRepository extends Repository
{
    public function findAll()
    {
        $sql = "SELECT * FROM genre";
        $request = $this->pdo->prepare($sql);
        $request->execute();
        $genres = $request->fetchAll(PDO::FETCH_CLASS, Genre::class);

        return $genres;
    }
    public function findById($id)
    {
        $sql = "SELECT * FROM genre WHERE id=:id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['id' => $id]);
        $request->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        $genre = $request->fetch();

        return $genre;
    }

}

