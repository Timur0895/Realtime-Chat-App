<?php 
    session_start();
    include_once "php/config.php";
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE  unique_id = {$user_id}");
    if(mysqli_num_rows($sql) > 0 ){
        $row = mysqli_fetch_assoc($sql);
    }else{
        header("location: users.php");
    }
?>

<?php include_once 'header.php'; ?>

<body>
    <div class="wrapper">
        <section class="head">
            <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <h4>Profile Page</h4>
            <a href="php/logout.php?logout_id=<?php echo $row['unique_id']?>" class="logout">Выйти</a>
        </section>
        <header class="profile">
            <img src="php/images/<?=$row['img'];?>" alt="">
            <div class="details">
                <h3><?= $row['fname'] . " " . $row['lname'];?></h3>
                <p><?= $row['status']?></p>
                <h3>Дата Регистрации: </h3>
                <p><?= " " . $row['mday'] . " " . $row['month'] . " " . $row['year'];?></p>
            </div>
        </header>
    </div>
</body>



