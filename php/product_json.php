<?php 
foreach ($json_pages as $payload){
    $page = json_decode($payload);
    foreach ($page as $item){
      
		if (count($item->variations) <= 1) {
			$bulk_option = "No";
			echo '<tr>';
		}
		else {
			$bulk_option = "Yes";
			echo '<tr class = bulk_parent data-parent_id-type="'.$item->id.'">';
		}

        $price_per_unit = 0;
        if(count($item->variations) == 1) $price_per_unit = 'RM '.$item->variations[0]->regular_price;
        else if ($item->regular_price ==  '') $price_per_unit = 'N/A';
        else $price_per_unit = $item->regular_price;

		echo '<td>'.$item->name.'</td>
		<td>'.$item->description.'</td>
		<td>'.$price_per_unit.' <button type="button" class=add_to_cart data-id-type="'.$item->id.'">Add to cart</button> </td>
		<td>'.$bulk_option.'</td>
		</tr>';
		if (count($item->variations) > 1) 
		{
            $index = 0;
			foreach($item->variations as $bulk_values){ 
               
                // known issue, FTW Hoodie -> id with 771737 has complex attributes and variation
                // null check
                if (count($item->attributes[0]->options) > $index) $attribute = $item->attributes[0]->options[$index];
                //echo $item->id;
				echo '<tr></tr><tr class = bulk_row style="display: none;" data-child_id-type="'.$item->id.'">
				<td>'.$bulk_values->sku.'</td>
                <td>'.$attribute.'</td>
				<td colspan = "2">RM '.$bulk_values->regular_price.'<button class=add_to_cart type="button" data-id-type="'.$bulk_values->id.'">Add to cart</button> </td>
				</tr>';
                $index += 1;
			}
		
	    }

    //if(count($item->variations)==0) echo $item->id."<br>";
    }
} echo '</table>';
?>