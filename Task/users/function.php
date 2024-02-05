<?php

require '../inc/dbcon.php';

function error422($message){

    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function storeUser($userInput){

    global $conn;

    $first_name = mysqli_real_escape_string($conn, $userInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $userInput['last_name']);
    $profile_picture = mysqli_real_escape_string($conn, $userInput['profile_picture']);
    $description = mysqli_real_escape_string($conn, $userInput['description']);
    $age= mysqli_real_escape_string($conn, $userInput['age']);
    $address = mysqli_real_escape_string($conn, $userInput['address']);

    if(empty(trim($first_name))){

        return error422('Enter Your First Name');

    }elseif(empty(trim($last_name))){

        return error422('Enter Your First Name');

    }elseif(empty(trim($profile_picture))){

        return error422('Upload your Picture');

    }elseif(empty(trim($description))){

        return error422('Enter Your Description');

    }elseif(empty(trim($age))){

        return error422('Enter Your Age');

    }elseif(empty(trim($address))){

        return error422('Enter Your Address');

    }else{

        $query = "INSERT INTO users (first_name, last_name, profile_picture, description, age, address) VALUES ('$first_name', '$last_name', '$profile_picture', '$description', $age, '$address')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 201,
                'message' => 'User Created Successfully',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);

        }else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);

    }
    }
}

function getUserList(){

    global $conn;

    $query = "SELECT * FROM users";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'User List Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        } else {

            $data = [
                'status' => 404,
                'message' => 'No User Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);

        }

    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);

    }
}

function getUser($userParams){

    global $conn;

    if($userParams['id'] == null){

        return error422('Enter Your User ID');
    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);

    $query = "SELECT * FROM users WHERE id='$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'User Fetch Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);


        }
        else{

            $data = [
                'status' => 404,
                'message' => 'No User Found',
            ];
            header("HTTP/1.0 404 No User Found");
            return json_encode($data);

        }


    }else{

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

} 

function updateUser($userInput, $userParams){

    global $conn;

    if(!isset($userParams['id'])){

        return error422('User Id Not Found in URL');

    }elseif($userParams['id'] == null){

        return error422('Enter the user id');

    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);
    
    $first_name = mysqli_real_escape_string($conn, $userInput['first_name']);
    $last_name = mysqli_real_escape_string($conn, $userInput['last_name']);
    $profile_picture = mysqli_real_escape_string($conn, $userInput['profile_picture']);
    $description = mysqli_real_escape_string($conn, $userInput['description']);
    $age= mysqli_real_escape_string($conn, $userInput['age']);
    $address = mysqli_real_escape_string($conn, $userInput['address']);

    if(empty(trim($first_name))){

        return error422('Enter Your First Name');

    }elseif(empty(trim($last_name))){

        return error422('Enter Your Last Name');

    }elseif(empty(trim($profile_picture))){

        return error422('Upload your Picture');

    }elseif(empty(trim($description))){

        return error422('Enter Your Description');

    }elseif(empty(trim($age))){

        return error422('Enter Your Age');

    }elseif(empty(trim($address))){

        return error422('Enter Your Address');

    }else{

        $query = "UPDATE users SET first_name='$first_name', last_name='$last_name', profile_picture='$profile_picture', description='$description', age='$age', address='$address' WHERE id='$userId' LIMIT 1" ; 
        $result = mysqli_query($conn, $query);

        if($result){

            $data = [
                'status' => 200,
                'message' => 'User Updated Successfully',
            ];
            header("HTTP/1.0 200 Created");
            return json_encode($data);

        }else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);

    }
    }
}

function deleteUser($userParams){

    global $conn;

    if(!isset($userParams['id'])){

        return error422('User Id Not Found in URL');

    }elseif($userParams['id'] == null){

        return error422('Enter the user id');

    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);

    $query = "DELETE FROM users WHERE id='$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'User Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }else{

        $data = [
            'status' => 404,
            'message' => 'User Not Found',
        ];
        header("HTTP/1.0 400 Not Found");
        return json_encode($data);

    }


}

?>
