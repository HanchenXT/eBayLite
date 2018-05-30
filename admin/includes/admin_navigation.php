 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">eBayLite Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               <li><a href="../index.php">HOME SITE</a></li>
  
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']." | "; echo $_SESSION['firstname']." ". $_SESSION['lastname']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#Report"><i class="fa fa-fw fa-arrows-v"></i> Report <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="Report" class="collapse">
                            <li>
                                <a href="./cate_report.php">View Category Report</a>
                            </li>
                            <li>
                                <a href="user_report.php">View User Report</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
                    </li>
                    <li>
                        <a href="./comments.php"><i class="fa fa-fw fa-file"></i> View All Comments</a>
                    </li>
                    <li>
                        <a href="./items.php"><i class="fa fa-fw fa-file"></i> View All Items</a>
                    </li>
                    <li>
                        <a href="./users.php"><i class="fa fa-fw fa-file"></i> View All Users</a>
                    </li>
                    <li>
                        <a href="./users.php?source=add_user"><i class="fa fa-fw fa-file"></i> Add a User</a>
                    </li>
                    <li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>