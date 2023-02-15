<?php
session_start();
?>  
  <html>
    <head> <link href="style.css" media="all" rel="stylesheet" type="text/css"/> </head>
    <body>
   

<?php


include '_conf.php';

if (isset($_POST['envoi'])) //reçois données rentrée lors de la connexion
{
   
    $login = $_POST['login'];
    $mdp = md5($_POST['mdp']);

    $connexion = mysqli_connect($serveurBDD,$userBDD,$mdpBDD,$nomBDD);
    $requete="Select * from utilisateur WHERE login = '$login' AND motdepasse= '$mdp'"; //recupere données utilisateur 
    //²echo "<br> ma req SQL : $requete <br>";
    $resultat = mysqli_query($connexion, $requete);
    $trouve=0;
    
    while($donnees = mysqli_fetch_assoc($resultat))
      {
   
        $trouve=1;
        $type=$donnees['type'];
        $login=$donnees['login'];
        $id=$donnees['num'];
        $prenom=$donnees['prenom'];
        $nom=$donnees['nom'];
        $tel=$donnees['tel'];
        $email=$donnees['email'];
        $dateN=$donnees['dateN'];
     //echo "je créé mes sessions !!!";
        $_SESSION["id"]=$id; //relie variable avec session
        $_SESSION["login"]=$login;
        $_SESSION["type"]=$type;
        $_SESSION["prenom"]=$prenom;
        $_SESSION["nom"]=$nom;
        $_SESSION["tel"]=$tel;
        $_SESSION["email"]=$email;
        $_SESSION["dateN"]=$dateN;
    
      }

    if($trouve==0)
    {
        echo "erreur de connexion";
    }
}
if (isset($_SESSION["login"]))
 
    {
        if($_SESSION["type"]==0)
        {
          ?>
         <ul class="nav">
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="perso.php">Profil</a></li>
        <li><a href="cr.php">Compte rendus</a></li>
        <li><a href="ccr.php">Nouveau compte-rendu</a></li>
        </ul>
 
            <?php
            echo "<br> <br>bienvenue sur le compte élève <br> <br>";
            echo "Vous êtes connecté en tant que ".$_SESSION["login"]."<br> <br>";
           echo "<FORM method='post' action='index.php'> <button type=submit name='deco'> DECONNEXION </button> </form>";
        }
        if($_SESSION["type"]==1)
        {
?>
              <ul class="nav">
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="perso.php">Profil</a></li>
        <li><a href="cr.php">Compte rendus</a></li>
        <li><a href="eleve.php">liste élève</a></li>
        </ul> </html>
<?php
           
  
            echo "<br> <br><br> <br>vous êtes un prof<br>";
            echo "<FORM method='post' action='index.php'> <button type=submit name='deco'> DECONNEXION </button> </form>";
        }

       


        if($_SESSION["type"]==2)
        {
         echo "<ul class='nav'>
          </ul>";
            
             echo "<br> <br>bienvenue sur le compte sécretaire <br> <br>";
             echo "Vous êtes connecté en tant que ".$_SESSION["login"]."<br> <br>";
            echo "<FORM method='post' action='index.php'> <button type=submit name='deco'> DECONNEXION </button> </form>";
            
            $requete0="Select COUNT(*) AS 'eleves' FROM utilisateur WHERE utilisateur.type=0;";
            $requete1="Select COUNT(*) AS 'professeur' FROM utilisateur WHERE utilisateur.type=1;";
            $requete2="Select COUNT(*) AS 'cr' FROM cr;";
    $resultat0 = mysqli_query($connexion, $requete0);
    $resultat1 = mysqli_query($connexion, $requete1);
    $resultat2 = mysqli_query($connexion, $requete2);

    echo "   <table border=1>
            <tr>
          <th>nombre d'élève</th>
          <th>nombre de professeur</th>
          <th>nombre de cr</th>
          </tr>";

    while($donnees = mysqli_fetch_assoc($resultat0))
      {
        $eleves=$donnees['eleves'];
      echo "<tr>
          <td>$eleves</td>";
      }
      while($donnees = mysqli_fetch_assoc($resultat1))
      {
        $professeur=$donnees['professeur'];
      echo "
          <td>$professeur</td>";
      }
      while($donnees = mysqli_fetch_assoc($resultat2))
      {
        $cr=$donnees['cr'];
      echo "
          <td>$cr</td>";
      }

     echo "</tr></table> ";
           
    }
  }
?>

     
  






