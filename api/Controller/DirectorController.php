<?php
require '../Repository/DirectorRepository.php';
header('Content-Type: application/json');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$parent = $_GET['parent'] ?? null;
if ($parent){
    switch ($parent){
        case 'movies':
            $directors = getDirectorsByMovie($id);
            break;
        default:
            $directors = false;
    }
    if($directors){
        http_response_code(200);
        echo json_encode($directors);
    }
    else{
        http_response_code(404);
        echo json_encode(['code' => 404, 'message' => 'il n\'y a pas de directeur correspondant']);
    }
}
else{
    switch ($requestMethod){
        case 'GET':
            if($id){
                $director = getDirector($id);
                if($director){
                    http_response_code(200);
                    echo json_encode($director);
                }else{
                    http_response_code(404);
                    echo json_encode(['code' => 404, 'message' => 'ce directeur n\'existe pas']);
                }

            }else{
                $directors = getDirectors();

                http_response_code(200);
                echo json_encode($directors);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'));
            if (!isset($data->first_name, $data->last_name, $data->dob, $data->bio)) {
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }
            else{
                $data->first_name = filter_var(htmlspecialchars(strip_tags($data->first_name)));
                $data->last_name = filter_var(htmlspecialchars(strip_tags($data->last_name)));
                $data->dob = filter_var(htmlspecialchars(strip_tags($data->dob)));
                $data->bio = filter_var(htmlspecialchars(strip_tags($data->bio)));
                $director = createDirector($data->first_name, $data->last_name, $data->dob, $data->bio);
                http_response_code(201);
                echo json_encode($director);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'));
            if(!isset($id,$data->first_name, $data->last_name, $data->dob, $data->bio)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }else{
                $data->first_name = filter_var(htmlspecialchars(strip_tags($data->first_name)));
                $data->last_name = filter_var(htmlspecialchars(strip_tags($data->last_name)));
                $data->dob = filter_var(htmlspecialchars(strip_tags($data->dob)));
                $data->bio = filter_var(htmlspecialchars(strip_tags($data->bio)));
                $director = updateDirector($id, $data->first_name, $data->last_name, $data->dob, $data->bio);
                http_response_code(200);
                echo json_encode($director);
            }
            break;
        case 'DELETE':
            if(!isset($id)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner l\'id de le directeur'];
                echo json_encode($error);
            }else{
                if(deleteDirector($id)){
                    http_response_code(204);
                    $message = ['message' => 'le directeur N°'.$id.' a bien été supprimé'];
                    echo json_encode($message);
                }
                else{
                    http_response_code(400);
                    $error = ['code' => 400, 'message' => 'le directeur  ne s\'est pas supprimé'];
                    echo json_encode($error);
                }
            }
            break;
        default:
            echo 'default';
            break;
    };
}

