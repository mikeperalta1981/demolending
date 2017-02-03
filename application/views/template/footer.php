 <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
        <script src="<?php echo get_template_dir('js/jquery.js')?>"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?php echo get_template_dir('js/jquery-ui-1.10.3.min.js');?>" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo get_template_dir('js/bootstrap.min.js');?>" type="text/javascript"></script>
        <!-- Morris.js charts
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="<?php //echo get_template_dir('js/plugins/morris/morris.min.js');?>" type="text/javascript"></script> -->
        <!-- Sparkline -->
        <script src="<?php //echo get_template_dir('js/plugins/sparkline/jquery.sparkline.min.js');?>" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?php //echo get_template_dir('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');?>" type="text/javascript"></script>
        <script src="<?php //echo get_template_dir('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');?>" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php //echo get_template_dir('js/plugins/jqueryKnob/jquery.knob.js');?>" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?php //echo get_template_dir('js/plugins/daterangepicker/daterangepicker.js');?>" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="<?php echo get_template_dir('js/plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php //echo get_template_dir('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo get_template_dir('js/plugins/iCheck/icheck.min.js');?>" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo get_template_dir('js/AdminLTE/app.js');?>" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!-- <script src="<?php //echo get_template_dir('js/AdminLTE/dashboard.js');?>" type="text/javascript"></script> -->

        <!-- AdminLTE for demo purposes 
        <script src="<?php //echo get_template_dir('js/AdminLTE/demo.js');?>" type="text/javascript"></script>
        -->
        <script>
			var base_url = '<?php echo base_url() ?>',
				site_url = '<?php echo site_url() ?>',
				template_dir = '<?php echo get_template_dir() ?>';

			var current_year_month = "<?php echo date('Y-m')?>";
		
		</script> 
        <?php  echo render_javascript(); ?>

    </body>
</html>