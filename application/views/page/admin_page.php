            <!-- 
            sales performance...collection performance
			Total Overdue..number of accounts and total amount
            
             -->
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Administrator Page
                        <small>Administrator Page</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Admin</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <!-- small box -->
                           <div class="box box-danger">
                                <div class="box-header">
                                    <h3 class="box-title">Areas</h3>
                                    <div class="box-tools pull-right">
	                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-area-modal"><i class="fa fa-plus-square"></i>Add Area</button>
                                    </div>
                                    
                                </div><!-- /.box-header -->
                                <!-- form start -->

                                    <div class="box-body table-responsive">
                                    	<table id="area-table" class="table table-bordered table-striped">
                                       		<thead>
                                            	<tr>
	                                            	<th>Id</th>
	                                                <th>Area Name</th>
	                                                <th>Date Created</th>
	                                                <th>Status</th>
	                                                <th>Action</th>
                                            	</tr>
                                        	</thead>
                                    	</table>
                                    </div><!-- /.box-body -->


                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-6 col-xs-6">
                            <!-- small box -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">Collectors</h3>
                                    <div class="box-tools pull-right">
	                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-collector-modal"><i class="fa fa-plus-square"></i>Add Collector</button>
                                    </div>
                                </div><!-- /.box-header -->
                                <!-- form start -->

                                    <div class="box-body table-responsive">
                                    	<table id="collector-table" class="table table-bordered table-striped">
                                       		<thead>
                                            	<tr>
	                                            	<th>Id</th>
	                                                <th>Name</th>
	                                                <th>Area</th>
	                                                <th>Status</th>
	                                                <th>Action</th>
                                            	</tr>
                                        	</thead>
                                    	</table>
                                    </div><!-- /.box-body -->


                            </div>
                        </div><!-- ./col -->
                        
                    </div><!-- /.row -->
					
                    <!-- Main row -->
                    <div class="row">
                    
                        <div class="col-lg-12 col-xs-12">
                            <!-- small box -->
                           <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Users</h3>
                                    <div class="box-tools pull-right">
	                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-user-modal"><i class="fa fa-plus-square"></i>Add User</button>
                                    </div>
                                    
                                </div><!-- /.box-header -->
                                <!-- form start -->

                                    <div class="box-body table-responsive">
                                    	<table id="user-table" class="table table-bordered table-striped">
                                       		<thead>
                                            	<tr>
	                                            	<th>Id</th>
	                                                <th>Name</th>
	                                                <th>User Type</th>
	                                                <th>Username</th>
	                                                <th>Status</th>
	                                                <th>Action</th>
                                            	</tr>
                                        	</thead>
                                    	</table>
                                    </div><!-- /.box-body -->


                            </div>
                        </div><!-- ./col -->
                        <!-- 
                        <div class="col-lg-6 col-xs-6">
                            
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Tools</h3>
                                    <div class="box-tools pull-right">
	                                    
                                    </div>
                                </div>

                                    <div class="box-body">
                                    	<form action="<?php //echo base_url('admin/backup_database')?>">
                                    		<button>Backup Database</button>
                                    	</form>
                                    </div>


                            </div>
                        </div>
                    	 -->
                    </div><!-- /.row (main row) -->
					
					 <!-- ADD AREA MODAL -->
					        <div class="modal fade" id="add-area-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add New Area</h4>
					                    </div>
					                    <form action="#" method="post" id="add-area-form">
					                        <div class="modal-body">
					                        	<div class="form-group">
					                            	<label>Area Name.</label>
					                                <input class="form-control" placeholder="Area Name" type="text" name="area_name" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Date Created</label>
					                                <input class="form-control" placeholder="Date Created" type="text" name="born" id="born">
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					                            <button type="submit" class="btn btn-primary  btn_submit"><i class="fa fa-share"></i> Save</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
					        
					        
					        <!-- EDIT AREA MODAL -->
					        <div class="modal fade" id="edit-area-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-plus-edit"></i> Edit Area</h4>
					                    </div>
					                    <form action="#" method="post" id="edit-area-form">
					                        <div class="modal-body">
					                        	<div class="form-group">
					                            	<label>Area Name.</label>
					                            	<input type='hidden' name='id'>
					                                <input class="form-control" placeholder="Area Name" type="text" name="area_name" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Date Created</label>
					                                <input class="form-control" placeholder="Date Created" type="text" name="born">
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
													
					                            <button type="submit" class="btn btn-primary  btn_submit"><i class="fa fa-share"></i> Update</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
					        
					        
					        
					        
					        
					        
					        
					        
					        
					         <!-- ADD COLLECTOR MODAL -->
					        <div class="modal fade" id="add-collector-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add New Collector</h4>
					                    </div>
					                    <form action="#" method="post" id="add-collector-form">
					                        <div class="modal-body">
					                        	<div class="form-group">
					                            	<label>Lastname</label>
					                                <input class="form-control" placeholder="Lastname" type="text" name="lastname" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Firstname</label>
					                                <input class="form-control" placeholder="Firstname" type="text" name="firstname" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Middlename</label>
					                                <input class="form-control" placeholder="Middlename" type="text" name="middlename">
					                            </div>
					                            <div class="form-group">
					                            	<label>Area</label>
					                                <select class='form-control' name='area_id'>
					                                	
					                                </select>
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
													
					                            <button type="submit" class="btn btn-primary  btn_submit"><i class="fa fa-share"></i> Save</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
					        
					        
					        <!-- EDIT COLLECTOR MODAL -->
					        <div class="modal fade" id="edit-collector-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-plus-edit"></i> Edit Collector</h4>
					                    </div>
					                    <form action="#" method="post" id="edit-collector-form">
					                        <div class="modal-body">
					                        	<div class="form-group">
					                            	<label>Lastname</label>
					                            	<input type="hidden" name="id">
					                                <input class="form-control" placeholder="Lastname" type="text" name="lastname" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Firstname</label>
					                                <input class="form-control" placeholder="Firstname" type="text" name="firstname" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Middlename</label>
					                                <input class="form-control" placeholder="Middlename" type="text" name="middlename">
					                            </div>
					                            <input type='hidden' id='c_area_id'>
					                            <div class="form-group">
					                            	<label>Area</label>
					                                <select class='form-control' name='area_id'>
					                                	
					                                </select>
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
													
					                            <button type="submit" class="btn btn-primary  btn_submit"><i class="fa fa-share"></i> Update</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
					        
					        
					        
					         <!-- ADD USER MODAL -->
					        <div class="modal fade" id="add-user-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add New User</h4>
					                    </div>
					                    <form action="#" method="post" id="add-user-form">
					                        <div class="modal-body">
					                        	<div class="form-group">
					                            	<label>Lastname</label>
					                                <input class="form-control" placeholder="Lastname" type="text" name="lastname" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Firstname</label>
					                                <input class="form-control" placeholder="Firstname" type="text" name="firstname" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Middlename</label>
					                                <input class="form-control" placeholder="Middlename" type="text" name="middlename">
					                            </div>
					                            <div class="form-group">
					                            	<label>Suffix</label>
					                                <input class="form-control" placeholder="Suffix" type="text" name="suffix">
					                            </div>
					                            <div class="form-group">
					                            	<label>User Type</label>
					                                <select class='form-control' name='user_type'>
					                                	<option value='1'>Super User</option>
					                                	<option value='2'>Manager</option>
					                                	<option value='3'>Secretary</option>
					                                	<option value='4'>Cashier</option>
					                                </select>
					                            </div>
					                            <div class="form-group">
					                            	<label>Username</label>
					                                <input class="form-control" placeholder="Username" type="text" name="username" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Password</label>
					                                <input class="form-control" placeholder="Password" type="text" name="password">
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					                            <button type="submit" class="btn btn-primary  btn_submit"><i class="fa fa-share"></i> Save</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
					        
					        
					        <!-- EDIT COLLECTOR MODAL -->
					        <div class="modal fade" id="edit-user-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					            <div class="modal-dialog">
					                <div class="modal-content">
					                    <div class="modal-header">
					                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					                        <h4 class="modal-title"><i class="fa fa-plus-edit"></i> Edit User</h4>
					                    </div>
					                    <form action="#" method="post" id="edit-user-form">
					                    	
					                        <div class="modal-body">
					                        	<div class="form-group">
					                            	<label>Lastname</label>
					                            	<input type="hidden" name="id">
					                                <input class="form-control" placeholder="Lastname" type="text" name="lastname" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Firstname</label>
					                                <input class="form-control" placeholder="Firstname" type="text" name="firstname" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Middlename</label>
					                                <input class="form-control" placeholder="Middlename" type="text" name="middlename">
					                            </div>
					                            <div class="form-group">
					                            	<label>Suffix</label>
					                                <input class="form-control" placeholder="Suffix" type="text" name="suffix">
					                            </div>
					                            <div class="form-group">
					                            	<label>User Type</label>
					                                <select class='form-control' name='user_type'>
					                                	<option value='1'>Super User</option>
					                                	<option value='2'>Manager</option>
					                                	<option value='3'>Secretary</option>
					                                	<option value='4'>Cashier</option>
					                                </select>
					                            </div>
					                            <div class="form-group">
					                            	<label>Username</label>
					                                <input class="form-control" placeholder="Username" type="text" name="username" required="required">
					                            </div>
					                            <div class="form-group">
					                            	<label>Password</label>
					                                <input class="form-control" placeholder="Password" type="text" name="password">
					                            </div>
					                        </div>
					                        <div class="modal-footer clearfix">
					
					                            <button type="button" class="btn btn-danger btn_cancel pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
													
					                            <button type="submit" class="btn btn-primary  btn_submit"><i class="fa fa-share"></i> Update</button>
					                        </div>
					                    </form>
					                </div><!-- /.modal-content -->
					            </div><!-- /.modal-dialog -->
					        </div><!-- /.modal -->
					        
					        
					        
					        
					        
					        
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->