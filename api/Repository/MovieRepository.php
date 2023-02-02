<?php

function getMovies():array{
    require '../Service/Database.php';
    $sql = "SELECT * FROM movies";
    $getMoviesStmt = $db->prepare($sql);
    $getMoviesStmt->execute();

    return $getMoviesStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMovie(int $id){
    require '../Service/Database.php';
    $sql = "SELECT * FROM movies WHERE id = :id";
    $getMovieStmt = $db->prepare($sql);
    $getMovieStmt->execute([
        'id' => $id
    ]);

    return $getMovieStmt->fetchAll(PDO::FETCH_ASSOC);
}
function createMovie($title, $releaseDate, $plot, $runtime){
    require '../Service/Database.php';
    $sql = "INSERT INTO movies (title, release_date, plot, runtime) VALUES (:title, :releaseDate, :plot, :runtime)";
    $createMovieStmt = $db->prepare($sql);
    $createMovieStmt->execute([
        'title' => $title,
        'releaseDate' => $releaseDate,
        'plot' => $plot,
        'runtime' => $runtime,
    ]);

    $sql = 'SELECT * FROM movies ORDER BY id DESC LIMIT 0, 1';
    $getMovieStmt = $db->prepare($sql);
    $getMovieStmt->execute();
    return $getMovieStmt->fetchAll(PDO::FETCH_ASSOC);
}
function updateMovie($id,$title, $releaseDate, $plot, $runtime){
    require '../Service/Database.php';
    $sql = "UPDATE movies SET title = :title, release_date = :releaseDate, plot = :plot, runtime = :runtime WHERE id = :id";
    $updateMovieStmt = $db->prepare($sql);
    $updateMovieStmt->execute([
        'id' => $id,
        'title' => $title,
        'releaseDate' => $releaseDate,
        'plot' => $plot,
        'runtime' => $runtime,
    ]);

    $sql = 'SELECT * FROM movies WHERE id = :id';
    $getMovieStmt = $db->prepare($sql);
    $getMovieStmt->execute([
        'id' => $id
    ]);
    return $getMovieStmt->fetchAll(PDO::FETCH_ASSOC);
}
function deleteMovie($id){
    require '../Service/Database.php';
    $sql = "DELETE FROM movies WHERE id = :id";
    $deleteMovieStmt = $db->prepare($sql);
    return $deleteMovieStmt->execute([
        'id' => $id,
    ]);
}
function getMoviesByActor($id){
    require '../Service/Database.php';
    $sql = "SELECT movies.* FROM movies 
    JOIN movie_actors ON movies.id = movie_actors.movie_id 
    JOIN actors ON movie_actors.actor_id = actors.id 
         WHERE actors.id = :id";
    $getMoviesStmt = $db->prepare($sql);
    $getMoviesStmt->execute([
        'id' => $id,
    ]);

    return $getMoviesStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMoviesByDirector($id){
    require '../Service/Database.php';
    $sql = "SELECT movies.* FROM movies 
    JOIN movie_directors ON movies.id = movie_directors.movie_id 
    JOIN directors ON movie_directors.director_id = directors.id 
         WHERE directors.id = :id";
    $getMoviesStmt = $db->prepare($sql);
    $getMoviesStmt->execute([
        'id' => $id,
    ]);

    return $getMoviesStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMoviesByGenre($id){
    require '../Service/Database.php';
    $sql = "SELECT movies.* FROM movies 
    JOIN movie_genres ON movies.id = movie_genres.movie_id 
    JOIN genres ON movie_genres.genre_id = genres.id 
         WHERE genres.id = :id";
    $getMoviesStmt = $db->prepare($sql);
    $getMoviesStmt->execute([
        'id' => $id,
    ]);

    return $getMoviesStmt->fetchAll(PDO::FETCH_ASSOC);
}
