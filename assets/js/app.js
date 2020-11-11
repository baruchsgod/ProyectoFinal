$(document).ready(function(){
  $("#submit_post_button").click(function(err){

    $.ajax({
      type:"POST",
      url:"includes/handlers/submitPostForm.php",
      data:$("form.profile_post").serialize(),
      success: function(msg){
        $("$myModal").modal('hide');
        location.reload();
      },
      error:function(){
        alert('Failure ');
      }
    })
  })
})
