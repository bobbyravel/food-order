<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            // 1. Get the id and all details
            $id = $_GET['id'];

            // 2. Create query to get all details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            if($res==true)
            {
                // Count the rows to check whether id correct or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    // Get all the data from row
                    $row = mysqli_fetch_assoc($res);

                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    // Give error message and redirect to manage category page
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                    header("location:".SITEURL."admin/manage-category.php");
                }
            }
            else
            {
                // Redirect to manage category page
                header("location:".SITEURL."admin/manage-category.php");
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image!="")
                            {
                                ?>
                                <img src="<?php echo SITEURL; ?>admin/images/<?php echo $current_image; ?>" width="100px">
                                <?php
                            }
                            else
                            {
                                echo "<div class='error'>Image Not Found</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST["submit"]))
            {
                // 1. Get all values from form
                $id = $_POST["id"];
                $title = $_POST["title"];
                $current_image = $_POST["current_image"];
                $featured = $_POST["featured"];
                $active = $_POST["active"];

                // 2. Update new image if selected
                // Check if image selected
                if(isset($_FILES["image"]["name"]))
                {
                    // Get the image details
                    $image_name = $_FILES["image"]["name"];

                    // Check whether image is available or not
                    if($image_name != "")
                    {
                        // Image available
                        // A. Upload new image
                        //Auto rename image
                        //get the extension of our image (jpg, png, gif, etc) e.g. "food1.jpg"
                        $ext = end(explode(".", $image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g. Food_Category_834.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            //Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image. </div>";
                            //Redirect to add category
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //Stop the process
                            die();
                        }
                        // B. Remove current image
                        $remove_path = "../images/category".$current_image;
                        $remove = unlink($remove_path);

                        // Check whether the image is removed or not
                        // If failed then display message and stop process
                        if($remove==false)
                        {
                            $_SESSION["failed-remove"] = "<div class='error'>Failed to remove current image</div>";
                            header("location:".SITEURL."admin/manage-category.php");
                            die();
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                // 3. Update the database
                $sql =  "UPDATE tbl_category SET 
                title = '$title',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
                ";

                // Execute query
                $res = mysqli_query($conn, $sql);

                // Check whether query executed or not
                if($res==true)
                {
                    $_SESSION["update"] = "<div class='success'>Category Updated Successfully</div>";
                    header("location:".SITEURL."admin/manage-category.php");
                }
                else
                {
                    $_SESSION["udpate"] = "<div class='error'>Category Failed to Update</div>";
                    header("location:".SITEURL."admin/manage-category.php");
                }
            }
        ?>
    </div>
</div>


<?php include("partials/footer.php") ?>