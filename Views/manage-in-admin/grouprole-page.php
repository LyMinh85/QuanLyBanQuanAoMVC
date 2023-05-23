<div class="container" style="text-align:center;">
    <?php   if($groles !=null): ?>
        <h3> Sửa Group roles</h3>
    <?php else: ?>
        <h3>Thêm Group Role</h3>
    <?php endif; ?>
</div>
<div class="mb-3">
  <label for="" class="form-label">Name</label>
  <input type="text"
    class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
        value="<?php echo $retVal = ($groles != null) ? $groles->name_group_role : ""?>">
</div>

<?php $open = 0;$end=3; ?>
<div class="container">
    <?php foreach ($roles as  $value):?>

        <?php if($open == 0):?>
            <div class="row">
        <?php endif; ?>

        <?php if($open == $end):?>
            </div>
            <div class="row">
            <?php $end+=3 ?>
        <?php endif; ?>

        <div class="col">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?php echo $value->id_role ?>" id="" <?php echo $retVal = (in_array($value->id_role,$rolesInGroup)) ? "Checked" : ""?>>
              <label class="form-check-label" for="">
                <?php echo $value->name_role ?>
              </label>
            </div>
        </div>

        <?php $open+=1 ?>

    <?php endforeach; ?>
</div>

<div class="row" style="text-align:center;">
    <?php if($groles != null): ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Update">Update</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Add">Add</button>
        </form>
    <?php endif; ?>

</div>

<script>
    var arr_checkval = [];

    function checkError(){
        if($("#name").val() == "") return "name + Please enter the name of role!";
        if(arr_checkval.length == 0) return "none + Please check the role!";
        return null;
    }

    $(document).ready(function(){
        $("#Add").click(function(e){
                e.preventDefault();

                try {
                arr_checkval=[];
                $(":checked").each(function(){
                    var ischecked = $(this).is(":checked");
                    if (ischecked) {
                        arr_checkval.push($(this).val());
                    }
                })      

                var check =checkError()
                if(check != null) throw check;  
            
                var mode = "GroupRole";
                var name = $("#name").val();

                formData = new FormData();
                formData.append('name',name);
                formData.append('mode',mode);
                formData.append('arr',arr_checkval);

                $.ajax({
                    url:"<?php echo Config::getUrl("/administrator/action/add")?>",
                    type: 'post',
                    data:formData,
                    processData:false,
                    contentType:false,
                    success: function(result){
                        if (result.split("+")[0].trim() == "false") {
                            $("#"+result.split("+")[1].trim()).focus();
                            alert(result.split("+")[2].trim());
                        } else {
                            console.log(result);

                            $.ajax({
                                alert("Success");
                                url:"<?php echo Config::getUrl("/administrator/manage-grouprole")?>",
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

        $("#Update").click(function(e){
                e.preventDefault();

                try {
                arr_checkval=[];
                $(":checked").each(function(){
                    var ischecked = $(this).is(":checked");
                    if (ischecked) {
                        arr_checkval.push($(this).val());
                    }
                })      

                var check =checkError()
                if(check != null) throw check;  
            
                var mode = "GroupRole";
                var name = $("#name").val();
                var id = "<?php if($groles != null) echo $groles->id_group_roles ?>";

                formData = new FormData();
                formData.append('name',name);
                formData.append('mode',mode);
                formData.append('arr',arr_checkval);
                formData.append('id',id);

                $.ajax({
                    url:"<?php echo Config::getUrl("/administrator/action/update")?>",
                    type: 'post',
                    data:formData,
                    processData:false,
                    contentType:false,
                    success: function(result){
                        if (result.split("+")[0].trim() == "false") {
                            $("#"+result.split("+")[1].trim()).focus();
                            alert(result.split("+")[2].trim());
                        } else {
                            alert("Update success");
                            $.ajax({
                                url:"<?php echo Config::getUrl("/administrator/manage-grouprole")?>",
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
