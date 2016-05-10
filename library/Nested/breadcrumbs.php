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
	$data = $model->breadcrumbs(6,0);
	
	echo '<pre  class="code">';
	print_r($data);
	echo '</pre>';

?>
