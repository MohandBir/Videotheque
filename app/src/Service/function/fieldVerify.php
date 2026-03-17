<?php

function fieldVerify ( $genreId,  $isWatched,  $description) { string :
    $errors = [];
    if ( $genreId === '' || !isset($isWatched)) {
        $errors[] = 'Le genre de film et La mention Vu/À voir sont obligatoires';
    }
    if ( mb_strlen($description) > 700) {
        $errors[] = 'La description ne doit pas dépasser 700 caractères';
    }

    return $errors;
}
