function login(){
    const password = document.getElementById("password").value;
    if(password !== null && password.trim() !== ''){
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const response = this.responseText;
                if(response === '2') alert('Errore nella connessione!');
                else{
                    if(response === '1') window.location.href = '/selezione.php';
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