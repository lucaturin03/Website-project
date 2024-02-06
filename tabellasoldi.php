<!DOCTYPE html>
<html>
<?php include("check.php"); ?>
<head>
  <title>Gestione economica</title>
  <style>
    .dark-mode .sinistrap{background-color: rgba(11, 59, 28, 0.4);}
    .diff, .sinistrap, .destrap{
      padding: 20px;
      display: flex;
      justify-content: center;
      border-radius: 15px;
      height: 90px;
    }
    .diff{
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 15%;
    }
    .sinistrap, .destrap{width: 43.7%;}
    .sinistrap{
      background-color: rgba(153, 201, 21, 0.4);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .dark-mode .destrap{background-color: rgba(120, 0, 0, 0.4);}
    .destrap{
      background-color: rgba(217, 22, 25, 0.4);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-left: 24px;
    }
    .par1, .par2, .par3{
      font-size: 50px;
      font-weight: bold;
      color: black;
    }
    .dark-mode .status{
      color: white;
      background-color: rgba(0, 0, 0, 0.9);
    }
    .status{
      font-size: 50px;
      color: black;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 150px;
      background-color: rgba(255, 255, 255, 0.9);
      z-index: 99;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }
    .status-content{z-index: 100;}
    .status.active{opacity: 1;}
    @keyframes fillOverlay{
      0%{left: -150%;}
      100%{left: 100%;}
    }
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button{
      -webkit-appearance: none;
      appearance: none;
      margin: 0;
    }
    .loader{
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .dot{
      width: 10px;
      height: 10px;
      background-color: white;
      border-radius: 50%;
      margin: 0 10px;
      animation: bounce 1.5s infinite ease-in-out;
    }
    .dot1{animation-delay: 0.2s;}
    .dot2{animation-delay: 0.4s;}
    .dot3{animation-delay: 0.6s;}
    @keyframes bounce{
      0%, 100%{transform: translateY(0);}
      50%{transform: translateY(-15px);}
    }
    .overlay{
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.9);
      z-index: 9999;
    }
    .overlay-content{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      font-size: 24px;
    }
    .dark-mode{
      background-color: #000000;
      color: #ffffff;
    }
    .dark-mode .table1 th{
      background-color: #0B3B1C;
      border: 3px solid #0B3B1C !important;
    }
    .dark-mode .sinistra th{
      background-color: #780000;
      border: 3px solid #780000 !important;
    }
    .dark-mode .tscuro{color: #969696 !important;}
    .dark-mode td{
      border: 3px solid #2B2528 !important;
      background-color: rgba(20, 20, 20, 0.4) !important;
    }
    .dark-mode .numero,.dark-mode .numerono{color: white;}
    body{
      font-size: 35px;
      font-family: Arial, sans-serif;
    }
    td{
      height: 50px !important;
      background-color: rgba(80, 80, 80, 0.1) !important;
    }
    .sinistra{
      max-height: 10px;
      overflow-y: auto;
    }
    table{
      border-collapse: collapse !important;
      width: 44% !important;
      border: 3px solid #B3B3B3;
      border-radius: 15px !important;
      overflow: hidden !important;
    }
    th, td{
      padding: 5px !important;
      text-align: left !important;
      border: 3px solid #B3B3B3 !important;
    }
    .table1 th{
      background-color: #99C915;
      border: 3px solid #99C915 !important;
    }
    .sinistra th{
      background-color: #D91619;
      border: 3px solid #D91619 !important;
    }
    th{
      height: 70px !important;
      background-color: #B3B3B3;
    }
    .dark-mode .ptab{color: #969696;}
    .dark-mode .stab{color: #969696;}
    .ptab{color: black;}
    .stab{color: black;}
    .numero, .numerono{
      border: none;
      outline: none;
      background-color: transparent;
      width: 100% !important;
      font-size: 40px !important;
      color: black;
    }
    .numero{text-align: center !important;}
    .tablea{
      display: flex !important;
      justify-content: space-around;
      gap: 70px;
    }
    .totali{
      display: flex !important; 
      width: 100%;
      height: 100%;
      justify-content: space-around;
      gap: 40px;
    }
    .table1{
      max-height: 10px;
      overflow-y: auto;
    }
    .dark-mode h2, .dark-mode p1{color: #ccc;}
    table td:active{background-color: #ccc !important;}
    .dark-mode table td:active{background-color: #2B2B2B !important;}
    .test{width: 20px !important;}
    @keyframes fadeIn{
      0%{
        opacity: 0;
        transform: translateY(-20px);
      }
      100%{
        opacity: 1;
        transform: translateY(0);
      }
    }
    @keyframes fadeOut{
      0%{
        opacity: 1;
        transform: translateY(0);
      }
      100%{
        opacity: 0;
        transform: translateY(-20px);
      }
    }
  </style>
</head>
<body>
  <script src="dark.js"></script>
  <?php require_once 'connessione.php';
    if($connessione->connect_error){
      echo("<center><p class='blinking' style='color: red; font-size: 55px'><b>ERRORE DI CONNESSIONE AL DATABASE!</b></p></center>");
      echo '<script>setTimeout(function(){window.location.href="selezione.php"}, 1500);</script>';
      die();
    }
    $query = "SELECT sum(TOTALE_SOLDI) AS TOTALE_SOLDI FROM organizzatori"; $result = $connessione->query($query); $row = $result->fetch_assoc();
    if($row['TOTALE_SOLDI'] == NULL) $risultato=0;
    else $risultato=$row['TOTALE_SOLDI'];
  ?>
  <h2 style="font-size: 80px;"><center>RIEPILOGO SPESE</center></h2>
  <div id="status" class="status">
    <div class="status-content">
      <div class="status-sfondo"></div>
      <p><b>Pagina bloccata per tutti gli altri utenti</b></p>
    </div>
  </div>
  <div class="tablea">
    <table id="dynamic-table" class="table1">
      <thead>
        <tr>
          <th colspan="2" class="ptab" style="font-size: 75px; text-align: center !important;">SOLDI AVUTI</th>
        </tr>
        <tr>
          <th class="tscuro" style="font-size: 55px; color: black;">DESCRIZIONE</th>
          <th class="tscuro" style="font-size: 55px; text-align: center; color: black;">EURO</th>
        </tr>
      </thead>
      <tbody>
        <tr id="0" class="test">
          <td class="numerono" style="border-right: 3px solid #ddd; background-color: #080808;">TOTALE SOLDI INVITATI</td>
          <td class="numero" style="background-color: #080808;" id="invi"><center><?php echo $risultato ?></center></td>
        </tr>
      </tbody>
    </table>

    <table id="dynamic-table1" class="sinistra">
      <thead>
        <tr>
          <th colspan="2" class="stab" style="font-size: 75px; text-align: center !important;">SOLDI SPESI</th>
        </tr>
        <tr>
          <th class="tscuro" style="font-size: 55px; color: black;">DESCRIZIONE</th>
          <th class="tscuro" style="font-size: 55px; text-align: center; color: black;">EURO</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div><br><br>
  <div class="totali">
    <div class="sinistrap"><p1 class="par1" id="par1">TOTALE SOLDI AVUTI: -</p1></div>
    <div class="destrap"><p1 class="par2" id="par2">TOTALE SOLDI SPESI: -</p1></div>
  </div><br><br>
  <center><div class="diff" id="diff"><p1 class="par3" id="par3"></p1></div></center>
  <div id="overlay" class="overlay">
  <div class="overlay-content">
    <p style="font-size: 70px; font-family: Arial, sans-serif;">LA PAGINA É BLOCCATA!<br><br>UN ALTRO UTENTE LA STA UTILIZZANDO</p>
    <div class="loader">
      <div class="dot dot1"></div>
      <div class="dot dot2"></div>
      <div class="dot dot3"></div>
    </div>
  </div>
</div>
<script src="http://192.168.0.113:3000/socket.io/socket.io.js"></script>
<script>
    let bloccata=false;
    let lockstatus=false;
    const socket = io('192.168.0.113:3000');
    const overlay = document.getElementById('overlay');

    document.addEventListener('DOMContentLoaded', function(){
      socket.emit('lockPage');
      var inputs = document.querySelectorAll("input");
      inputs.forEach(function (input){input.addEventListener('input',function(){});});
    });

    socket.on('pageStatus',({isLocked, lockedBy})=>{
      var statusElement = document.querySelector(".status");
      if(isLocked){
        if(lockedBy === socket.id){
          if(!lockstatus){
            statusElement.classList.add("active");
            setTimeout(function(){statusElement.classList.remove("active");},3000);
            lockstatus=true;
          }
          overlay.style.display = 'none';
          bloccata = false;
        } 
        else{
          statusElement.classList.remove("active");
          overlay.style.display = 'block';
          bloccata = true;
        }
      }
      else lockstatus=false;
    });

  socket.on('inputC',(datar)=>{
    const inputElement = document.getElementById(datar.id);
    if(inputElement){
      if(inputElement.value != datar.content && (socket.id !== datar.ids && datar.ids!==undefined)){
        inputElement.value = datar.content;
        const inputEvent = new Event('input',{bubbles: true, cancelable: true,});
        inputElement.dispatchEvent(inputEvent);
      }
    }
  });

  const rn = Math.random();
  const url = `http://192.168.0.113:3000/soldir?random=${rn}`;
  let datal;
  fetch(url, {mode:'cors'})
  .then(response => response.json())
  .then(data =>{
    datal = data;
    const tabella = document.querySelector('#dynamic-table tbody');
    if(Object.values(data).length === 0) aggiungr(tabella, 0, true);
    data.forEach((data, index)=>{
      const row = document.createElement('tr');
      row.id = data.ID;

      const descCell = document.createElement('td');
      descCell.innerHTML = `<input id="t1_${data.ID}" type='text' class='numerono' contenteditable='true' oninput='checkAndRemoveRow(this, true)' value="${data.DESCRIZIONE}"/>`;
      row.appendChild(descCell);
  
      const euroCell = document.createElement('td');
      euroCell.innerHTML = `<center><input id="n1_${data.ID}" type="number" style='text-align: center' class='numero' min='0' oninput='updateTotal(this, true)' contenteditable='true' value="${data.EURO}"/></center>`;
      row.appendChild(euroCell);

      tabella.appendChild(row);
      if(index === datal.length-1 || !hasRowBelow(index, tabella))
        aggiungr(tabella, datal[index].ID, true);
    });
  })
  .catch(error=>{console.error('Errore nel recupero dei dati: ', error);});

  const urll = `http://192.168.0.113:3000/soldid?random=${rn}`;
  let datall;
  let tmp;
  fetch(urll,{mode:'cors'})
  .then(response => response.json())
  .then(data =>{
    datall = data;
    const tabella = document.querySelector('#dynamic-table1 tbody');
    if(Object.values(data).length === 0) aggiungr(tabella, 0, false);
    data.forEach((data, index) =>{
      const row = document.createElement('tr');
      row.id = "#"+(data.ID);

      const descCell = document.createElement('td');
      descCell.innerHTML = `<input id="t2_${data.ID}" type='text' class='numerono' contenteditable='true' oninput='checkAndRemoveRow(this, false)' value="${data.DESCRIZIONE}"/>`;
      row.appendChild(descCell);
        
      const euroCell = document.createElement('td');
      euroCell.innerHTML = `<center><input id="n2_${data.ID}" type="number" style='text-align: center' class='numero' min='0' oninput='updateTotal(this, false)' contenteditable='true' value="${data.EURO}"/></center>`;
      euroCell.classList.add("test");
      row.appendChild(euroCell);

      tabella.appendChild(row);
      if(index === datall.length-1 && !hasRowBelow(index, tabella))
        aggiungr(tabella, datall[index].ID+1, false); 
    });
  })
  .catch(error=>{console.error('Errore nel recupero dei dati: ', error);});

  function aggiungr(tabella, data, tab){
    const row = document.createElement('tr');
    const descCell = document.createElement('td');
    const euroCell = document.createElement('td');
    row.id = tab ? data+1 : "#" + data;
    const nR = tab ? 1 : 2;
    descCell.innerHTML = '<input id="t'+ nR +'_'+(data+1)+'" type="text" class="numerono" contenteditable="true" oninput="checkAndRemoveRow(this, ' + tab + ')" value=""/>';
    euroCell.innerHTML = '<center><input id="n'+ nR +'_'+(data+1)+'" type="number" class="numero" style="text-align: center;" min="0" oninput="updateTotal(this, ' + tab + ')" contenteditable="true" value=""/></center>';
    if(!tab) euroCell.classList.add("test");
    descCell.addEventListener('input',function(){});
    euroCell.addEventListener('input',function(){});

    row.appendChild(descCell);
    row.appendChild(euroCell);
    row.style.animation = "fadeIn 0.5s ease-in-out";
    tabella.appendChild(row);
  }

  function hasRowBelow(currentRow, table1){
    let length = table1.rows.length;
    return (currentRow+1)<length;
  }

  function hasRowAbove(currentRow){return currentRow>0;}

  function isPreviousRowEmpty(row, table1){
    if(row<=0) return true;
    var inputField = table1.rows[row-1].cells[0].getElementsByTagName('input')[0];
    return !inputField || inputField.value.trim()==='';
  }

  function isallNextRowInputEmpty(row, table1){
    var length = table1.rows.length;
    for(let i=row;i<length;i++){
      var inputField = table1.rows[i].cells[0].getElementsByTagName('input')[0];
      if(!inputField || inputField.value.trim()!=='') return false;
    }
    return true;
  }

  function findPreviousNonEmptyRow(index, table){
    var previousRow = table.rows[index-1];
    if(!previousRow) return false;
    var inputField = previousRow.cells[0].getElementsByTagName('input')[0];
    var inputF = previousRow.cells[1].getElementsByTagName('input')[0];
    if(inputField && inputField.value.trim()!=='') return true;
    return false;
  }

  function checkAndRemoveRow(input, tab){
    const sTab = tab? "dynamic-table" : "dynamic-table1";
    var table1 = document.getElementById(sTab).getElementsByTagName('tbody')[0];
    var row = input.closest("tr");
    var rowid = row.id;
    rowid = parseFloat(rowid.match(/\d+/g));
    let nv;
    var num1 = table1.rows[rowid].cells[1].getElementsByTagName('input')[0];
    const id = input.getAttribute('id');
    const content = input.value;
    const ids = socket.id;
    const data = {id, content, ids}
    if(!bloccata) socket.emit('inputChange', data);

    input.addEventListener("input", function(event){
      var inputValue = event.target.value;
      event.target.value = inputValue;
    });

    var eurInput = row.querySelector('.numero').value;
    var descInput = row.querySelector('.numerono').value;
    const sEmit = tab? 'addsoldir' : 'addsoldid';
    if(input.value!==""){
      if(eurInput==='') eurInput = null;
      datar = {"id": rowid, "desc": descInput, "euro": eurInput};  
      socket.emit(sEmit, datar);

      if(!hasRowBelow(rowid, table1)){
        if(tab) aggiungr(table1, rowid, true);
        else aggiungr(table1, rowid+1, false);
      }
    }
    else if(eurInput==="" || descInput===""){
      if(hasRowBelow(rowid, table1) && descInput!==""){
        datam = {"id": rowid, "desc": descInput, "euro": null};
        socket.emit(sEmit, datam);
        num1.value = "";
      }

      if(hasRowBelow(rowid, table1) && descInput===""){
        datam = {"id": rowid, "desc": "", "euro": null};
        socket.emit(sEmit, datam);
        num1.value = "";
        nv="";
      }

      if(nv==="" && descInput==="" && isallNextRowInputEmpty(rowid+1, table1)){
        var i=rowid;
        const minimo = tab? 1 : 0;
        while(findPreviousNonEmptyRow(i, table1)===false){
          if(i>minimo) i--;
          else break;
        }
        var length = table1.rows.length;
        eliminaRigheCA(i, length, table1, tab);
      }
    }
  }

  async function eliminaRigheCA(i, length, table1, tab){
    var cellt = table1.rows[i].cells[1].getElementsByTagName('input')[0];
    const event = tab ? 'eliminasoldir' : 'eliminasoldid';
    for(let z=length-1;z>i;z--){
      const elementId = tab ? z : '#'+z;
      var edr = document.getElementById(elementId);
      await eliminaRiga(z, edr, tab, event);
    }
    cellt.value = "";
    socket.emit(event, i);
  }

  function eliminaRiga(id, edr, tab, event){
    return new Promise((resolve)=>{
      edr.style.animation = "fadeOut 0.5s ease";
      setTimeout(()=>{
        socket.emit(event, id);
        edr.parentNode.removeChild(edr);
        resolve();
      }, 300);
    });
  }

  function updateTotal(input, tab){
    caricamento(tab);
    checkAndRemoveRow(input, tab);
  }

  function caricamento(tab){
    const tabSelezionata = tab ? "#dynamic-table .numero" : "#dynamic-table1 .numero";
    const parSelezionato = tab ? "par1" : "par2";
    var inv = document.getElementById("invi").textContent;
    var total = tab ?  parseInt(inv) : 0;
    var cells=document.querySelectorAll(tabSelezionata);
    var paragraph = document.getElementById(parSelezionato); 
    for(var i=0; i<cells.length; i++){
      var cellValue = parseFloat(cells[i].value);
      if(!isNaN(cellValue)) total += cellValue;
    }
    const parTot = tab ? "AVUTI" : "SPESI ";
    paragraph.innerHTML = "TOTALE SOLDI " + parTot + ": <b>" + total + "</b>";
    diff();
  }

  function diff(){
    var pa1 = document.getElementById("par1").textContent;  
    pa1 = pa1.match(/\d+/g);
    var pa2 = document.getElementById("par2").textContent;  
    pa2 = pa2.match(/\d+/g);
    var pa3 = document.getElementById("par3");
    var dif = document.getElementById("diff");
    var element = document.body;

    pa1 = pa1-pa2;
    if(element.classList.contains('dark-mode')){
      if(pa1>0) dif.style.backgroundColor = "rgba(11, 59, 28, 0.4)";
      else if(pa1<0) dif.style.backgroundColor = "rgba(120, 0, 0, 0.4)";
      else dif.style.backgroundColor = "rgba(120, 120, 120, 0.4)";
    }
    else{
      if(pa1>0) dif.style.backgroundColor = "rgba(153, 201, 21, 0.4)";
      else if(pa1<0) dif.style.backgroundColor = "rgba(217, 22, 25, 0.4)";
      else dif.style.backgroundColor = "rgba(120, 120, 120, 0.4)";
    }
    pa3.innerHTML = "<b>" + pa1 + "</b>";
  }
  
  setInterval(()=>{caricamento(true); caricamento(false);}, 100);
</script>
</body>
</html>
