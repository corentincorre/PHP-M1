<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=api_film;charset=utf8', 'root', 'password');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}