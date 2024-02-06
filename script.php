<?php 
    if(isset($_SESSION['ultimo_accesso']) && (time()-$_SESSION['ultimo_accesso']>1)) {
        $_SESSION["autorizzato"]=NULL;
        header("Location: /login.html");
    }   
    $_SESSION['ultimo_accesso']=time();
?>