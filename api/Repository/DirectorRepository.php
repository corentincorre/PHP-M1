<?php

function getDirectors():array{
    require '../Service/Database.php';
    $sql = "SELECT * FROM directors";
    $getDirectorsStmt = $db->prepare($sql);
    $getDirectorsStmt->execute();

    return $getDirectorsStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDirector(int $id){
    require '../Service/Database.php';
    $sql = "SELECT * FROM directors WHERE id = :id";
    $getDirectorStmt = $db->prepare($sql);
    $getDirectorStmt->execute([
        'id' => $id
    ]);

    return $getDirectorStmt->fetchAll(PDO::FETCH_ASSOC);
}
function createDirector($firstName, $lastName, $dob, $bio){
    require '../Service/Database.php';
    $sql = "INSERT INTO directors (first_name, last_name, dob, bio) VALUES (:firstName, :lastName, :dob, :bio)";
    $createDirectorStmt = $db->prepare($sql);
    $createDirectorStmt->execute([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'dob' => $dob,
        'bio' => $bio,
    ]);

    $sql = 'SELECT * FROM directors ORDER BY id DESC LIMIT 0, 1';
    $getDirectorStmt = $db->prepare($sql);
    $getDirectorStmt->execute();
    return $getDirectorStmt->fetchAll(PDO::FETCH_ASSOC);
}
function updateDirector($id,$firstName, $lastName, $dob, $bio){
    require '../Service/Database.php';
    $sql = "UPDATE directors SET first_name = :firstName, last_name = :lastName, dob = :dob, bio = :bio WHERE id = :id";
    $updateDirectorStmt = $db->prepare($sql);
    $updateDirectorStmt->execute([
        'id' => $id,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'dob' => $dob,
        'bio' => $bio,
    ]);

    $sql = 'SELECT * FROM directors WHERE id = :id';
    $getDirectorStmt = $db->prepare($sql);
    $getDirectorStmt->execute([
        'id' => $id
    ]);
    return $getDirectorStmt->fetchAll(PDO::FETCH_ASSOC);
}
function deleteDirector($id){
    require '../Service/Database.php';
    $sql = "DELETE FROM directors WHERE id = :id";
    $deleteDirectorStmt = $db->prepare($sql);
    return $deleteDirectorStmt->execute([
        'id' => $id,
    ]);
}
function getDirectorsByMovie($id){
    require '../Service/Database.php';
    $sql = "SELECT directors.* FROM directors 
    JOIN movie_directors ON directors.id = movie_directors.director_id 
    JOIN movies ON movie_directors.movie_id = movies.id 
         WHERE movies.id = :id";
    $getDirectorsStmt = $db->prepare($sql);
    $getDirectorsStmt->execute([
        'id' => $id,
    ]);

    return $getDirectorsStmt->fetchAll(PDO::FETCH_ASSOC);
}

