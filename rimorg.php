<!DOCTYPE html>
<html lang="it">
<?php include("check.php"); ?>
<head>
    <meta charset="utf-8">
    <title>Tabella rimozione organizzatori</title>
    <?php ini_set('display_errors', 0);?>
    <style>
    input::placeholder{text-align: center;}
    table{       
        border-radius: 15px !important;
        overflow: hidden;
        border-collapse: collapse;
        font-size: 50px;
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
    td{
        border: 5px solid #8C8C8C;
        border-color: #ADADAD;
    }
    .tabella1{
        background-color: transparent;
        color: red; 
        border: none;
        font-size: 50px !important;
        font-weight: bold;
        text-align: center;
    }
    img{
        width: 80px;
        height: 80px;
    }
    .dark-mode{
        background-color: #000000;
        color: #ffffff;
    }
    .dark-mode .resetta, .dark-mode .cerca{background-color: #000000;}
    .dark-mode input{
        background-color: #000000;
        color: #ffffff;
    }
    .dark-mode table{color: white;}
    .dark-mode .tabella1:active{background-color: #ff8c8c !important;}
    .resetta:active{
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
        color: red;
    }
    .cerca{
        display: inline-block;
        font-weight: bold;
        text-align: center;
        background-color: #fff;
        border-color: green;
        cursor: pointer;
        border: 3px solid;
        color: #008000; 
        margin-left: 50px;
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
    .container1{
        width: 100%;
        height: 190px;
    }
    input[type="text"]{
        vertical-align: middle;
        margin: 5px auto;
        padding: 10px;
        border: 5px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
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
    .tabella{
        font-size: 50px !important;
        font-weight: bold;
        text-align: center;
        background-color: transparent;
	}
    img{vertical-align: middle;}
	.tabella:active{background-color: #ff8c8c !important;}
    body{font-family: Arial, sans-serif;}

    @media only screen and (min-width: 1500px){
        body{font-size: 35px;}
        table{
            width: 90%;
            height: 70%;
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
        }
        table{width: 100%;}
        table th{
            height: 150px;
            font-size: 50px;
        }
        table td{
            height: 90px;
            font-size: 45px;
        }
        body{font-size: 45px;}
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
    @keyframes slideAndFade {
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
    <form id="primoform">
        <div class="id">
            <input type="text" placeholder="RICERCA" id="cercaa" style="display: inline-block;">
        </div>
        <div class="container">
            <button type="reset" onClick="resetta()" class="resetta">CANCELLA</button>
            <button type="button" class="cerca" onClick="cercaInvitato()" id="salvabtn">CERCA</button><br><br><br>
        </div>
    </form>
    <div class="container1"></div>
    <form id="secondoform">
        <table id="orgTable" align="center">
            <thead>
                <tr bgcolor="dcdcdc">
                    <th>NOME</th><th>COGNOME</th>
                    <th><button title="⚠️ Elimina tutti gli organizzatori presenti nel database!" id="buttonel" type="button" class="tabella1" onclick="eliminatutto()">RIMUOVI TUTTI</button></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </form>
<script src="http://192.168.0.113:3000/socket.io/socket.io.js"></script>
<script>
    fetch('http://192.168.0.113:3000/org', {mode: 'cors'})
    .then(response => response.json())
    .then(data => {
        const tabella = document.querySelector('#orgTable tbody');
        data.forEach(data =>{
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
            const buttonHTML = `<button id="button_${data.ID}" type="button" title="⚠️ Elimina organizzatore selezionato" class="tabella" style="border: none;" onclick="eliminaRecord(${data.ID}, '${data.NOME}', '${data.COGNOME}', this)"><img src="x.png"/></button>`;
            delCell.innerHTML = buttonHTML;
            delCell.setAttribute('align', 'center');
            row.appendChild(delCell);

            row.style.animation = "slideAndin 0.3s forwards";
            setTimeout(function(){tabella.appendChild(row);}, 100);
        });
    })
    .catch(error => {console.error('Errore nel recupero dei dati:', error);});

    const socket = io('192.168.0.113:3000');
    function eliminatutto(){
        if(confirm("Sei sicuro di voler rimuovere tutti gli organizzatori?"))
            socket.emit('eliminatorg', socket.id);
    }

    socket.on('eto', (id)=>{
        const tableRows = document.querySelectorAll('#orgTable tr');
        for(let i=1;i<tableRows.length;i++){
            const row = tableRows[i];
            row.style.animation = "slideAndFade 0.5s forwards";
            setTimeout(function(){row.remove();},500);
        }
        if(socket.id === id){
            setTimeout(function(){
                if(confirm("Confermare l'operazione?")) socket.emit('rEO', true);
                else socket.emit('rEO', false);  
            }, 500);
        }
    });

    socket.on('reloadOrg',()=>{location.reload();});
    
    function eliminaRecord(id, nome, cognome, button){
        var idb = button.id
        if(confirm("Sei sicuro di voler rimuovere l'organizzatore " + nome + " " + cognome + "?"))
            socket.emit('eliminarg', id, idb);
    }

    socket.on('euno', (response, buttonp) =>{
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
            setTimeout(function(){row.classList.remove('shaking-row'); button.style.display = 'block';},550);
        }
    });

    socket.on('nuovaRigao', (nuovaRigao) => {
        const tabella = document.querySelector('#orgTable tbody');
        var row = document.createElement('tr');
        row.id = nuovaRigao.id;
        if(document.body.classList.contains("dark-mode")) row.style.backgroundColor = "#969696";
        else row.style.backgroundColor = "#D6D6D6";
        const nomeCell = document.createElement('td');
        nomeCell.textContent = nuovaRigao.nome;
        nomeCell.setAttribute('align', 'center');
        row.appendChild(nomeCell);
  
        const cognomeCell = document.createElement('td');
        cognomeCell.setAttribute('align', 'center');
        cognomeCell.textContent = nuovaRigao.cognome;
        row.appendChild(cognomeCell);

        const delCell = document.createElement('td');
        delCell.innerHTML = `<button id="button_${nuovaRigao.id}" type="button" title="⚠️ Elimina organizzatore selezionato" class="tabella" style="border: none;" onclick="eliminaRecord(${nuovaRigao.id}, '${nuovaRigao.nome}', '${nuovaRigao.cognome}', this)"><img src="x.png"/></button>`;
        delCell.setAttribute('align', 'center');
        row.appendChild(delCell);

        row.style.animation = "slideAndin 0.3s forwards";
        setTimeout(function(){tabella.appendChild(row);}, 300);
    });

    var table = document.getElementById("orgTable");
    var rows = table.getElementsByTagName("tr");  
    function cercaInvitato(){
        var input = document.getElementById("cercaa").value.toUpperCase();

        for(var i=1;i<rows.length;i++){
            var nome = rows[i].getElementsByTagName("td")[0].innerText;
            var cognome = rows[i].getElementsByTagName("td")[1].innerText;
            if(nome.includes(input) || cognome.includes(input)) rows[i].style.display = "";
            else rows[i].style.display = "none";    
        }
    }

	function resetta(){
        for(var i=1;i<rows.length;i++) rows[i].style.display = "";
    }

    document.addEventListener("keydown", function(event){
        if(event.keyCode === 13){
            event.preventDefault();
            cercaInvitato();
        }
    });
</script>
</body>
</html>