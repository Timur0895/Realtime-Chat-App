<?php
    ob_start();
    session_start();
    include "php/config.php";
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE  unique_id = {$_SESSION['unique_id']}");
    if(mysqli_num_rows($sql) > 0 ){
        $row = mysqli_fetch_assoc($sql);
    };
?>

<?php include 'header.php';?>

<body>
    <div class="wrapper">
        <header class="head">
            <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <h4> My Profile</h4>
            <a href="php/logout.php?logout_id=<?php echo $row['unique_id']?>" class="logout">Выйти</a>
        </header>
        <section class="profile">
            <img src="php/images/<?=$row['img'];?>" alt="">
            <div class="details">
                <h3><?= $row['fname'] . " " . $row['lname'];?></h3>
                <p><?= $row['status']?></p>
                <h3>Дата Регистрации: </h3>
                <p><?= " " . $row['mday'] . " " . $row['month'] . " " . $row['year'];?></p>
            </div>
        </section>
        <form class="change" method="POST" enctype="multipart/form-data">
            <div class="status">
                <label>Change Status: </label>
                <input type="text" name="status" placeholder="<?= $row['status']?>">
            </div>
            <div class="field image">
                    <label>Change Image: </label>
                    <input type="file" name="image"/>
            </div>
            <div class="field buttom">
                    <input type="submit" name="submit" value="Change" />
            </div>
        </form>
        <?php
            if(isset($_POST['submit'])){
                $new_status = $_POST['status'];
                $current_image = $row['img'];
                
                if(isset($_FILES['image']['name'])){
                    $image_name = $_FILES['image']['name'];

                    $ext = end(explode(".", $image_name));
                    $image_name = "Changed_image_".rand(000, 999).'.'.$ext;
                    $src = $_FILES['image']['tmp_name'];
                    $destonation_path = "php/images/".$image_name;
                    $upload = move_uploaded_file($src, $destonation_path);

                    $remove_path = "php/images/".$current_image;

                    $remove = unlink($remove_path);
                } else {
                    $image_name = $current_image;
                }
                
                $sql2 = "UPDATE users SET status = '$new_status', img = '$image_name' WHERE unique_id = {$_SESSION['unique_id']}";
                $res = mysqli_query($conn, $sql2);
                header("location: profile.php");
            }
        
        ?>
    </div>
</body>