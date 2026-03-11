<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Film;
use PDO;


class FilmRepository extends Repository
{
    public function findFilms()
    {
        $sql = "SELECT * FROM film";
        $request = $this->pdo->prepare($sql);
        $request->execute();
        $films = $request->fetchAll(PDO::FETCH_CLASS, Film::class);

        return $films;
    }
}