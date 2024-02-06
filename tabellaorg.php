<!DOCTYPE html>
<html lang="it">
<?php include("check.php"); ?>
<head>
    <meta charset="UTF-8">
    <title>Tabella organizzatori</title>
    <?php ini_set('display_errors', 0);?>
    <style>
        input::placeholder{text-align: center;}
        @keyframes slideAndin{
            0%{
                background-color: white;
                transform: translateX(-100%);
                opacity: 0;
            }
            70%{background-color: green;}
            100%{
                background-color: none;
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideAndFade{
            0%{
                background-color: white;
                transform: translateX(0);
                opacity: 1;
            }
            100%{
                background-color: red;
                transform: translateX(-100%);
                opacity: 0;
            }
        }
        @keyframes flash-red{
            50%{background-color: red;}
        }
        body{font-family: Arial, sans-serif;}
        .flash-row{animation: flash-red 1s;}
        .dark-mode td{
            background-color: #242424;
            border: 5px solid #4A4A4A;
        }
        th{
            border: 5px solid #99C915;
            background-color: #99C915;
            font-size: 50px;
        }
        .dark-mode th{
            border-color: #0B3B1C;
            background-color: #0B3B1C;
            color: #969696;
        }
        td{border: 5px solid #ADADAD;}
        .dark-mode{
            background-color: #000000;
            color: #ffffff;
        }
        .dark-mode .resettar{
            background-color: #000000;
            color: red;
            border-color: red;
        }
        .dark-mode .cercar{
            background-color: #000000;
            color: green;
            border-color: green;
        }
        .dark-mode input{
            background-color: #000000;
            color: #ffffff;
        }
        .dark-mode table{color: white;}    
        .cercar:active{
            background-color: #98FB98;
            box-shadow: 0 0 #98FB98;
            transform: translateY(2px);
        }
        .resettar:active{
            background-color: #FF897B;
            box-shadow: 0 0 #FF897B;
            transform: translateY(2px);
        }
        .dark-mode .resettar:active{
            background-color: #FF897B;
            box-shadow: 0 0 #FF897B;
            transform: translateY(2px);
        }
        table{       
            border-radius: 15px !important;
            overflow: hidden;
            border-collapse: collapse;
            font-size: 35px;
        }
        .cercar{
            display: inline-block;
            font-weight: bold;
            text-align: center;
            border-color: green;
            cursor: pointer;
            border: 3px solid;
            color:#008000; 
            margin-left: 50px;
        }
        .resettar{
            font-size: 30px !important;
            font-weight: bold;
            text-align: center;
            background-color: #fff;
            border-color: red;
            cursor: pointer;
            border: 3px solid;
            color: red;
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
        .container2{width: 100%;}
        .totale{
            position: relative;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
        }
    @media only screen and (min-width: 1000px){
        table{
            width: 90%;
            height: 70%;
        }
        table th{height: 120px;}
        table td{
            font-size: 50px;
            height: 90px;
        }
        body{font-size: 35px;}
        .cercar{
            padding: 12px;
            font-size: 30px;
            border-radius: 10px;
        }
        .resettar{
            padding: 12px !important;
            font-size: 30px !important;
            border-radius: 10px;
        }
        input[type="text"]{
            width: 50%;
            height: 70px;
            font-size: 55px;
        }
        .id{top: 40px;}
        .totale{top: 30px;}
        .container{top: 67px;;}
        .container2{height: 30px;}
    }
    @media only screen and (max-width: 999px){
        table{width: 100%;}
        .totale{top: 140px;}
        table th{height: 150px;}
        table td{
            height: 90px;
            font-size: 45px;
        }
        .resettar{
            padding: 40px !important;
            font-size: 40px !important;
            border-radius: 30px !important;
        }
        .cercar{
            padding: 40px !important;
            font-size: 40px;
            border-radius: 30px;
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
	    .container2{height: 130px;}
    }
</style>
</head>
<body>
<script type="text/javascript" src="dark.js"></script>
    <form id="cercaForm">
        <div class="id"><input type="text" placeholder="RICERCA" name="cerca" id="cerca"></div>
        <div class="container">
            <button type="reset" class="resettar" onClick="resettat()">CANCELLA</button>
            <button type="button" class="cercar" onClick="cercaorga()">CERCA</button>
        </div>
        <div class="totale"><h1 style="color: #9E9E9E;" id="h1">NESSUN ORGANIZZATORE</h1></div>
    </form>
    <div class="container2"></div>
        <table id="orgTable" align=center>
            <thead>
                <tr bgcolor=dcdcdc>
                    <th>NOME</th>
                    <th>COGNOME</th>
                    <th>SOLDI</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
<script src="http://192.168.0.113:3000/socket.io/socket.io.js"></script>
<script>
    fetch('http://192.168.0.113:3000/org', {mode:'cors'})
    .then(response => response.json())
    .then(data=>{
        const tabella = document.querySelector('#orgTable tbody');
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
  
            const totCell = document.createElement('td');
            totCell.textContent = data.TOTALE_SOLDI;
            totCell.setAttribute('align', 'center');
            row.appendChild(totCell);

            row.style.animation = "slideAndin 0.3s forwards";
            setTimeout(function(){tabella.appendChild(row);}, 100);
        });
    })
    .catch(error=>{console.error('Errore nel recupero dei dati:', error);});

    function tot(){
        var cells=document.querySelectorAll("#orgTable tbody tr td:nth-child(3)");
        var total=0;
        var h1 = document.getElementById("h1");   
        for(var i=0; i<cells.length; i++){
            var cellValue = parseFloat(cells[i].textContent);
            if(!isNaN(cellValue)) total += cellValue;
        }
        if(cells.length!=0) h1.innerHTML = "TOTALE: <b>" + total + "</b>";
    }
   setInterval(tot, 1000);

    const socket = io('192.168.0.113:3000');
    setTimeout(()=>{ 
        socket.on('nuovaRigao', (nuovaRigao)=>{
            const tabellao = document.querySelector('#orgTable tbody');
            const row = document.createElement('tr');
            row.id = nuovaRigao.id;
            if(document.body.classList.contains("dark-mode")) row.style.backgroundColor = "#969696";
            else row.style.backgroundColor = "#D6D6D6";

            const nomeCell = document.createElement('td');
            nomeCell.textContent = nuovaRigao.nome;
            nomeCell.setAttribute('align', 'center');
            row.appendChild(nomeCell);
  
            const cognomeCell = document.createElement('td');
            cognomeCell.textContent = nuovaRigao.cognome;
            cognomeCell.setAttribute('align', 'center');
            row.appendChild(cognomeCell);

            const totCell = document.createElement('td');
            totCell.textContent = nuovaRigao.tots;
            totCell.setAttribute('align', 'center');

            row.appendChild(totCell);
            row.style.animation = "slideAndin 0.3s forwards";
            setTimeout(function(){tabellao.appendChild(row);}, 300);
        });
    }, 500);

    socket.on('euno', (response, buttonp)=>{
        var idn = buttonp.replace(/\D/g, '');
        var row = document.getElementById(idn);
        if(response.status == 200){
            row.style.animation = "slideAndFade 0.5s forwards";
            setTimeout(function(){row.remove(); location.reload();}, 500);
        }
        else{
            row.classList.add('shaking-row');
            setTimeout(function(){row.classList.remove('shaking-row');},550);
        }
    });

    socket.on('updateTot', (response)=>{
        const row = document.getElementById(response.ido);
        var val = row.cells[2].textContent;
        val = val.match(/\d+/g);
        if(val){
            val = parseInt(val[0]);
            row.cells[2].textContent = "";
            row.cells[2].textContent = (val + response.add).toString();
        }
    });

    socket.on('updateTotR', (response)=>{
        const row = document.getElementById(response.ido);
        var val = row.cells[2].textContent;
        val = val.match(/\d+/g);
        if(val){
            val = parseInt(val[0]);
            row.cells[2].textContent = "";
            row.cells[2].textContent = (val - response.add).toString();
        }
    });

    socket.on('eto',(id)=>{
        const tableRows = document.querySelectorAll('#orgTable tr');
        for(let i=1;i<tableRows.length;i++){
            const row = tableRows[i];
            row.style.animation = "slideAndFade 0.5s forwards";
            setTimeout(function(){row.remove(); location.reload();},500);           
        }  
    });

    socket.on('reloadOrg',()=>{location.reload();});

    var table = document.getElementById("orgTable");
    var rows = table.getElementsByTagName("tr");
    function resettat(){
        for(var i=1;i<rows.length;i++) rows[i].style.display = "";
    }

    function cercaorga(){
        var input = document.getElementById("cerca").value.toUpperCase();
        for(var i=1;i<rows.length;i++){
            var nome = rows[i].getElementsByTagName("td")[0].innerText;
            var cognome = rows[i].getElementsByTagName("td")[1].innerText;
            if(nome.includes(input) || cognome.includes(input)) rows[i].style.display = "";
            else rows[i].style.display = "none";
        }
    }

    document.addEventListener("keydown", function(event){
        if(event.keyCode === 13){
            event.preventDefault();
            cercaorga();
        }
    });
</script>
</body>
</html>
