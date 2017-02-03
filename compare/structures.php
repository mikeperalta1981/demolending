		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">	
				<h1>
					Structure Management <small>Playtech Entity Structures</small>
				</h1>		
			</section>

			<!-- Main content -->			
			<section class="content">
				
				<div class="alert-wrap">
					<div class="alert alert-dismissable<?php echo empty($servers) ? ' alert-warning' : '' ?>"<?php echo ! empty($servers) ? ' style="display:none;"' : '' ?>>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa <?php echo empty($servers) ? ' fa-warning' : ''?>"></i><span class="alert-title"><?php echo empty($servers) ? 'Warning' : '' ?></span></h4>
						<span class="alert-message"><?php echo empty($servers) ? 'Please check <a class="alert-link" href="'.site_url('servers').'">API servers</a> to be able to add entity keys.' : '' ?></span>
					</div>			
				</div>		
					
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">Business Entities</h3>
								<div class="box-tools pull-right">
									<?php if(! empty($servers)): ?>
		                				<!-- <button class="btn btn-primary btn-add-entity" data-toggle="modal" data-target="#add-entity-modal"><i class='fa fa-plus'></i> Add Structure</button> -->
		                			<?php endif ?>
		               			</div>
							</div>
							<form id="display-structure-form" action="<?php echo site_url('structures/ajax/display_structure') ?>" class="form-horizontal" role="form">	
								<div class="box-body">
									<div class="alert-wrap">
										<div class="alert alert-dismissable" style="display:none;">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<h4><i class="icon fa"></i><span class="alert-title"></span></h4>
											<span class="alert-message"></span>
										</div>			
									</div>
									
									<div class="form-group">
										<label for="server_id" class="col-sm-2 control-label">Server</label>
										<div class="col-sm-8">
											<select id="server_id" name="server_id" class="form-control" style="width:100%;">
												<?php foreach($servers as $key => $server): ?>
												<option value="<?php echo $server['id'] ?>"><?php echo $server['name'] ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="entity_id" class="col-sm-2 control-label">Entity</label>
										<div class="col-sm-8">
											<select id="entity_id" name="entity_id" class="form-control" style="width:100%;">
												
											</select>
											<input type="hidden" id="entity_name_hidden" name="entity_name"/>
										</div>
									</div>
      								
								</div>
								<div class="box-footer text-center">
									<button type="submit" class="btn btn-primary btn-display-structure" data-loading-text="Processing..."><i class='fa fa-sitemap'></i> Display Structure</button> 
      								<!--<button type="button" class="btn btn-primary btn-add-structure" data-toggle="modal" data-target="#add-structure-modal"><i class='fa fa-plus'></i> Add Structure</button>-->
								</div>
							</form>
							
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
				</div>
				
				<!-- Tree view -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">Tree Structure</h3>
								<div class="box-tools pull-right">
									<?php if(! empty($servers)): ?>
										<div class="btn-group">
										  <button type="button" class="btn btn-primary dropdown-toggle btn-entity btn-entity-functions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Entity <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
										    <li class='li_apifunction add-entity' data-apiparam="entity/create" data-method="create_entity" data-prompt="Create Entity" data-buttonname='entity'><a href="#">Add Child Entity</a></li>
										    <li class='li_apifunction update-entity' data-apiparam="entity/update" data-method="update_entity" data-prompt="Update Entity" data-buttonname='entity'><a href="#">Update Entity</a></li>

										    <li><a href="#">Broken Games</a></li>
											<li><a href="#">Freeze Entity</a></li>
											<li><a href="#">Generate Key</a></li>
											<li role="separator" class="divider"></li>
											<li class="entity-games"><a id="btn-entity-games" href="<?php echo site_url('entity/games') ?>" class="btn-remote-modal">Entity Games</a></li>
											<li class="entity-limits"><a id="btn-entity-limits" href="<?php echo site_url('entity/limits') ?>" class="btn-remote-modal">Entity Limits</a></li>
											<li><a href="#">Entity Jackpots</a></li>

										  </ul>
										</div>

										<!-- Admin -->
										<div class="btn-group">
										  <button type="button" class="btn btn-primary dropdown-toggle btn-admin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Admin <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
										    <li class='li_apifunction add-admin' data-apiparam="admin/create" data-method="create_admin" data-prompt="Create Admin" data-buttonname='admin'><a href="#">Add Admin</a></li>
										    <li class='li_apifunction update-admin' data-apiparam="admin/update" data-method="update_admin" data-prompt="Update Admin" data-buttonname='admin'><a href="#">Update Admin</a></li>
										  </ul>
										</div>

										<!-- Kiosk -->
										<div class="btn-group">
										  <button type="button" class="btn btn-primary dropdown-toggle btn-kiosk" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Kiosk <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
										    <li class='li_apifunction add-kiosk' data-apiparam="kiosk/create" data-method="create_kiosk" data-prompt="Create Kiosk" data-buttonname='kiosk'><a href="#">Add Kiosk</a></li>
										    <li class='li_apifunction update-kiosk' data-apiparam="kiosk/update" data-method="update_kiosk" data-prompt="Update Kiosk" data-buttonname='kiosk'><a href="#">Update Kiosk</a></li>
										  </ul>
										</div>
		                			<?php endif ?>
		               			</div>
							</div>
								
								<div class="box-body">
									<div id='success_info'></div>
									<div id="container"></div>
								</div>
							
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
				</div>
				
				
			</section>
			<!-- /.content -->
		</div>

		<!-- general modal -->
		<div id="form-modal" class="modal fade" role="dialog" aria-labelledby="formLabel"  data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="formLabel"></h4>
					</div>
					<form id="subject-form" method="post" action="" class="form-horizontal">			
						<div class="modal-body" id='subject_modal_body'>
							<div class="alert-wrap">
								<div class="alert alert-dismissable" style="display:none;">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<h4><i class="icon fa"></i><span class="alert-title"></span></h4>
									<span class="alert-message"></span>
								</div>			
							</div>
							<div class="form-group">
								<label for="server_id" class="col-sm-4 control-label">Server</label>
								<div class="col-sm-6">
									<input class="form-control" name="server_id" type="hidden">
									<input class="form-control" name="server_name" type="text" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="col-sm-4 control-label" id='entityname_label'>Parent Entity</label>
								<div class="col-sm-6">
									<input class="form-control" name="entity_id" type="hidden">
									<input class="form-control" name="api_request" type="hidden">
									<input type="hidden" class="form-control"  name="parent_entity_id" placeholder="Name or Description" readonly>
									<input type="text" class="form-control"  name="parent_entity_name" placeholder="Name or Description" readonly>
								</div>
							</div>
							<div id="subject_formfields"></div>	
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn-submit" data-loading-text="Processing...">Submit</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- end general modal -->

		<!--admin info modal -->
		<div id="admin-info-form-modal" class="modal fade" role="dialog" aria-labelledby="adminInfoLabel"  data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="adminInfoLabel"></h4>
					</div>
					<form id="admin-info-form" method="post" action="" class="form-horizontal">			
						<div class="modal-body" id='subject_modal_body'>
							<div class="alert-wrap">
								<div class="alert alert-dismissable" style="display:none;">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<h4><i class="icon fa"></i><span class="alert-title"></span></h4>
									<span class="alert-message"></span>
								</div>			
							</div>
							<div class="form-grou hidden">
								<label for="server_id" class="col-sm-4 control-label">Server</label>
								<div class="col-sm-6">
									<input class="form-control" name="server_id" type="hidden">
									<input class="form-control" name="server_name" type="hidden" readonly>
								</div>
							</div>
							<div class="form-group hidden">
								<label for="name" class="col-sm-4 control-label" id='entityname_label'>Parent Entity</label>
								<div class="col-sm-6">
									<input class="form-control" name="entity_id" type="hidden">
									<input class="form-control" name="api_request" type="hidden">
									<input type="hidden" class="form-control"  name="parent_entity_id" placeholder="Name or Description" readonly>
									<input type="hidden" class="form-control"  name="parent_entity_name" placeholder="Name or Description" readonly>
								</div>
							</div>
							<div id="admin_formfields"></div>	
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn-submit" data-loading-text="Processing...">Submit</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!--end admin info modal -->
		<div id="entity-functions-modal" data-backdrop="static" class="modal fade" role="dialog" aria-labelledby="entityFunctionsLabel">
		   <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		     
		    </div><!-- /.modal-content -->
		   </div><!-- /.modal-dialog -->
	  	</div><!-- /.modal -->