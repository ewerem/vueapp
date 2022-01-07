<?php

$con = new mysqli('localhost', 'root', '', 'vdb');
if($con->connect_error){
    die("Connection Failed".$con->connect_error);
}

$result = array('error'=>false);
$action = '';

if(isset($_GET['action'])){
    $action = $_GET['action'];
}

if($action == 'read'){
    $sql = $con->query("SELECT * FROM register");
    $users = array();
    while($row = $sql->fetch_assoc()){
        array_push($users, $row);
    }
    $result['users'] = $users;
}

if($action == 'create'){
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = $con->query("INSERT INTO register VALUES(null, '$name', '$email', '$phone')");
    
    if($sql){
        $result['message'] = "User added successfully!";
    }else{
        $result['error'] = true;
        $result['message'] = "Failed to add User";
    }
}

if($action == 'update'){
    $id = $_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = $con->query("UPDATE register SET name = '$name', email = '$email', phone = '$phone' WHERE id = '$id'");
    
    if($sql){
        $result['message'] = "User Updated successfully!";
    }else{
        $result['error'] = true;
        $result['message'] = "Failed to Update User";
    }
}

if($action == 'delete'){
    $id = $_POST['id'];
    $sql = $con->query("DELETE FROM register WHERE id = '$id'");
    
    if($sql){
        $result['message'] = "User Deleted successfully!";
    }else{
        $result['error'] = true;
        $result['message'] = "Failed to Delete User";
    }
}

echo json_encode($result);


?>