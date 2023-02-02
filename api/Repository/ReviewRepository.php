<?php

function getReviews():array{
    require '../Service/Database.php';
    $sql = "SELECT * FROM reviews";
    $getReviewsStmt = $db->prepare($sql);
    $getReviewsStmt->execute();

    return $getReviewsStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReview(int $id){
    require '../Service/Database.php';
    $sql = "SELECT * FROM reviews WHERE id = :id";
    $getReviewStmt = $db->prepare($sql);
    $getReviewStmt->execute([
        'id' => $id
    ]);

    return $getReviewStmt->fetchAll(PDO::FETCH_ASSOC);
}
function createReview($movieId, $username, $content, $date){
    require '../Service/Database.php';
    $sql = "INSERT INTO reviews (movie_id, username, content, date) VALUES (:movieId, :username, :content, :date)";
    $createReviewStmt = $db->prepare($sql);
    $createReviewStmt->execute([
        'movieId' => $movieId,
        'username' => $username,
        'content' => $content,
        'date' => $date,
    ]);

    $sql = 'SELECT * FROM reviews ORDER BY id DESC LIMIT 0, 1';
    $getReviewStmt = $db->prepare($sql);
    $getReviewStmt->execute();
    return $getReviewStmt->fetchAll(PDO::FETCH_ASSOC);
}
function updateReview($id,$movieId, $username, $content, $date){
    require '../Service/Database.php';
    $sql = "UPDATE reviews SET movie_id = :movieId, username = :username, content = :content, date = :date WHERE id = :id";
    $updateReviewStmt = $db->prepare($sql);
    $updateReviewStmt->execute([
        'id' => $id,
        'movieId' => $movieId,
        'username' => $username,
        'content' => $content,
        'date' => $date,
    ]);

    $sql = 'SELECT * FROM reviews WHERE id = :id';
    $getReviewStmt = $db->prepare($sql);
    $getReviewStmt->execute([
        'id' => $id
    ]);
    return $getReviewStmt->fetchAll(PDO::FETCH_ASSOC);
}
function deleteReview($id){
    require '../Service/Database.php';
    $sql = "DELETE FROM reviews WHERE id = :id";
    $deleteReviewStmt = $db->prepare($sql);
    return $deleteReviewStmt->execute([
        'id' => $id,
    ]);
}
function getReviewsByMovie($id){
    require '../Service/Database.php';
    $sql = "SELECT reviews.* FROM reviews 
         WHERE reviews.movie_id = :id";
    $getReviewsStmt = $db->prepare($sql);
    $getReviewsStmt->execute([
        'id' => $id,
    ]);

    return $getReviewsStmt->fetchAll(PDO::FETCH_ASSOC);
}
