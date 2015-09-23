<?php
/* 
 * Pagina di controllo username e password per gli Admin
 * 
 * Dovrebbe essere richiamata come target delle form. Alla fine invia l'utente alla admin.php
 * 
 */
session_start();
?>

<!-- Pagina header -->
<?php include 'theme/header.php'; ?>

<!-- Inizio del controllo di login utente -->
<?php	
include("config.php");
include("init.php");
include("functions/function.php");
include("functions/functionDb.php");

$username=filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
$password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$submit = filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_STRING);

//convert password for security this system is possible change to md5 sha256 ecc..
$password = hash('sha256', $password);

if (!empty($submit)) {
    $conn=getDbConnection();
    $sql="select username from admins where username=:username and password=:password and active=1";
    //$password=password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username',$username, PDO::PARAM_STR);
    $stmt->bindValue(':password',$password , PDO::PARAM_STR);
    $stmt->execute();

    if ($riga=$stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['username']=$riga['username'];
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
