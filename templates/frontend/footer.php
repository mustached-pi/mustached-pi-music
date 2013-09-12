
    </div>

    <div class="container">

      <h3 id="theTableDescription">&nbsp;</h3>

      <table id="theTable" style="display: none;" class="table table-striped">
        <thead>
          <tr>
            <th>Title</th>
            <th>Album</th>
            <th>Artist</th>
            <th>Year</th>
            <th>Genre</th>
            <th>Lenght</th>
            <th>Play</th>
          </tr>
        </thead>

        <tbody>

        </tbody>
      </table>
    </div>

    <div class="container">
      <hr>
      <footer>
        <p>&copy; [[author]] 2013</p>
      </footer>
    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Mustached Pi Play</a>
      </div>
      
      <audio src="about:blank" controls autoplay id="thePlayer"></audio>

      <div class="collapse navbar-collapse navbar-ex1-collapse">

      <div class="btn-group">
        <a class="btn btn-default">
          <i class="icon-step-backward"></i>
        </a>
        <a class="btn btn-default">
          <i class="icon-step-forward"></i>
        </a>
      </div>

      The track name

        <form class="navbar-form navbar-right" role="search">
          <div class="form-group">

            <input id="theSearchInput" type="text" class="form-control" autofocus placeholder="Search music...">
          </div>
          <button type="submit" id="theSearchButton" class="btn btn-default">
            <i class="icon-search"></i>
          </button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#">Link</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li>
        </ul>

      </div>
    </nav>



    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/application.js"></script>
    <?php
    $js_file = "js/pages/{$page}.js";
    if ( is_readable($js_file) ) { ?>
      <script type="text/javascript" src="<?= $js_file; ?>"></script>
    <?php } ?>
  </body>
</html>
