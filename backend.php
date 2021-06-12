<?php
session_start();

if($_POST){
    require 'db_key.php';
    $conn = connect_db();
    if(isset($_POST['register']) ){
        register($conn);
    }else if(isset($_POST['login']) ){
        login($conn);
    }
}else{
    header('location: index.php');
    exit();
}

/**
 * @param mysqli $conn
 */
function register(mysqli $conn)
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = (int)$_POST['role'];
    $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $passwordHashed = mysqli_real_escape_string($conn, $passwordHashed);
    $sql = "Select username From users Where username = '$username'";
    $sql = $conn->query($sql);
    $sql = $sql->fetch_assoc();
    if ($sql) {
        header('location: register.php');
        exit();
    } else {
        $sql = "Insert Into users (username, email, password, role_id) VALUES ('$username', '$email', '$passwordHashed', '$role')";
        $sql = $conn->query($sql);
        if ($sql) {
            echo "Registration succesful. You may <a href= '/'>login</a> now";

        }

    }
}

/**
 * @param mysqli $conn
 */
function login(mysqli $conn)
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "Select * From users left join role on users.role_id=role.role_id Where username = '$username'";
    $sql = $conn->query($sql);
    $sql = $sql->fetch_assoc();
    if (count($sql)) {
        if (password_verify($password, $sql['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['userRole'] = $sql['name'];
            echo 'You have successfully logged-in';
            header('location: account.php');
        }else{
            $_SESSION['error'] = "Incorrect password !";
            header('location: index.php');
        }
    } else {
        $_SESSION['error'] = "User not Found !";
        header('location: index.php');
    }
}
?>