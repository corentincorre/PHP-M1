<?php
require '../Repository/MovieRepository.php';
header('Content-Type: application/json');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$parent = $_GET['parent'] ?? null;
if ($parent){
    switch ($parent){
        case 'actors':
            $movies = getMoviesByActor($id);
            break;
        case 'directors':
            $movies = getMoviesByDirector($id);
            break;
        case 'genres':
            $movies = getMoviesByGenre($id);
            break;
        default:
            $movies = false;
    }
    if($movies){
        http_response_code(200);
        echo json_encode($movies);
    }
    else{
        http_response_code(404);
        echo json_encode(['code' => 404, 'message' => 'il n\'y a pas de film correspondant']);
    }
}
else{
    switch ($requestMethod){
        case 'GET':
            if($id){
                $movie = getMovie($id);
                if($movie){
                    http_response_code(200);
                    echo json_encode($movie);
                }else{
                    http_response_code(404);
                    echo json_encode(['code' => 404, 'message' => 'ce film n\'existe pas']);
                }

            }else{
                $movies = getMovies();

                http_response_code(200);
                echo json_encode($movies);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'));
            if (!isset($data->title, $data->release_date, $data->plot, $data->runtime)) {
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }
            else{
                $data->title = filter_var(htmlspecialchars(strip_tags($data->title)));
                $data->release_date = filter_var(htmlspecialchars(strip_tags($data->release_date)));
                $data->plot = filter_var(htmlspecialchars(strip_tags($data->plot)));
                $data->runtime = filter_var(htmlspecialchars(strip_tags($data->runtime)));
                $movie = createMovie($data->title, $data->release_date, $data->plot, $data->runtime);
                http_response_code(201);
                echo json_encode($movie);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'));
            if(!isset($id,$data->title, $data->release_date, $data->plot, $data->runtime)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }else{
                $data->title = filter_var(htmlspecialchars(strip_tags($data->title)));
                $data->release_date = filter_var(htmlspecialchars(strip_tags($data->release_date)));
                $data->plot = filter_var(htmlspecialchars(strip_tags($data->plot)));
                $data->runtime = filter_var(htmlspecialchars(strip_tags($data->runtime)));
                $movie = updateMovie($id, $data->title, $data->release_date, $data->plot, $data->runtime);
                http_response_code(200);
                echo json_encode($movie);
            }
            break;
        case 'DELETE':
            if(!isset($id)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner l\'du film'];
                echo json_encode($error);
            }else{
                if(deleteMovie($id)){
                    http_response_code(204);
                    $message = ['message' => 'Le film N°'.$id.' a bien été supprimé'];
                    echo json_encode($message);
                }
                else{
                    http_response_code(400);
                    $error = ['code' => 400, 'message' => 'Le film  ne s\'est pas supprimé'];
                    echo json_encode($error);
                }
            }
            break;
        default:
            echo 'default';
            break;
    };
}

