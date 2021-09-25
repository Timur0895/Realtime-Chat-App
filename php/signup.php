<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
        // let`s  check user email is  valid or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            // if email si valid
            //lets check that email already exist in the database or not
            $sql  = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0) {//if email alreday exist
                echo "$email - already exist";
            } else {
                //lets check  user uploadfile or not
                if(isset($_FILES['image'])){
                    // if file uploaded
                    $img_name = $_FILES['image']['name']; // getting user upload img name
                    $tmp_name = $_FILES['image']['tmp_name']; // this temporary name is used to save/movefile in our folder

                    //lets explode image and get the last extension like jpg png
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode); // here we get the extension of anuser uploaded image file

                    $extensions = ['png', 'jpeg', 'jpg']; // these are some valid img ext and  we`ve store them in  array
                    if(in_array($img_ext, $extensions) === true) {
                        // if user uploaded img ext is matched with any array extensions
                        $time = time(); // this will return us current time to make unique name img
                        // lets move the user uploaded img to our particular folder
                        $new_img_name = $time.$img_name;
                        if(move_uploaded_file($tmp_name, "images/".$new_img_name)) {// if user uploaded img move to our folder successfully
                            $status = "Active now"; // onse user signed up then this status will be active now
                            $random_id = rand(time(), 1000000); //  creating ranmdom  id for user
                            //  letsinsert all user data inside table
                            $gettime = getdate();
                                    $minutes = $gettime['minutes'];
                                    $hours = $gettime['hours'];
                                    $mday = $gettime['mday'];
                                    $month = $gettime['month']; 
                                    $year = $gettime['year'];
                            $sql2  = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname,  email, password, img, status, mday, month, year, hours, minutes) VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}', {$mday}, '{$month}', {$year}, {$hours}, {$minutes})");
                            if($sql2){
                                // if these  date inserted 
                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if(mysqli_num_rows($sql3) > 0) {
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['unique_id'] = $row['unique_id']; // using this session we used user unique_id in other php file
                                    echo "success";
                                }
                            }  else  {
                                echo "Something went wrong!";
                            }
                        }

                    } else {
                        echo "Please select an Image - jpg, jpeg, png!";
                    }
                }  else {
                    echo "Please select an Image!";
                }
            }
        } else {
            echo "$email - this is not a valid email";
        }
    } else {
        echo "Requered  All";
    };
?>



