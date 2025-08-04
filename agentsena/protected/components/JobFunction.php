<?php
class JobFunction extends CApplicationComponent
{

	public function GetStaffMail($id){
	$staff_mail = "info-coagent@sena.co.th";
		if($id){
			$model = Project::model()->findByPk($id);

			if($model){
				switch($model->project_sale){
					case "admin1" :
						$staff_mail = "sucheran@sena.co.th";
					break;

					case "admin2" :
						$staff_mail = "kittiyaphans@sena.co.th";
					break;

					case "admin3" :
					 // $staff_mail = "pornpisith.sena@gmail.com";
						$staff_mail = "auchariyas@sena.co.th";
					break;

					default:
						$staff_mail = "info-coagent@sena.co.th";

				}


			}else{
				$staff_mail = "info-coagent@sena.co.th";
			}

		}

		return $staff_mail;

	}


	public function GetProveSt($id){
	$prove_st = 0;
		if($id){
			$model = AgCustomer::model()->findByPk($id);
			if($model){
				$prove_st = $model->sena_approve;
			}else{
				$prove_st = 0;
			}

		}

		return $prove_st;

	}

	public function GetCusName($id){
	$cus_name = "-";
		if($id){
			$model = AgCustomer::model()->findByPk($id);
			if($model){
				$cus_name = $model->fname." ".$model->lname;
			}else{
				$cus_name = "-";
			}

		}

		return $cus_name;

	}

	public function GetAgentName($id){
	$agent_name = "-";
		if($id){
			$model = AgAgent::model()->findByPk($id);
			if($model){
				$agent_name = $model->fname." ".$model->lname;
			}else{
				$agent_name = "-";
			}

		}

		return $agent_name;

	}

	public function GetProjectName($id){
	$project_name = "-";
		if($id){
			$model = Project::model()->findByPk($id);
			if($model){
				$project_name = $model->project_name;
			}else{
				$project_name = "-";
			}

		}

		return $project_name;

	}

	public function GetBudget($id){
	$bud_name = "-";
		if($id){
			$model = Budget::model()->findByPk($id);
			if($model){
				$bud_name = $model->bud_name;
			}else{
				$bud_name = "-";
			}

		}

		return $bud_name;

	}

	public function GetDuplicateName($id,$tb){
	$duplicate_name = "-";
		if($id){
			if($tb == "lead"){
				$model = AgLead::model()->findByPk($id);
				if($model){
					$duplicate_name = $model->fname." ".$model->lname;
				}else{
					$duplicate_name = "-";
				}
			}else{
				$model = AgCustomer::model()->findByPk($id);
				if($model){
					$duplicate_name = $model->fname." ".$model->lname;
				}else{
					$duplicate_name = "-";
				}
			}

		}

		return $duplicate_name;

	}


}
?>
