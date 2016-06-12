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
    if ($conteggio>14){
        break;
    } else {
        // Estraggo il contenuto dei singoli tag del nodo <item>
        $titolo = $nodo->item($i)->getElementsByTagName("title")->item(0)->childNodes->item(0)->nodeValue;
        $collegamento = $nodo->item($i)->getElementsByTagName("link")->item(0)->childNodes->item(0)->nodeValue;
        //Short link create
        $shortURL = initShort($collegamento);
        // Not used:
        // $descrizione = $nodo->item($i)->getElementsByTagName("description")->item(0)->childNodes->item(0)->nodeValue;
        $risultato .= $titolo."\r\n".$shortURL."\r\n\r\n";
        }
    } 
return $risultato;
}

/*
 * Fuction FreeHost($link)
 * For extract txt from http://freetexthost.com/
 * Insert in to fine message: [fine]
 * 
 */
function FreeHost($link){
  $linkNew = $link[1];
  $txt = file_get_contents($linkNew);
  $txt_i = "<div id=\"contentsinner\">";
  $txt_f = "[fine]";
  $off = "0";
  $letto = scrapeFreeHost($txt,$txt_i,$txt_f,$off);
  $letto = str_replace("<div id=\"contentsinner\">","" ,$letto);
  $letto = str_replace("<br />","" ,$letto);
  return $letto;
}

function scrapeFreeHost($testo,$txt_inizio,$txt_fine,$offset){
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
     * Example link:
     * http://cdn4.3bmeteo.com/images/png_2014/2016-01-18_6_regione6_verdi.jpg
     * http://cdn4.3bmeteo.com/images/png_2014/2016-01-18_12_regione6_verdi.jpg
     * http://cdn4.3bmeteo.com/images/png_2014/2016-01-18_18_regione6_verdi.jpg
     * http://cdn4.3bmeteo.com/images/png_2014/2016-01-18_24_regione6_verdi.jpg            
    */ 
    $link = "http://cdn4.3bmeteo.com/images/png_2014/"."$data"."_".$funzionePersonalizzata[1]."_"."$funzionePersonalizzata[2]";  
    return $link;
}

/*
 * Fuction Oroscopo($link)
 * Oroscopo da: http://www.oggi.it/oroscopo/oroscopo-di-oggi/
 * Valido solo per questo sito
 * 
 */

function Oroscopo($link){
    $linkNew = $link[1];
    $txt = file_get_contents($linkNew);
    $txt_i = "<h2 class=\"entry-title\">";
    $txt_f = "horoscope-links";
    $off = "0";
    // To Clean Text-HTML and convet character
    $letto = scrapeOroscopo($txt,$txt_i,$txt_f,$off);
    $letto = str_replace("&#8217;","'" ,$letto);
    $letto = str_replace("&#249;","u'" ,$letto);
    $letto = str_replace("&#232;","e'" ,$letto);
    $letto = str_replace("&#224;","a'" ,$letto);
    $letto = str_replace("&#242;","o'" ,$letto);
    $letto = str_replace("&#233;","e'" ,$letto);
    $letto = str_replace("&#236;","i'" ,$letto);
    $letto = str_replace("&#8230;","..." ,$letto);
    $letto = str_replace("&#8220;","\"" ,$letto);
    $letto = str_replace("&#8221;","\"" ,$letto);
    $letto = str_replace("&#160;"," " ,$letto);
    $letto = str_replace("&","" ,$letto);
    $letto = strip_tags($letto);
    return $letto;
}

function scrapeOroscopo($testo,$txt_inizio,$txt_fine,$offset){
    $inizio = strpos($testo,$txt_inizio);
    $inizio = $inizio+25;
    $fine = strpos($testo,$txt_fine,$inizio);
    $fine = $fine-33;
    $darestituire = substr($testo,$inizio,$fine-$inizio+$offset);
    return $darestituire;
}


/*
 * 
 * FINE FUNZIONI DI DEFAULT
 * 
 */
