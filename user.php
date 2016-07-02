<?php
include ('theme/verification.php');
include ('theme/header.php');
include ('functions/function.php');
include ('functions/functionDb.php');
include ('config.php');
include ('functions/functionInit.php');

$userActive = dbCountActiveUsers(); //User active
$name = dbDemName(); //Name of Bot
$forPage = 20; //Limit record view from page
$totPage=ceil($userActive/$forPage); //Ceil for page
?>
<div id="content" class="clearfix">
    <div align="center">
        <h2>Ci sono attualmente <strong> <?php echo $userActive; ?> </strong> utenti attivi in <?php if(isset($name)){echo $name[Param];}?>.</h2>
    </div>      
    <?php
    if($userActive>0){ 
        //Current Page
        if(isset($_GET["idpag"])){
            $idpag=$_GET["idpag"];
        }else{ 
            $idpag='1';
        }
        //Calcolo i numeri iniziale e finale che andranno a limitare la query
        if($idpag==1){
            $init=0;
        }else{
            $init=($idpag*$forPage)-$forPage;
        }
        //Query della pagina: la ripeto limitando ai record che devono essere mostrati nella pagina
        $userActivePage = dbActiveUsersFull($init, $forPage);
    ?>
    <div align="center">
        <table border="1" align="center" id="order">
            <thead>
            <tr>
                <th><span>N:</span></th>
                <th><span>ID utente</span></th>
                <th><span>Nome</span></th>
                <th><span>Cognome</span></th>
                <th><span>Username</span></th>
                <th><span>Data inserimento</span></th>
            </tr>
            </thead>
            <tbody> 
            <?php
                $initCount = $init;
                foreach ($userActivePage as $user) {
                    $initCount = $initCount+1;
                    echo '<tr class="align">';
                    echo '<td>'.$initCount.'</td>';
                    echo '<td>'.$user['UserID'].'</td>';
                    echo '<td>'.$user['FirstName'].'</td>';
                    echo '<td>'.$user['LastName'].'</td>';
                    echo '<td>'.$user['Username'].'</td>';
                    $insert = $user['insertDate'];
                    echo '<td>'.$insert.'</td>';
                    echo '</tr>';
                }
            ?> 
            </tbody>
        </table>
    <!-- table order --> 
    <script type="text/javascript">
      $(function(){
      $('#order').tablesorter(); 
      });
    </script>
    </div>
    <div style="float: right;">
    <?php //Link per scorrere le pagine: la pagina corrente ha un aspetto diverso 
        if($idpag>1){?>
            <span style="text-decoration: underline; margin-right: 10px"><a href="?idpag=<?php echo ($idpag-1);?>"> << </a></span>
        <?php }else{?>
            <span> << </span>
        <?php }
        $i=1;
        do{
            //Link per scorrere le pagine: la pagina corrente ha un aspetto diverso
            if($i==$idpag){ ?>
                <span style="text-decoration: none; font-weight: bold; margin-right: 10px"><a href="?idpag=<?php echo $i; ?>"><?php echo $i; ?></a></span>
            <?php }else{ ?>
                <span style="text-decoration: underline; margin-right: 10px"><a href="?idpag=<?php echo $i;?>"><?php echo $i;?></a></span>
            <?php }
            $i++;
        }while($i<=$totPage);
        if($idpag<$totPage){?>
                <span style="text-decoration: underline; margin-right: 10px"><a href="?idpag=<?php echo ($idpag+1);?>"> >> </a></span>
        <?php }else{?>
                <span> >> </span>
        <?php }?>
        </div>
<?php
} //if($num>0) 
?>  
</div>
<!-- Footer page -->
<?php include ('theme/footer.php');?>