<html lang="it">
<head>
    <script type="text/javascript" src="dark.js"></script>
    <link rel="stylesheet" href="base.css"/>
</head>
<body>
<script type="text/javascript" src="dark.js"></script>
<?php
    session_start();
    if(!isset($_SESSION["autorizzato"])){
        echo "<p style='color:red; font-size:100px' align=center><b>AREA RISERVATA!</b></p>";
        echo "<center><img src='divietoa.png'></center><br>";
        echo "<p style='font-size:55px' align=center><b>Autenticati per accedere a questa pagina</b></p>";
        echo "<center><a href='login.html'>LOGIN</a></center>";
        die();
    }
?>
</body>
</html>
