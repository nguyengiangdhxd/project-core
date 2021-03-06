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

 	$data = $model->listItem(0,'all',0);
 	$orderArr = $model->orderGroup($data);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
<head>	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >	
<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" >
<body>	
<h2 style="margin: 10px;">List Nodes</h2>
<div class="main">
<form action="order.php" method="post">
<input type="submit" name="submit" value="order" />
 	<table id="list" width="100%" >
 		<thead>
 			<tr class="textCenter bold">
 				<td width="50">ID</td>
 				<td width="50">parents</td>
 				<td>Name</td>
 				<td width="50">Level</td>
 				<td width="50">left</td>
 				<td width="50">right</td>
 				<td width="80">Order</td>
 				<td width="100">Control</td>
 			</tr>
 		</thead>
 		<tbody>
 	
 	<?php 
 		if(count($data)>0){
 			foreach ($data as $key => $val){
 				$id 		= $val['id'];
 				$parents 	= $val['parents'];
 				$level 		= $val['level'];
 				$lft 		= $val['lft'];
 				$rgt 		= $val['rgt'];
 				$levelCss = '';
 				if($val['level'] == 0){
 					$name = '<b style="color:red">' . $val['name'] . '</b>';
 				}else if($val['level'] == 1){
	 				$name = '<b> + ' . $val['name'] . '</b>';
	 			}else{
	 				$name = '<b> - - ' . $val['name'] . '</b>';
	 				$levelCss =  'padding-left: ' . (20 * $val['level']) . 'px;';
	 			}
	 			
	 			$lnkEdit 	= 'index.php?action=edit&id=' . $val['id'];
	 			$lnkDelete 	= 'index.php?action=delete&id=' . $val['id'];
	 			$lnkMove 	= 'index.php?action=move&id=' . $val['id'];
	 			$orderName	= 'ordering[' . $val['lft'] . ']';
	 			$orderValue	= $model->getNodeOrdering($val['parents'],$val['lft']);
	 			$ordering	= '<input type="text" name="' . $orderName .'" 
	 							id="' . $orderName .'" 
	 							value="' . $orderValue . '" style ="width:50px; text-align: center;" />';
	 			
		?>
			<tr class="textCenter" style="text-align: ">
 				<td><?php echo $id;?></td>
 				<td><?php echo $parents;?></td>
 				<td class="textLeft" style="<?php echo $levelCss;?>"><?php echo $name;?></td>
 				<td><?php echo $level;?></td>
 				<td><?php echo $lft;?></td>
 				<td><?php echo $rgt;?></td>
 				<td><?php echo $ordering;?></td>
 				<td>
 				<?php if($val['level'] != 0):?>
					<a href="<?php echo $lnkEdit;?>">Edit</a> | 
					<a href="<?php echo $lnkDelete;?>">Delete</a>
				<?php endif;?>
				</td>
 			</tr>
		<?php 
 			}
 		}
 	?>
 		</tbody>
 	</table>
 </form> 
</div> 	
</body>
</html> 