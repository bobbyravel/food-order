<?php 

    //Include constants.php
    include('../config/constants.php');

    //check whether id and image_name value is set or not
    if(isset($_GET["id"]) AND isset($_GET["image_name"]))
    {
        // 1. Get the ID of Admin to be deleted
        $id = $_GET['id'];
        $image_name = $_GET["image_name"];

        // 2. Remove physical image file
        if($image_name != "")
        {
            //image is available
            $path = "../images/category/".$image_name;
            //remove the image
            $remove = unlink($path);

            //if fail to remove image then add an error message and stop the process
            if($remove == false)
            {
                //set session message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                //redirect to manage category
                header("location:".SITEURL."admin/manage-category.php");
                //stop the process
                die();
            }
        }

        // 3. Create SQL Query to delete category
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        // 4. Redirect to Manage Admin page with message (success/error)

        //Check whether the query exexcuted successfully
        if($res == true){
            //query execution succesful
            
            //Create session variable to display message
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            //Redirect to Manage Admin Page
            header("location:".SITEURL."admin/manage-category.php");
        }
        else
        {
            //query execution failed
            $_SESSION['delete'] = "<div class='error'>Category Delete Failed, Try again later</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else
    {
        //redirect to manage category
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    
?>