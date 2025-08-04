<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo Yii::app()->createUrl('site/index');?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo Yii::app()->createUrl('job/all');?>" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">All Work Progress</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo Yii::app()->createUrl('job/assign');?>" aria-expanded="false"><i class="mdi mdi-pencil"></i><span class="hide-menu">My Work Active</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo Yii::app()->createUrl('job/success');?>" aria-expanded="false"><i class="mdi mdi-check"></i><span class="hide-menu">My Work Success</span></a></li>
				            
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo Yii::app()->createUrl('job/report');?>" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Report</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">Menage </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                    	<li class="sidebar-item"><a href="<?php echo Yii::app()->createUrl('register/all');?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> User Register </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo Yii::app()->createUrl('user/admin');?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> User Account </span></a></li>
                        <li class="sidebar-item"><a href="<?php echo Yii::app()->createUrl('rights');?>" target="_blank" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> User Roles </span></a></li>
                        <!--<li class="sidebar-item"><a href="<?php echo Yii::app()->createUrl('JobType/admin');?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Work Type </span></a></li>-->
                        <li class="sidebar-item"><a href="<?php echo Yii::app()->createUrl('department/admin');?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Department </span></a></li>
                         <li class="sidebar-item"><a href="<?php echo Yii::app()->createUrl('ProjectJob/admin');?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Marcom Job </span></a></li>
                         <li class="sidebar-item"><a href="<?php echo Yii::app()->createUrl('MarcomTeam/admin');?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Marcom Team </span></a></li>
                         <li class="sidebar-item"><a href="<?php echo Yii::app()->createUrl('ProjectSupport/admin');?>" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Project Support </span></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
