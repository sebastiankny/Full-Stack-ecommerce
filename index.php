<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
</style>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript" src="js/functions.js"></script>
</head>
<?php include 'php/db_connection.php';?>
<body>
<div style="display:hidden;" id="top" class=main></div>

<div class="w3-bar w3-light-grey navbar">
  <a href="#" class="w3-bar-item w3-button">Top</a>
  <a href="#cart" class="w3-bar-item w3-button">Cart</a>
  <a href="#order_list" class="w3-bar-item w3-button">Order List</a>
  <div id="notification" class="w3-dropdown-click notification">
      <button class="w3-button" onclick="showDropdown()">
        Notification <i class="fa fa-caret-down"></i>
      </button>
    <div id="dropdown_div" class="w3-dropdown-content w3-bar-block w3-card-4">
      <!-- <a href="#" class="w3-bar-item w3-button dropdown">Link 1</a>
      <a href="#" class="w3-bar-item w3-button dropdown">Link 2</a>
      <a href="#" class="w3-bar-item w3-button dropdown">Link 3</a> -->
    </div>
  </div>
</div> 


<?php include 'php/mock_json_payload.php';?>

<?php include 'php/catalogue_table.php';?>
<?php include 'php/product_json.php';?>

<div id="tooltip"> Click to view bulk option.</div> <!-- //Tooltip -->

<div class=center>
<p>Simple cart</p>
<table class=center>
  <tbody id=cart><tr><th>ID</th><th>Quantity</th></tr>  
  </tbody>
</table>  
<section class=container>
  <div><button id=submit>Submit cart</button></div>
  <div><button id=clear_cart>Clear cart</button><br></div>
</section>

<p><button id=load_order_list>Refresh Order List</button></p>
</div>
<div class=center id=order_list></div>
<footer class="w3-container w3-teal w3-center w3-margin-top">
  <p>Find me on social media.</p>
  <i class="fa fa-facebook-official w3-hover-opacity"></i>
  <i class="fa fa-instagram w3-hover-opacity"></i>
  <i class="fa fa-snapchat w3-hover-opacity"></i>
  <i class="fa fa-pinterest-p w3-hover-opacity"></i>
  <i class="fa fa-twitter w3-hover-opacity"></i>
  <i class="fa fa-linkedin w3-hover-opacity"></i>
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>

</body>
</html>