<?php include("partials/menu.php") ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Change Password</h1>
            <br><br>

            <?php 
                if(isset($_GET['id']))
                {
                   $id = $_GET['id'];
                }
            
            ?>

            <form action="" method="POST">

                <table class="tbl-30">
                    <tr>
                        <td>Old Password: </td>
                        <td>
                            <input type="password" name="current_password" placeholder="Current Password">
                        </td>
                    </tr>

                    <tr>
                        <td>New Password: </td>
                        <td>
                            <input type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password: </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>

        </div>
    </div>

    <?php
        //Check whether the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //Get all the values from form
            $id = $_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);


            // Check whether the user with current ID and current password exist or not
            $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            if($res==true)
            {
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //User exist and pass can be change
                    if($new_password == $confirm_password)
                    {
                        // update the password
                        $sql2 = "UPDATE tbl_admin SET
                            password='$new_password'
                            WHERE id=$id
                        ";

                        // execute the query
                        $res2 = mysqli_query($conn, $sql2);

                        //check if query is executed or not
                        if($res2==true)
                        {
                            //password change succedd
                            $_SESSION['change-pwd'] = "<div class='success'>Password Change Successfully</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                        else
                        {
                            //Password change fail
                            //redirect to manage admin and show error message
                            $_SESSION['change-pwd'] = "<div class='error'>Password Change Fail</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        //redirect to manage admin and show error message
                        $_SESSION['pwd-not-match'] = "<div class='error'>Password doesn't match</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //user doesn't exist
                    $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
                    // redirect user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

            // Check whether the new password and confirm pasword match or not


            // Update password if all above is true

        }
    ?>

<?php include("partials/footer.php") ?>