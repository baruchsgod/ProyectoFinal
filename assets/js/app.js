$(document).ready(function(){
  $("#submit_post_button").click(function(err){

    $("$myModal").modal("hide");
    

    // $.ajax({
    //   type:"POST",
    //   url:"includes/handlers/submitPostForm.php",
    //   data:$("form.profile_post").serialize(),
    //   success: function(msg){
    //     $("$myModal").modal('hide');
    //     alert("pase x el ajax");
    //     location.reload();
    //   },
    //   error:function(){
    //     alert('Failure ');
    //   }
    // })

  })
})
