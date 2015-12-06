<?php include 'theme/header.php'; ?>
    <div id="content" class="clearfix">
        <div class="content-row">
            <h2>Per accedere alla piattaforma di gestione di devi fare il Login:</h2>        
            <form id='login' action='login.php' method='post' accept-charset='UTF-8'>
            <fieldset >
            <legend>Login</legend>
            <input type='hidden' name='submitted' id='submitted' value='1'/>
            <div class="form-group">
            <label for='username' >UserName:</label>
            <input type='text'  class="form-control" name='username' id='username'  placeholder="Inserisci lo username" maxlength="50" />
            </div>
            <br>
            <div class="form-group">
            <label for='password' >Password: </label>
            <input type='password' class="form-control" name='password' id='password' placeholder="Inserisci la password" maxlength="50" />
            </div>
            <br>
            <input type='submit' name='Submit' value='Accedi' />
            </fieldset>
            </form>
        </div>
        <div align="center">
            <img src="theme/img/AGPLv3.png" alt="AGPL version 3">
            <br>
            <p align="center">NEWS</p>
            <p align="justify">{S}Bot &egrave; rilasciato gratuitamente nello spirito della massima condivisione e dello sviluppo di una P.A. digitale efficiente.</p>
            <p align="justify">{S}Bot &egrave; testato e sviluppato per poter funzionare su tutte le piattaforme.</p>
        </div>
    </div>
<!-- Footer page -->
<?php include ('theme/footer.php');?>