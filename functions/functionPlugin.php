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
 * Function ore()
 * return time now
 * 
*/

function ore(){
    $houre = "Ora esatta: ".date("j F Y, H:i:s", time());
    return $houre;
}

/*
 * Function Read($link)
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
$linkNew = $link[1];
$xmldom->load($linkNew);
//recupera il nodo rappresentato da <item>
$nodo = $xmldom->getElementsByTagName("item");
$risultato = "";
// Scorre tutti i nodi <item> della pagina
// Limita a 7 il blocco di estrazione
for($i=0; $i<=$nodo->length-1; $i++){
     $conteggio = $conteggio + 1;
    if ($conteggio>8){
        break;
    } else {
        // Estraggo il contenuto dei singoli tag del nodo <item>
        $titolo = $nodo->item($i)->getElementsByTagName("title")->item(0)->childNodes->item(0)->nodeValue;
        $collegamento = $nodo->item($i)->getElementsByTagName("link")->item(0)->childNodes->item(0)->nodeValue;
        // Not used:
        // $descrizione = $nodo->item($i)->getElementsByTagName("description")->item(0)->childNodes->item(0)->nodeValue;
        $risultato .= $titolo."\r\n".$collegamento."\r\n\r\n";
        }
    } 
return $risultato;
}

/*
 * Fuction Estrai($link)
 * For extract txt from http://freetexthost.com/
 * 
 */
function Estrai($link){
  $linkNew = $link[1];
  $txt = file_get_contents($linkNew);
  $txt_i = "<div id=\"contentsinner\">";
  $txt_f = "[fine]";
  $off = "0";
  $letto = scrape($txt,$txt_i,$txt_f,$off);
  $letto = str_replace("<div id=\"contentsinner\">","" ,$letto);
  $letto = str_replace("<br />","" ,$letto);
  return $letto;
}

function scrape($testo,$txt_inizio,$txt_fine,$offset){
    $inizio = strpos($testo,$txt_inizio);
    $fine = strpos($testo,$txt_fine,$inizio);
    $daRestituire = substr($testo,$inizio,$fine-$inizio+$offset);
    return $daRestituire;
}

/*
 * Fuction FunzionePrevisioniMeteo($funzionePersonalizzata)
 * Previsioni Meteo da 3B Meteo
 * 
 */

function FunzionePrevisioniMeteo($funzionePersonalizzata){
    $startDate = time();
    $gg = $funzionePersonalizzata[3];
    $data = date('Y-m-d', strtotime('+'.$gg.' day', $startDate)); 
    /*
    * http://cdn4.3bmeteo.com/images/png_2014/2016-01-18_6_regione6_verdi.jpg
    * http://cdn4.3bmeteo.com/images/png_2014/2016-01-18_12_regione6_verdi.jpg
    * http://cdn4.3bmeteo.com/images/png_2014/2016-01-18_18_regione6_verdi.jpg
    * http://cdn4.3bmeteo.com/images/png_2014/2016-01-18_24_regione6_verdi.jpg            
    */ 
    $link = "http://cdn4.3bmeteo.com/images/png_2014/"."$data"."_".$funzionePersonalizzata[1]."_"."$funzionePersonalizzata[2]";  
    return $link;
}


/*
 * 
 * FINE FUNZIONI DI DEFAULT
 * 
 */
