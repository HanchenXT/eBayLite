    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
       
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']." | "; echo $_SESSION['firstname']." ". $_SESSION['lastname']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        
                        <li>
                            <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">GTBay</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  
                    <?php if($_SESSION['admin']) : ?>
                    <li>
                        <a href="admin">Admin</a>
                    </li>
                    <?php endif; ?>
                             
                    <li>
                        <a href="home.php">My Item</a> 
                        
                    </li>
                              
                    <li>
                        <a href="sell_item.php">Sell</a> 
                        
                    </li>
                    
                    <li>
                        <a href="search.php">Search</a>
                    </li>
                    
                    <li>
                        <a href="auction_results.php">Bidding Results</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        
        <!-- /.container -->
    </nav>