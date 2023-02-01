<?php
session_start(); 
//check if user is logged in
if(empty($_SESSION['email']) || !isset($_SESSION['email'])){
    header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>HomePage</title>
</head>
<body>
    <div class="container-fluid">
        <?php include('includes/nav.php'); ?>

        <div class="row justify-content-center">
            <div class="col-12 pt-4 text-center">
                Latest Orders
            </div>
            <div class="col-8 py-3">
                <table class="table table-bordered ">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>Orderid</th>
                            <th>Customer Name</th>
                            <th>Customer Location</th>
                            <th>Fare</th>
                            <th>Pickup Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#23232</td>
                            <td>Emeka Aponsus</td>
                            <td>34. Aba Road</td>
                            <td>&#8358;3,400</td>
                            <td>5:50 PM</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>  
</body>
</html>