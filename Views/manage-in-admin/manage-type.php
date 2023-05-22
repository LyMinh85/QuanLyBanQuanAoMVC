<div class="container" style="text-align:center;">
    <h5>Manage TypeProduct</h5>
</div>

<table class="table table-hover" id="displayTable">
    <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Gender</th>
          <th scope="col">Category</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($types as $type):?>       
          <tr>
          <td><?php  echo $type->id ?></td>
          <td><?php echo $type->name ?></td>
          <td><?php echo $type->gender->value ?></td>
          <td><?php echo $type->category->name ?></td>

          
          
          <td><button type="button" class="btn btn-warning buttonEdit">Edit</button>
          </td>
          <tr>
        <?php endforeach;?>
      </tbody>
</table>

<div class="container" style="text-align:center;" method="post">
  <button id="Add" class="btn btn-outline-primary" value="AddCategory" name="function">Add</button> 
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
        </script>
<script>
  $(document).ready(function(){
    $("#Add").click(function(){
      $.ajax({
        url:"administrator/manage-type/type-page?id=-1",
        success: function(result){
          $("#content").html(result);
        }
      })
    })
    $("#displayTable").on('click',".buttonEdit",function(){
      var currentRow = $(this).closest("tr");
      var id=currentRow.find("td:eq(0)").text(); 
      $.ajax({
        url:"administrator/manage-type/type-page?id="+id,
        success:function(result){
          $("#content").html(result);
        }
      })
    })
})