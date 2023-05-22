<div class="container" style="text-align:center;">
    <h5>Manage Category</h5>
</div>

<table class="table table-hover" id="displayTable">
    <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $category):?>       
          <tr>
          <td><?php  echo $category->id ?></td>
          <td><?php echo $category->name ?></td>
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
        url:"administrator/manage-category/category-page?id=-1",
        success: function(result){
          $("#content").html(result);
        }
      })
    })
    $("#displayTable").on('click',".buttonEdit",function(){
      var currentRow = $(this).closest("tr");
      var id=currentRow.find("td:eq(0)").text(); 
      $.ajax({
        url:"administrator/manage-category/category-page?id="+id,
        success:function(result){
          $("#content").html(result);
        }
      })
    })
})
</script>