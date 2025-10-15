<?php
session_start();
require 'db.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $user  = $_POST["user"] ?? '';
    $pass  = $_POST["pass"] ?? '';
    $email = $_POST["email"] ?? '';
    $cpf   = $_POST["cpf"] ?? '';
    // $m é se vai ser login ou cadastro
    $m     = $_POST["metodo"] ?? '';
    
    if(preg_match('/\s/', $pass) || preg_match('/\s/', $user)){
        die(json_encode(['error' => true, 'msg' => 'Pelo amor de Deus escreve direito']));
    }
    
    if(empty($user) || empty($pass) || empty($email) || empty($cpf)){
        die(json_encode(['error' => true, 'msg' => 'fax as coisas puta q pariu']));
    }
    
    try{
        
    } catch (PDOException $e){
        
    }
    
    
}

if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

?>