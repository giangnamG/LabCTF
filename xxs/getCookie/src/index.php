<?php
    session_start();
    include './db_conn.php';
    if(!isset($_SESSION['logged'])){
        die(header('location: /login.php'));
    }
    if(isset($_POST['Logout'])){
        session_destroy();
        die(header('location: /index.php'));
    }
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT role FROM users where id = '$user_id'";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res))
        $role = $row['role'];
    if($role == 'admin')
        echo 'CTF{Cookie_Funny_93423ij3r45e}';
    if(isset($_POST['submit'])){
        $comment = $_POST['message'];
        $user_id = $_SESSION['user_id'];
        $stmt = mysqli_prepare($conn, "INSERT INTO comments (user_id, comments) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $user_id, $comment);
        mysqli_stmt_execute($stmt);
        header(header('location: /'));
    }
    $sql = "select * from comments";
    $res = mysqli_query($conn,$sql);
    $comments = array();
    while($row = mysqli_fetch_assoc($res))
        $comments[] = $row;
    function getUsername($conn,$id){
        $sql = "select username from users where id = '$id'";
        $res = mysqli_query($conn,$sql);
        $res = mysqli_fetch_assoc($res);
        return $res['username'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="./comment.css">
</head>
<body>
<form method="post">
    <div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-secondary">hi <?php echo $_SESSION['username']; ?></button>
    <button type="submit" name="Logout" class="btn btn-secondary">Logout</button>
    </div>
</form>
<br><br>
<hr>

<div class="container mt-5">
    <div class="row  d-flex justify-content-center">
        <div class="col-md-8">
            <div class="headings d-flex justify-content-between align-items-center mb-3">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">@</span>
                    </div>
                        <form method="post">
                            <div class="form-outline">
                                <textarea class="form-control" name="message" placeholder="some message ..." id="textAreaExample1" rows="6"></textarea>
                                <input class="form-label" type="submit" name="submit" for="textAreaExample" value="Send Message">
                            </div>
                        </form>
                    </div>
                <h5>comments</h5>
                <div class="buttons">
                    <span class="badge bg-white d-flex flex-row align-items-center">
                        <span class="text-primary">Comments "ON"</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                        </div>
                    </span>   
                </div>        
            </div>
            <?php foreach ($comments as $comment):?>
                <div class="card p-3 mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                    <div class="user d-flex flex-row align-items-center">
                    <img src="https://i.imgur.com/C4egmYM.jpg" width="30" class="user-img rounded-circle mr-2">
                    <span><small class="font-weight-bold text-primary">&nbsp;&nbsp;<?php echo getUsername($conn,$comment['user_id']);?></small> <small class="font-weight-bold"><?php echo $comment['comments']?></small></span>
                    </div>
                    <small>3 days ago</small>
                    </div>
                    <div class="action d-flex justify-content-between mt-2 align-items-center">
                    <div class="reply px-4">
                        <small>Remove</small>
                        <span class="dots"></span>
                        <small>Reply</small>
                        <span class="dots"></span>
                        <small>Translate</small>
                    </div>
                    <div class="icons align-items-center">
                        <i class="fa fa-check-circle-o check-icon text-primary"></i>
                    </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
</body>
</html>