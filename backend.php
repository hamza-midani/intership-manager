<?php
session_start();


if($_POST){
    require 'db_key.php';
    $conn = connect_db();
    if(isset($_POST['register']) ){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role=(int) $_POST['role'];
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
//sanitize your input
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $passwordHashed = mysqli_real_escape_string($conn, $passwordHashed);
//check for existing record
        $sql = "Select username From users Where username = '$username'";
        $sql = $conn->query($sql);
        $sql = $sql->fetch_assoc();
        if($sql){
            header('location: register.php');
            exit();
        }else{
            $sql = "Insert Into users (username, email, password, role_id) VALUES ('$username', '$email', '$passwordHashed', '$role')";
            $sql = $conn->query($sql);
            if($sql){
                echo "Registration succesful. You may <a href= '/'>login</a> now";

            }

        }
    }else if(isset($_POST['login']) ){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
        $sql = "Select * From users left join role on users.role_id=role.role_id Where username = '$username'";
        $sql = $conn->query($sql);
        $sql = $sql->fetch_assoc();
        if(count($sql)){
            if(password_verify($password, $sql['password'])){
                $_SESSION['username'] = $username;
                $_SESSION['userRole']=$sql['name'];
                echo 'You have successfully logged-in';
                header('location: account.php');
            }
        }else{
            $_SESSION['error']="Username or Password are incorrect !";
            header('location: index.php');
        }
    }
}else{
    echo json_encode($_POST);
    header('location: index.php');
    exit();
}
//header('location: index.php');
?>