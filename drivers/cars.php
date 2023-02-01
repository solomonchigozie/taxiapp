<?php
session_start(); 
require 'includes/config.php';

//check if user is logged in
if(empty($_SESSION['email']) || !isset($_SESSION['email'])){
    header('location:login.php');
}
$error = [];
if(isset($_POST['add'])){
    $carname = mysqli_real_escape_string($connect,$_POST['carname']);
    $model = mysqli_real_escape_string($connect,$_POST['model']);
    $des = mysqli_real_escape_string($connect,$_POST['des']);
     
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

    if(count($error) ==0){
        //upload the file
        move_uploaded_file($_FILES['image']['tmp_name'], $filepath);

        $insert = "INSERT INTO cars(carname, model, description,image) 
        VALUES('$carname','$model', '$des', '$filename') ";

        if(mysqli_query($connect, $insert)){
            echo "<script>alert('Car Added Successfully')</script>";
        }else{
            echo "<script>alert('An error occured, please try agin')</script>";
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
    <title>Cars - TaxiApp</title>
</head>
<body>
    <div class="container-fluid">
        <?php include('includes/nav.php'); ?>

        <div class="row justify-content-center">
            <div class="col-md-8 pt-4 text-center">
                <div class="row">
                    <?php 
                        $sql = "SELECT * FROM cars ORDER BY ID DESC";
                        $query = mysqli_query($connect, $sql);
                        while($row = mysqli_fetch_assoc($query)):
                    ?>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h5> <?=$row['color']?> <?=$row['carname']?> </h5>
                            </div>
                            <div class="card-body">
                                <img src="uploads/<?=$row['image']?>" class="img-fluid" alt="car">
                                <p>
                                    <?=$row['description']?>
                                </p>
                                <p>
                                <a href="editcar.php?id=<?=$row['id']?>" class="btn-primary btn">Edit</a>
                                <a href="#" onclick='if(confirm("Are you sure")){location.href="cars.php?delete=<?=$row["id"]?>"}' class="btn-danger btn">Delete</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <div class="card">
                    <div class="card-header text-center">Add a New Car</div>
                    <div class="card-body">
                        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" 
                            method="post" enctype="multipart/form-data">
                            <div class="form-group my-3">
                                <input type="text" class="form-control"
                                    name="carname" placeholder="Car Name">
                            </div>
                            <div class="form-group my-3">
                                <input type="text" class="form-control" 
                                    name="model" placeholder="Model">
                            </div>
                            
                            <div class="form-group my-3">
                                <label for="desc">Description</label>
                                <textarea name="des" id="desc" cols="30" rows="5" 
                                class="form-control"></textarea>
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
            </div>
        </div>


    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>  
</body>
</html>