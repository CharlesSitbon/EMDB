<?php 
include("utils.php");
do_mysql_connect();
start_page("Recherche");
$requete =  htmlspecialchars($_GET['search']); 
$query = mysql_query("SELECT * FROM FILM WHERE NOM LIKE '%$requete%' or GENRE LIKE '%$requete%' or Description LIKE '%$requete%' ORDER BY id DESC") or die (mysql_error());
$nb_resultats =mysql_num_rows($query); // on utilise la fonction mysql_num_rows pour compter les résultats pour vérifier par après
$query2 = mysql_query("SELECT * FROM PERSONNE WHERE NOM LIKE '%$requete%' or NATIONALITE LIKE '%$requete%' or Description LIKE '%$requete%' ORDER BY id DESC") or die (mysql_error());
$nb_resultats2 = mysql_num_rows($query2);
echo'<h3>Résultats de votre recherche : </h3>';
echo	'<p>Nous avons trouvé ';
echo $nb_resultats+$nb_resultats2; 
echo ' resultats</p>';
if($nb_resultats>= 1) {  
  echo "<table id=\"myTable\" class=\"table table-hover tablesorter\">\n";
  echo "<thead> <tr>";
  echo "<th>Nom du film</th><th>Genre</th><th>Date de sortie</th>";
  echo "<th>Autorisations</th><th>Budget</th><th>Durée</th>";
  echo "</tr> </thead>";
  echo "<tbody>";
  while ($line = mysql_fetch_array($query, MYSQL_ASSOC)) {
      echo "<tr>";
      echo "<td>"; 
      echo "<a href='/film.php?id="; echo $line['Id']; echo "'>";
      echo $line['Nom']; 
      echo "</a>";
      echo "</td>";
      echo "<td>"; echo $line['Genre']; echo "</td>";
      echo "<td>"; echo $line['Annee']; echo "</td>";
      echo "<td>"; echo $line['Autorisation']; echo "</td>";
      echo "<td>"; echo $line['Budget']; echo "</td>";
      echo "<td>"; echo $line['Duree']; echo "</td>";
      echo "</tr>\n";
  }
  echo "</tbody>";
  echo "</table>\n";
}


if($nb_resultats2>= 1) {  
  echo "<table id=\"myTable2\" class=\"table table-hover tablesorter\">\n";
  echo "<thead> <tr>";
  echo "<th>Nom de l'artiste</th><th>Date de Naissance</th><th>Nationalité</th>";
  echo "</tr> </thead>";
  echo "<tbody>";
  while ($line2 = mysql_fetch_array($query2, MYSQL_ASSOC)) {
    echo "<tr>";
    echo "<td>"; 
    echo "<a href='/personne.php?id="; echo $line2['Id']; echo "'>";
    echo $line2['Nom']; 
    echo "</a>";
    echo "</td>";
    echo "<td>"; 
    echo date("d M Y", strtotime($line2['Annee'])); 
    echo "</td>";
    echo "<td>"; echo $line2['Nationalite']; echo "</td>";
    echo "</tr>\n";
  }
  echo "</tbody>";
  echo "</table>\n";
}

?>