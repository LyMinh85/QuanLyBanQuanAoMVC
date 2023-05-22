<div class="container" style="text-align:center;">
    <h5>ADD Roles</h5>
</div>
<div class="mb-3">
  <label for="" class="form-label">Name</label>
  <input type="text"
    class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
        value="<?php echo $retVal = ($roles != null) ? $roles->name_role : ""?>">
</div>

<div class="row" style="text-align:center;">
    <?php if($roles != null): ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Add">Add</button>
        </form>
    <?php endif; ?>

</div>
<script>
    function checkError(){
        if($("#name").val() == "") return "name + Please enter the name of role!";
        return null;
    }

$(document).ready(function(){
  $("#Add").click(function(e){
    e.preventDefault();
    
    
    try {
        var check =checkError()
        if(check != null) throw check;  
    
        var mode = "Role";
        var name = $("#name").val();
        
        $.ajax({
            url:"<?php echo Config::getUrl("/administrator/action/add")?>",
            type: 'post',
            data:{name:name,
                  mode:mode},
            success: function(result){
                if (result.split("+")[0].trim() == "false") {
                    $("#"+result.split("+")[1].trim()).focus();
                    alert(result.split("+")[2].trim());
                } else {
                    $.ajax({
                        url:"<?php echo Config::getUrl("/administrator/manage-roles")?>",
                        success: function(result){
                            $("#content").html(result);
                        }
                    })
                }
            }
        })
    } catch (error) {
        idError = "#" + error.split("+")[0];
        messageError = error.split("+")[1]
        $(idError).focus();
        alert(messageError);
    }

  })


})


</script>