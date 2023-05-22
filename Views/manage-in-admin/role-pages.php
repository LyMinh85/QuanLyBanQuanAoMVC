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
        if($("#name").val() == "") return " Please enter the name of role!";
        return null;
    }

$(document).ready(function(){
  $("#Add").click(function(e){
    e.preventDefault;
   
    var check =checkError()
    // if(check !=null) {
    //   alert(check);
    // }
    var mode = "Role";
    var name = $("#name").val();
    
    $.ajax({
            url:"administrator/manage-roles/role-pages/add",
            type: 'post',
            success: function(result){
            $("#"+result.split("+")[1].trim()).focus();
            alert(result.split("+")[2].trim());
        }
    })
  })


})


</script>