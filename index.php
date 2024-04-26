<!DOCTYPE html>
<html lang="it">
<head>
    <?php session_start(); session_unset();?>
    <meta charset="UTF-8">
    <title>Inserimento invitati</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .campop{width: 50%;}
        #statusl{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #7A7A7A;
            z-index: 99;
            transform: translateY(-100%);
            transition: transform 0.5s ease-in-out;
        }
        #statusl.active{transform: translateY(0);}
        .dark-mode #statusl{background-color: #3B3B3B;}
        .pulsantiO{margin-top: 6%;}
        .dark-mode .status, .dark-mode .statusRimosso{background-color: #303030;}
        .status, .statusRimosso{
            font-size: 50px;
            text-align: center;
            display: flex;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #A1A1A1;
            z-index: 99;
            transform: translateY(-100%);
            transition: transform 0.7s ease-in-out;
        }
        .statusRimosso{align-items: center;}
        .closep{
            position: absolute;
            top: 0;
            right: 0;
        }
        .status.active, .statusRimosso.active{transform: translateY(0);}
        p{color: black;}
        .dark-mode p{color: white;}
        body{
            font-size: 35px;
            font-family: Arial, sans-serif;
        }
        .dark-mode .pulsante{
            color: white;
            border-color: white;
        }
        .dark-mode .pulsante:active{
            background-color: #575757;
            box-shadow: 0 0 #575757;
            transform: translateY(2px);
        }
        .pulsante{
            padding: 30px;
            font-size: 30px;
            border-radius: 10px;
            display: inline-block;
            font-weight: bold;
            text-align: center;
            border-color: black;
            color: black;
            cursor: pointer;
            border: 3px solid;
            background-color: transparent;
        }
        .pulsante:active{
            background-color: #696969;
            box-shadow: 0 0 #696969;
            transform: translateY(2px);
        }
        .dark-mode{
            background-color: #000000;
            color: #ffffff;
        }
        .dark-mode .overlay{background-color: rgba(20, 20, 20, 0.8);}
        .overlay{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
        }
        .overlay-content{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            background-color: red;
            font-size: 24px;
        }
        .dark-mode button[type="reset"]{
            background-color: transparent;
            color: red;
            border-color: red;
        }
        .dark-mode button[type="submit"]{
            background-color: transparent;
            color: green;
            border-color: green;
        }
        .loginl{
            background-color: transparent;
        }
        .dark-mode .loginl{
            background-color: transparent;
            border-color: blue;
            color: blue;
        }   
        .dark-mode .selez{
            background-color: #000000;
            color: #ffffff;
            border: 3px solid #ccc;
        }
        .dark-mode select option{color: #fff;}
        .dark-mode input{
            background-color: #000000;
            color: #ffffff;
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
        .temasc{
            border: none;
            background-color: white;
            position: fixed;
            left: 0;
            bottom: 0;
            z-index: 1000;
        }
        .dark-mode .temasc{background-color: black;}
        .loginl:active{
            background-color: #9ED8FF;
            box-shadow: 0 0 #9ED8FF;
            transform: translateY(2px);
        }
        input{border: 3px solid #ccc;}
        .selez:checked{border-color: red;}

        @media only screen and (max-width: 1000px){
            .status{height: 350px;}
            .statusRimosso{height: 150px;}
            .pulsantiO{margin-top: 3%;}
            .pulsante{padding: 40px;}
            img{
                width: 50px;
                height: 50px;
            }
        }
        @media only screen and (min-width: 1056px) and (max-width: 1138px){
            .status{height: 330px;}
            .statusRimosso{height: 315px;}
            img{
                width: 30px;
                height: 30px;
            }
        }
        @media only screen and (min-width: 1000px) and (max-width: 1138px){
            .pulsantiO{margin-top: -2%;}
        }
        @media only screen and (min-width: 1000px){
            .status{height: 300px;}
            .resetta{margin-right:200px !important;}
            img{
                width: 30px;
                height: 30px;
            }
        }
        .testop{margin-bottom: 220px;}
        .formp, .bottonep{margin-bottom: 70px;}
    </style>
<script src="http://192.168.0.113:3000/socket.io/socket.io.js"></script>
<script>
    const socket = io('192.168.0.113:3000');
    document.addEventListener('DOMContentLoaded', function (){
        socket.on('connect', ()=>{socket.emit('requestOrg');});
        socket.on('organizzatoriData', (data)=>{
            const select = document.getElementById('selezio');
            if(data.error) console.error(data.error);           
            else if(data.empty){
                select.innerHTML += '<option value="" disabled>Nessun organizzatore trovato</option>';
                apri();
            }
            else data.forEach(org =>{select.innerHTML += `<option value="${org.ID}">${org.ID} - ${org.NOME} ${org.COGNOME}</option>`;});
        });
    });
</script>
</head>
<body>
    <?php require_once 'connessione.php';
        if($connessione->connect_error)
            echo '<script> document.addEventListener("DOMContentLoaded", function() { document.getElementById("overlay").style.display = "block"; }); </script>';
        $errorMessage = "ERRORE DI CONNESSIONE AL DATABASE!";
    ?>
    <div id="statusl" class="statusl">
        <div class="closep"><button style="border: none; background-color: transparent;" onclick="chiudil()"><img style="width: 80px; height: 80px; vertical-align: middle;" src="xp.png"/></button></div>
        <div class="testop"><p1 style="font-size: 80px; font-style: bold;">LOGIN</p1></div>
        <div class="formp"><form><input autocomplete="current-password" style="width: 100%;" type="password" id="password" placeholder="PASSWORD"></form></div>
        <div class="bottonep"><button class="loginl" style="border-color: white !important; color: white;" onclick="login()">ACCEDI</button> </div>
    </div>
    <div id="status" class="status">
        <div class="status-content">
            <p style="margin-top: 2%;"><b>Non sono presenti organizzatori, inserirne uno?</b></p>
            <div class="pulsantiO" style="display: flex; justify-content: center;">
                <div><button class="pulsante" onclick="chiudi()"><b>NO</b></button></div>
                <div style="margin-left: 40%;"><button class="pulsante" onclick="reindirizza()"><b>SI</b></button></div>
            </div>
        </div>
    </div>
    <div id="statusRimosso" class="statusRimosso">
        <p id="rimosso" style="margin-top: 2%;"><b></b></p>
    </div>
    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <p style="font-size: 50px;"><?php echo isset($errorMessage)? $errorMessage : ""; ?></p>
        </div>
    </div>
    <center><h1>INSERIRE DATI INVITATO</h1></center><br>
    <center>
        <input type="text" name="nome" id="nome" required placeholder="NOME"><br><br>
        <input type="text" name="cognome" id="cognome" required placeholder="COGNOME"><br><br>
	    <select name="orga" class="selez" id="selezio" required>
            <option value="ini">ORGANIZZATORE</option>
            <option value="" disabled></option>
        </select><br><br><br>

        <button type="reset" class="resetta" style="margin-right:25px">CANCELLA</button>
        <button type="submit" id="invio" style="color:#008000" onclick="inserimentoInv()">INSERISCI</button>
    </center><br><br><br>

    <center><button class="loginl" type="button" onclick="april(false)">LOGIN</button></center>  
    <div class="temas"><button style="background-color: transparent;" id="altern" class="temasc" onclick="darkmode()"><img id="imga" src="luna.png"/></button></div>

<script src="/dark.js"></script>
<script src="./jquery-3.6.0.min.js"></script>
<script>
    var pg;
    var campologin = document.getElementById('password');
    var statdiv = document.getElementById("status");
    var statldiv = document.getElementById("statusl");
    function apri(){statdiv.classList.add("active");}
    function chiudi(){statdiv.classList.remove("active");}   
    function reindirizza(){chiudi();april(true);}
    function april(check){
        pg = check? 'insorg.php' : 'selezione.php';
        statldiv.classList.toggle("active");
        campologin.focus();
    }
    function chiudil(){statldiv.classList.toggle("active");}

    var statrdiv = document.getElementById("statusRimosso");
    var prim = document.getElementById("rimosso");
    socket.on('nuovaRigaR', (inv)=>{
        prim.textContent = `Invitato rimosso: ${inv.nome} ${inv.cognome}`;
        statrdiv.classList.add("active");
        setTimeout(function(){statrdiv.classList.remove("active");}, 2000);
    });

    socket.on('RimossiTutti', ()=>{
        prim.textContent = `Rimossi tutti gli invitati`;
        statrdiv.classList.add("active");
        setTimeout(function(){statrdiv.classList.remove("active");}, 2000);
    });

    window.onload = function(){var input = document.getElementById("password"); input.select();};
    document.addEventListener("keydown", function(event){
        if(event.key === 'Enter'){
            event.preventDefault();       
            login();
        }
    });
    function login(){
        const password = document.getElementById("password").value;
        if(password !== null && password.trim() !== ''){
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    const response = this.responseText;
                    if(response === '2') alert('Errore nella connessione!');
                    else{
                        if(response === '1') window.location.href = pg;
                        else alert('Password errata. Accesso negato!');
                    }
                }
            };
            xhttp.open('POST', 'loginn.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send('password=' + password);
        }
        else alert('Fornire una password!');
    }

    function darkmode(){ 
        var element=document.body;
        var image=document.getElementById('imga');
        var isDarkMode = localStorage.getItem('dark') === 'dark'; 
        if(!isDarkMode){ 
            image.setAttribute('src', 'sole.png'); 
            localStorage.setItem('dark', 'dark'); 
        } 
        else{ 
            image.setAttribute('src', 'luna.png'); 
            localStorage.removeItem('dark'); 
        }
        element.classList.toggle("dark-mode"); 
    } 

    document.addEventListener('DOMContentLoaded', function(){
        showPopup();
        var image = document.getElementById('imga'); 
        if(localStorage.getItem('dark', 'dark')) image.setAttribute('src', 'sole.png');
        else image.setAttribute('src', 'luna.png');
    });

    function inserimentoInv(){
        const nome = document.getElementById('nome').value;
        const cognome = document.getElementById('cognome').value;
        const nomei = nome.toUpperCase();
        const cognomei = cognome.toUpperCase();
        const orga = document.getElementById('selezio').value;
        if(nome === "" || cognome === "" || (orga ==="" || orga ==="ini")) alert("Inserire dati mancanti!");
        else{
            const data = {nome: nomei, cognome: cognomei, orga: orga};
            socket.emit('ins-rec', data);
        }
    }

    socket.on('inserisci-record-response', (data)=>{
        if(data.response == '0') alert('Invitato inserito con successo con ID pagamento: ' + data.idp);
        else alert('Errore durante l\'inserimento dell\'invitato');
    });

    document.getElementById('selezio').addEventListener('change', function(){
        var selectedValue = this.value;
        localStorage.setItem('selectedValue', selectedValue);
        color(selectedValue);
    });
    
    var storedValue = localStorage.getItem('selectedValue');
    if(storedValue){
        document.getElementById('selezio').value = storedValue;
        color(storedValue);
    }

    function color(value){
        var sel = document.getElementById("selezio");
        var sV = sel.value;
        if(value === "ini" || sV === "ini") sel.style.color = "#757575";
        else sel.removeAttribute("style");
    }

    function setCookie(days){
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        document.cookie = "prezzoinserito=true; expires=" + date.toUTCString() + "; path=/";
    }

    function checkCookie(name){
        var cookies = document.cookie.split(';');
        for(var i=0; i<cookies.length; i++){
            var cookie = cookies[i].trim();
            if(cookie.startsWith(name + '=')) return true;
        }
        return false;
    }

    function showPopup(){
        if(!checkCookie('prezzoinserito')){
            socket.emit('check-prezzo');
            socket.on('check-prezzo-response', (response)=>{
                if(response.stato == 0){
                    var prezzo = null;
                    while(prezzo == null || isNaN(prezzo) || prezzo == "")
                        prezzo = prompt("Inserisci il prezzo che ogni invitato deve pagare");
                    if(prezzo !== null){
                        socket.emit('ins-prezzo', prezzo);
                        socket.on('ins-prezzo-response', (respons)=>{
                            if(respons == '1') alert('Prezzo inserito');
                            else alert('Errore nell\'inserimento del prezzo');
                        });
                    }
                }
                else setCookie(1);
            });
        }
    }
</script>
</body>
</html>
