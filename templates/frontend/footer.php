
    </div>

    <div class="container" id="theTableContainer"> 

      <div class="row visible-lg visible-md">
        <div class="col-xs-6 upperPart">
          <table id="theArtists" class="table table-striped table-condensed">
            <thead>
              <th>Artist</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="col-xs-6 upperPart">
          <table id="theAlbums" class="table table-striped table-condensed">
            <thead>
              <th>Albums</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

      <hr class="visible-md visible-lg" />
      <table id="theTable" class="table table-striped table-condensed table-hover">
        <thead>
          <th>&nbsp;</th>
          <th>Title</th>
          <th>Album</th>
          <th>Artist</th>
          <th>Year</th>
          <th class="visible-lg">Genre</th>
          <th>Lenght</th>
        </thead>

        <tbody>
          <tr class="info align-center">
            <td colspan="7">
            <h2>
              <i class="icon-smile"></i> Welcome to the Mustached Pi Music Project
            </h2>
            <p>&nbsp;</p>
            <p>
              <i class="icon-info-sign"></i>
              Please search for something using the search form. Or you may select an artist or an album.
            </p>  
            <p>&nbsp;</p>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

    <div class="container">
      <hr>
      <footer>
        <p>&copy;2013 The Mustached Pi Music project</p>
      </footer>
    </div>
    <nav class="navbar thePlayerBar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container ">


      <div class="row align-center">
        <div class="navbar-header col-md-3">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="">
            <audio src="about:blank" controls id="thePlayer"></audio>
          </div>

        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse">



          <div class="col-md-6">
          <p>
            <span class="strong" id="theTrackName">(No track playing)</span>
            &mdash; <span id="theArtistName">(No artist)</span><br />
            <span id="theTrackDuration">0:00</span>
            from the album <span id="theAlbumName">(no album)</span>
          </p>
          </div>

          <div class="col-md-3">
          <form class="navbar-right" role="search">
            <div class=" input-group">

              <input id="theSearchInput" type="text" class="form-control" autofocus placeholder="Search music...">
              <div class="input-group-btn">
                <button type="submit" id="theSearchButton" class="btn btn-default">
                  <i class="icon-search"></i>
                </button>
              </div>
            </div>
          </form>
          </div>

        </div>
      </div>

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
