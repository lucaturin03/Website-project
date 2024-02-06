<?php
    ini_set('display_errors', 0);
    require_once 'connessione.php';
    session_start();
    $result = null;
    $passwordr = $_POST['password'];

    $result = $connessione -> query("SELECT psw FROM password");
    $psw = mysqli_fetch_array($result, MYSQLI_NUM);

    if(!$result){echo '2'; exit();}
    if(password_verify($passwordr, $psw[0])){
        session_regenerate_id(true);
        $_SESSION["autorizzato"]=1;
        //$_SESSION['ultimo_accesso']=time();
        echo '1';
        exit();
    } 
    else exit();
    $connessione->close();
?>