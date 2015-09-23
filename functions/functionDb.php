<?php

// TODO: 
// Funzione che salva e carica i parametri su DB
//

/* 
 * Funzioni database
 * 
 * 
 * 
 */

/**
 * 
 * Function dbLogUserStart
 * 
 * @param type $chat ID dell'utente come riportato da Telegram
 * @param type $first_name Nome proprio dell'utente
 * @param type $last_name Cognome dell'utente
 * @param type $username Username inserito in Telegram
 * @return int Ritorna 0 su successo, altrimenti un testo descrittivo dell'errore 
 */

function dbLogUserStart ($chat,$first_name,$last_name, $username)
{
    try {
        $conn=getDbConnection();
        $sql = "select UserID from utenti where UserID=:UserID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':UserID',$chat,PDO::PARAM_STR);
        $stmt->execute();
        if ($id=$stmt->fetchColumn(0)) {
            // Se l'utente gia conosciuto cambio il suo stato mettendolo a 1
            $sql = "update utenti set StatoUtente=1, DataInsert=now() where UserID=:UserID and StatoUtente=0";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':UserID',$id , PDO::PARAM_STR);
            $stmt->execute();
        } else {
            // Se l'utente non conosciuto salvo i suoi dati nel db
            $sql = "insert into utenti(UserID, FirstName, LastName, Username, StatoUtente, DataInsert) values (:UserID, :FirstName, :LastName, :Username, 1, now())";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':UserID',$chat , PDO::PARAM_STR);
            $stmt->bindValue(':FirstName',$first_name , PDO::PARAM_STR);
            $stmt->bindValue(':LastName',$last_name , PDO::PARAM_STR);
            $stmt->bindValue(':Username',$username , PDO::PARAM_STR);
            $stmt->execute();
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return 0;
}

/**
 * Function dbLogUserStop
 * Invocata quando un utente si scollega:
 * imposta lo stato utente a zero nel DB
 * 
 * @param type $chat ID dell'utente come riportato da Telegram
 */
function dbLogUserStop ($chat)
{
    try {
        $conn=getDbConnection();
        $sql = "update utenti set StatoUtente=0 where UserID=:UserID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':UserID',$chat,PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $ex) {
        return ($ex->getMessage());
    }
    return 0;
}        


/**
 * Function dbActiveUsers
 * Ritorna un array posizionale con gli userID inseriti tramite la funzione dbLogUserStart
 * 
 * @return type Array 
 */
function dbActiveUsers()
{
    try {
        $conn=getDbConnection();
        $sql = "select UserID from utenti where StatoUtente=1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $active=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $active[]=$riga['UserID'];
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    
    return ($active);
}

/**
 * Function dbCountActiveUsers
 * Ritorna un array posizionale con il numero degli utenti attivi
 * 
 * @return type Array 
 */

function dbCountActiveUsers()
{
    try {
        $conn=getDbConnection();
        $sql = "select count(*) as conteggio from utenti where StatoUtente=1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $valore = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    // restituisce il numero totale utenti attivi
    return ($valore['conteggio']);
}

/**
 * Function dbActiveUsersFull
 * Ritorna un array posizionale con tutti i dati degli utenti iscritti tramite la funzione dbLogUserStart
 * 
 * @return type Array 
 */

function dbActiveUsersFull()
{
    try {
        $conn=getDbConnection();
        $sql = "select UserID, FirstName, LastName from utenti where StatoUtente=1 order BY FirstName";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tableUser=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableUser[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableUser);
}

/**
 * Function dbLogTextOn
 * Inserisce nel DB utenti_message i messaggi lasciati dagli utenti 
 * 
 * @return type Array 
 */

function dbLogTextOn ($chat,$first_name,$message,$text)
{
    try {
        $conn=getDbConnection();
        $sql = "select UserID from utenti_message where UserID=:UserID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':UserID',$chat,PDO::PARAM_STR);
        $stmt->execute();
        $sql = "insert into utenti_message(UserID, FirstName, DataInsert, Message, Text) values (:UserID, :FirstName, now(),:Message,:Text)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':UserID',$chat , PDO::PARAM_STR);
        $stmt->bindValue(':FirstName',$first_name , PDO::PARAM_STR);
        $stmt->bindValue(':Message',$message , PDO::PARAM_STR);
        $stmt->bindValue(':Text',$text , PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return 0;
}

/**
 * Function dbLogTextFull
 * Ritorna tutti i messaggi degli utenti che hanno inviato
 * 
 * @return type Array 
 */
function dbLogTextFull()
{
    try {
        $conn=getDbConnection();
        $sql = "select UserID, FirstName, DataInsert, Text from utenti_message order BY DataInsert desc";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tableMessage=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableMessage[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableMessage);
}

/**
 * Function dbLogTextSend
 * Inserisce nel DB message_send i messaggi inviati agli utenti tramite bot
 * 
 * @return type Array 
 */

function dbLogTextSend ($text)
{
    try {
        $conn=getDbConnection();
        $sql = "insert into message_send(DataInsert, Text) values (now(),:Text)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':Text',$text , PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return 0;
}


/**
 * Function dbLogTextFullSend
 * Ritorna tutti i messaggi inviati agli utenti
 * 
 * @return type Array 
 */
function dbLogTextFullSend()
{
    try {
        $conn=getDbConnection();
        $sql = "select DataInsert, Text from message_send order BY DataInsert desc";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tableMessage=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableMessage[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableMessage);
}



/**
 * getDbConnection
 * 
 * Funzione che tenta di aprire il database e ritorna una connessione al database funzionante, oppure un messaggio di errore
 * 
 * @return \PDO
 * @throws Exception
 */

function getDbConnection() {
    // Apertura connessione al database
    // NB: Non necessita di chiusura connessione - vedi http://php.net/manual/en/pdo.connections.php
    try {
        $mysqlConn = new PDO('mysql:dbname='.$GLOBALS['mysql_db'].';port='.$GLOBALS['mysql_port'].';host='.$GLOBALS['mysql_host'],$GLOBALS['mysql_user'],$GLOBALS['mysql_pass']);
        if ($mysqlConn===false) {
            throw new Exception ('Apertura database MySql fallita. Host '.$GLOBALS['mysql_host'].', User '.$GLOBALS['mysql_user']);
        }
        /* scommentare per debug */
        $mysqlConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mysqlConn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        /***/
    } catch (PDOException $e) {
        die('Connessione fallita al DB. Non posso proseguire');
        // return 'Connection failed: ' . $e->getMessage();
    }

    return $mysqlConn;
}
