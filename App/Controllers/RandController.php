<?php

class RandController
{
	public function actionIndex()
	{
		$proj_id_list = App\Models\getProject::getIdActiveProj();
		$proj_id_arr = explode(",", $proj_id_list['proj_id_list']);
		$rand_proj_id = $proj_id_arr[mt_rand(0, count($proj_id_arr) - 1)]; 
		header("Location: /catalog/item/$rand_proj_id");
		return true;
	}
}