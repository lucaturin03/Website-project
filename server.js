const express = require('express');
const app = express();
const mysql = require('mysql2');
const mysqlpr = require('mysql2/promise');
const cors = require('cors');
const http = require('http');
const server = http.createServer(app);
const io = require('socket.io')(server, {cors: { origin:"*"}});
const bodyParser = require('body-parser');
const TelegramBot = require('node-telegram-bot-api');
//^ Costanti inizializzate con i moduli per far funzionare questo server Node ^

//Credenziali per connessione a database
global.HOST = 'localhost';
global.USER = 'luca';
global.PSW = 'utenteprova';
global.DB = 'organizzazione_festa';

//Creazione connessione al database
const db = mysql.createConnection({
  host: global.HOST,
  user: global.USER,
  password: global.PSW,
  database: global.DB
});

//Inizializzazione bot Telegram
const token = '6769367117:AAEj0_dWkgkMm68v5b7yGhin1iA6ETImWbo';
const bot = new TelegramBot(token, {polling: true});
bot.data = {};

//Gestione comando /start
bot.onText(/\/start/, (msg) => {
  const chatId = msg.chat.id;
  bot.sendMessage(chatId, 'Ciao, sono il bot della festa, come posso aiutarti?');
  bot.sendMessage(chatId, '/partecipa per assicurarti il posto.');
  bot.sendMessage(chatId, 'IMPORTANTE: se non ti sei registrato attraverso questo bot sarà impossibile recuperare il tuo ID con il comando /recupera in caso di smarrimento.');
});

//Funzione per gestione callback bot Telegram
bot.on('callback_query', (query)=>{
  const chatId = query.message.chat.id;
  if(!bot.data[chatId]) bot.data[chatId]={};
  switch (query.data){
    case 'yes':
      bot.deleteMessage(chatId, query.message.message_id);
      bot.sendMessage(chatId, "Inserisci il tuo nome.");
      bot.data[chatId].state = GETTING_N;
      break;
    case 'no':
      bot.sendMessage(chatId, "RICHIESTA ANNULLATA");
      bot.deleteMessage(chatId, query.message.message_id);
      break;
    case 'yes1':
      const userId = query.from.id;
      verificaIdTg(query.message, userId, chatId);
      bot.deleteMessage(chatId, query.message.message_id);
      break;
    case 'no1':
      bot.deleteMessage(chatId, query.message.message_id);
      bot.sendMessage(chatId, "Inserisci l'ID che ti è stato fornito.");
      bot.data[chatId].state = GETTING_ID;
      break;
    case 'yes2':
      EliminaDaLista(query.message, global.idr, chatId);
      bot.deleteMessage(chatId, query.message.message_id);
      break;
    case 'no2':
      bot.sendMessage(chatId, "OPERAZIONE ANNULLATA");
      bot.deleteMessage(chatId, query.message.message_id);
      break;
    default:
      break;
  }
  /*if(query.data === 'yes'){
    bot.deleteMessage(chatId, query.message.message_id);
    bot.sendMessage(chatId, "Inserisci il tuo nome.");
    bot.data[chatId].state = GETTING_N;
  } 
  else if(query.data === 'no'){
    bot.sendMessage(chatId, "RICHIESTA ANNULLATA");
    bot.deleteMessage(chatId, query.message.message_id);
  }
  else if(query.data === 'no1'){
    bot.deleteMessage(chatId, query.message.message_id);
    bot.sendMessage(chatId, "Inserisci l'ID che ti è stato fornito.");
    bot.data[chatId].state = GETTING_ID;
  } 
  else if(query.data === 'yes1'){
    const userId = query.from.id;
    verificaIdTg(query.message, userId, chatId);
    bot.deleteMessage(chatId, query.message.message_id);
  }
  else if(query.data === 'yes2'){
    EliminaDaLista(query.message, global.idr, chatId);
    bot.deleteMessage(chatId, query.message.message_id);
  }
  else if(query.data === 'no2'){
    bot.sendMessage(chatId, "OPERAZIONE ANNULLATA");
    bot.deleteMessage(chatId, query.message.message_id);
  }*/
});

//Gestione comando /partecipa
bot.onText(/\/partecipa/, (msg)=>{
  const chatId = msg.chat.id;
  const userId = msg.from.id;
  db.query('SELECT ID FROM checkpagato WHERE ID_TG = ?', userId, (error, results)=>{
    if(error) console.log("Errore");
    else{
      if(results.length === 1) bot.sendMessage(chatId, "Sei già registrato.");
      else partecipaMessage(chatId);
    }
  });
});
function partecipaMessage(chatId){
  const keyboard={
    reply_markup:{inline_keyboard:[[{ text: 'Si', callback_data: 'yes' }, { text: 'No', callback_data: 'no' }]]}
  };
  bot.sendMessage(chatId, "Vuoi inviare una richiesta di partecipazione alla festa?", keyboard);
}
function verificaNome(message){
  const chatId = message.chat.id;
  global.nome = message.text;
  bot.sendMessage(chatId, "Inserisci il tuo cognome.");
  bot.data[chatId].state = GETTING_C;
}
function verificaCognome(message){
  const chatId = message.chat.id;
  global.cognome = message.text;
  const userId = message.from.id;
  invio(chatId, userId);
  bot.data[chatId].state = null;
}
function invio(chatId, userId){ 
  const nC = generaNumeroCasuale();
  InserisciPagato(nC, null, global.nome, global.cognome, 0, userId);
  bot.sendMessage(chatId, "RICHIESTA INVIATA CON SUCCESSO");
  bot.sendMessage(chatId, "Il tuo ID partecipante è: " + nC);
  bot.sendMessage(chatId, "Una volta pagato verrai messo in lista e riceverai una notifica di conferma.");
}

//Gestione comando /verifica
bot.onText(/\/verifica/, (message)=>{
  const chatId = message.chat.id;
  VerificaMessage(chatId)
});
function VerificaMessage(chatId){
  const keyboard={reply_markup:{inline_keyboard:[[{ text: 'Si', callback_data: 'yes1' }, { text: 'No', callback_data: 'no1' }]]}};
  bot.sendMessage(chatId, "Ti sei registrato con questo bot?", keyboard);
}
function ottieniId(message){
  const chatId = message.chat.id;
  IDUtente = message.text;
  verificaIdNTg(message, IDUtente, chatId);
  bot.data[chatId].state = null;
}
function verificaIdTg(message, userId, chatId){
  db.query('SELECT PAGATO FROM checkpagato WHERE ID_TG = ?', userId, (error, results)=>{
    if(error) console.log("Errore");
    else{
      if(results.length === 1){
        if(results[0].PAGATO == 1) bot.sendMessage(chatId, "STATO: hai pagato, sei in lista.");
        else bot.sendMessage(chatId, "STATO: non hai pagato, non sei in lista.");
      }
      else bot.sendMessage(chatId, "ID non trovato nel database.");
    }
  });
}
function verificaIdNTg(message, userId){
  const chatId = message.chat.id;
  db.query('SELECT PAGATO FROM checkpagato WHERE ID = ?', userId, (error, results)=>{
    if(error) console.log("Errore");
    else{
      if(results.length === 1){
        if(results[0].PAGATO == 1) bot.sendMessage(chatId, "STATO: hai pagato, sei in lista.");
        else bot.sendMessage(chatId, "STATO: non hai pagato, non sei in lista.");
      }
      else bot.sendMessage(chatId, "ID non trovato nel database.");
    }
  });
}

//Gestione comando /recupera
bot.onText(/\/recupera/, (message)=>{
  const userId = message.from.id;
  const chatId = message.chat.id;
  db.query('SELECT ID FROM checkpagato WHERE ID_TG = ?', userId, (error, results)=>{
    if(error) console.log("Errore");
    else{
      if(results.length === 1){
        if(results[0].ID) bot.sendMessage(chatId, "Il tuo ID partecipante è: " + results[0].ID);
      }
      else bot.sendMessage(chatId, "Non sei ancora registrato.");
    }
  });
});

//Gestione comando /rimozione
bot.onText(/\/rimozione/, (message)=>{
  const userId = message.from.id;
  const chatId = message.chat.id;
  if (!bot.data[chatId]) bot.data[chatId]={};
  bot.sendMessage(chatId, "Potrai richiedere la rimozione fino a 7 giorni prima del giorno della festa.");
  setTimeout(()=>{bot.sendMessage(chatId, "Con la richiesta di rimozione verrai cancellato/a dalla lista e NON potrai partecipare alla festa.");},100);
  setTimeout(()=>{bot.sendMessage(chatId, "Inoltre dovrai venire TU a riprendere i soldi dati.");},200);
  setTimeout(()=>{
    db.query('SELECT ID FROM checkpagato WHERE ID_TG =?', userId, (error, results)=>{
      if(error) console.log("Errore");
      else{
        if(results.length === 1){
          if(results[0].ID){
            bot.sendMessage(chatId, "Il tuo ID partecipante è: " + results[0].ID);
            RimuoviMessage(chatId);
            global.idr = results[0].ID;
          }
        }
        else{
          bot.sendMessage(chatId, "Inserisci l'ID partecipante da rimuovere");
          bot.data[chatId].state = GETTING_IDR;
        }
      }
    });
  },500);
});
function richiediIdR(message){
  const chatId = message.chat.id;
  global.idr = message.text;
  RimuoviMessage(chatId);
  bot.data[chatId].state = null;
}
function RimuoviMessage(chatId){
  const keyboard = {reply_markup:{inline_keyboard:[[{text: 'Si', callback_data: 'yes2'}, {text: 'No', callback_data: 'no2'}]]}};
  bot.sendMessage(chatId, "Vuoi davvero essere rimosso/a dalla lista della festa?", keyboard);
}
function EliminaDaLista(message, userId, chatId){
  db.query('SELECT ID_PAGATO, NOME, COGNOME FROM checkpagato WHERE ID = ?', userId, (error, results)=>{
    setTimeout(()=>{ 
      if(error) console.log("Errore");
      else{
        if(results.length>0){
          db.query('SELECT ID_ORGANIZZATORE FROM invitati WHERE ID = ?', results[0].ID_PAGATO, (error, results)=>{
            if(error) console.log("Errore");
            else global.orga = results[0].ID_ORGANIZZATORE;
          });
          const risultatoNome = results[0].NOME;
          const risultatoCognome = results[0].COGNOME;
          db.query('INSERT INTO rimossi (ID, NOME, COGNOME) VALUES (?, ?, ?)', [userId, results[0].NOME, results[0].COGNOME], (error, results)=>{
            if(error) console.log("Errore");
            else{
              console.log("Inserito nella tabella rimossi");
              const nuovaRiga = {id: userId, nome: risultatoNome, cognome: risultatoCognome, stato: 0};
              io.emit('nuovaRigaR', nuovaRiga);
            }
          });
          if(results[0].ID_PAGATO!=null){
            db.query('DELETE FROM invitati WHERE ID = ?', results[0].ID_PAGATO, (error, results)=>{
              if(error) console.log("Errore");
              else console.log("Eliminato dalla lista invitati");
            });
          }
          db.query('DELETE FROM checkpagato WHERE ID = ?', userId, (error, results)=>{
            if(error) console.log("Errore");
            else{
              bot.sendMessage(chatId, "Stato: RIMOSSO/A dalla lista invitati");  
              console.log("Eliminato dalla lista paganti");
              numeriGenerati.delete(userId);
              io.emit('updateTotR', {ido: global.orga, add: global.prezzo});
            }
          });
        }
        else bot.sendMessage(chatId, "Nessun invitato trovato associato all'ID inserito"); 
      }  
    },500);
  });
};

//Variabili utilizzate globalmente dal bot di Telegram
const GETTING_N = 'getting_name';
const GETTING_C = 'getting_surname';
const GETTING_ID = 'getting_id';
const GETTING_IDR = 'getting_idr'

//Funzione per il controllo delle scelte dell'utente del bot di Telegram
bot.on('text', (msg)=>{
  const chatId = msg.chat.id; 
  if(bot.data[chatId] && bot.data[chatId].state === GETTING_N) verificaNome(msg);
  else if(bot.data[chatId] && bot.data[chatId].state === GETTING_C) verificaCognome(msg);
  else if(bot.data[chatId] && bot.data[chatId].state === GETTING_ID) ottieniId(msg);
  else if(bot.data[chatId] && bot.data[chatId].state === GETTING_IDR) richiediIdR(msg);
});

//Avvia server Node e specifico porta sulla quale il server ascolta
server.listen(3000,()=>{
  console.log("Server avviato sulla porta 3000");
  prezzo();
});

//Variabili utilizzate globalmente
global.prezzo = 0;
const waitingQueue = [];
const signalQueue = [];
let currentPageOwner = null;

//Connessione al server database
db.connect((err)=>{
  if(err) console.error('Errore nella connessione al database: ' + err.message); 
  else console.log('Connessione al server database stabilita');
});

//Selezione del prezzo dalla tabella soldi per gestione cookie pagina index.php
function prezzo(){
  db.query('SELECT PREZZO FROM soldi WHERE ID = 0', (err, results)=>{
    if(results.length>0){
      console.log("Prezzo presente: " + results[0].PREZZO)
      global.prezzo = results[0].PREZZO;
    }
  });
}

//Gestione RNG per ID nuovi partecipanti
const numeriGenerati = new Set();
function generaNumeroCasuale(){
  let nuovoNumero;
  do nuovoNumero = Math.floor(Math.random()*1000000); while(numeriGenerati.has(nuovoNumero));
  numeriGenerati.add(nuovoNumero); 
  return nuovoNumero;
}

//Connessione nuovo utente
io.on("connection",(socket)=>{
  console.log("Connesso con id: " + socket.id);

//Richiesta organizzatori per popolare menù a tendina nella pagina index.php e tabnonpagato.php
  socket.on('requestOrg', ()=>{
    db.query('SELECT ID, NOME, COGNOME FROM organizzatori', (error, results)=>{
      if(error) socket.emit('organizzatoriData', {error: 'Database query failed'});
      else{
        if(results.length === 0) socket.emit('organizzatoriData', { empty: true });
        else socket.emit('organizzatoriData', results);
      }
    });
  });

//Funzioni gestione coda utenti per la pagina tabella soldi
  function addToQueue(signal){signalQueue.push(signal);}

  socket.on('inputChange', (data)=>{
    addToQueue(data);
    sendSignals();
  });

  function sendSignals(){
    if(signalQueue.length>0){
      const datas = signalQueue.shift();
      io.emit('inputC', datas);
      sendSignals();
    }
  }

//Lock della pagina tabella soldi
  socket.on('lockPage', ()=>{
    console.log("Pagina bloccata");
    if(!currentPageOwner){
      console.log("Proprietario corrente pagina: " + currentPageOwner);
      currentPageOwner = socket.id;
      io.emit('pageStatus', {isLocked: true, lockedBy: socket.id});
    } 
    else{
      console.log("Proprietario corrente pagina: " + currentPageOwner);
      io.emit('pageStatus', {isLocked: true, lockedBy: currentPageOwner});
      waitingQueue.push(socket.id);
    }
  });

//Disconnessione di un utente da un socket nella pagina tabella soldi
  socket.on('disconnect', ()=>{
    if(currentPageOwner === socket.id){
      currentPageOwner = null; 
      if(waitingQueue.length>0){
        const nextUserId = waitingQueue.shift();
        currentPageOwner = nextUserId;
        io.to(nextUserId).emit('pageStatus', {isLocked: true, lockedBy: nextUserId});
      }
    } 
    else{
      const index = waitingQueue.indexOf(socket.id);
      if(index !== -1) waitingQueue.splice(index, 1);
    }
  });

//Controllo presenza prezzo nella tabella soldi
  socket.on('check-prezzo', ()=>{
    db.query ('SELECT PREZZO FROM soldi WHERE ID = 0', (err, results)=>{
      if(results.length>0){
        const prezzotrovato = results[0].PREZZO;
        db.query('SELECT ID FROM invitati', (err, results)=>{
          if(err) throw err;
          if(results.length>0){
            console.log("Ci sono degli invitati, impossibile aggiornare il prezzo");
            io.emit('check-prezzo-response', {stato: 2, prezzo: null});
          }
          else{
            console.log('Prezzo presente');
            socket.emit('check-prezzo-response', {stato: 1, prezzo: prezzotrovato});
          }
        });
      }
      else{
        console.log('Prezzo non presente');
        socket.emit('check-prezzo-response', {stato: 0, prezzo: null});
      }
    });
  });

//Inserimento prezzo nella tabella soldi
  socket.on('ins-prezzo', (prez)=>{
    db.query('INSERT INTO soldi (ID, PREZZO) VALUES (0, ?)', [prez], (err, results)=>{
      if(err){
        console.error('Errore durante l\'aggiunta del prezzo:', err);
        socket.emit('ins-prezzo-response', 0);
      }
      else{
        console.log('Prezzo aggiunto: ' + prez + ' euro');
        global.prezzo = prez;
        socket.emit('ins-prezzo-response', 1);
      }
    });
  });
  
//Modifica checkbox presenza invitati
  socket.on('modch', (id, stato)=>{
    db.query('UPDATE invitati SET PRESENZA = ? WHERE ID = ?', [stato, id], (err, results)=>{
        if(err) throw err;
        console.log("ID " + id + " - Dati salvati con successo, stato: " + stato);
        io.emit('updc', {id, stato});
      }
    );
  });

//Eliminazione di un invitato da tabelle: checkpagato, invitati
  socket.on('eliminarecord', (id, button)=>{
    db.query('SELECT ID_ORGANIZZATORE FROM invitati WHERE ID = ?', id, (err, results)=>{
      if(err) throw err;
      else global.orga = results[0].ID_ORGANIZZATORE;
    });
    db.query('DELETE FROM invitati WHERE ID = ?', id, (err, results)=>{
      if(err) throw err;
      db.query('SELECT ID, NOME, COGNOME, ID_TG FROM checkpagato WHERE ID_PAGATO = ?', id, (err, results)=>{
        if(results.length>0){
          const risultatoId = results[0].ID;
          const risultatoNome = results[0].NOME;
          const risultatoCognome = results[0].COGNOME;
          const idtg = results[0].ID_TG;
          db.query('INSERT INTO rimossi (ID, NOME, COGNOME) VALUES (?, ?, ?)', [risultatoId, results[0].NOME, results[0].COGNOME], (error, results)=>{
            if(error) console.log("Errore");
            else{
              const nuovaRiga = {id: risultatoId, nome: risultatoNome, cognome: risultatoCognome, stato: 0};
              io.emit('nuovaRigaR', nuovaRiga);
              console.log("Inserito nella tabella rimossi");
              if(idtg!=null) bot.sendMessage(idtg, "Stato: RIMOSSO/A dalla lista");
            }
          });
          numeriGenerati.delete(risultatoId);
          io.emit('eliminaRecordPagante', {status: 200}, risultatoId);
          io.emit('updateTotR', {ido: global.orga, add: global.prezzo});
        }
        else console.log('Nessun numero memorizzato salvato');
      });
      db.query('DELETE FROM checkpagato WHERE ID_PAGATO = ?', id, (err, results)=>{
        if(err) throw err;
        console.log("Eliminato l'invitato con id: " + id);
        io.emit('eliminarecordr', {status: 200}, button);
      });
    });
  });

//Eliminazione di tutti gli invitati da tabelle: checkpagato, invitati
  socket.on('eliminaTInv', (id)=>{
    db.beginTransaction(err=>{
      if(err) throw err;
      db.query('DELETE FROM checkpagato', (err, results)=>{
        if(err){return db.rollback(()=>{throw err;});}
        else console.log("Eliminati TUTTI gli id paganti");
      });
      db.query('DELETE FROM invitati', (err, results)=>{
        if(err){return db.rollback(()=>{throw err;});}
        io.emit('azioneCompletata', id);
        socket.on('rispostaEliminazione', (data)=>{
          if(data === true){
            db.commit(err =>{
              if(err){return db.rollback(()=>{throw err;});}
              console.log("Tutti gli invitati eliminati - commit");
              io.emit('RimossiTutti');
              numeriGenerati.clear();
            });
          } 
          else{
            db.rollback(()=>{console.log("Eliminazione annullata - rollback effettuato");});
            io.emit('reloadInv');
          }
        });
      });
    });
  });

//Rimozione soldi a tabellla soldi ricevuti
  socket.on('eliminasoldir', (id)=>{
    const query = 'DELETE FROM soldiricevuti WHERE ID = ?';
    db.query(query, [id], (err, results)=>{
      if(err) console.error('Errore durante l\'eliminazione dei soldi ricevuti:', err); 
      else console.log('Soldi ricevuti eliminati');
    });
  });

//Rimozione soldi a tabellla soldi dati
  socket.on('eliminasoldid', (id)=>{
  const query = 'DELETE FROM soldidati WHERE ID = ?';
    db.query(query, [id], (err, results)=>{
      if(err) console.error('Errore durante l\'eliminazione dei soldi dati:', err);
      else console.log('Soldi dati eliminati');
    });
  });

//Aggiunta soldi a tabellla soldi ricevuti
  socket.on('addsoldir', (data)=>{
    const {id, desc, euro} = data;
    const query1 = "SELECT ID FROM soldiricevuti WHERE ID = ?";
    db.query(query1, [id], (err, results)=>{
      if(err) console.error('Errore nella ricerca riga: ', err);
      if(results.length === 0){
        const query = "INSERT INTO soldiricevuti (ID, DESCRIZIONE, EURO) VALUES (?, ?, ?)";
        db.query(query, [id, desc, euro], (err, results)=>{
          if(err) console.error('Errore durante l\'aggiunta dei soldi ricevuti:', err);
          else console.log('Soldi dati aggiunti');
        });
      }
      else{
        const query = "UPDATE soldiricevuti SET DESCRIZIONE = ?, EURO = ? WHERE ID = ?";
        console.log('Descrizione soldi ricevuti: ' + desc + ', Soldi: ' + euro);
        db.query(query, [desc, euro, id], (err, results)=>{
          if(err) console.error('Errore durante la modifica dei soldi ricevuti:', err);
          else console.log('Modifica tabella soldi ricevuti');
        });
      }
    });
  });

//Aggiunta soldi a tabellla soldi dati
  socket.on('addsoldid', (data)=>{
    const {id, desc, euro} = data;
    const query1 = "SELECT ID FROM soldidati WHERE ID = ?";
    db.query(query1, [id], (err, results)=>{
      if(err) console.error('Errore nella ricerca riga: ', err);
      if(results.length === 0){
        const query = "INSERT INTO soldidati (ID, DESCRIZIONE, EURO) VALUES (?, ?, ?)";
        db.query(query, [id, desc, euro, id], (err, results)=>{
          if(err) console.error('Errore durante l\'aggiunta dei soldi dati:', err);
          else console.log('Soldi dati aggiunti');
        });
      }
      else{
        const query = "UPDATE soldidati SET DESCRIZIONE = ?, EURO = ? WHERE ID = ?";
        console.log('Descrizione soldi dati: ' + desc + ', Soldi: ' + euro);
        db.query(query, [desc, euro, id], (err, results)=>{
          if(err) console.error('Errore durante la modifica dei soldi dati:', err);
          else console.log('Modifica tabella soldi dati');
        });
      }
    });
  });

//Eliminazione di un organizzatore e gli invitati collegati da tabelle: checkpagato, invitati, organizzatori
  socket.on('eliminarg', (id, button)=>{
    db.query('SELECT ID FROM invitati WHERE ID_ORGANIZZATORE = ?', id, (err, results)=>{
      if(err) throw err;
      io.emit('setio', results);
    });
    if(results>0){
      for(let i=0; i<results.length; i++){
        db.query('DELETE FROM checkpagato WHERE ID_PAGATO = ?', results[i].ID, (err, results)=>{
          if(err) throw err;
          else console.log("Eliminati invitati con ID: " + results[i].ID + " dalla tabella paganti");
        });
      }
    }
    db.query('DELETE FROM invitati WHERE ID_ORGANIZZATORE = ?', id, (err, results)=>{
      if(err) throw err;
      console.log("Eliminati gli invitati con id sopra collegati all'organizzatore: " + id);
      db.query('DELETE FROM organizzatori WHERE ID=?', id, (err, results)=>{
        if(err) throw err;
        console.log("Eliminato l'organizzatore con id: " + id);
        io.emit('euno', {status: 200}, button);
      });
    });
  });

//Eliminazione di tutti gli organizzatori e invitati da tabelle: checkpagato, invitati, organizzatori
  socket.on('eliminatorg',(id)=>{
    db.beginTransaction(err=>{
      if(err) throw err;
      db.query('DELETE FROM checkpagato', (err, results)=>{
        if(err){return db.rollback(()=>{throw err;});}
        else console.log("Eliminati TUTTI gli id paganti");
      });
      db.query('DELETE FROM invitati',(err, results)=>{
        if(err){return db.rollback(()=>{throw err;});}
        console.log("Eliminati tutti gli invitati");
        db.query('DELETE FROM organizzatori',(err, results)=>{
          if(err){return db.rollback(()=>{throw err;});}
          console.log("Eliminati tutti gli organizzatori");
          io.emit('eto', id);
          socket.on('rEO', (data)=>{
            if(data === true){
              db.commit(err =>{
                if(err){return db.rollback(()=>{throw err;});}
                console.log("Tutti gli organizzatori eliminati - commit");
                io.emit('RimossiTutti');
                numeriGenerati.clear();
              });
            } 
            else{
              db.rollback(()=>{console.log("Eliminazione annullata - rollback effettuato");});
              io.emit('reloadOrg');
            }
          });
        });
      });
    });
  });

//Socket che richiama la funzione di inserimento di un invitato
  socket.on('ins-rec', (data)=>{
    InserisciInvitatoT(data.nome, data.cognome, data.orga, true);
  });

//Inserimento di un invitato invitato 
  function InserisciInvitatoT(nome, cognome, orga, check){
    return new Promise((resolve, reject)=>{
      async function findFreeID(){
        const connection = await mysqlpr.createConnection({
          host: global.HOST,
          user: global.USER,
          password: global.PSW,
          database: global.DB
        });
        let idc = 0;
        while(true){
          const [rows] = await connection.query('SELECT ID FROM invitati WHERE ID = ?', [idc]);
          if(rows.length === 0){
            console.log('ID libero trovato:', idc);
            const query = "INSERT INTO invitati (ID, ID_ORGANIZZATORE, NOME, COGNOME) VALUES (?, ?, ?, ?)";
            const values = [idc, orga, nome, cognome];
            db.query(query, values, (err, result)=>{
              if(err){
                console.error('Errore durante l\'inserimento dell\'invitato:', err);
                io.emit('inserisci-record-response', '1');
                reject(err);
              }      
              else{
                if(check){
                  const nC = generaNumeroCasuale();
                  InserisciPagato(nC, idc, nome, cognome, 1);
                  io.emit('inserisci-record-response', {response: 0, idp: nC});
                }
                console.log('Invitato inserito con successo con id: ' + idc + ' e id organizzatore: ' + orga);
                const nuovaRiga = {id: idc, nome: nome, cognome: cognome};
                io.emit('nuovaRiga', nuovaRiga);
                io.emit('updateTot', {ido: orga, add: global.prezzo});
                resolve(idc);
              }
            });
            break;
          } 
          idc++;
        }
        connection.end();
      }
      findFreeID();
    });
  }

//Inserimento nella tabella di un organizzatore
  socket.on('insreco', (data)=>{
    const nome = data.nome;
    const cognome = data.cognome;
    async function findFreeIDo(){
      const connection = await mysqlpr.createConnection({
        host: global.HOST,
        user: global.USER,
        password: global.PSW,
        database: global.DB
      });
      let idc = 0;
      while(true){
        const [rows] = await connection.query('SELECT ID FROM organizzatori WHERE ID = ?', [idc]);
        if(rows.length === 0){
          console.log('ID libero trovato:', idc);
          db.query("INSERT INTO organizzatori (ID, NOME, COGNOME, TOTALE_SOLDI) VALUES (?, ?, ?, ?)", [idc, nome, cognome, "0"], (err, result)=>{
            if(err){
              console.error('Errore durante l\'inserimento dell\'organizzatore:', err);
              io.emit('insrro', '1');
            }      
            else{
              console.log('Organizzatore inserito con successo con id: ' + idc);
              io.emit('insrro', '0');
              const nuovaRigao = {id: idc, nome: nome, cognome: cognome, tots: 0};
              io.emit('nuovaRigao', nuovaRigao);
            }
          });
          break;
        } 
        idc++;
      }
      connection.end();
    }
    findFreeIDo();
  });

//Conferma pagamento della quota di iscrizione
  socket.on('ConfermaRecordPagato', (data)=>{t(data);});
  async function t(data){
    try{
      const idp = await InserisciInvitatoT(data.nome, data.cognome, data.idorg, false);
      const id = data.id;
      setTimeout(function(){
          db.query("UPDATE checkpagato SET PAGATO = ?, ID_PAGATO = ? WHERE ID = ?", [1, idp, id], (err, result)=>{
          if(err) console.error('Errore durante l\'inserimento dell\'invitato nella tabella non pagato:', err);      
          else console.log('Invitato modificato con successo nella tabella pagato con id: ' + idp);
          io.emit('EliminaRecordPagato', id);
        });
        db.query("SELECT ID_TG FROM checkpagato WHERE ID = ?", id, (err, result)=>{
          if(err) console.error('Errore durante l\'inserimento dell\'invitato nella tabella non pagato:', err);      
          else bot.sendMessage(result[0].ID_TG, "Stato: AGGIUNTO/A in lista");
          io.emit('AggiornaStatoPagamento', id);
        });
      },100);
    } 
    catch(error){console.error('Errore:', error);}
  }

//Modifica stato rimborso di un invitato
  socket.on('modchR', (id, stato)=>{
    db.query('UPDATE rimossi SET RIMBORSO = ? WHERE ID = ?', [stato, id], (err, results)=>{
        if (err) throw err;
        console.log("ID " + id + " - Dati salvati con successo, stato rimborso: " + stato);
        const data = {id, stato};
        io.emit('updcR', data);
      }
    );
  });

//Modifica del prezzo
  socket.on('modificaPrezzo', (prezzo)=>{
    db.query('UPDATE soldi SET PREZZO = ? WHERE ID = 0', [prezzo], (err, results)=>{
      if(err) throw err;
      else{
        console.log("Prezzo modificato con successo");
        socket.emit('check-prezzo-response', {stato: 3, prezzo: null});
      }
    });
  });
});

//Inserimento nella lista checkpagato
function InserisciPagato(idc, id_pagato, nome, cognome, pagato, idtg){
  const query = "INSERT INTO checkpagato (ID, ID_PAGATO, NOME, COGNOME, PAGATO, ID_TG) VALUES (?, ?, ?, ?, ?, ?)";
  const values = [idc, id_pagato, nome, cognome, pagato, idtg];
  db.query(query, values, (err, result)=>{
    if(err) console.error('Errore durante l\'inserimento dell\'invitato nella tabella paganti:', err);      
    else{
      console.log('Invitato inserito con successo nella tabella paganti con id: ' + idc);
      const nuovaRigaP = {idp: idc, nome: nome, cognome: cognome, pagato: pagato};
      io.emit('nuovaRigaPagante', nuovaRigaP);
      io.emit('nuovaRigaP', nuovaRigaP);
    }
  });
}

//Sezione fetch dati tabelle varie
//------------------------------------------------------------------------------------------------------------------------------//
app.use(bodyParser.urlencoded({extended: false}));
app.use(cors({origin: "http://192.168.0.113", credentials: true}));

//Pagina gestione invitati in lista
app.get('/invi',(par, res)=>{
  const query = 'SELECT ID, NOME, COGNOME, PRESENZA FROM invitati ORDER BY NOME ASC';
  db.query(query,(err, results)=>{
    if(err){
      console.error('Errore nella query del database: ' + err.message);
      res.status(500).json({error: 'Errore nel recupero dei dati'});
    } 
    else res.json(results);
  });
});

//Pagina gestione invitati nella tabella che controlla lo stato del pagamento
app.get('/idinvi',(par, res)=>{
  const query = 'SELECT ID, NOME, COGNOME, PAGATO FROM checkpagato ORDER BY NOME ASC';
  db.query(query,(err, results)=>{
    if(err){
      console.error('Errore nella query del database: ' + err.message);
      res.status(500).json({error: 'Errore nel recupero dei dati'});
    } 
    else res.json(results);
  });
});

//Pagina gestione invitati rimossi da un organizzatori o autorimossi
app.get('/invirimossi',(par, res)=>{
  const query = 'SELECT ID, NOME, COGNOME, RIMBORSO FROM rimossi ORDER BY NOME ASC';
  db.query(query,(err, results)=>{
    if(err){
      console.error('Errore nella query del database: ' + err.message);
      res.status(500).json({error: 'Errore nel recupero dei dati'});
    } 
    else res.json(results);
  });
});

//Pagina gestione invitati paganti
app.get('/paganti',(par, res)=>{
  const query = 'SELECT ID, NOME, COGNOME FROM checkpagato WHERE PAGATO="0" ORDER BY NOME ASC';
  db.query(query,(err, results)=>{
    if(err){
      console.error('Errore nella query del database: ' + err.message);
      res.status(500).json({ error: 'Errore nel recupero dei dati' });
    } 
    else res.json(results);
  });
});

//Pagina gestione soldi (soldi dati)
app.get('/soldid',(par, res)=>{
  const query = 'SELECT ID, DESCRIZIONE, EURO FROM soldidati';
  db.query(query,(err, results)=>{
    if(err){
      console.error('Errore nella query del database: ' + err.message);
      res.status(500).json({ error: 'Errore nel recupero dei dati' });
    } 
    else res.json(results);
  });
});

//Pagina gestione soldi (soldi ricevuti)
app.get('/soldir',(par, res)=>{
  const query = 'SELECT ID, DESCRIZIONE, EURO FROM soldiricevuti';
  db.query(query,(err, results)=>{
    if(err){
      console.error('Errore nella query del database: ' + err.message);
      res.status(500).json({ error: 'Errore nel recupero dei dati' });
    } 
    else res.json(results);
  });
});

//Pagina organizzatori
app.get('/org',(par, res)=>{
  const query = 'SELECT ID, NOME, COGNOME, TOTALE_SOLDI FROM organizzatori ORDER BY NOME ASC';
  db.query(query,(err, results)=>{
    if(err){
      console.error('Errore nella query del database: ' + err.message);
      res.status(500).json({ error: 'Errore nel recupero dei dati' });
    } 
    else res.json(results);
  });
});

