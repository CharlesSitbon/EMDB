
<?php 
  include("utils.php");
  do_mysql_connect();
  start_page("Films");

  // Exécution des requêtes SQL
  $query = "SELECT * FROM FILM ORDER BY Nom";
  $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

  // Affichage des résultats en HTML
  echo "<table id=\"myTable\" class=\"table table-hover tablesorter\">\n";
  echo "<thead> <tr>";
  echo "<th>Nom du film</th><th>Genre</th><th>Date de sortie</th>";
  echo "<th>Autorisations</th><th>Budget</th><th>Durée</th>";
  echo "</tr> </thead>";
  echo "<tbody>";
  while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      echo "<tr>";
        echo "<td>"; 
          echo "<a href='/film.php?id="; echo $line['Id']; echo "'>";
          echo $line['Nom']; 
          echo "</a>";
          echo "</td>";
        echo "<td>"; echo $line['Genre']; echo "</td>";
        echo "<td>"; echo date("d M Y", strtotime($line['Annee'])); echo "</td>";
        echo "<td>"; echo $line['Autorisation']; echo "</td>";
        echo "<td>"; echo $line['Budget']; echo "</td>";
        echo "<td>"; echo $line['Duree']; echo "</td>";
      echo "</tr>\n";
  }
  echo "</tbody>";
  echo "</table>\n";
  end_page(); 
?>
