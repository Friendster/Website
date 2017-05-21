<nav class="navbar navbar-default nomargin">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Friendster</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav navbar-right">
                <li><?php echo "<p class=\"navbar-text\">Logged in as: " . htmlentities($session->get(Session::EMAIL)) ."</p>";?></li>
                <li><a href="?page=login">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>