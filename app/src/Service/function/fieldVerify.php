<?php

function fieldVerify ( $genreId,  $isWatched,  $description) { string :
    $errors = [];
    if ( $genreId === '' || !isset($isWatched)) {
        $errors[] = 'Le genre de film et La mention Vu/À voir sont obligatoires';
    }
    if ( mb_strlen($description) > 500 ) {
        $errors[] = 'La description ne doit pas dépasser 500 caractères';
    }

    return $errors;
}
