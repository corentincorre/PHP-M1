<?php

function getGenres():array{
    require '../Service/Database.php';
    $sql = "SELECT * FROM genres";
    $getGenresStmt = $db->prepare($sql);
    $getGenresStmt->execute();

    return $getGenresStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getGenre(int $id){
    require '../Service/Database.php';
    $sql = "SELECT * FROM genres WHERE id = :id";
    $getGenreStmt = $db->prepare($sql);
    $getGenreStmt->execute([
        'id' => $id
    ]);

    return $getGenreStmt->fetchAll(PDO::FETCH_ASSOC);
}
function createGenre($name){
    require '../Service/Database.php';
    $sql = "INSERT INTO genres (name) VALUES (:name)";
    $createGenreStmt = $db->prepare($sql);
    $createGenreStmt->execute([
        'name' => $name,
    ]);

    $sql = 'SELECT * FROM genres ORDER BY id DESC LIMIT 0, 1';
    $getGenreStmt = $db->prepare($sql);
    $getGenreStmt->execute();
    return $getGenreStmt->fetchAll(PDO::FETCH_ASSOC);
}
function updateGenre($id,$name){
    require '../Service/Database.php';
    $sql = "UPDATE genres SET name = :name WHERE id = :id";
    $updateGenreStmt = $db->prepare($sql);
    $updateGenreStmt->execute([
        'id' => $id,
        'name' => $name
    ]);

    $sql = 'SELECT * FROM genres WHERE id = :id';
    $getGenreStmt = $db->prepare($sql);
    $getGenreStmt->execute([
        'id' => $id
    ]);
    return $getGenreStmt->fetchAll(PDO::FETCH_ASSOC);
}
function deleteGenre($id){
    require '../Service/Database.php';
    $sql = "DELETE FROM genres WHERE id = :id";
    $deleteGenreStmt = $db->prepare($sql);
    return $deleteGenreStmt->execute([
        'id' => $id,
    ]);
}
function getGenresByMovie($id){
    require '../Service/Database.php';
    $sql = "SELECT genres.* FROM genres 
    JOIN movie_genres ON genres.id = movie_genres.genre_id 
    JOIN movies ON movie_genres.movie_id = movies.id 
         WHERE movies.id = :id";
    $getGenresStmt = $db->prepare($sql);
    $getGenresStmt->execute([
        'id' => $id,
    ]);

    return $getGenresStmt->fetchAll(PDO::FETCH_ASSOC);
}

