<!DOCTYPE html>
<html lang="it">
<head>
    <title>Dashboard</title>
    <?php include("check.php");?>
    <style>
        @keyframes blink{
            0%, 100%{opacity: 1;}
            50%{opacity: 0;}
        }
        button{
            border: 5px solid;
            display: inline-block;
            border-radius: 15px;
            font-weight: bold;
            font-size: 50px;
            text-align: center;
            background-color: #fff;
            cursor: pointer;
        }
        .dark-mode button{background-color: #000000;}
        .blinking{animation: blink 2.5s infinite;}
        body{
            font-size: 35px;
            font-family: Arial, sans-serif;
        }
        .dark-mode{
            background-color: #000000;
            color: #ffffff;
        }
        button:active{transform: translateY(2px);}
        .pfila1:active{
            background-color: #98FB98;
            box-shadow: 0 0 #98FB98;
        }
        .pfila2:active{
            background-color: #FF6142;
            box-shadow: 0 0 #FF6142;
        }
        .sfila1:active{
            background-color: #FF897B;
            box-shadow: 0 0 #FF897B;
        }
        .sfila2:active{
            background-color: #9ED8FF;
            box-shadow: 0 0 #9ED8FF;
        }
        .tfila1:active{
            background-color: #FFB415;
            box-shadow: 0 0 #FFB415;
        }
        .tfila2:active{
            background-color: #FF5BD9;
            box-shadow: 0 0 #FF5BD9;
        }
        .qfila1:active{
            background-color: #00452E;
            box-shadow: 0 0 #00452E;
        }
        .qfila2:active{
            background-color: #0A2736;
            box-shadow: 0 0 #0A2736;
        }
        .qifila1:active{
            background-color: #686E23;
            box-shadow: 0 0 #686E23;
        }
        .qifila2:active{
            background-color: #312361;
            box-shadow: 0 0 #312361;
        }
        .dark-mode .selez{
            background-color: #000000;
            color: #C4C4C4;
            border: 5px solid #525252;
            border-radius: 15px;
        }
        .dark-mode select option{color: #C4C4C4;}
        .pfila1{color: green;}
        .pfila2{color: #a52a2a;}
        .sfila1{color: red;}
        .sfila2{color: blue;}
        .tfila1{color: #FF7F27;}
        .tfila2{color: #A91DE0;}
        .qfila1{color: #00875B;}
        .qfila2{color: #1B688F;}
        .qifila1{color: #A4AD38;}
        .qifila2{color: #573EAB;}
        @media only screen and (min-width: 1326px){
            .pfila1{
                padding: 20px;
                margin-right: 300px;
                width: 500px;
            }
            .pfila2{
                padding: 20px;
                width: 500px;
            }
            .sfila1{
                padding: 20px;
                margin-right: 300px;
                width: 500px;
            }
            .sfila2{
                padding: 20px;
                width: 500px;
            }
            .tfila1{
                padding: 20px;
                margin-right: 300px;
                width: 500px;
            }
            .tfila2{
                padding: 20px;
                width: 500px;
            }
            .qfila1{
                padding: 20px;
                margin-right: 300px;
                width: 500px;
            }
            .qfila2{
                padding: 20px;
                width: 500px;
            }
            .qifila1{
                padding: 20px;
                margin-right: 300px;
                width: 500px;
            }
            .qifila2{
                padding: 20px;
                width: 500px;
            }
        }

        @media only screen and (max-width: 1325px){
            .pfila1{
                width: 450px;
                padding: 10px;
                margin-right: 30px;
            }
            .pfila2{
                width: 450px;
                padding: 10px;
            }
            .sfila1{
                width: 450px;
                padding: 10px;
                margin-right: 30px;
            }
            .sfila2{
                width: 450px;
                padding: 10px;
            }
            .tfila1{
                width: 450px;
                padding: 10px;
                margin-right: 30px;
            }
            .tfila2{
                width: 450px;
                padding: 10px;
            }
            .qfila1{
                width: 450px;
                padding: 10px;
                margin-right: 30px;
            }
            .qfila2{
                width: 450px;
                padding: 10px;
            }
            .qifila1{
                padding: 10px;
                width: 450px;
                margin-right: 30px;
            }
            .qifila2{
                padding: 10px;
                width: 450px;
            }
            .selez{width: 90% !important;}
        }
    </style>
    <link rel="stylesheet" href="style.css">
    <script src="dark.js"></script>
    <script src="./jquery-3.6.0.min.js"></script>
    <script src="http://192.168.0.113:3000/socket.io/socket.io.js"></script>
</head>
<body>
    <h1 align=center>SELEZIONA L'ELEMENTO DA VISUALIZZARE</h1>
    <?php require_once './connessione.php'; 
        if($connessione->connect_error)
            echo("<center><p class='blinking' style='color: red; font-size: 55px'><b>ERRORE DI CONNESSIONE AL DATABASE!</b></p></center>");?>
    
    <center>
        <select name="orga" class="selez" id="selezio" required></center>
            <option value="0" style="text-align: center;">FILTRA CATEGORIA</option>
            <option value="" disabled></option>
            <option value="1" style="text-align: center;">GESTIONE INVITATI</option>
            <option value="2" style="text-align: center;">GESTIONE ORGANIZZATORI</option>
            <option value="3" style="text-align: center;">GESTIONE SOLDI</option>
        </select>
    </center><br><br>
    
    <center><button class="pfila1" type="button" onclick="window.location.href = 'tabella.php';">TABELLA<br>INVITATI</button>
    <button class="pfila2" type="button" onclick="window.location.href = 'tabellaorg.php';">TABELLA<br>ORGANIZZATORI</button></center><br><br><br>
    <center><button class="sfila1" type="button" onclick="window.location.href = 'tabellaelimina.php';">GESTIONE<br>INVITATI</button>
    <button class="sfila2" type="button" onclick="window.location.href = 'rimorg.php';">GESTIONE<br>ORGANIZZATORI</button></center><br><br><br>
    <center><button class="tfila1" type="button" onclick="window.location.href = 'tabnonpagato.php';">LISTA<br>D'ATTESA</button>
    <button class="tfila2" type="button" onclick="window.location.href = 'insorg.php';">INSERIMENTO<br>ORGANIZZATORE</button></center><br><br><br>
    <center><button class="qfila1" type="button" onclick="window.location.href = 'tabellaid.php';">TABELLA<br>STATO INVITATI</button>
    <button class="qfila2" type="button" onclick="window.location.href = 'tabellasoldi.php';">TABELLA<br>SOLDI</button></center><br><br><br>
    <center><button class="qifila1" type="button" onclick="window.location.href = 'tabellaerimossi.php';">TABELLA<br>RIMBORSI</button>
    <button class="qifila2" type="button" onclick="showPopup()">MODIFICA<br>PREZZO</button></center></center><br><br><br><br>
    <center><a href=index.php><img src=casa.svg style='width: 100px; height: 70px'></a></center>

<script>
    var tinv = document.querySelector(".pfila1");
    var torg = document.querySelector(".pfila2");
    var rinv = document.querySelector(".sfila1");
    var insorg = document.querySelector(".sfila2");
    var paginv = document.querySelector(".tfila1");
    var rorg = document.querySelector(".tfila2");
    var id = document.querySelector(".qfila1");
    var soldi = document.querySelector(".qfila2");
    var invrim = document.querySelector(".qifila1");
    var prezzo = document.querySelector(".qifila2");
    document.getElementById("selezio").addEventListener("change", function(){
        var selectedValue = this.value;
        if(selectedValue === "0"){
            tinv.removeAttribute("style");
            rinv.removeAttribute("style");
            torg.removeAttribute("style");
            insorg.removeAttribute("style");
            soldi.removeAttribute("style");
            paginv.removeAttribute("style");
            rorg.removeAttribute("style");
            id.removeAttribute("style");
            invrim.removeAttribute("style");
            prezzo.removeAttribute("style");
        }
        else if(selectedValue === "1"){
            rorg.style.display = "none";
            torg.style.display = "none";
            insorg.style.display = "none";
            soldi.style.display = "none";
            tinv.style.margin = "0px";
            rinv.style.marginRight = "0px";
            rinv.style.display = "";
            tinv.style.display = "";
            paginv.style.display = "";
            paginv.style.margin = "0px";
            id.style.margin = "0px";
            id.style.display = "";
            invrim.style.display = "";
            invrim.style.margin = "0px";
            prezzo.style.display = "none";
        }
        else if(selectedValue === "2"){
            soldi.style.display = "none";
            tinv.style.display = "none";
            rinv.style.display = "none";
            torg.style.display = "";
            insorg.style.display = "";
            rorg.style.display = "";
            paginv.style.display = "none";
            id.style.display = "none";
            invrim.style.display = "none";
            prezzo.style.display = "none";
        }        
        else{
            rorg.style.display = "none";
            torg.style.display = "none";
            insorg.style.display = "none";
            tinv.style.display = "none";
            rinv.style.display = "none";
            soldi.style.marginRight = "0px";
            soldi.style.transform = "translateY(-300px)";
            soldi.style.display = "";
            paginv.style.display = "none";
            id.style.display = "none";
            invrim.style.display = "none";
            prezzo.style.display = "";
            prezzo.style.transform = "translateY(-270px)";
        }        
    });
    const socket = io('192.168.0.113:3000');
    function showPopup(){socket.emit('check-prezzo');}
    let prezzoattuale
    socket.on('check-prezzo-response', (prezzoatt)=>{
        if(prezzoatt.prezzo != null) prezzoattuale = prezzoatt.prezzo;
        if(prezzoatt.stato == 1){
            prezzo = prompt("Il prezzo attuale è: " + prezzoatt.prezzo + "\nInserisci il prezzo desiderato:") 
            prezzo = parseFloat(prezzo);
            if(prezzo !== null && !isNaN(prezzo)) socket.emit('modificaPrezzo', prezzo); 
        }
        else if(prezzoatt.stato == 0){
            prezzo = prompt("Inserisci il prezzo che ogni invitato dovrà pagare:") 
            prezzo = parseFloat(prezzo);
            if(prezzo !== null && !isNaN(prezzo)) socket.emit('ins-prezzo', prezzo);
        }
        else if(prezzoatt.stato == 2) alert("Sono presenti degli invitati, impossibile modificare il prezzo!");
        else setTimeout(alert("Prezzo modificato con successo!\n" + prezzoattuale + " -> " + prezzo), 2000);
    });
    socket.on('ins-prezzo-response', (response)=>{
        if(response == 1) alert("Prezzo inserito con successo!");
        else alert("Errore. Prezzo NON inserito con successo");
    });
</script>   
</body>
</html>
