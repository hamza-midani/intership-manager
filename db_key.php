<?php
$sql_host="localhost";
$sql_username="admin";
$sql_password='admin007321';
$sql_database="intership_manager";
function connect_db() {
    global $sql_host, $sql_username, $sql_password, $sql_database;
    $conn=new mysqli($sql_host,$sql_username,$sql_password);
    if(mysqli_connect_error($conn) !== null) {
        return false;
    }
    $conn -> select_db($sql_database);
    return $conn;
}
?>
