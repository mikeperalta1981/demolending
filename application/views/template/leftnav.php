<?php $userdata = $this->session->userdata('logged_in');?>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <!--<img src="<?php //echo get_template_dir('img/logo.png');?>" class="img-circle1" alt="User Image" style="border: none"/>-->
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $userdata['firstname']?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    
                   <div class="alert alert-info" style="margin-bottom: 0!important; margin-left: 0px;">
                        Today is <strong><?php echo date('M d, Y');?></strong>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="dashboard">
                            <a href="<?php echo base_url('dashboard')?>" class="leftmenu">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="customers">
                            <a href="<?php echo base_url('customers');?>" class="leftmenu">
                                <!-- <i class="fa fa-th"></i> <span>Widgets</span> <small class="badge pull-right bg-green">new</small> -->
                                <i class="fa fa-users"></i> <span>Customers</span>
                            </a>
                        </li>
                        
                        <li class="treeview loan_grouping">
                            <a href="#">
                                <i class="fa fa-money"></i>
                                <span>Loans</span>
                                <i class="fa pull-right fa-angle-left angleicon"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li class="loan_applications"><a href="<?php echo base_url('loan_applications');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="application_text">Application</span></a></li>
                                <li class="loan_details"><a href="<?php echo base_url('loans');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="detail_text">Active</span></a></li>
                                <li class="loan_payments"><a href="<?php echo base_url('loan_payments');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="posting_text">Posting</span></a></li>
                                <li class="completed_loans"><a href="<?php echo base_url('completed_loans');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="completed_text">Completed</span></a></li>
                            </ul>
                        </li>
                     
                        <li class="treeview reports_grouping">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Reports</span>
                                <i class="fa pull-right fa-angle-left angleicon"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li class="ncr"><a href="<?php echo base_url('reports/ncr');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="ncr_text">NCR</span></a></li>
                                <li class="sales"><a href="<?php echo base_url('reports/scp');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="sales_text">Sales and Collection</span></a></li>
                                <li class="dcr"><a href="<?php echo base_url('reports/dcr');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="dcr_text">DCR</span></a></li>
                                <li class="repayment-performance"><a href="<?php echo base_url('reports/repayment_performance');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="repayment_performance_text">Repayment Performance</span></a></li>
                                <li class="collection-performance"><a href="<?php echo base_url('reports/collection_performance');?>" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <span id="collection_performance_text">Collection Performance</span></a></li>
                            </ul>
                        </li>
                        <?php if($userdata['user_type']=='1'):?>
                        <li class="admin">
                            <a href="<?php echo base_url('admin');?>" class="leftmenu">
                                <!-- <i class="fa fa-th"></i> <span>Widgets</span> <small class="badge pull-right bg-green">new</small> -->
                                <i class="fa fa-cog"></i> <span>Admin</span>
                            </a>
                        </li>
                        <?php endif;?>
                    </ul>
                    
                </section>
                
                <!-- /.sidebar -->
            </aside>