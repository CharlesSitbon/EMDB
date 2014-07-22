
<?php include("utils.php");
  do_mysql_connect();
  start_page("Accueil");
  ?>
  <div class="starter-template">
  <p class="lead">
  Bienvenue sur ENSAE MDB,<br />
  Le site du ciné club ENSAE 
  </p>
  <div id="artiste_mois">
    <h2>Artiste du mois:</h2>
    <a href='/personne.php?id=9'> <h2>Scarlett Johansson </h2>
    <img height='500' src='/artistes/Scarlett_Johansson.jpg'>
    </a>
    </div>
  <div id="meilleurs_films">
    <h2>Films les mieux notés</h2>
    <?php
      echo "<table >";
      echo "<thead> <tr>";
      echo "<th>Nom du film</th><th>Note moyenne</th>";
      echo "</tr> </thead>";
      echo "<tbody>";
      $query = "SELECT FILM.Id, FILM.Nom, AVG(NOTATIONS.NOTE) as Note FROM FILM  
                LEFT JOIN NOTATIONS ON FILM.Id = NOTATIONS.Film_id GROUP BY FILM.Id 
                ORDER BY Note DESC LIMIT 10";
      $films = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
      while($film = mysql_fetch_array($films)) {
        echo "<tr>";
        echo "<td><a href='film.php?id=";
        echo $film["Id"];
        echo "'>";
        echo $film["Nom"];
        echo "</a></td><td>";
        echo number_format($film["Note"], 1);
        echo "</td></tr>\n";
      }
      echo "</tbody>";
      echo "</table>\n";
    ?>
    </div>
  <div id="personalized_films">
    <h2>Films conseillés pour vous</h2>
    <?php
    $userid = get_visitor();
    $query = "SELECT FILM.Nom, Film.Id, SCORES.Score, SCORES.Note
      FROM FILM
      LEFT JOIN ( # Les ID des films conseillés
        SELECT NOTATIONS.Film_id, 
          AVG(IFNULL(SIMU_USER.Similarite, 0.5) * NOTATIONS.Note) as SCORE,
          AVG(NOTATIONS.Note) as Note
        FROM NOTATIONS
        LEFT JOIN (
          # Similarité user-user
          SELECT NOTATIONS.Visitor_id, 
                1 / (1+EXP(-SUM(
                  (NOTATIONS.Note - MeanFilm.Note) * (MyNotes.Note - MeanFilm.Note))))
                as Similarite
          FROM NOTATIONS
          LEFT JOIN ( # Les notes moyennes des films
            SELECT NOTATIONS.Film_id, AVG(NOTATIONS.Note) as Note FROM NOTATIONS 
            GROUP BY Film_id
          ) AS MeanFilm 
          ON MeanFilm.Film_id = NOTATIONS.Film_id
          RIGHT JOIN ( #Les notes  de l'utisateur
            SELECT NOTATIONS.Film_id, NOTATIONS.Note as Note 
            FROM NOTATIONS
            WHERE NOTATIONS.Visitor_id = '$userid' 
          ) AS MyNotes 
          ON Mynotes.Film_id = Notations.Film_id
          GROUP BY NOTATIONS.Visitor_id
        ) AS SIMU_USER
        ON SIMU_USER.Visitor_id = NOTATIONS.Visitor_id
        GROUP BY NOTATIONS.Film_id
        ORDER BY SCORE DESC
        LIMIT 10
      ) AS SCORES
      ON FILM.Id = SCORES.Film_id
      ORDER BY SCORE DESC
      ";
    $films = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    echo "<table >";
    echo "<thead> <tr>";
    echo "<th>Nom du film</th><th><span>Note moyenne</span></th><th>Votre score</th>";
    echo "</tr> </thead>";
    echo "<tbody>";
    while($film = mysql_fetch_array($films)) {
      echo "<tr>";
      echo "<td><a href='film.php?id=";
      echo $film["Id"];
      echo "'>";
      echo $film["Nom"];
      echo "</a></td><td>";
      echo number_format($film["Note"], 1);
      echo "</td><td><span>";
      echo number_format(2*$film["Score"], 1);
      echo "</span></td></tr>\n";
    }
    echo "</tbody>";
    echo "</table>\n";
    ?>
    </div>
  </div>
<?php end_page(); ?>
 