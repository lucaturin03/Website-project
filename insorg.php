<!DOCTYPE html>
<html>
<?php include("check.php");?>
<head>
    <title>Inserimento organizzatore</title>
    <link rel="stylesheet" href="style.css">
<style>
    .dark-mode{
        background-color: #000000;
        color: #ffffff;
    }
    .dark-mode button[type="reset"]{
        background-color: #000000;
        color: red;
        border-color: red;
    }
    .dark-mode button[type="submit"]{
        background-color: #000000;
        color: green;
        border-color: green;
    }
    .dark-mode input{
        background-color: #000000;
        color: #ffffff;
    }
	input{border: 3px solid #ccc;}
    button[class="indietror"]:active{
        background-color: #98FB98;
        box-shadow: 0 0 #98FB98;
        transform: translateY(2px);
    }
    button[type="reset"]:active{
        background-color: #FF897B;
        box-shadow: 0 0 #FF897B;
        transform: translateY(2px);
    }
    button[type="submit"]:active{
        background-color: #98FB98;
        box-shadow: 0 0 #98FB98;
        transform: translateY(2px);
    }
    @media only screen and (min-width: 1000px){
        .resetta{margin-right: 200px !important;}
    }
</style>
<script type="text/javascript" src="./sessione/sessioneuno.js"></script>
</head>
<body>
    <script type="text/javascript" src="dark.js"></script>  
    <center><h1>INSERIRE DATI ORGANIZZATORE</h1></center><br>
    <center>
        <input type="text" id="nome" required placeholder="NOME"></input><br><br>
        <input type="text" id="cognome" required placeholder="COGNOME"></input><br><br><br>

        <button type="reset" class="resetta" style="color:red; margin-right:25px;">CANCELLA</button>
        <button type="submit" id="invio" style="color:#008000;" onclick="inserimentoOrg()">INSERISCI</button>
    </center><br><br><br><br>  
    <center><a href=index.php><img src=casa.svg style='width: 100px; height: 70px'></a></center>

<script src="http://192.168.0.113:3000/socket.io/socket.io.js"></script>
<script> 
    const socket = io('192.168.0.113:3000');
    function inserimentoOrg(){
        const nome = document.getElementById('nome').value;
        const nomeo = nome.toUpperCase();
        const cognome = document.getElementById('cognome').value;
        const cognomeo = cognome.toUpperCase();
        console.log("Nome: " + nomeo);
        console.log("Cognome:"+ cognomeo);
        if(nomeo !== "" && cognomeo !== ""){
            const data = {nome: nomeo, cognome: cognomeo,};
            socket.emit('insreco', data);
        }
        else alert("Inserire nome e cognome!");
    }
    
    socket.on('insrro', (response)=>{
        if(response === '0') alert('Organizzatore inserito con successo');
        else alert('Errore durante l\'inserimento dell\'organizzatore');
    });
</script>
</body>
</html>
