<?php
require 'App.php';
require 'Db.php';
class Api extends Db {

	public function get($view, $string, $page){
		if (($result = $this->select2($view, $string, $page)) > 0)
		{
			$json = [];
			$json[] = ['total_count'=>sizeof($result)];
			foreach($result as $row){
     			$json[] = ['id'=>$row['id'], 'text'=>$row['nombre']];
			}
			return $json;
		} else{
			return  '0 found';
		}
	}
}