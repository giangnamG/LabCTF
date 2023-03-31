<?php
    session_start();
    include './db_conn.php';
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "select * from users where username = HEX('$username') and password = HEX('$password')";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res)) {
            $_SESSION['logged'] = 1;
            $_SESSION['username'] = $username;
            $sql = "select id from users where username = HEX('$username') and password = HEX('$password')";
            $res = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($res))
                $_SESSION['user_id'] = $row['id'];
            header(header('location: /'));
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
<div class="container">
    <div class="row" style="margin-top: 100px">
        <h4>Login</h4>
        <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="username" name="username" class="form-control" id="username" aria-describedby="username">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
            <label class="form-check-label" for="exampleCheck1"><a href="/register.php">Create Account </a></label>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
</body>
</html>