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
				     
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
