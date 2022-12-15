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



if (!empty($_POST)) {
    
    $_POST['name'] ? $name = htmlspecialchars(strip_tags($_POST['name'])) : '';
    $_POST['id'] ? $id = strip_tags($_POST['id']) : '';
    $content = $_POST['content'] ? htmlspecialchars(strip_tags($_POST['content'])) : '';
    

    if(isset($name) && isset($id)){
        $sql = 'UPDATE todo SET name = :name , content = :content WHERE id = :id';
        $todoStmt = $db->prepare($sql);
        $todoStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $todoStmt->bindParam(':content', $content, PDO::PARAM_STR);
        $todoStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $todoStmt->execute();
    }

    $_POST='';
    header('Location: index.php');
    exit();
}else{  
    if (!empty($_GET)) {
        $_GET['id'] ? $id = strip_tags($_GET['id']) : '';
        }else{
            return false;
        } 
    $sql = 'SELECT * FROM todo WHERE id='.$id;
    $todoStmt = $db->prepare($sql);
    $todoStmt->execute();
    $element = $todoStmt->fetch();
}



?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODOS | Modifier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h1>Modifer <?= $element['name'] ?></h1>
        <form action="update.php" method="POST">
        <input type="hidden" name="id"  value="<?= $element['id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $element['name'] ?>">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Texte</label>
                <textarea class="form-control" id="content" name="content" rows="3"><?= $element['content'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Modifier</button>
        </form>
    </div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>