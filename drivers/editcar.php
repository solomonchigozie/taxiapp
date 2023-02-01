<?php
session_start(); 
require 'includes/config.php';

//check if user is logged in
if(empty($_SESSION['email']) || !isset($_SESSION['email'])){
    header('location:login.php');
}

$id = "";
//redirect users if they try to access this page without a car id
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
}else{
    header('location:login.php');
}

$error = [];
if(isset($_POST['add'])){
    $carname = mysqli_real_escape_string($connect,$_POST['carname']);
    $model = mysqli_real_escape_string($connect,$_POST['model']);
    $des = mysqli_real_escape_string($connect,$_POST['des']);
    $color = mysqli_real_escape_string($connect,$_POST['color']);
    $platenumber = mysqli_real_escape_string($connect,$_POST['platenumber']);
     
    //validaiton
    if(empty($carname)){
        array_push($error, "Enter a car name");
    }
    if(empty($model)){
        array_push($error, "Enter your model");
    }

    if(empty($des)){
        array_push($error, "Desscription Cannot be empty");
    }

    if(empty($_FILES['image']['name'])){
        //if no error
        if(count($error) ==0){
            $update = "UPDATE cars set carname='$carname', model='$model', description='$des', color='$color', 
            platenumber='$platenumber' where id=$id ";

            if(mysqli_query($connect, $update)){
                echo "<script>alert('Car Updated Successfully')</script>";
            }else{
                echo "<script>alert('An error occured, please try agin')</script>";
            }
        }

    }else{
        $filename = $_FILES['image']['name'];
        $size = $_FILES['image']['size'];
        $filepath= "uploads/" . $_FILES['image']['name'];
        $ext = pathinfo($filepath, PATHINFO_EXTENSION);

        $extarray = ['png','jpg','jpeg'];
        if(!in_array($ext, $extarray)){
            array_push($error, "Invalid Extension");
        }

        if($size > 500000){
            array_push($error, "File is too large");
        }

        if(file_exists($filepath)){
            array_push($error, "The file already exist");
        }

        //if no error
        if(count($error) ==0){
            //upload the file
            move_uploaded_file($_FILES['image']['tmp_name'], $filepath);

            $update = "UPDATE cars set carname='$carname', model='$model', description='$des', color='$color', 
            platenumber='$platenumber', image='$filename' where id=$id ";


            if(mysqli_query($connect, $update)){
                echo "<script>alert('Car Updated Successfully')</script>";
            }else{
                echo "<script>alert('An error occured, please try agin')</script>";
            }
        }

    }

    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Edit Car - TaxiApp</title>
</head>
<body>
    <div class="container-fluid">
        <?php include('includes/nav.php'); ?>

        <div class="row justify-content-center">
            <div class="col-md-5 py-3">
                <?php 
                    $sql = "SELECT * FROM cars where id=$id ";
                    $query = mysqli_query($connect, $sql);
                    while($row = mysqli_fetch_assoc($query)):
                ?>

                <div class="card">
                    <div class="card-header text-center">Update <?=$row['carname']?></div>
                    <div class="card-body">
                        <img src="uploads/<?=$row['image']?>" class="img-fluid" alt="car">

                        <form action="editcar.php?id=<?=$id?> " 
                            method="post" enctype="multipart/form-data">
                            <div class="form-group my-3">
                                <input type="text" class="form-control"
                                    name="carname" value="<?=$row['carname']?>" placeholder="Car Name">
                            </div>
                            <div class="form-group my-3">
                                <input type="text" class="form-control" 
                                    name="model" value="<?=$row['model']?>" placeholder="Model">
                            </div>
                            <div class="form-group my-3">
                                <input type="text" class="form-control" 
                                    name="color" value="<?=$row['color']?>" placeholder="Color">
                            </div>
                            <div class="form-group my-3">
                                <input type="text" class="form-control" 
                                    name="platenumber" value="<?=$row['platenumber']?>" placeholder="Plate Number">
                            </div>
                            
                            <div class="form-group my-3">
                                <label for="desc">Description</label>
                                <textarea name="des" id="desc" cols="30" rows="5" 
                                class="form-control"><?=$row['description']?></textarea>
                            </div>
                            
                            <div class="form-group my-3">
                                <label for="">Car Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group my-3 text-center">
                                <input type="submit" class="btn btn-primary" 
                                name="add" value="Add Car">
                            </div>
                        </form>
                    </div>
                </div>

                <?php endwhile; ?>
            </div>
        </div>


    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>  
</body>
</html>