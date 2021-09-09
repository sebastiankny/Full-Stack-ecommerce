<?php
    // Perform query
if ($result = $con -> query("SELECT * FROM catalogue")) {

	$row = $result -> fetch_all();

	// Free result set
	$result -> free_result();

	echo
	'<table id="customers">
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Unit Price</th>
	  <th>Bulk Option</th>
    </tr>';
	foreach($row as $values){
		if ($values[4] == false) {
			$bulk_option = "No";
			echo '<tr>';
		}
		else {
			$bulk_option = "Yes";
			echo '<tr class = bulk_parent data-parent_id-type="'.$values[0].'">';
		}

		echo '<td>'.$values[1].'</td>
		<td>'.$values[2].'</td>
		<td>RM '.$values[3].'</td>
		<td>'.$bulk_option.'</td>
		</tr>';
		if ($values[4] == true) 
		{
			if ($bulk_result = $con -> query("SELECT * FROM `bulk_option_table` WHERE `Item_ID` = ".$values[0])) {

			$bulk_row = $bulk_result -> fetch_all();
			// Free result set
			$bulk_result -> free_result();
			}
			$index = 0;
			foreach($bulk_row as $bulk_values){ 
				echo '<tr></tr><tr class = bulk_row style="display: none;" data-child_id-type="'.$values[0].'">
				<td colspan = "2">'.$bulk_values[1].'</td>
				<td colspan = "2">RM '.$bulk_values[2].'</td>
				</tr>';
			}
		}
	}//echo '</table>';
	
	
}
?>

