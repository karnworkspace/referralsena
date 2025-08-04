<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Sales Cards  -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->

        <!-- Column -->
        <div class="border-top">
                    <!-- <div class="card-body">
                        <a href="<?=Yii::app()->createUrl('job/create')?>"><button type="button" class="btn btn-secondary"><i class="fas fa-folder-open"></i> Assign Job</button></a>
                    </div> -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ชื่อผู้สั่งงาน</th>
                                    <th>ฝ่าย/แผนก</th>
                                    <th>โครงการ</th>
                                    <th>ชื่องาน</th>
                                    <th>ผู้รับผิดชอบ</th>
                                    <th>วันที่สั่งงาน</th>
                                    <th>วันที่ขอรับงาน</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($listcustomer){
                            foreach($listcustomer as $key_list_customer => $value_list_customer){
                            // switch($value_list_customer->sena_approve){
                            // case "0":
                            // $st_job = "<span class=\"badge badge-secondary\">Pending</span>";
                            // break;
                            // case "1":
                            // $st_job = "<span class=\"badge badge-warning\">In process</span>";
                            // break;
                            // default
                          //}

							?>

                                <tr id="<?=$value_list_customer->agent_id?>">

                                    <td><?=$value_list_customer->fname?></td>
                                    <td><?=$value_list_customer->fname?></td>
                                    <td><?=$value_list_customer->fname?></td>
                                    <td><?=$value_list_customer->fname?></td>
                                    <td><?=$value_list_customer->fname?></td>
                                    <td><?=$value_list_customer->fname?></td>
                                    <td><?=$value_list_customer->fname?></td>
                                </tr>

                            <?php
								}
							}else{
							?>
                                <tr>
                                    <td colspan="8">NO DATA.</td>
                                </tr>

                            <?php
							}
							?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
</div>
