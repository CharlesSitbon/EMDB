
<?php 
  include("utils.php");
  do_mysql_connect();
  

// Exécution des requêtes SQL
$id = $_GET['id'];
$query = "SELECT * FROM PERSONNE WHERE Id='$id' LIMIT 1";
$result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
$pers = mysql_fetch_array($result) or die("Film inconnu");
start_page($pers['Nom']);


$query = "SELECT FILM.Nom, ROLE.Role as Role, FILM.Id FROM ROLE RIGHT JOIN FILM ON ROLE.Film_id=FILM.id WHERE ROLE.Personne_id=$id";
$films = mysql_query($query) or die('Échec de la requête : ' . mysql_error());


echo "<div id='film'>";

  echo "<h1>"; echo $pers['Nom']; echo "</h1>";

  echo "<div id='enhaut'>";
    echo "<img class='affiche' src='artistes/"; 
      echo $pers['img']; 
      echo "'>";
    echo "<div id='infos'>";
      echo "<p>";
        echo "Né le "; 
        echo "<date>"; 
        echo date("d M Y", strtotime($pers['Annee'])); 
        echo '</date>';
        echo "</p>";
      echo "<p>Nationalité "; 
        echo $pers['Nationalite']; 
        echo '</p>';
      echo "<p id='films'>";
        while ($film = mysql_fetch_array($films, MYSQL_ASSOC)) {
          #echo "<li>";
          echo "<a href='/film.php?id="; echo $film["Id"]; echo "'>";
          echo $film["Nom"];
          echo "</a>";
          echo " dans le rôle de ";
          echo $film["Role"];
          echo "<br>";
        }
        echo "</p>";
    echo "</div>";

  echo "<div>";
  echo "<p id='description'>";
    echo nl2br($pers["Description"]);
  echo "</p>";
  echo "</div>";

  echo "</div>";


  end_page();
?>
