<?php 

    //Include constants.php
    include('../config/constants.php');

    // 1. Get the ID of Admin to be deleted
    $id = $_GET['id'];

    // 2. Create SQL Query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    // 3. Redirect to Manage Admin page with message (success/error)

    //Check whether the query exexcuted successfully
    if($res == true){
        //query execution succesful
        
        //Create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
        //Redirect to Manage Admin Page
        header("location:".SITEURL."admin/manage-admin.php");
    }
    else
    {
        //query execution failed
        $_SESSION['delete'] = "<div class='error'>Admin Delete Failed, Try again later</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

?>