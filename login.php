<?php
/* 
 * Pagina di controllo username e password per gli Admin
 * 
 * Dovrebbe essere richiamata come target delle form. Alla fine invia l'utente alla admin.php
 * 
 */
session_start();
?>

<!-- Pagina header e functions -->
<?php
include ('theme/header.php');
include('config.php');
include('init.php');
include('functions/function.php');
include('functions/functionDb.php');
include('functions/passwordHash.php');

$username=filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
$password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$submit = filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_STRING);

if (!empty($submit)) {
    $conn=getDbConnection();
    $sql="select username,password,signature from admins where username=:username and active=1";
    //$password=password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username',$username, PDO::PARAM_STR);
    $stmt->execute();
    $riga=$stmt->fetch(PDO::FETCH_ASSOC);

    if ($riga != FALSE && validate_password($password, $riga['password'])) {
        $_SESSION['username']=$riga['username'];
        $_SESSION['signature']=$riga['signature'];
    } else {
        unset($_SESSION['username']);
    }
}
if (!empty($_SESSION['username'])) {
    header('Location: admin.php'); 
} else {
    echo '<div id="content" class="clearfix">';
    echo '<div class="content-row">';
    echo '<h1>Username o password non validi, ritenta: </h1>';
    echo '<h2><p><a href="index.php">Torna alla pagina di Login</a></p></h2> ';
    echo '</div></div>';
}
?>

<!-- Footer della pagina html -->
<?php include 'theme/footer.php'; ?>