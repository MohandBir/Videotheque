<?php

namespace Cine\App\Controller;

use Cine\App\Entity\Film;
use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;
use Cine\App\Service\Tmdb\Tmdb;

class VthequeController 
{
    public function index()
    {
      $genreRepo = new GenreRepository;
      $genres = $genreRepo->findAll();
 
      $filmRepo = new FilmRepository;
      $films = $filmRepo->findAll();
      $message = (!$films) ? 'Votre collection est vide!' : null;
      require __DIR__ . '/../View/index.phtml';
    }

    public function sort() 
    {
      if (isset($_POST['all'])) {
        header('location: /index.php');
        exit;
      }
      $filmRepo = new FilmRepository;
      $films = $filmRepo->findAll();

      if($films) {
        if (isset($_POST['genre'])) {       
          $genreId =($_POST['genre'] !== '') ? (int)$_POST['genre'] : NULL;
          $filmRepo = new FilmRepository;
          $films = $filmRepo->findAllByGenreId($genreId);
          $message = (empty($films)) ? '🚫 Aucun film pour cette Categorie !':'';
        }   
        if (isset($_POST['sortWatched'])) {
          $isWatched = (int)$_POST['sortWatched'];
          $filmRepo = new FilmRepository;
          $films = $filmRepo->findAllByIsWatched($isWatched);
          if ($_POST['sortWatched']==='0') {
            $message = (empty($films)) ? '🚫 Tous les films sont dèja vu !':'';
          }
          if ($_POST['sortWatched']==='1') {
            $message = (empty($films)) ? '🚫 Aucun film vu pour le moment !':'';
          }  
        }
      } else {
        $message = 'Votre collection est vide!';
      }
       
   
      $genreRepo = new GenreRepository;
      $genres = $genreRepo->findAll();

      require __DIR__ . '/../View/index.phtml';
    }

    public function show() 
    { 
      $id = (int) ($_GET['id']) ?? null;
      if ($_GET['genreId'] !== '') {
        $genreId = (int) $_GET['genreId'];
        $genreRepo = new GenreRepository;
        $genreShow = $genreRepo->findById($genreId)->getName();
      } else {
        $genreShow = 'n/c';
      }

      $filmRepo = new FilmRepository;
      $film = $filmRepo->findById($id);

      require __DIR__ . '/../View/show.phtml';
    }

    public function delete()
    {
      $id = ($_GET['id']) ?? null;
      $filmRepo = new FilmRepository;
      $film = $filmRepo->delete($id);

    }

    public function update()
    {
      if (empty($_POST)) {
        $id = (int) ($_GET['id']) ?? null;
        $genreRepo = new GenreRepository;

        if ($_GET['genreId'] !== '') {
          $genreId = (int) $_GET['genreId']; 
          $genreShow = $genreRepo->findById($genreId)->getName();
        } else {
          $genreShow = 'n/c';
        }
        $genres = $genreRepo->findAll();

        $filmRepo = new FilmRepository;
        $film = $filmRepo->findById($id);  
      }
      if (!empty($_POST)) { 
        require __DIR__ . '/../Service/function/fieldVerify.php';
        $errors = fieldVerify($_POST['genreId'], $_POST['isWatched'], $_POST['description'] );
        if ($errors) {
            $id = (int) ($_POST['filmId']) ?? null;
            
            if ( $_POST['genreId']!== 'null' ) {
              $filmRepo = new FilmRepository;
              $film = $filmRepo->findById($id);  
              $genreId = $film->getGenre_id();
              $genreRepo = new GenreRepository;
              $genreResult = $genreRepo->findById($genreId);
              if ($genreResult) {
                $genreShow = $genreResult->getName(); 
              } else {
                $genreShow = 'n/c';
              }
            } 
            if ($_POST['genreId'] === 'null') {
                $genreShow = 'n/c';
            }
            $genres = $genreRepo->findAll();

            $filmRepo = new FilmRepository;
            $film = $filmRepo->findById($id);
        }
        if (!($errors)) {
            $filmEntity = new Film;
            $film = $filmEntity->setId((int)$_POST['filmId'])
            ->setGenre_id((int)$_POST['genreId'])
            ->setIsWatched((int)$_POST['isWatched'])
            ->setDescription($_POST['description'])
            ;
            $filmRepo = (new FilmRepository)->update($film);
            
            header('location: index.php?route=show&id='.$film->getId().'&genreId='.$film->getGenre_id().'&success=1');
            exit;
        } 
        
      }

      require __DIR__ . '/../View/update.phtml';

    }


}
