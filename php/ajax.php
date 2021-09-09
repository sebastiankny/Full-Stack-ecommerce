<?php

    header('Content-Type: application/json');

    $aResult = array();

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

    //if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

    if( !isset($aResult['error']) ) {

        switch($_POST['functionname']) {
                case 'submit_cart':
                    if( !is_array($_POST['arguments']) || (count($_POST['arguments']) != 1) ) {
                        $aResult['error'] = 'Error in arguments!';
                    }
                    else {
                        include 'db_connection.php';
                        $sql = "INSERT INTO `order`(`Description`, `Status`) VALUES ('".$_POST['arguments'][0]."','Pending')";
                            if ($con->query($sql) === TRUE) {
                                $aResult['sql'] = "New record created successfully";
                            } else {
                                $aResult['error'] = 'Error in SQL query!';
                                $aResult['error_details'] = "Error: " . $sql . "<br>" . $con->error;
                            }

                            // load order list after submit
                            include 'function_load_order_list.php';
                    }
               
                break;

                case 'load_order_list':
                    include 'db_connection.php';
                    // export order list
                    include 'function_load_order_list.php';
                break;

                case 'mark_as_done':
                    include 'db_connection.php';

                    $sql = "UPDATE `order` SET `Status` = 'Done', `Changed_by_user` = '1' WHERE `order`.`Order_ID` = ".$_POST['arguments'][0];
                    if ($con->query($sql) === TRUE) {
                        $aResult['sql'] = "Status changed successfully!";
                    } else {
                        $aResult['error'] = 'Error in SQL query!';
                        $aResult['error_details'] = "Error: " . $sql . "<br>" . $con->error;
                    }

                break;

                case 'fetch_notification':
                    include 'db_connection.php';

                    $sql = "SELECT * FROM `notification`";// WHERE `Seen` = FALSE";
                    if ($notification_result = $con->query($sql)) {
                        $notification_table = $notification_result -> fetch_all(); 
                        //free result
                        $notification_result -> free_result();
                        $new_unseen_notification_available = false;
                        $html_output = '';
                        foreach($notification_table as $notification){
                            $html_output = $html_output.'<a href="#order_id_'.$notification[4].'" class="w3-bar-item w3-button notification';
                            
                            if (!$notification[3]) {
                                $html_output = $html_output.' unseen_notification';
                                $new_unseen_notification_available = true;
                            }
                            $html_output = $html_output.'" data-notification_id-type = '.$notification[0].'><b>'.$notification[1].'</b><br>'.$notification[2].'</a>';
                        }

                        $aResult['notification'] = $html_output;
                        if ($new_unseen_notification_available) $aResult['new_notification'] = 1;
                        $aResult['sql'] = "Notification fecthed successfully!";
                    } else {
                        $aResult['error'] = 'Error in SQL query!';
                        $aResult['error_details'] = "Error: " . $sql . "<br>" . $con->error;
                    }
                    
                break;

                case 'seen_notification':
                    include 'db_connection.php';
                    $sql = "UPDATE `notification` SET `Seen` = TRUE WHERE `notification`.`ID` = ".$_POST['arguments'][0];
                    if ($con->query($sql) === TRUE) {
                        $aResult['sql'] = "Notification seen successfully!";
                    } else {
                        $aResult['error'] = 'Error in SQL query!';
                        $aResult['error_details'] = "Error: " . $sql . "<br>" . $con->error;
                    }
                break;
            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }

    echo json_encode($aResult);

?>