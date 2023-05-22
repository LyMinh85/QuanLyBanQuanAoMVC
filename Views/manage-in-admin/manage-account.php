<div class="container" style="text-align:center;">
    <h5>Manage Account</h5>
</div>

<table class="table table-hover" id="displayTable">
    <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">User</th>
          <th scope="col">Pass</th>
          <th scope="col">Email</th>
          <th scope="col">Gender</th>
          <th scope="col">Phone</th>
          <th scope="col">Address</th>
          <th scope="col">BirthDay</th>
          <th scope="col">GroupRole</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($accounts as $account):?>       
          <tr>
          <td><?php echo $account->id_account ?></td>
          <td><?php echo $account->name ?></td>
          <td><?php echo $account->username ?></td>
          <td><?php echo $account->password?></td>
          <td><?php echo $account->email ?></td>
          <td><?php echo $account->gender ?></td>
          <td><?php echo $account->phone ?></td>
          <td><?php echo $account->address ?></td>
          <td><?php echo $account->birthday->format('Y-m-d') ?></td>
          <td><?php echo $account->id_group_roles ?></td>
          <td><button type="button" class="btn btn-warning buttonEdit">Edit</button>
          </td>
          <tr>

        <?php endforeach;?>
      </tbody>
  
</table>
<div class="container" style="text-align:center;" method="post">
  <button id="Add" class="btn btn-outline-primary" value="AddAccount" name="function">Add</button> 
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
        </script>
<script>
  $(document).ready(function(){
    $("#Add").click(function(){
      $.ajax({
        url:"administrator/manage-account/account-page?id=-1",
        success: function(result){
          $("#content").html(result);
        }
      })
    })
    $("#displayTable").on('click',".buttonEdit",function(){
      var currentRow = $(this).closest("tr");
      var id=currentRow.find("td:eq(0)").text(); 
      $.ajax({
        url:"administrator/manage-account/account-page?id="+id,
        success:function(result){
          $("#content").html(result);
        }
      })
    })
})
</script>