$(document).ready(function () {
  //console.log("hi");
	$("select.toggleallowdeny").change(function() {
    //console.log("firing")
    var selected = $(this).find('option:selected').val();
    var id = getId($(this).attr('id'));

    if (selected == "allow") {
      //code
      console.log("show me");
      $("#filegroupperm_"+id).show();
      
    }
    
    if (selected == "deny" || selected == "none") {
      // code
      console.log("hide me");
      $("#filegroupperm_"+id).hide()
    }
    
  });
  
  $("button.commit").click(function(){
    
    var id = getId($(this).attr('id'));
    
    var selected = $('#allowdeny_' +id).find('option:selected').val();
    
    if (selected == "allow") {
      // Need to determine if a group is selected or the form is filled out
      var group_id = $("#select_"+id).find('option:selected').val();
      
      var newgroup = $("#newgroup_"+id).val()
      var url = ""

      // Use newgroup if it is filled in
      if (newgroup.length==0 && group_id=="none") {
        
        sendAlert(id,"Please select a group or fill in the text field with a new group.")
        console.log(newgroup);
        return;
      }
      
      // Use newgroup if it is filled in
      if (newgroup.length>0 && (group_id === undefined ||group_id=="none")) {
        
        
        console.log(newgroup);
        url = "/portal/request/verifyapprove?request_id=" + request_id + "&file_id="+ id+"&user_id=" + user_id +"&group="+newgroup;

      }
      
      if (newgroup.length==0 && group_id!="none") {
        url = "/portal/request/verifyapprove?request_id=" + request_id + "&file_id="+ id+"&user_id=" + user_id +"&group="+group_id;
        
        console.log(group_id)
      }
      
      
      
      $.get(url, function(data, status){
        console.log("Status: " + data.status + "\nStatus: " + status);
        if (status == "success") {
          $('#form-group_'+id).remove();
        }
        else{
          sendAlert(id,"Problem submitting request.")
        }
        
      });

    }
    
    if (selected == "deny") {
      // Do the AJAX call
      
      var url = "/portal/request/verifydeny?request_id=" + request_id + "&file_id="+ id;
      
      $.get(url, function(data, status){
        console.log("Status: " + data.status + "\nStatus: " + status);
        if (status == "success") {
          $('#form-group_'+id).remove();
        }
        else{
          sendAlert(id,"Problem submitting request.")
        }
        
      });
      
      
    }
    
    if (selected == "none") {
      sendAlert(id,"Please select Allow or Deny.")
    }
    
    //console.log("commit " + selected + " " + id);
    
  });
  
});

function sendAlert(id,message){
  $('#alert_' + id).html('<span class="glyphicon glyphicon-alert"  aria-hidden="true"></span><span class="message">' + message + '</message>');
  
}



function getId(val) {
  var res = val.split("_")
  return res[1];
  
  //code
}