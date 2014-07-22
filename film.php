<?php 
  include("utils.php");
  do_mysql_connect();
  $id = $_GET['id'];
  $cookiename = "note_" . $id;
  $visitor = get_visitor();
  $note = $_GET['note'];
  $query = "SELECT Note FROM NOTATIONS WHERE Film_id='$id' AND Visitor_id='$visitor' LIMIT 1";
  $rnote = mysql_query($query);
  if ($note) {
    $query = "REPLACE INTO NOTATIONS (Film_id, Visitor_id, Note) VALUES ('$id', '$visitor', '$note')";
    mysql_query($query) or die("INSERT impossible");
  } else {
    $note = mysql_fetch_array($rnote)["Note"];
  }
  start_page("Mon site");

  // Exécution des requêtes SQL
  $query = "SELECT FILM.Id, FILM.Nom, FILM.Genre, FILM.Annee, FILM.Autorisation, FILM.Budget, FILM.Duree, FILM.Affiche, FILM.Description, AVG(NOTATIONS.Note) as Note FROM FILM LEFT JOIN NOTATIONS ON FILM.ID = NOTATIONS.Film_id WHERE FILM.ID=$id";
  $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
  $film = mysql_fetch_array($result) or die("Film inconnu");

  $query = "SELECT PERSONNE.Nom, ROLE.Role, PERSONNE.Id FROM ROLE RIGHT JOIN PERSONNE ON ROLE.Personne_id=Personne.id WHERE ROLE.Film_id=$id";
  $artistes = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

  
  echo "<div id='film'>";

    echo "<h1>"; echo $film['Nom']; echo "</h1>";

    echo "<div id='enhaut'>";
      echo "<img class='affiche' src='affiches/"; 
        echo $film['Affiche']; 
        echo "'>";
      echo "<div id='infos'>";
        echo "<h2 id='genre'>"; echo $film['Genre']; echo "</h2>";
        echo "<date>"; 
          echo "<b>Date de sortie : </b>";
          echo date("d M Y", strtotime($film['Annee'])); 
          echo '</date>';
        echo "<p id='autorisation'>"; 
          echo "<b>Autorisation : </b>";
          echo $film['Autorisation']; 
          echo '</p>';
        echo "<p id='budget'>";
          echo "<b>Budget : </b>"; 
          echo $film['Budget']; 
          echo '</p>';
        echo "<p id='artistes'>";
          while ($artiste = mysql_fetch_array($artistes, MYSQL_ASSOC)) {
            #echo "<li>";
            echo "<a href='/personne.php?id="; echo $artiste["Id"]; echo "'>";
            echo $artiste["Nom"];
            echo "</a>";
            echo " dans le rôle de ";
            echo $artiste["Role"];
            echo "<br>";
          }
          echo "</p>";
        if($film["Note"]) {
          echo "<p id='note'><b>Note des visiteurs : </b>"; 
            echo number_format($film["Note"], 1);
            echo "</p>";
          }
        echo "<div class='rating'>";
          for ($i=$note; $i<5; $i++) {
            echo "<a class='bs' href='/film.php?id=";
            echo $id;
            echo "&note=";
            echo 5-$i+$note;
            echo "'>☆</a>";
          }
          for ($i=0; $i<$note; $i++) {
            echo "<a class='gs' href='/film.php?id=";
            echo $id;
            echo "&note=";
            echo $note-$i;
            echo "'>★</a>";
          }
          echo "</div>";
      echo "</div>";

    echo "<div>";
    echo "<p id='description'>";
      echo nl2br($film["Description"]);
    echo "</p>";
    echo "</div>";

    echo "</div>";

  end_page();
?>
