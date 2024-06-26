<!DOCTYPE html>
<html lang="it">
<?php include("check.php"); ?>
<head>
    <meta charset="utf-8">
    <title>Tabella ID invitati</title>
    <script src="jquery-3.6.0.min.js"></script>
    <style>
        input::placeholder{text-align: center;}
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
        @keyframes flash-red{
            50%{background-color: red;}
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
        .container{
            position: relative;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .container2{
            width: 100%;
            height: 170px;
        }
        .flash-row {animation: flash-red 1s;}
        .dark-mode{
            background-color: #000000;
            color: #ffffff;
        }
        .dark-mode h2{color: #B3B3B3;}
        .dark-mode .res{
            background-color: #000000;
            color: red;
            border-color: red;
        }
        .dark-mode .cercar{
            background-color: #000000;
            color: green;
            border-color: green;
        }
        .dark-mode table{color: white;}
        .dark-mode td{
            background-color: #242424;
            border-color: #4A4A4A;
        }
        th{
            border: 5px solid #99C915;
            height: 120px;
            font-size: 50px;
            background-color: #99C915;
        }
        .dark-mode th{
            border: 5px solid #0B3B1C;
            height: 120px;
            font-size: 50px;
            background-color: #0B3B1C;
            color: #969696;
        }
        td{
            border: 5px solid #ADADAD;
            text-align: center;
            vertical-align: middle;
        }
        .dark-mode input[type='checkbox']{
            accent-color: black;
        }
        input[type='checkbox']{
            accent-color: grey;
            display: block;
            margin: 0 auto;
        }
        .res:active{
            background-color: #FF897B;
            box-shadow: 0 0 #FF897B;
            transform: translateY(2px);
        }
        .cercar:active{
            background-color: #98FB98;
            box-shadow: 0 0 #98FB98;
            transform: translateY(2px);
        }
        table{       
            border-radius: 15px !important;
            overflow: hidden;
            border-collapse: collapse;
            font-size: 35px;
        }
        .dark-mode input[type="text"]{
            border: 5px solid #424242;
            background-color: #000000;
            color: #ffffff;
        }
        input[type="text"]{
            border: 5px solid #ccc;
            vertical-align: middle;
            border-radius: 5px;
            box-sizing: border-box;
            margin: 5px auto;
            padding: 10px;
            display: inline-block;
        }
        .cercar{
            display: inline-block;
            font-weight: bold;
            text-align: center;
            border-color: green;
            border: 3px solid;
            cursor: pointer;
            background-color: #fff;
            color:#008000; 
            margin-left: 50px;
        }
        .res{
            display: inline-block;
            font-weight: bold;
            text-align: center;
            background-color: #fff;
            border-color: red;
            cursor: pointer;
            border: 3px solid;
            color:red;
        }
        body{
            font-size: 35px;
            font-family: Arial, sans-serif;
        }
        
    @media only screen and (min-width: 1070px){
        .cercar{
            padding: 12px;
            font-size: 30px;
            border-radius: 10px;
        }
        .res{
            padding: 12px !important;
            font-size: 30px !important;
            border-radius: 10px;
        }
        table{
            width: 90%;
            height: 70%;
	    }
        table th{
            font-size: 50px;
            height: 120px;
        }
        table td{
            font-size: 50px;
            height: 90px;
        }
        input[type="checkbox"]{
            transform: scale(6.0);
        }
        input[type="text"]{
            width: 50%;
            height: 70px;
            font-size: 55px;
        }
        .id{top: 40px;}
        .container{top: 67px;}
        .container1{
	        position: relative;
	        top: 40px;
            left: 0%;
            width: 100%;
            height: 0px;
            display: flex;
            justify-content: space-between;
        }
        .column{
            margin-right: auto;
            margin-left: auto;
        }
        .column1{
            margin-left: auto;
            margin-right: auto;
        }
        .container2{height: 220px;}
    }

    @media only screen and (max-width: 1069px){
        .res{
            padding: 40px !important;
            font-size: 40px !important;
            border-radius: 30px !important;
        }
        .cercar{
            padding: 40px !important;
            font-size: 40px;
            border-radius: 30px;
        }
        table{width: 100%;}
        table th{
            height: 150px;
            font-size: 50px;
        }
        table td{
            height: 110px;
            font-size: 45px;
        }
        input[type="checkbox"]{transform: scale(6.0);}
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
        .container1{
 	        position: absolute;
	        top: 400px;
            width: 100%;
            height: 100px;
        }
        .column{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 160px;
        }
        .column1{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 110px;
        }
	    .container2{height: 360px;}
    }
</style>
</head>
<body>
<script type="text/javascript" src="dark.js"></script>
    <form id="cercaForm">
        <div class="id"><input type="text" placeholder="RICERCA" name="cerca" id="cerca"></div>
        <div class="container">
            <button type="reset" class="res" onClick="resetta()">CANCELLA</button>
            <button type="button" class="cercar" onClick="cercaInvitato()" id="salvabtn">CERCA</button>
        </div>
    </form>
    <div class="container1">
        <div class="column"><h2 id="ninv">NESSUN INVITATO</h2></div>
    </div>
	<div class="container2"></div>
    <form id="secondoform">
        <table id="invitatiTable" align="center">
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>COGNOME</th>
                    <th>ID</th>
                    <th>PAGATO</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </form>
<script src="http://192.168.0.113:3000/socket.io/socket.io.js"></script>
<script>
    fetch('http://192.168.0.113:3000/idinvi',{mode: 'cors'})
    .then(response => response.json())
    .then(data =>{
        const tabella = document.querySelector('#invitatiTable tbody');
        data.forEach(data =>{
            const row = document.createElement('tr');
            row.id = data.ID;
            if(document.body.classList.contains("dark-mode")) row.style.backgroundColor = "#969696";
            else row.style.backgroundColor = "#D6D6D6";

            const nomeCell = document.createElement('td');
            nomeCell.textContent = data.NOME;
            row.appendChild(nomeCell);
  
            const cognomeCell = document.createElement('td');
            cognomeCell.textContent = data.COGNOME;
            row.appendChild(cognomeCell);

            const idCell = document.createElement('td');
            idCell.textContent = data.ID;
            row.appendChild(idCell);

            const pagatoCell = document.createElement('td');
            pagatoCell.id = "cell_" + data.ID;
            if(data.PAGATO == 1) pagatoCell.style.backgroundColor = 'green';
            else pagatoCell.style.backgroundColor = 'red';
            row.appendChild(pagatoCell);
  
            row.style.animation = "slideAndin 0.3s forwards";
            setTimeout(function(){tabella.appendChild(row);}, 300);
        });
    })
    .catch(error => {console.error('Errore nel recupero dei dati:', error);});

    const socket = io('192.168.0.113:3000');
    setTimeout(()=>{ 
        socket.on('nuovaRigaP',(nuovaRiga)=>{
            const tabella = document.querySelector('#invitatiTable tbody');
            const row = document.createElement('tr');
            row.id = nuovaRiga.idp;
            if(document.body.classList.contains("dark-mode")) row.style.backgroundColor = "#969696";
            else row.style.backgroundColor = "#D6D6D6";

            const nomeCell = document.createElement('td');
            nomeCell.textContent = nuovaRiga.nome;
            row.appendChild(nomeCell);
  
            const cognomeCell = document.createElement('td');
            cognomeCell.textContent = nuovaRiga.cognome;
            row.appendChild(cognomeCell);

            const idCell = document.createElement('td');
            idCell.textContent = nuovaRiga.idp;
            row.appendChild(idCell);

            const pagatoCell = document.createElement('td');
            pagatoCell.id = "cell_" + nuovaRiga.idp;
            if(nuovaRiga.pagato == 1) pagatoCell.style.backgroundColor = 'green';
            else pagatoCell.style.backgroundColor = 'red';
            row.appendChild(pagatoCell);
            
            row.style.animation = "slideAndin 0.3s forwards";
            setTimeout(function(){tabella.appendChild(row);}, 100);
        });

        socket.on('eliminaRecordPagante', (response, idp)=>{
            if(response.status == 200){
                console.log(idp);
                var row = document.getElementById(idp);
                row.style.animation = "slideAndFade 0.5s forwards";
                setTimeout(function(){row.remove();}, 500);
            }
        });

        socket.on('setio', (result)=>{
            for(let i=0;i<result.length;i++){
                var row = document.getElementById(result[i].ID);
                row.style.animation = "slideAndFade 0.5s forwards";
                setTimeout(function(){row.remove();}, 500);
            }
        });
    }, 500);

    socket.on('AggiornaStatoPagamento', (idp)=>{
        const tCell = document.getElementById("cell_" + idp);
        tCell.style.backgroundColor = 'green';
    });

    socket.on('azioneCompletata', (id)=>{
        const tableRows = document.querySelectorAll('#invitatiTable tr');
        for(let i=1;i<tableRows.length;i++){
            const row = tableRows[i];
            row.style.animation = "slideAndFade 0.5s forwards";
            setTimeout(function(){row.remove();},500);
        }  
    });

    socket.on('reloadInv',()=>{location.reload();});

    document.addEventListener("DOMContentLoaded", function(){
        function contaInvi(){
            var tab = document.getElementById('invitatiTable');
            var numeroRighe = tab.rows.length-1;
            var risultato = document.getElementById('ninv');
            if(numeroRighe > 0) risultato.textContent = `N° INVITATI: ${numeroRighe}`;
            else risultato.textContent = `NESSUN INVITATO`;
        }
        setInterval(contaInvi, 1000);
    });

    document.addEventListener("keydown", function(event){
        if(event.keyCode === 13){
            event.preventDefault();
            cercaInvitato();
        }
    });

    var table = document.getElementById("invitatiTable");
    var rows = table.getElementsByTagName("tr");
    function cercaInvitato(){
        var input = document.getElementById("cerca").value.toUpperCase();
        for(var i=1;i<rows.length;i++){
            var nome = rows[i].getElementsByTagName("td")[0].innerText.toUpperCase();
            var cognome = rows[i].getElementsByTagName("td")[1].innerText.toUpperCase();
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
