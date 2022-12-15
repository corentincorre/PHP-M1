<?php
if (!empty($_POST)) {
    
    $_POST['name'] ? $name = htmlspecialchars(strip_tags($_POST['name'])) : '';
    $content = $_POST['content'] ? htmlspecialchars(strip_tags($_POST['content'])) : '';
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

    if(isset($name)){
        //print_r($name);die;
        $sql = 'INSERT INTO todo (name, content) VALUES (:name, :content)';
        $todoStmt = $db->prepare($sql);
        $todoStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $todoStmt->bindParam(':content', $content, PDO::PARAM_STR);
        $todoStmt->execute();
    }

    header('Location: index.php');
    exit();
}



?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODOS | Ajouter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h1>Ajouter un To do</h1>
        <form action="create.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Texte</label>
                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Ajouter</button>
        </form>
    </div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>