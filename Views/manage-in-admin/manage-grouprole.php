<div class="container" style="text-align:center;">
    <h5>Manage Group-Roles</h5>
</div>

<table class="table table-hover" id="displayTable">
    <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($groles as $grole):?>       
          <tr>
          <td><?php  echo $grole->id_group_roles ?></td>
          <td><?php echo $grole->name_group_role ?></td>
          <td><button type="button" class="btn btn-warning buttonEdit">Edit</button>
          </td>
          <tr>
        <?php endforeach;?>
      </tbody>
</table>
<div class="container" style="text-align:center;" method="post">
  <button id="Add" class="btn btn-outline-primary" value="AddGroupRole" name="function">Add</button> 
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
        </script>
<script>
  $(document).ready(function(){
    $("#Add").click(function(){
      $.ajax({
        url:"administrator/manage-grouprole/grouprole-page?id=-1",
        success: function(result){
          $("#content").html(result);
        }
      })
    })
    $("#displayTable").on('click',".buttonEdit",function(){
      var currentRow = $(this).closest("tr");
      var id=currentRow.find("td:eq(0)").text(); 
      $.ajax({
        url:"administrator/manage-grouprole/grouprole-page?id="+id,
        success:function(result){
          $("#content").html(result);
        }
      })
    })
})
</script>