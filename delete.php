<?php
try
{
    $db = new PDO(
        'mysql:host=localhost;dbname=todos;charset=utf8',
        'root',
        'password',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // Permet d'avoir des erreurs SQL précises
    );
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
};



if (!empty($_GET)) {
    

    $_GET['id'] ? $id = strip_tags($_GET['id']) : '';
    

    if(isset($id)){
        $sql = 'DELETE FROM todo 
        WHERE id = :id';
        $todoStmt = $db->prepare($sql);
        $todoStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $todoStmt->execute();
    }
    header('Location: index.php');
    exit();
}else{
    return false;
}