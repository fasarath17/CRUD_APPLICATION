<?php
include('../inc/dbcon.php');

if (isset($_POST['storeUser']) || !empty($_FILES["profile_picture"]["name"])) {
    // Handle form submission and file upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        echo "File is not a valid image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_image_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_image_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert data into the database
            $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
            $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
            $age = isset($_POST['age']) ? $_POST['age'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $profile_picture_path = $target_file;

            // Insert data into the 'users' table
            $query = "INSERT INTO `users` (`first_name`, `last_name`, `age`, `address`, `description`, `profile_picture`) VALUES ('$first_name', '$last_name', '$age', '$address', '$description', '$profile_picture_path')";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "Error: " . mysqli_error($conn);
            } else {
                echo "User added successfully!";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "No data received.";
}
?>
