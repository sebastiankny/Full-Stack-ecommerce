$(document).ready(function(){
    $(".bulk_parent").click(
    function(){
        var item_id = $(this).attr("data-parent_id-type");
        $("[data-child_id-type ="+item_id+"]").toggle();
    });   
      
    $(".bulk_parent").hover(function(e) {
      $("#tooltip").css({
          left: e.pageX + 1,
          top: e.pageY + 1
        }).show();
    }, function() {
      $("#tooltip").hide();
    });

    $("#submit").click(function(){

      //prepare json
      var cart_json = '[';
      var Ids = extractId();
      for (let i = 0; i < Ids.length; i++) {
        cart_json = cart_json.concat('{"id":"',Ids[i],'", "quantity":"1"},');
      } 
      cart_json = cart_json.slice(0,cart_json.length-1).concat(']');
      
      
      $.ajax({
        type: "POST",
        url: 'php/ajax.php',
        dataType: 'json',
        data: {functionname: 'submit_cart', arguments: [cart_json]},
    
        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                        $('#order_list').html(obj.order_list);
                        //console.log(obj.sql);
                      }
                      else {
                        //console.log(obj.error_details); commented to avoid sql injection
                        console.log(obj.error);
                      }
                }
                
      });
    });

    $("#load_order_list").click(function(){
      load_order_list();
    });
    
    $(".add_to_cart").click(function(){
      var id = $(this).attr("data-id-type");
      var txt1 = $("<td></td>").text(id);
      var txt2 = $("<td></td>").text("x1");
      $("#cart").append("<tr>",txt1,txt2,"</tr>");

    });

    $(document).on("click", ".mark_as_done", function(){
      var id = $(this).attr("data-order_id-type");
      $("[data-status_order_id-type ="+id+"]").html("Done");
      $(this).hide();

      $.ajax({
        type: "POST",
        url: 'php/ajax.php',
        dataType: 'json',
        data: {functionname: 'mark_as_done', arguments: [id]},
    
        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                        // do nothing
                        //console.log(obj.sql);
                      }
                      else {
                        //console.log(obj.error_details); commented to avoid sql injection
                        console.log(obj.error);
                      }
                }
                
      });
    });

    $("#clear_cart").click(function(){
      $("#cart").html('<tr><th>ID</th><th>Quantity</th></tr>');

    });

    $(document).on("click", ".notification", function(){
      
      // seen the notification
      var x = $(this);
      var id = x.attr("data-notification_id-type");
      if (x.attr("class").indexOf("unseen_notification") != -1) {
        x.attr("class", x.attr("class").replace(" unseen_notification", ""));
      }

      $.ajax({
        type: "POST",
        url: 'php/ajax.php',
        dataType: 'json',
        data: {functionname: 'seen_notification', arguments: [id]},
    
        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                        // do nothing
                        //console.log(obj.sql);
                      }
                      else {
                        //console.log(obj.error_details); commented to avoid sql injection
                        console.log(obj.error);
                      }
                }
                
      });
    });

    function extractId(){
      let cart_html = $("#cart").html();
      let cart_html2 = cart_html.split("<tr>")
      cart_html2.splice(0,2);

      var ids = new Array(cart_html2.length);
      for (let i = 0; i < cart_html2.length; i++) {
        ids[i] = cart_html2[i].slice(cart_html2[i].indexOf("<td>")+4, cart_html2[i].indexOf("</td>"));
      } 
      return ids;
    }
    
    load_unseen_notification();
    load_order_list();

    setInterval(function(){ 
      load_unseen_notification();
      load_order_list();
     }, 5000);
});

function load_unseen_notification()
      {
        $.ajax({
        url:"php/ajax.php",
        method:"POST",
        data:{functionname: 'fetch_notification'},
        dataType:"json",
        success:function(obj){
                      if( !('error' in obj) ) {
                      $('#dropdown_div').html(obj.notification);
                      if (obj.new_notification) unseenNotification();
                    }
                    else{
                      console.log(obj.error);
                    }
                }
        });
      }

function load_order_list(){
  $.ajax({
    type: "POST",
    url: 'php/ajax.php',
    dataType: 'json',
    data: {functionname: 'load_order_list', arguments: []},

    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                    $('#order_list').html(obj.order_list);
                    //console.log(obj.sql);
                  }
                  else {
                    //console.log(obj.error_details); commented to avoid sql injection
                    console.log(obj.error);
                  }
            }
            
  });
      }
function showDropdown() {
  var x = document.getElementById("dropdown_div");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}

// for nav bar
function unseenNotification() {
  var x = document.getElementById("notification");
  if (x.className.indexOf("unseen_notification") == -1) {
    x.className += " unseen_notification";
  }
}