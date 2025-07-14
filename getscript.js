
  $(document).ready(function() {
  $("#comp").change(function() {
    var comp = $(this).val();
    if(comp != "") {
      $.ajax({
        url:"../get-comp.php",
        data:{c_id:comp},
        method:'POST',
        success:function(data) {
          var resp = $.trim(data);
          $("#pn").html(resp);
        }
      });
    } else {
      $.ajax({
        url:"../get-comp1.php",
        data:{c_id:comp},
        method:'POST',
        success:function(data) {
          var resp = $.trim(data);
          $("#pn").html(resp);
        }
      });
    }
  });
});