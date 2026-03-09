CREATE TABLE genre (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL UNIQUE
);
CREATE TABLE film (
 id INT AUTO_INCREMENT PRIMARY KEY,
 tmdb_id INT NOT NULL UNIQUE,
 title VARCHAR(255) NOT NULL,
 poster_path VARCHAR(500) NULL,
 release_date YEAR NULL,
 runtime INT NULL,
 overview TEXT NULL,
 genre_id INT NULL,
 description TEXT NULL,
 isWatched BOOLEAN NOT NULL DEFAULT FALSE,
 CONSTRAINT fk_genre FOREIGN KEY (genre_id) REFERENCES genre(id) ON DELETE
SET NULL
);


INSERT INTO genre (name) VALUES
 ('Action'),
 ('Comédie'),
 ('Drame'),
 ('Horreur'),
 ('Fantastique');
INSERT INTO film (tmdb_id, title, poster_path, release_date, runtime, overview, genre_id,
description, isWatched) VALUES
(1265609,'War Machine','/rFhKkXhk7ClU03jQ5rHIApJDwev.jpg', 2026, 110, "Lors d'une
dernière mission éprouvante pendant sa formation de Ranger, un ingénieur militaire doit
mener son unité contre une gigantesque machine à tuer venue d'un autre monde.",1, 'Un
classique indémodable',true),
(1290821,'Shelter','/u071a2uGEgC5lAMskhxdASwfQSt.jpg', 2026, 107, "Lors d'une dernière
mission éprouvante pendant sa formation de Ranger, un ingénieur militaire doit mener son
unité contre une gigantesque machine à tuer venue d'un autre monde.",null, null,false),
(1159559,'Scream 7','/j6Y7vqULt8tRlXVFXHK5aj3nCo4.jpg', 2026, 114, "Lorsqu’un nouveau
Ghostface surgit dans la paisible ville où Sidney Prescott a reconstruit sa vie, ses pires
cauchemars refont surface. Alors que sa fille devient la prochaine cible, Sidney n’a d’autre
choix que de reprendre le combat. Déterminée à protéger les siens, elle doit alors affronter
les démons de son passé pour tenter de mettre fin une bonne fois pour toutes au bain de
sang.",4, null,false);