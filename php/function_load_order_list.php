<?php
    $sql = "SELECT * FROM `order`";
    if ($order_result = $con->query($sql)) {
        $order_table = $order_result -> fetch_all(); 
        //free result
        $order_result -> free_result();
        $html_output = '
        
        <table class=center>
        <tr>
            <th>Order ID</th>
            <th>Details</th>
            <th>Status</th>
        </tr>';
        
        foreach($order_table as $order_row){
            $description = json_decode($order_row[1]);
            $index = 0;
            $details = '';
            foreach ($description as $description_values){
                $details = $details.$description_values->id.' x'.$description_values->quantity;
                if ($index != count($description)-1) $details = $details.'<br>';
            }

            $html_output = $html_output.'<tr id=order_id_'.$order_row[0].'>
            <td>'.$order_row[0].'</td>
            <td>'.$details.'</td>
            <td><div data-status_order_id-type='.$order_row[0].'>'.$order_row[2].'</div>';
            if ($order_row[2] != 'Done')  $html_output = $html_output.'<div><button class=mark_as_done data-order_id-type='.$order_row[0].'>Mark as done</button></div></td>';
            $html_output = $html_output.'</tr>';
        }

        $html_output = $html_output."</table>";
        $aResult['order_list'] = $html_output;

    } 
    else {
        $aResult['error'] = 'Error in SQL query!';
        $aResult['error_details'] = "Error: " . $sql . "<br>" . $con->error;
    }
    


?>