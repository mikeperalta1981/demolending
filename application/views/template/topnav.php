<!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url('dashboard')?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                iLend
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <span style="font-size: 30px; color: white; margin: 0 Auto;">Ginhawa Lending Company</span>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                                <!-- <span class="label label-danger">9</span> -->
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Task</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
	                                        
                                            <a href="<?php echo base_url('admin/backup_database')?>">
                                                <h3>
                                                    Backup Database Now
                                                    <!-- <small class="pull-right">20%</small> -->
                                                </h3>
                                                <!-- 
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                                 -->
                                            </a>
                                        </li><!-- end task item -->
                                    </ul>
                                </li>
                                <!-- <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li> -->
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php $userdata = $this->session->userdata('logged_in'); echo $userdata['firstname']?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo get_template_dir('img/avatar3.png');?>" class="img-circle" alt="User Image" />
                                    <p>
                                    	<?php echo $userdata['firstname'] . " " . $userdata['lastname'];?>
                                        <!-- Nyor Bolanyos - President -->
                                        <!-- <small>Member since Nov. 2012</small> -->
                                    </p>
                                </li>
                                <!-- Menu Body
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                 -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('logout')?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>