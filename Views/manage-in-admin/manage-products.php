<div class="container" style="text-align:center;">
    <h5>Manage Production</h5>
</div>

<table class="table table-hover" id="displayTable">
    <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Price</th>
          <th scope="col">Material</th>
          <th scope="col">Gender</th>
          <th scope="col">Made_by</th>
          <th scope="col">Status</th>
          <th scope="col">Category</th>
          <th scope="col">Type</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product):?>       
          <tr>
          <td><?php echo $product->id ?></td>
          <td><?php echo $product->name ?></td>
          <td><?php echo $product->price ?></td>
          <td><?php echo $product->material?></td>
          <td><?php echo $product->typeProduct->gender->name ?></td>
          <td><?php echo $product->madeBy ?></td>
          <td><?php echo $product->status->name ?></td>
          <td><?php echo $product->typeProduct->name ?></td>
          <td><?php echo $product->typeProduct->category->name ?></td>
          <td><button type="button" class="btn btn-warning buttonEdit">Edit</button>
          </td>
          <tr>

        <?php endforeach;?>
      </tbody>
</table>

<div class="container" style="text-align:center;" method="post">
  <button id="Add" class="btn btn-outline-primary" value="AddProduct" name="function">Add</button> 
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
</script>

</script>

<script>
  $(document).ready(function(){
    $("#Add").click(function(){
      $.ajax({
        url:"<?php echo Config::getUrl("/administrator/manage-products/product-page?id=-1")?>",
        success: function(result){
          $("#content").html(result);
        }
      })
    })

    $("#displayTable").on('click',".buttonDelete",function(){
      var currentRow = $(this).closest("tr");
      var id=currentRow.find("td:eq(0)").text(); 
      // alert(id);
    })

    $("#displayTable").on('click',".buttonEdit",function(){
      var currentRow = $(this).closest("tr");
      var id=currentRow.find("td:eq(0)").text(); 
      
      var url = "<?php echo Config::getUrl("/administrator/manage-products/product-page?id=")?>";
      url += id;

      $.ajax({
        url:url,
        success:function(result){
          $("#content").html(result);
        }
      })
    })
  })
</script>