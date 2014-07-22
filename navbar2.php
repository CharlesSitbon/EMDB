<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">EMDB</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="films.php">Films</a></li>
        <li><a href="artistes.php">Artistes</a></li>
      </ul>
      <form method = "get" action="search.php" class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text"  id="search_submit" class="form-control" placeholder="Film, Acteur..." name="search">
        </div>
        <button type="submit" class="btn btn-default">Recherche</button>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>