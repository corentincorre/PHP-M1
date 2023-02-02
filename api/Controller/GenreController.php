<?php
require '../Repository/GenreRepository.php';
header('Content-Type: application/json');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$parent = $_GET['parent'] ?? null;
if ($parent){
    switch ($parent){
        case 'movies':
            $genres = getGenresByMovie($id);
            break;
        default:
            $genres = false;
    }
    if($genres){
        http_response_code(200);
        echo json_encode($genres);
    }
    else{
        http_response_code(404);
        echo json_encode(['code' => 404, 'message' => 'il n\'y a pas de genre correspondant']);
    }
}
else{
    switch ($requestMethod){
        case 'GET':
            if($id){
                $genre = getGenre($id);
                if($genre){
                    http_response_code(200);
                    echo json_encode($genre);
                }else{
                    http_response_code(404);
                    echo json_encode(['code' => 404, 'message' => 'ce genre n\'existe pas']);
                }

            }else{
                $genres = getGenres();

                http_response_code(200);
                echo json_encode($genres);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'));
            if (!isset($data->name)) {
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }
            else{
                $data->name = filter_var(htmlspecialchars(strip_tags($data->name)));
                $genre = createGenre($data->name);
                http_response_code(201);
                echo json_encode($genre);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'));
            if(!isset($id,$data->name)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }else{
                $data->name = filter_var(htmlspecialchars(strip_tags($data->name)));
                $genre = updateGenre($id, $data->name);
                http_response_code(200);
                echo json_encode($genre);
            }
            break;
        case 'DELETE':
            if(!isset($id)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner l\'id de le genre'];
                echo json_encode($error);
            }else{
                if(deleteGenre($id)){
                    http_response_code(204);
                    $message = ['message' => 'le genre N°'.$id.' a bien été supprimé'];
                    echo json_encode($message);
                }
                else{
                    http_response_code(400);
                    $error = ['code' => 400, 'message' => 'le genre  ne s\'est pas supprimé'];
                    echo json_encode($error);
                }
            }
            break;
        default:
            echo 'default';
            break;
    };
}


