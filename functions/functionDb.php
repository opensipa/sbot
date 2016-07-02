<?php

/**
 * ############################################
 * Funzione database per la gestione del demone
 * ############################################
 */

/**
 * Function dbDemoneStatus
 * 
 * 
 * @return type boolean 
 */
function dbDemoneStatus()
{
    try {
        $conn=getDbConnection();
        $sql = "SELECT Active FROM `software_config` WHERE SoftDesc = 'Demone' AND Code = 'status'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $value=$stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($value['Active']);
}

/**
 * Function dbDemName
 * Ritorna il nome del Bot che stai gestendo
 * 
 * @return type Array 
 */
function dbDemName()
{
    try {
        $conn=getDbConnection();
        $sql = "SELECT Param FROM `software_config` WHERE Code = 'nomebot' AND SoftDesc = 'Demone'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $name=$stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return $name;
}

/* 
 * ###########################################
 * Funzioni database per gestione tastiera Bot
 * ###########################################
 */

/**
 * Function dbDemoneKeyboard
 * 
 * 
 * @return Titolo, Param, Type.
 * @return type string
 * 
 */
function dbDemoneKeyboard($value)
{
    try {
        $conn=getDbConnection();
        $sql = "SELECT Titolo, Param, Type FROM `software_config_button` WHERE $value AND Active=1 ORDER BY Number";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':value',$value, PDO::PARAM_STR);
        $stmt->execute();
        $tableButton=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableButton[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableButton);
}

/**
 * Function dbDemoneCountKeyboard
 * 
 * 
 * @return type boolean 
 */

function dbDemoneCountKeyboard()
{
    try {
        $conn=getDbConnection();
        $sql = "Select Count(Titolo) FROM `software_config_button` WHERE Active=1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $number=$stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return $number;
}

/**
 * Function dbDemoneNumberKeyboard
 * 
 * 
 * @return type boolean 
 */

function dbDemoneNumberKeyboard()
{
    try {
        $conn=getDbConnection();
        $sql = "SELECT MAX(Number) AS numero FROM `software_config_button` where Active = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $maxNumber=$stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return $maxNumber;
}

/* 
 * ##########################################
 * Funzioni database per gestione bottoni
 * ##########################################
 */

/**
 * Function dbButtonExtraction
 * Ritorna tutti i valori dei parametri per il settaggio
 * 
 * @return type Array 
 */
function dbButtonExtraction($value)
{
    try {
        $conn=getDbConnection();
        $sql = "SELECT ID, SoftDesc, Param, Number, Type, Titolo, Active, Log, DateUpdt FROM `software_config_button` WHERE $value ORDER BY Number";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tableButton=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableButton[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableButton);
}

/**
 * Function dbButtonUpdate
 * Cambia i valori dei parametri 
 * 
 * @return 0 
 */

function dbButtonUpdate($ID, $software, $param, $tipo, $number, $state, $user, $titolo)    
{
    try {
        $conn=getDbConnection();
        $sql = "UPDATE software_config_button SET SoftDesc=:software, Param=:param, Type=:tipo, Number=:number, Active=:state, Log=:user, Titolo=:titolo, DateUpdt=now() WHERE ID=:ID";      
        $stmt = $conn->prepare($sql);        
        $stmt->bindValue(':ID',$ID, PDO::PARAM_INT);
        $stmt->bindValue(':software',$software, PDO::PARAM_STR);
        $stmt->bindValue(':param',$param, PDO::PARAM_STR);
        $stmt->bindValue(':tipo',$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':number',$number, PDO::PARAM_INT);
        $stmt->bindValue(':state',$state, PDO::PARAM_STR);
        $stmt->bindValue(':titolo',$titolo, PDO::PARAM_STR);
        $stmt->bindValue(':user',$user, PDO::PARAM_STR);
        $stmt->execute();

        } catch (Exception $ex) {
            return $ex->getMessage();
            }
        return 0;
}

/**
 * Function dbButtonInsert
 * Inserisce tutti i valori dei parametri per il settaggio
 * 
 * @return type Array 
 */

function dbButtonInsert($software, $param, $tipo, $number, $active, $user, $titolo)
{
    try {
        $conn=getDbConnection();
        $sql = "insert software_config_button SET SoftDesc=:software, Param=:param, Type=:tipo, Number=:number, Active=:active, Log=:user, Titolo=:titolo, DateUpdt=now()";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':software',$software, PDO::PARAM_STR);
        $stmt->bindValue(':param',$param, PDO::PARAM_STR);
        $stmt->bindValue(':tipo',$tipo, PDO::PARAM_STR);
        $stmt->bindValue(':number',$number, PDO::PARAM_INT);
        $stmt->bindValue(':active',$active, PDO::PARAM_STR);
        $stmt->bindValue(':titolo',$titolo, PDO::PARAM_STR);
        $stmt->bindValue(':user',$user, PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return 0;
}

/**
 * Function dbButtonDelete
 * Use this function for delete record of button
 * (dont't use in this moment - future implementations)
 * 
 * @return 0 
 */
function dbButtonDelete($ID)    
{
    try {
        $conn=getDbConnection();
        $sql = "delete from software_config_button WHERE ID=:ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID',$ID, PDO::PARAM_INT);
        $stmt->execute();
        } catch (Exception $ex) {
            return $ex->getMessage();
            }
        return 0;
}

/* 
 * ##########################################
 * Funzioni database per gestione degli scheduler
 * ##########################################
 */

/**
 * Function dbSchedulerExtraction
 * Ritorna tutti i valori dei parametri per il settaggio
 * 
 * @return type Array 
 */
function dbSchedulerExtraction($value)
{
    try {
        $conn=getDbConnection();
        $sql = "SELECT ID, DataInsert, DataScheduler, Repeater, NumberRepeat, HowOften, Text, Note, Signature, SingleUserID, AlreadySent, Counter FROM `message_scheduler` WHERE $value ORDER BY DataScheduler DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tableButton=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableButton[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableButton);
}

/**
 * Function dbSchedulerUpdate
 * Cambia i valori dei parametri 
 * 
 * @return 0 
 */

function dbSchedulerUpdate($ID, $date, $signature, $text, $note)    
{
    try {
        $conn=getDbConnection();
        $sql = "UPDATE message_scheduler SET DataScheduler=:date, Text=:text, Note=:note, Signature=:signature, AlreadySent=1 WHERE ID=:ID";      
        $stmt = $conn->prepare($sql);        
        $stmt->bindValue(':ID',$ID, PDO::PARAM_INT);
        $stmt->bindValue(':date',date('Y-m-d H:i:s', strtotime ($date)), PDO::PARAM_STR);
        $stmt->bindValue(':text',$text, PDO::PARAM_STR);
        $stmt->bindValue(':note',$note, PDO::PARAM_STR);
        $stmt->bindValue(':signature',$signature, PDO::PARAM_STR);
        $stmt->execute();

        } catch (Exception $ex) {
            return $ex->getMessage();
            }
        return 0;
}

/**
 * Function dbSchedulerInsert
 * Inserisce tutti i valori dei parametri per il settaggio
 * 
 * @return type Array 
 */

function dbSchedulerInsert($date, $signature, $text, $note)
{
    try {
        $conn=getDbConnection();
        $sql = "INSERT message_scheduler SET DataInsert=now(), DataScheduler=:date, Text=:text, Note=:note, Signature=:signature, AlreadySent=1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':date',date('Y-m-d H:i:s', strtotime ($date)), PDO::PARAM_STR);
        $stmt->bindValue(':text',$text, PDO::PARAM_STR);
        $stmt->bindValue(':note',$note, PDO::PARAM_STR);
        $stmt->bindValue(':signature',$signature, PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return 0;
}

/**
 * Function dbSchedulerDelete
 * Use this function for delete record of scheduler
 * (dont't use in this moment - future implementations)
 * 
 * @return 0 
 */
function dbSchedulerDelete($ID)    
{
    try {
        $conn=getDbConnection();
        $sql = "DELETE from message_scheduler WHERE ID=:ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID',$ID, PDO::PARAM_INT);
        $stmt->execute();
        } catch (Exception $ex) {
            return $ex->getMessage();
            }
        return 0;
}

/**
 * Function dbSchedulerUpdate
 * Cambia i valori dei parametri 
 * 
 * @return 0 
 */

function dbCronUpdate($ID)    
{
    try {
        $conn=getDbConnection();
        $sql = "UPDATE message_scheduler SET AlreadySent=0 WHERE ID=:ID";      
        $stmt = $conn->prepare($sql);        
        $stmt->bindValue(':ID',$ID, PDO::PARAM_INT);
        $stmt->execute();

        } catch (Exception $ex) {
            return $ex->getMessage();
            }
        return 0;
}

/* 
 * ##########################################
 * Funzioni database per gestione del sistema
 * ##########################################
 */

/**
 * 
 * Function dbInsertAdmin
 * 
 * @param type $username username utente
 * @param type $password password utente
 * @param type $signature firma utente
 * Permette l'inserimento di nuovi utenti in Sbot 
 *  
 * @return int ritorna 1 su errore, altrimenti inserimento correto
 */

function dbInsertAdmin ($username, $password, $signature)
{
try {
    $conn=getDbConnection();
    $sql="insert admins set username=:username, password=:password, signature=:signature, active='1'";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username',$username, PDO::PARAM_STR);
    $stmt->bindValue(':signature',$signature, PDO::PARAM_STR);
    $stmt->bindValue(':password',create_hash($password), PDO::PARAM_STR);    
    $stmt->execute();
  } catch (Exception $ex) {
    //return error for DB
    return '1';
  }
} 
/**
 * 
 * Function dbChangeSignatureAdmin
 * 
 * @param type $username username utente
 * @param type $signature firma utente
 * Permette l'update della firma degli utenti Amministratori 
 *  
 * @return int ritorna 1 su errore, altrimenti inserimento correto
 */

function dbChangeSignatureAdmin ($username, $signature)
{
try {
    $conn=getDbConnection(); 
    $sql="UPDATE admins SET signature=:signature WHERE username=:username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username',$username, PDO::PARAM_STR);
    $stmt->bindValue(':signature',$signature, PDO::PARAM_STR);
    $stmt->execute();
  } catch (Exception $ex) {
    echo $ex;
    return '1';
  }
}

/**
 * 
 * Function dbChangeStateAdmin
 * 
 * @param type $id id utente
 * @param type $active stato utente
 * Permette l'update dello stato degli utenti Amministratori 
 *  
 * @return int ritorna 1 su errore, altrimenti inserimento correto
 */

function dbChangeStateAdmin ($id, $active)
{
try {
    $conn=getDbConnection(); 
    $sql="UPDATE admins SET active=:active WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id',$id, PDO::PARAM_STR);
    $stmt->bindValue(':active',$active, PDO::PARAM_STR);
    $stmt->execute();
  } catch (Exception $ex) {
    return $ex->getMessage();
  }
    return 0;
}

/**
 * 
 * Function dbSelectAdmin
 * 
 * @param type $username username utente
 * @param type $password password utente
 * @param type $signature firma utente
 * @Permette di avere la lista degli utenti admin in Sbot
 *   
 * @return int ritorna 1 su errore, altrimenti crea elenco
 */
 
function dbSelectAdmin()
{
    try {
        $conn=getDbConnection();
        $sql = "select username, signature, level from admins where active=1 order BY username";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tableAdmin=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableAdmin[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableAdmin);
}

/**
 * 
 * Function dbSelectAllAdmin
 * 
 * @param type $username username utente
 * @param type $password password utente
 * @param type $signature firma utente
 * @Permette di avere la lista degli utenti admin attivi e disattivi in Sbot
 *   
 * @return int ritorna 1 su errore, altrimenti crea elenco
 */
 
function dbSelectAllAdmin()
{
    try {
        $conn=getDbConnection();
        $sql = "select id, username, signature, level, active from admins order BY username";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tableAdmin=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableAdmin[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableAdmin);
} 

/**
 * 
 * Function dbUpdatePwd
 * 
 * @param type $username username utente
 * @param type $password password utente
 * @param type $signature firma utente
 * @Permette di avere la lista degli utenti admin in Sbot
 *   
 * @return int ritorna 1 su errore, altrimenti crea elenco
 */
function dbUpdatePwd($username,$password)
{
    try {
        $conn=getDbConnection();
        $sql="UPDATE admins SET password=:password WHERE username=:username";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username',$username, PDO::PARAM_STR);
        $stmt->bindValue(':password',create_hash($password), PDO::PARAM_STR);    
        $stmt->execute();
        } catch (Exception $ex) {
        return $ex->getMessage();
  }
  return 0;
}
/**
 * 
 * Function dbLogUserStart
 * 
 * @param type $chat ID dell'utente come riportato da Telegram
 * @param type $first_name Nome proprio dell'utente
 * @param type $last_name Cognome dell'utente
 * @param type $username Username inserito in Telegram
 *  
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
            $sql = "UPDATE utenti SET StatoUtente=1, DataInsert=now() where UserID=:UserID and StatoUtente=0";
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
 * @param type $chat ID dell'utente come riportato da Telegram
 */
function dbLogUserStop ($chat)
{
    try {
        $conn=getDbConnection();
        $sql = "UPDATE utenti SET StatoUtente=0 WHERE UserID=:UserID";
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
function dbActiveUsersFull($start, $forPage)
{
    try {
        $conn=getDbConnection();
        $sql = "select UserID, FirstName, LastName, Username, DATE_FORMAT(DataInsert,'%d/%m/%Y') as insertDate from utenti where StatoUtente=1 ORDER BY DataInsert LIMIT :limit , :offset";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $start, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $forPage, PDO::PARAM_INT);
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
        $sql = "insert into utenti_message(UserID, FirstName, DataInsert, Message, Text, Archive) values (:UserID, :FirstName, now(),:Message,:Text,'1')";
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
 * @database utenti_message
 * 
 * @return type Array 
 */
function dbLogTextFull()
{
    try {
        $conn=getDbConnection();
        $sql = "select UserID, FirstName, DataInsert, Text, ID, Message,Archive from utenti_message where Archive='1' OR Archive IS NULL order BY DataInsert desc";
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
 * Function dbLogTextUpdate
 * Aggiorna nel DB utenti_message i messaggi che non si vuole più visualizzare
 * @param Archive 0/1 
 * 
 * @return type Error 
 */
function dbLogTextUpdate ($ID)
{
    try {
        $conn=getDbConnection();
        $sql = "UPDATE utenti_message SET Archive=0 WHERE ID=:ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID',$ID,PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $ex) {
        return ($ex->getMessage());
    }
    return 0;
}  

/**
 * Function dbLogSearchFull()
 * Search into utenti_message the key
 * 
 * @database utenti_message
 * @param type $type int (0/1), param of recent/archive
 * @param type $param1 text
 * @param type $param2 text
 * @param type $param3 text
 * 
 * @return type Array 
 */
function dbLogSearchFull($type, $param1)
{
    try {
        $conn=getDbConnection();
        $sql = "select UserID, FirstName, DataInsert,Text, ID, Message, Archive from utenti_message where Archive=$type AND Text Like '%$param1%' order BY DataInsert desc";
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
function dbLogTextSend ($text, $signature,$MessageID, $Utenti_messageID)
{
    try {
        $conn=getDbConnection();
        $sql = "insert into message_send(DataInsert, Text, Signature, MessageID, Utenti_messageID, Archive) values (now(),:Text,:Signature,:MessageID,:Utenti_messageID,'1')";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':Text',$text , PDO::PARAM_STR);
        $stmt->bindValue(':Signature',$signature , PDO::PARAM_STR);
        $stmt->bindValue(':MessageID',$MessageID , PDO::PARAM_STR);
        $stmt->bindValue(':Utenti_messageID',$Utenti_messageID , PDO::PARAM_STR);
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
        $sql = "select ID, DataInsert, Text, Signature from message_send where Archive=1 AND MessageID=0 OR Archive=1 AND MessageID IS NULL OR Archive IS NULL AND MessageID IS NULL order BY DataInsert desc";
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
 * Function dbLogTextUpdate
 * Aggiorna nel DB message_send i messaggi che non si vuole più visualizzare
 * @param Archive 0/1 
 * 
 * @return type Error 
 */
function dbLogTextUpdateSend($ID)
{
    try {
        $conn=getDbConnection();
        $sql = "UPDATE message_send SET Archive=0 WHERE ID=:ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID',$ID,PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $ex) {
        return ($ex->getMessage());
    }
    return 0;
}

/**
 * Function dbLogDocumentOn
 * Inserisce nel DB document_send i documenti lasciati dagli utenti 
 * 
 * @param type $chat ID dell'utente come riportato da Telegram
 * @param type $first_name Nome proprio dell'utente
 * @param type $message_id
 * @param type $document_id
 * @param type $mime_type
 * @param type $file_name
 * @param type $file_id
 * @param type $file_size
 *     
 * @return type Array 
 */

/*
 * Not use this function in this moment. 
 * Future implementations
 * 
function dbLogDocumentOn ($chat_id,$first_name_id,$message_id,$document_id,$mime_type,$file_name,$file_id,$file_size)
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
 * 
 */

/**
 * Function dbJoinMessageSend
 * Ritorna tutti i messaggi inviati agli utenti collegato al messaggio originale
 * 
 * @return type Array 
 */
function dbJoinMessageSend($Message)
{
    try {
        $conn=getDbConnection();
        $sql = "SELECT utenti_message.FirstName,utenti_message.DataInsert, utenti_message.Text, message_send.Text, message_send.DataInsert, message_send.Signature FROM utenti_message, message_send WHERE utenti_message.Message=MessageID  AND utenti_message.Message=$Message";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':MessageID',$Message,PDO::PARAM_STR);
        $stmt->execute();
        $tableJoinMessage=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableJoinMessage[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableJoinMessage);
}

/**
 * Function dbParamExtraction
 * Ritorna tutti i valori dei parametri per il settaggio
 * 
 * @return type Array 
 */
function dbParamExtraction($function)
{
    try {
        $conn=getDbConnection();
        $sql = "SELECT Code, Param, SoftDesc, Active, Log, ID, Note, Number FROM `software_config` WHERE $function ORDER BY SoftDesc, Code";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tableParam=array();
        while ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tableParam[]=$riga;            
        }
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return ($tableParam);
}

/**
 * Function dbParamChange
 * Cambia i valori dei parametri 
 * 
 * @return 0 
 */
function dbParamUpdate($ID, $software, $code, $param, $state, $user, $note)    
{
    try {
        $conn=getDbConnection();
        $sql = "UPDATE software_config SET SoftDesc=:software, Code=:code, Param=:param, Active=:state, Log=:user, Note=:note, DateUpdt=now() WHERE ID=:ID";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ID',$ID, PDO::PARAM_STR);
        $stmt->bindValue(':software',$software, PDO::PARAM_STR);
        $stmt->bindValue(':code',$code, PDO::PARAM_STR);
        $stmt->bindValue(':param',$param, PDO::PARAM_STR);
        $stmt->bindValue(':state',$state, PDO::PARAM_STR);
        $stmt->bindValue(':note',$note, PDO::PARAM_STR);
        $stmt->bindValue(':user',$user, PDO::PARAM_STR);
        $stmt->execute();
        } catch (Exception $ex) {
            return $ex->getMessage();
            }
        return 0;
}

/**
 * Function dbParamInsert
 * Inserisce tutti i valori dei parametri per il settaggio
 * 
 * @return type Array 
 */
function dbParamInsert($software, $param, $valore, $attivo, $user, $note)
{
    try {
        $conn=getDbConnection();
        $sql = "insert software_config set SoftDesc=:software, Code=:param, Param=:valore, Active=:active, Note=:note, Log=:user, DateUpdt=now()";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':software',$software, PDO::PARAM_STR);
        $stmt->bindValue(':param',$param, PDO::PARAM_STR);
        $stmt->bindValue(':valore',$valore, PDO::PARAM_STR);
        $stmt->bindValue(':active',$attivo, PDO::PARAM_STR);
        $stmt->bindValue(':user',$user, PDO::PARAM_STR);
        $stmt->bindValue(':note',$note, PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
    return 0;
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