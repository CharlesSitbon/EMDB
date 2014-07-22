
<?php 
  include("utils.php");
  do_mysql_connect();
  start_page("Artistes");

  // Exécution des requêtes SQL
  $query = "SELECT * FROM PERSONNE ORDER BY Nom";
  $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

  // Affichage des résultats en HTML
  echo "<table id=\"myTable\" class=\"table table-hover tablesorter\">\n";
  echo "<thead> <tr>";
  echo "<th>Nom de l'artiste</th><th>Date de Naissance</th><th>Nationalité</th>";
  echo "</tr> </thead>";
  echo "<tbody>";
  while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
     echo "<tr>";
        echo "<td>"; 
          echo "<a href='/personne.php?id="; echo $line['Id']; echo "'>";
          echo $line['Nom']; 
          echo "</a>";
          echo "</td>";
        echo "<td>"; 
          echo date("d M Y", strtotime($line['Annee'])); 
          echo "</td>";
        echo "<td>"; echo $line['Nationalite']; echo "</td>";
        echo "</tr>\n";
  }
  echo "</tbody>";
  echo "</table>\n";
  end_page(); 
?>
