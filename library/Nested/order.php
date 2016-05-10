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

	$sql = 'SELECT * 
			FROM nested_menu 
			ORDER BY lft ASC
			';
	$result = mysql_query($sql,$model->_connect);
	
	$data = array();
	while ($row = mysql_fetch_assoc($result)){
		$data[] = $row;
	}
	$orderArr = $_POST['ordering'];
	$model->orderTree($data, $orderArr);
	/*echo '<pre  class="code">';
	print_r($_POST);
	echo '</pre>';*/

?>
