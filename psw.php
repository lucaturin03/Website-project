<?php
    $passwordr="lucabello1";

    require_once 'connessione.php';
    $result = $connessione -> query("SELECT psw FROM password");
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        echo 'Password presente: ';
        echo $row['psw'];
    }
    $hashedUser = crypt($passwordr, '$2a$07$usesomesillystringforsalt$');
    $result = null;
    $result = $connessione -> query("INSERT INTO password (psw) VALUES ('$hashedUser')");
    if(!$result) echo("<br><br>Password non inserita");
    else echo("<br><br>Password inserita");
    $connessione->close();
?>