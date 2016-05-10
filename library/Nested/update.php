<?php 
	require_once 'nested.set.php';
	$dbParams = array(
					  'localhost'=>'localhost',
					  'user'=>'root',
					  'password'=>'',
					  'table'=>'nested_menu',
					  'db'=>'nested'
					);
	$model = new Nested_Set($dbParams);				
	$data = array('name'=>'Group C2');
 	$model->updateNode($data,8,3);