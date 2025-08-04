<?php
    $session=new CHttpSession;
    $session->open();
    $session['lastpage']=Yii::app()->request->url;
    $cs        = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery', CClientScript::POS_HEAD);
	 $cs->registerCoreScript('jquery.ui', CClientScript::POS_HEAD);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/images/favicon.png">
    <title>Dash board</title>
    <!-- Custom CSS -->
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/extra-libs/multicheck/multicheck.css">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/css/style.min.css?v=1.0" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/themes/fontawesome/css/all.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
   <!-- <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/jquery/dist/jquery.min.js"></script>-->

    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!-- <script src="dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
<!--    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/flot/excanvas.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/flot/jquery.flot.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/flot/jquery.flot.time.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/flot/jquery.flot.stack.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/js/pages/chart/chart-page-init.js"></script>
-->
    <!-- data table js -->
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/extra-libs/DataTables/datatables.min.js"></script>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/js/pages/mask/mask.init.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/themes/js/jquery.multifile.min.js"></script>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
            <?php
			$this->renderPartial('//layouts/header');
			?>


        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->


			<?php
					if(Yii::app()->user->getState('role') == 'admin') {
						$this->renderPartial('//layouts/left-slidebar-marcom-admin');
					}else{
						$this->renderPartial('//layouts/left-slidebar-user');
					}


					//echo $role_name."<br>";


				//print_r(Yii::app()->user->isSuperuser);


			//if(Yii::app()->user->checkAccess('OtherUser')){
				//other user
			//
			//}else{


			//}

            ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->


			<?php
            echo $content;
            ?>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->

			<?php
            $this->renderPartial('//layouts/footer');
            ?>

            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
       /*var table = $('#zero_config').DataTable({
			"order": [],
			"columns": [
						{ "width": "10%" },
						{ "width": "10%" },
						{ "width": "10%" },
						{ "width": "30%" },
						{ "width": "10%" },
						{ "width": "10%" },
						{ "width": "10%" },
						null,
						null
					  ]
			});
		*/
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();


        /*colorpicker*/
        $('.demo').each(function() {
        //
        // Dear reader, it's actually very easy to initialize MiniColors. For example:
        //
        //  $(selector).minicolors();
        //
        // The way I've done it below is just for the demo, so don't get confused
        // by it. Also, data- attributes aren't supported at this time...they're
        // only used for this demo.
        //
        $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                position: $(this).attr('data-position') || 'bottom left',

                change: function(value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(value);
                    }
                },
                theme: 'bootstrap'
            });

        });
        /*datwpicker*/
        jQuery('.mydatepicker').datepicker();
        jQuery('#Job_job_recive_date').datepicker({
            autoclose: true,
			format: 'yyyy-mm-dd',
			startDate: '+2d',
            todayHighlight: true
        });
        /*var quill = new Quill('#editor', {
            theme: 'snow'
        });*/
    </script>


</body>

</html>
