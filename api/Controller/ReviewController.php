<?php
require '../Repository/ReviewRepository.php';
header('Content-Type: application/json');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$parent = $_GET['parent'] ?? null;
if ($parent){
    switch ($parent){
        case 'movies':
            $reviews = getReviewsByMovie($id);
            break;
        default:
            $reviews = false;
    }
    if($reviews){
        http_response_code(200);
        echo json_encode($reviews);
    }
    else{
        http_response_code(404);
        echo json_encode(['code' => 404, 'message' => 'il n\'y a pas d\'avis correspondant']);
    }
}
else{
    switch ($requestMethod){
        case 'GET':
            if($id){
                $review = getReview($id);
                if($review){
                    http_response_code(200);
                    echo json_encode($review);
                }else{
                    http_response_code(404);
                    echo json_encode(['code' => 404, 'message' => 'cet avis n\'existe pas']);
                }

            }else{
                $reviews = getReviews();

                http_response_code(200);
                echo json_encode($reviews);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'));
            if (!isset($data->movie_id, $data->username, $data->content, $data->date)) {
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }
            else{
                $data->movie_id = filter_var(htmlspecialchars(strip_tags($data->movie_id)));
                $data->username = filter_var(htmlspecialchars(strip_tags($data->username)));
                $data->content = filter_var(htmlspecialchars(strip_tags($data->content)));
                $data->date = filter_var(htmlspecialchars(strip_tags($data->date)));
                $review = createReview($data->movie_id, $data->username, $data->content, $data->date);
                http_response_code(201);
                echo json_encode($review);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'));
            if(!isset($id, $data->movie_id, $data->username, $data->content, $data->date)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner tous les champs'];
                echo json_encode($error);
            }else{
                $data->movie_id = filter_var(htmlspecialchars(strip_tags($data->movie_id)));
                $data->username = filter_var(htmlspecialchars(strip_tags($data->username)));
                $data->content = filter_var(htmlspecialchars(strip_tags($data->content)));
                $data->date = filter_var(htmlspecialchars(strip_tags($data->date)));
                $review = updateReview($id, $data->movie_id, $data->username, $data->content, $data->date);
                http_response_code(200);
                echo json_encode($review);
            }
            break;
        case 'DELETE':
            if(!isset($id)){
                http_response_code(400);
                $error = ['code' => 400, 'message' => 'Veuillez renseigner l\'id de l\'avis'];
                echo json_encode($error);
            }else{
                if(deleteReview($id)){
                    http_response_code(204);
                    $message = ['message' => 'L\'avis N°'.$id.' a bien été supprimé'];
                    echo json_encode($message);
                }
                else{
                    http_response_code(400);
                    $error = ['code' => 400, 'message' => 'L\'avis  ne s\'est pas supprimé'];
                    echo json_encode($error);
                }
            }
            break;
        default:
            echo 'default';
            break;
    };
}


