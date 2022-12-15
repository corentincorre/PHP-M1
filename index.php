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
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}
$sql1 = 'SELECT COUNT(*) AS cnt FROM todo';
$querynb = $db->prepare($sql1);
$querynb->execute();
$queryres = $querynb->fetch();
$count = $queryres['cnt'];
$first = ($currentPage -1) * 5;

$pages = ceil($count / 5);

$sql = 'SELECT * FROM todo ORDER BY id DESC LIMIT :first, 5';

$todoStmt = $db->prepare($sql);
$todoStmt->bindValue(':first', $first, PDO::PARAM_INT);

$todoStmt->execute();

$elements = $todoStmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>TODOS | Accueil</title>
</head>
<body>
    <div class="container">
        <h1>TO DO List</h1>
        <a href="create.php" class="btn btn-primary mb-3">Ajouter un to do</a>

        <div class="card">
            <?php if (!empty($elements)):?>
            <ul class="list-group">
                <?php foreach ($elements as $element):?>
                <li class="list-group-item <?=$element['done'] ?'list-group-item-success':'' ?>">
                <div class="row align-items-center">
                    <div class="col">
                            <h2><?= $element['name'] ?></h2>
                            <p><?= $element['content'] ?></p>
                        </div>
                        <div class="col d-flex align-items-center justify-content-end gap-2">
                        <?php if (!$element['done']):?>
                            <a href="update.php?id=<?= $element['id'] ?>"  class="btn btn-secondary">Modifier</a>
                            <a href="update_status.php?id=<?= $element['id'] ?>" class="btn btn-success">Terminer</a>
                            <a href="delete.php?id=<?= $element['id'] ?>" class="btn btn-danger">Supprimer</a>
                        <?php else:?>
                            <p class="mb-0">Terminé</p>
                            <a href="update_status.php?id=<?= $element['id'] ?>" class="btn btn-secondary">Repasser en cours</a>
                            <a href="delete.php?id=<?= $element['id'] ?>" class="btn btn-danger">Supprimer</a>
                        <?php endif ;?>
                        </div>
                    </div>                 
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else:?>
                <p>Il n'y a pas de to do</p>
            <?php endif ;?>
        </div>
        <div class="d-flex align-items-center justify-content-end mt-4">
            <nav>
                <ul class="pagination">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="./?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                            <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endfor ?>
                        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="./?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>   
</body>
</html>