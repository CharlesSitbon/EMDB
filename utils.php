<?php
function do_mysql_connect() {
    $link = mysql_connect('127.0.0.1:8889', 'root', 'root')
        or die('Impossible de se connecter : ' . mysql_error());
    mysql_select_db('IMDB') or die('Impossible de sélectionner la base de données');
    mysql_query("SET NAMES utf8") or die('Échec de la requête : ' . mysql_error());
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


function get_visitor() {
    $id = $_COOKIE["id_visitor"];
    if ($id) {
        return $id;
    } else {
        $id = generateRandomString();
        setcookie("id_visitor", $id, time()+60*60*24*30*36, "/");
        return $id;
    }
}


function do_mysql_diconnect() {
    // Libération des résultats
    mysql_free_result($result);

    // Fermeture de la connexion
    mysql_close($link);
}


function start_page($title) { 
    error_reporting(E_ERROR);
    ini_set('display_errors', 'On');
    ?>
        <!doctype html>
        <html lang="fr">
        <head>
            <title><?php echo($title);?></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <link href="css/bootstrap2.css" rel="stylesheet">
            <link href="css/mystyle.css" rel="stylesheet">
        </head>
        <body>
            <header>
                <?php include("navbar2.php"); ?>
            </header>
<?php }


function end_page() { 
    ?>
        <footer>  
        </footer>
         <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
        <script>
        $(document).ready(function(){
        $(function(){
        $("#myTable").tablesorter(
        {
        theme : 'blue',
    
        sortList : [[1,0],[2,0],[3,0]],
        // header layout template; {icon} needed for some themes
        headerTemplate : '{content}{icon}',
 
        // initialize column styling of the table
        widgets : ["columns"],
        widgetOptions : {
        // change the default column class names
        // primary is the first column sorted, secondary is the second, etc
        columns : [ "primary", "secondary", "tertiary" ]
        }
        });
        $("#myTable2").tablesorter(
        {
        theme : 'blue',
    
        sortList : [[1,0],[2,0],[3,0],[4,0],[5,0],[6,0]],
        // header layout template; {icon} needed for some themes
        headerTemplate : '{content}{icon}',
 
        // initialize column styling of the table
        widgets : ["columns"],
        widgetOptions : {
        // change the default column class names
        // primary is the first column sorted, secondary is the second, etc
        columns : [ "primary", "secondary", "tertiary" ]
        }
        });
        });
        });
        </script>
        </body>
        </html>
    <?php    
    do_mysql_diconnect();
 }
?>