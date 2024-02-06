<!DOCTYPE html>
<html lang="it">
<?php include("check.php"); ?>
<head>
    <meta charset="utf-8">
    <title>Tabella rimozione invitati</title>
    <?php ini_set('display_errors', 0);?>
    <style>
        input::placeholder{text-align: center;}
        table{       
            border-radius: 15px !important;
            overflow: hidden;
            border-collapse: collapse;
        } 
        .dark-mode td{
            background-color: #242424;
            border-color: #4A4A4A;
        }
        th{
            background-color: #99C915;
            border: 5px solid #99C915;
        }
        .dark-mode th{
            border: 5px solid #0B3B1C;
            background-color: #0B3B1C;
            color: #969696;
        }
        td{border: 5px solid #ADADAD;}
        img{
            width: 80px;
            height: 80px;
            vertical-align: middle;
        }
        .dark-mode{
            background-color: #000000;
            color: #ffffff;
        }
        .container1{width: 100%;}
        .tabella1{
            font-size: 50px !important;
            font-weight: bold;
            text-align: center;
	    }
        .tabella{
            font-size: 50px !important;
            font-weight: bold;
            text-align: center;
	    }
        .tabella:active{background-color: #ff8c8c !important;}
        .dark-mode button[type="reset"]{
            background-color: #000000;
            color: red;
            border-color: red;
        }
        .dark-mode .cerca{
            background-color: #000000;
            color: green;
            border-color: green;
        }
        .dark-mode input{
            background-color: #000000;
            color: #ffffff;
        }
        .dark-mode table{color: white;}
        .dark-mode .tabella{background-color: transparent;}
        .tabella{background-color: transparent;}
        .dark-mode .tabella1{background-color: transparent;}
        .tabella1{background-color: transparent;}
        .dark-mode .tabella1:active{background-color: #ff8c8c;}
        button[type="reset"]:active{
            background-color: #FF897B;
            box-shadow: 0 0 #FF897B;
            transform: translateY(2px);
        }
        .cerca:active{
            background-color: #98FB98;
            box-shadow: 0 0 #98FB98;
            transform: translateY(2px);
        }
        .resetta{
            display: inline-block;
            font-weight: bold;
            text-align: center;
            background-color: #fff;
            border-color: red;
            cursor: pointer;
            border: 3px solid;
        }
        .cerca{
            display: inline-block;
            font-weight: bold;
            text-align: center;
            background-color: #fff;
            border-color: green;
            cursor: pointer;
            border: 3px solid;
        }
        .id{
            position: relative;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
        }
        input[type="text"]{
            vertical-align: middle;
            margin: 5px auto;
            padding: 10px;
            border: 5px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            display: inline-block;
        }
        .dark-mode input[type="text"]{border: 5px solid #424242;}
        .container{
            position: relative;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
    @media only screen and (min-width: 1500px){
        body{
            font-size: 35px;
            font-family: Arial, sans-serif;
        }
        table{
            width: 90%;
            height: 70%;
            font-size: 35px;
        }
        table th{
            height: 120px;
            font-size: 50px;
        }
        table td{
            font-size: 50px;
            height: 90px;
        }
        input[type="text"]{
            width: 50%;
            height: 70px;
            font-size: 55px;
        }
        .cerca{
            padding: 12px;
            border-radius: 10px;
            font-size: 30px !important;
        }
        .resetta{
            padding: 12px !important;
            font-size: 30px !important;
            border-radius: 10px;
        }
        .id{top: 40px;}
        .container{top: 95px;}
        .container1{height: 50px;}
    }
    @media only screen and (max-width: 1499px){
        .resetta{
            padding: 40px !important;
            font-size: 40px !important;
            border-radius: 30px !important;
        }
        .cerca{
            padding: 40px;
            font-size: 40px;
            border-radius: 30px;
            border: 3px solid;
        }
        table{
            width: 100%;
            font-size: 35px;
        }
        table th{
            height: 150px;
            font-size: 50px;
        }
        table td{
            height: 90px;
            font-size: 45px;
        }
        body{
            font-family: Arial, sans-serif;
            font-size: 45px;
        }
        input[type="text"]{
            width: 90%;
            height: 130px;
            font-size: 100px;
        }
        .id{
            top: 100px;
            height: 100px;
        }
        .container{top: 210px;}
        .container1{height: 200px;}
    }
    @keyframes flash-red{
        50%{background-color: red;}
    }
    .flash-row {animation: flash-red 1s;}
    @keyframes slideAndFade{
        0%{
            transform: translateX(0);
            opacity: 1;
        }
        100%{
            transform: translateX(-100%);
            opacity: 0;
        }
    }
    @keyframes shake{
        0%, 100%{transform: translateX(0);}
        25%{transform: translateX(-30px);}
        50%{transform: translateX(-50px);}
        75%{transform: translateX(-30px);}
    }
    @keyframes slideAndin{
        0%{
            transform: translateX(-100%);
            opacity: 0;
        }
        100%{
            transform: translateX(0);
            opacity: 1;
        }
    }
    .shaking-row{
        animation: shake 0.5s;
        background-color: red !important;
    }
    </style>
</head>
<body>
<script type="text/javascript" src="dark.js"></script>
    <form id="cercaForm">
        <div class="id"><input type="text" placeholder="RICERCA" id="cercaa"></div>
        <div class="container">
            <button type="reset" style="color:red;" onClick="resetta()" class="resetta">CANCELLA</button>
            <button type="button" class="cerca" style="color:#008000; margin-left: 50px;" onClick="cercaInvitato()" id="salvabtn">CERCA</button><br><br><br>
        </div>
    </form>
    <div class="container1"></div>
    <form id="secondoform">
        <table id="invitatiTable" align="center">
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>COGNOME</th>
                    <th><button title="⚠️ Elimina tutti gli invitati presenti nel database!" id="buttonel" type="button" class="tabella1" style="color: red; border: none;" onclick="eliminatutto()">RIMUOVI TUTTI</button></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </form>
<script src="http://192.168.0.113:3000/socket.io/socket.io.js"></script>
<script>
    document.addEventListener("keydown", function(event){
        if(event.keyCode === 13){
            event.preventDefault();
            cercaInvitato();
        }
    });

    fetch('http://192.168.0.113:3000/invi', {mode: 'cors'})
    .then(response => response.json())
    .then(data=>{
        const tabella = document.querySelector('#invitatiTable tbody'); 
        data.forEach(data=>{
            const row = document.createElement('tr');
            row.id = data.ID;
            if(document.body.classList.contains("dark-mode")) row.style.backgroundColor = "#969696";
            else row.style.backgroundColor = "#D6D6D6";

            const nomeCell = document.createElement('td');
            nomeCell.textContent = data.NOME;
            nomeCell.setAttribute('align', 'center');
            row.appendChild(nomeCell);
  
            const cognomeCell = document.createElement('td');
            cognomeCell.textContent = data.COGNOME;
            cognomeCell.setAttribute('align', 'center');
            row.appendChild(cognomeCell);
  
            const delCell = document.createElement('td');
            delCell.innerHTML = `<button id="button_${data.ID}" type="button" title="⚠️ Elimina invitato selezionato" class="tabella" style="border: none;" onclick="eliminaRecord(${data.ID}, '${data.NOME}', '${data.COGNOME}', this)"><img src="x.png"/></button>`;
            delCell.setAttribute('align', 'center');  
            row.appendChild(delCell);

            row.style.animation = "slideAndin 0.3s forwards";
            setTimeout(function(){tabella.appendChild(row);}, 100);
        });
    })
    .catch(error=>{console.error('Errore nel recupero dei dati:', error);});

    const socket = io('192.168.0.113:3000');
    function eliminatutto(){
        if(confirm("Sei sicuro di voler rimuovere tutti gli invitati?")) 
            socket.emit('eliminaTInv', socket.id);
    }

    socket.on('azioneCompletata',(id)=>{
        const tableRows = document.querySelectorAll('#invitatiTable tr');
        for(let i=1;i<tableRows.length;i++){
            const row = tableRows[i];
            row.style.animation = "slideAndFade 0.5s forwards";
            setTimeout(function(){row.remove();},500);
        }
        if(socket.id === id){
            setTimeout(function(){
                if(confirm("Confermare l'operazione?")) socket.emit('rispostaEliminazione', true);
                else socket.emit('rispostaEliminazione', false);               
            }, 1000);
        }
    });

    socket.on('reloadInv',function(){location.reload();});

    socket.on('nuovaRiga', (nuovaRiga)=>{
        const tabella = document.querySelector('#invitatiTable tbody');
        var row = document.createElement('tr');
        row.id = nuovaRiga.id;
        if(document.body.classList.contains("dark-mode")) row.style.backgroundColor = "#969696";
        else row.style.backgroundColor = "#D6D6D6";
        const nomeCell = document.createElement('td');
        nomeCell.textContent = nuovaRiga.nome;
        nomeCell.setAttribute('align', 'center');
        row.appendChild(nomeCell);
  
        const cognomeCell = document.createElement('td');
        cognomeCell.setAttribute('align', 'center');
        cognomeCell.textContent = nuovaRiga.cognome;
        row.appendChild(cognomeCell);

        const delCell = document.createElement('td');
        delCell.innerHTML = `<button id="button_${nuovaRiga.id}" type="button" title="⚠️ Elimina invitato selezionato" class="tabella" style="border: none;" onclick="eliminaRecord(${nuovaRiga.id}, '${nuovaRiga.nome}', '${nuovaRiga.cognome}', this)"><img src="x.png"/></button>`;
        delCell.setAttribute('align', 'center');
        row.appendChild(delCell);

        row.style.animation = "slideAndin 0.3s forwards";
        setTimeout(function(){tabella.appendChild(row);}, 300);
    });

    socket.on('setio',(result)=>{
        for(let i=0;i<result.length;i++){
            var row = document.getElementById(result[i].ID);
            row.style.animation = "slideAndFade 0.5s forwards";
            setTimeout(function(){row.remove();}, 500);
        }
    });

    function eliminaRecord(id, nome, cognome, button){
        var idb = button.id
        if(confirm("Sei sicuro di voler rimuovere l'invitato " + nome + " " + cognome + "?"))
            socket.emit('eliminarecord', id, idb);
    }

    socket.on('eliminarecordr', (response, buttonp) =>{
        if(response.status == 200){
            var buttone = document.getElementById(buttonp);
            var rowa = buttone.closest('tr');
            rowa.style.animation = "slideAndFade 0.5s forwards";
            setTimeout(function(){rowa.remove();}, 500);
        }
        else{
            var row = buttona.closest('tr');
            buttona.style.display = 'none';
            row.classList.add('shaking-row');
            setTimeout(function(){
                row.classList.remove('shaking-row');
                button.style.display = 'block';
            },550);
        }
    });

    var table = document.getElementById("invitatiTable");
    var rows = table.getElementsByTagName("tr");
    function cercaInvitato(){
        var input = document.getElementById("cercaa").value.toUpperCase();
        
        for(var i=1;i<rows.length; i++){
            var nome = rows[i].getElementsByTagName("td")[0].innerText;
            var cognome = rows[i].getElementsByTagName("td")[1].innerText;
            if(nome.includes(input) || cognome.includes(input)) rows[i].style.display = "";
            else rows[i].style.display = "none";
        }
    }
        
	function resetta(){
        for(var i=1;i<rows.length;i++) rows[i].style.display = "";
    }
</script>
</body>
</html>
