<?php
include('header.php');
include('../inc/dbcon.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM `users` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['updateUser'])) {
    $id_new = isset($_GET['id_new']) ? $_GET['id_new'] : '';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $description = $_POST['description'];

    // Handle file upload if a new profile picture is provided
    if (!empty($_FILES["profile_picture"]["name"])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);

        // Validate and move uploaded file
        include('upload_validation.php');  // You can create a separate file for validation

        // Update profile picture path
        $profile_picture = $target_file;
    } else {
        // Keep the existing profile picture path if no new file is provided
        $profile_picture = $row['profile_picture'];
    }

    // Use prepared statements to prevent SQL injection
    $query = "UPDATE users SET 
                first_name=?, 
                last_name=?, 
                age=?, 
                address=?, 
                description=?, 
                profile_picture=?
                WHERE id=?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssisssi", $first_name, $last_name, $age, $address, $description, $profile_picture, $id_new);

        if (mysqli_stmt_execute($stmt)) {
            header('location:index.php?update_msg=You have successfully updated the data');
            exit;
        } else {
            die("Query Failed: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Prepared Statement Failed: " . mysqli_error($conn));
    }
}
?>

<form action="update1.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" class="form-control" value="<?php echo $row['first_name'] ?>">
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?php echo $row['last_name'] ?>">
    </div>
    <div class="form-group">
        <label for="age">Age</label>
        <input type="text" name="age" class="form-control" value="<?php echo $row['age'] ?>">
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" name="address" class="form-control" value="<?php echo $row['address'] ?>">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" class="form-control" value="<?php echo $row['description'] ?>">
    </div>

    <div class="form-group">
        <label for="profile_picture">Profile Picture</label>
        <input type="file" name="profile_picture" class="form-control-file">
    </div>

    <input type="submit" class="btn btn-success" name="updateUser" value="UPDATE">
</form>

<?php include('footer.php'); ?>