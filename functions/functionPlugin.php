<?php

/* 
 * Function for implements with plugin
 * 
 */

/*
 *  Launcher for all function
 */

function Launcher($chat_id,$reply_markup,$param){
    $functionParam =  explode("|",$param);
    if (function_exists($functionParam[0])) {
        // In position 0 this is a function     
        return $functionParam[0]($functionParam);
    } else {
       writeLog("La funzione".$functionParam." non esiste.");
       sendMail("C'è un errore nella funzione ",$functionParam[0]);
       return "Chiedo scusa per l'errore, ho già avvisato il mio gestore.";
    }
}

/*
 * Function ore
 * return time now
 * 
*/

function ore(){
    $houre = "Ora esatta: ".date("j F Y, H:i:s", time());
    return $houre;
}

/*
 * Function Read
 * return string
 * 
*/

function Read($link){
/*******************************************************
Trovate questo e altri script su http://www.manuelmarangoni.it
Autore: Manuel Marangoni
Data messa online dello script: 9 ottobre 2013
Lo script mostra come recuperare un feed rss da un link online.
Utilizza le funzioni dell'XML DOM di PHP.
*******************************************************/
// crea un nuovo oggetto XML DOM
$xmldom = new DOMDocument();

// carica il contenuto del feed presente al link indicato
// rss type http://messaggeroveneto.gelocal.it/rss/cmlink/rss-messaggero-veneto-udine-cronaca-1.9271567
// param in position 1
$linkNew = $link[1];
$xmldom->load($linkNew);

//recupera il nodo rappresentato da <item>
$nodo = $xmldom->getElementsByTagName("item");
$risultato = "";
//scorre tutti i nodi <item> della pagina
//for($i=0; $i<=$nodo->length-1; $i++){
for($i=0; $i<=$nodo->length-1; $i++){
    // Estraggo il contenuto dei singoli tag del nodo <item>
    $titolo = $nodo->item($i)->getElementsByTagName("title")->item(0)->childNodes->item(0)->nodeValue;
    $collegamento = $nodo->item($i)->getElementsByTagName("link")->item(0)->childNodes->item(0)->nodeValue;
    // Not used
    // $descrizione = $nodo->item($i)->getElementsByTagName("description")->item(0)->childNodes->item(0)->nodeValue;
  $risultato .= $titolo."\r\n".$collegamento."\r\n\r\n";
  }
return $risultato;
}