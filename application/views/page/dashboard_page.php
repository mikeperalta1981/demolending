            <!-- 
            sales performance...collection performance
			Total Overdue..number of accounts and total amount
            
             -->
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Dashboard</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                             <div class="box box-info">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Sales Graph</h3>

                                  <div class="box-tools pull-right">
                                      <select name="sales_year" id="sales_year">
                                        <?php for($i=2015; $i<=2020; $i++): ?>
                                            <?php if($i==date('Y')): ?>
                                                <option value='<?php echo $i ?>' selected><?php echo $i ?></option>
                                            <?php else: ?>
                                                <option value='<?php echo $i ?>'><?php echo $i ?></option>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                      </select>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <div id="saleschart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box box-primary box-solid">
                                                <div class="box-header">
                                                    <h3 class="box-title"></h3> 
                                                    <div class="box-tools">
                                                        <div class="input-group pull-right">
                                                            <form action="#" method="post" target="_blank">
                                                            
                                                            <!-- <button class="btn btn-success" type="submit">Generate PDF</button> -->
                                                            </form>
                                                        </div> 
                                                        <div>
                                                            <form action="#" method="post" id="frm_cpchart">

                                                            <span style='font-size: 20px;'>&nbsp;&nbsp;&nbsp;View Type:</span>
                                                            <select name="view_type" id="view_type" style='height: 27px;'>
                                                                <option value="weekly">Per Cutoff</option>
                                                                <option value="monthly">Monthly</option>
                                                            </select>    

                                                            <input name="cp_date" type="text" value="<?php echo date('Y-m')?>" id="cp_date">

                                                            <input name="cp_year" type="text" value="<?php echo date('Y')?>" id="cp_year">


                                                            <span style='font-size: 20px;'>&nbsp;&nbsp;&nbsp;Branch:</span>
                                                            <select name="branch_id" id="branch_id" style='height: 27px;'>
                                                                <!-- <option value="" selected="selected">All</option> -->
                                                                <?php foreach($branches as $val):?>
                                                                    <option value="<?php echo $val['id']?>"><?php echo $val['branch_name']?></option>
                                                                <?php endforeach;?>
                                                            </select>


                                                            <span style='font-size: 20px;'>&nbsp;&nbsp;&nbsp;Area:</span>
                                                            <select name="area_id" id="area_id" style='height: 27px;'>
                                                                <option value="" selected="selected">All</option>
                                                                <?php foreach($areas as $val):?>
                                                                    <option value="<?php echo $val['id']?>"><?php echo $val['area_name']?></option>
                                                                <?php endforeach;?>
                                                            </select>

                                                             
                                                            
                                                            </form>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div><!-- /.box-header -->
                                                <div class="box-body table-responsive no-padding">
                                                    <div id="collectionchart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                                    </div>
                                                    
                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->
                                        </div>
                                    </div>  
                        </div>
                    </div><!-- /.row -->
					          <!-- <div class="row">
                      <div class="col-md-6">
                        Repayment Performance
                      </div>
                      <div class="col-md-6">
                        Collection Performance
                      </div>
                    </div> -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->