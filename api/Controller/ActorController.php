<?php
require '../Repository/ActorRepository.php';
header('Content-Type: application/json');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$parent = $_GET['parent'] ?? null;
if ($parent){
    switch ($parent){
        case 'movies':
            $actors = getActorsByMovie($id);
            break;
        default:
            $actors = false;
    }
    if($actors){
        http_response_code(200);
        echo json_encode($actors);
    }
    else{
        http_response_code(404);
        echo json_encode(['code' => 404, 'message' => 'il n\'y a pas d\'acteur correspondant']);
    }
}
else{
    switch ($requestMethod){
        case 'GET':
            if($id){
                $actor = getActor($id);
                if($actor){
                    http_response_code(200);
                    echo json_encode($actor);
                }else{
                    http_response_code(404);
                    echo json_encode(['code' => 404, 'message' => 'cet acteur n\'existe pas']);
                }

            }else{
                $actors = getActors();

                http_response_code(200);
                echo json_encode($actors);
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
                $actor = createActor($data->first_name, $data->last_name, $data->dob, $data->bio);
                http_response_code(201);
                echo json_encode($actor);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'));
            if(!isset($id, $data->first_name, $data->last_name, $data->dob, $data->bio)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }else{
                $data->first_name = filter_var(htmlspecialchars(strip_tags($data->first_name)));
                $data->last_name = filter_var(htmlspecialchars(strip_tags($data->last_name)));
                $data->dob = filter_var(htmlspecialchars(strip_tags($data->dob)));
                $data->bio = filter_var(htmlspecialchars(strip_tags($data->bio)));
                $actor = updateActor($id, $data->first_name, $data->last_name, $data->dob, $data->bio);
                http_response_code(200);
                echo json_encode($actor);
            }
            break;
        case 'DELETE':
            if(!isset($id)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner l\'id de l\'acteur'];
                echo json_encode($error);
            }else{
                if(deleteActor($id)){
                    http_response_code(204);
                    $message = ['message' => 'L\'acteur N°'.$id.' a bien été supprimé'];
                    echo json_encode($message);
                }
                else{
                    http_response_code(400);
                    $error = ['code' => 400, 'message' => 'L\'acteur  ne s\'est pas supprimé'];
                    echo json_encode($error);
                }
            }
            break;
        default:
            echo 'default';
            break;
    };
}

