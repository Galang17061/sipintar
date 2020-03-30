<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/js/popper.js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/js/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/js/jquery-slimscroll/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/js/modernizr/modernizr.js"></script>
<!-- am chart -->
<script src="<?php echo base_url() ?>assets/themes_primary/pages/widget/amchart/amcharts.min.js"></script>
<script src="<?php echo base_url() ?>assets/themes_primary/pages/widget/amchart/serial.min.js"></script>
<!-- Chart js -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/js/chart.js/Chart.js"></script>
<!-- Todo js -->
<script type="text/javascript " src="<?php echo base_url() ?>assets/themes_primary/pages/todo/todo.js "></script>
<!-- Custom js -->
<!--<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/pages/dashboard/custom-dashboard.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url() ?>assets/themes_primary/js/script.js"></script>
<!--<script src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>-->
<!--<script src="<?php echo base_url() ?>assets/js/jquery.bootstrap.wizard.min.js"></script>-->
<script src="<?php echo base_url() ?>assets/plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/components/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/flipclock.js"></script>
<!--<script type="text/javascript " src="<?php echo base_url() ?>assets/themes_primary/js/SmoothScroll.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/script_template.js"></script>
<script src="<?php echo base_url() ?>assets/themes_primary/js/pcoded.min.js"></script>
<script src="<?php echo base_url() ?>assets/themes_primary/js/vartical-demo.js"></script>
<script src="<?php echo base_url() ?>assets/themes_primary/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/toastr.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/pagination.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootbox.js"></script>
<script src="<?php echo base_url() ?>assets/js/helper.js"></script>
<script src="<?php echo base_url() ?>assets/js/url.js"></script>
<script src="<?php echo base_url() ?>assets/js/message.js"></script>
 <!--<script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>-->
 <!--<script src="<?php echo base_url() ?>assets/js/jquery.stickytable.min.js"></script>-->



<script type="text/javascript">
    var url_link = window.location.href;
    console.log('url', url_link);
	// for sidebar menu entirely but not cover treeview
	$('ul.pcoded-left-item a').filter(function() {        
        console.log('ini ', $(this));
		return this.href == url_link;
    }).parent().addClass('active');
    
	// for treeview
	$('ul.pcoded-submenu a').filter(function() {
		return this.href == url_link;
	}).closest('li.pcoded-hasmenu').addClass('active').addClass('pcoded-trigger').addClass('complete');
</script>