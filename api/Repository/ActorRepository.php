<?php

function getActors():array{
    require '../Service/Database.php';
    $sql = "SELECT * FROM actors";
    $getActorsStmt = $db->prepare($sql);
    $getActorsStmt->execute();

    return $getActorsStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getActor(int $id){
    require '../Service/Database.php';
    $sql = "SELECT * FROM actors WHERE id = :id";
    $getActorStmt = $db->prepare($sql);
    $getActorStmt->execute([
        'id' => $id
    ]);

    return $getActorStmt->fetchAll(PDO::FETCH_ASSOC);
}
function createActor($firstName, $lastName, $dob, $bio){
    require '../Service/Database.php';
    $sql = "INSERT INTO actors (first_name, last_name, dob, bio) VALUES (:firstName, :lastName, :dob, :bio)";
    $createActorStmt = $db->prepare($sql);
    $createActorStmt->execute([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'dob' => $dob,
        'bio' => $bio,
    ]);

    $sql = 'SELECT * FROM actors ORDER BY id DESC LIMIT 0, 1';
    $getActorStmt = $db->prepare($sql);
    $getActorStmt->execute();
    return $getActorStmt->fetchAll(PDO::FETCH_ASSOC);
}
function updateActor($id,$firstName, $lastName, $dob, $bio){
    require '../Service/Database.php';
    $sql = "UPDATE actors SET first_name = :firstName, last_name = :lastName, dob = :dob, bio = :bio WHERE id = :id";
    $updateActorStmt = $db->prepare($sql);
    $updateActorStmt->execute([
        'id' => $id,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'dob' => $dob,
        'bio' => $bio,
    ]);

    $sql = 'SELECT * FROM actors WHERE id = :id';
    $getActorStmt = $db->prepare($sql);
    $getActorStmt->execute([
        'id' => $id
    ]);
    return $getActorStmt->fetchAll(PDO::FETCH_ASSOC);
}
function deleteActor($id){
    require '../Service/Database.php';
    $sql = "DELETE FROM actors WHERE id = :id";
    $deleteActorStmt = $db->prepare($sql);
    return $deleteActorStmt->execute([
        'id' => $id,
    ]);
}
function getActorsByMovie($id){
    require '../Service/Database.php';
    $sql = "SELECT actors.* FROM actors 
    JOIN movie_actors ON actors.id = movie_actors.actor_id 
    JOIN movies ON movie_actors.movie_id = movies.id 
         WHERE movies.id = :id";
    $getActorsStmt = $db->prepare($sql);
    $getActorsStmt->execute([
        'id' => $id,
    ]);

    return $getActorsStmt->fetchAll(PDO::FETCH_ASSOC);
}
