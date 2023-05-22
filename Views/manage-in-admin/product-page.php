<div class="mb-3">
  <label for="" class="form-label">Name</label>
  <input type="text"
    class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
        value="<?php echo $retVal = ($products != null) ? $products->name : ""?>">

</div>

<div class="row">
    <div class="col">
        <div class="mb-3">
          <label for="" class="form-label">Price</label>
          <input type="number" class="" name="" id="price" aria-describedby="helpId" placeholder="Price"
            value="<?php echo $retVal = ($products != null) ? $products->price : ""?>">
        </div>
    </div>
    <div class="col">
        <div class="mb-3">
              <label for="" class="form-label">Material</label>
              <input type="text" class="" name="" id="material" aria-describedby="helpId" placeholder="Material"
                value="<?php echo $retVal = ($products != null) ? $products->material : ""?>">
        </div>
    </div>
    <div class="col">
        <div class="mb-3">
          <label for="" class="form-label">Made by</label>
          <input type="text" class="" name="" id="made_by" aria-describedby="helpId" placeholder="Made by"
            value="<?php echo $retVal = ($products != null) ? $products->madeBy : ""?>">
        </div>
    </div>
</div>

<div class="row justify-content-center align-items-center g-2">
    <div class="col">
        <div class="mb-3">
              <label for="" class="form-label">Gender</label>
              
                <select id="gender">
                    <option <?php if($products != null) echo $retVal = ($products->typeProduct->gender->value == "female") ? "selected" : ""?>>Female</option>
                    <option <?php if($products != null) echo $retVal = ($products->typeProduct->gender->value == "male") ? "selected" : ""?>>Male</option>
                    <option <?php if($products != null) echo $retVal = ($products->typeProduct->gender->value == "unisex") ? "selected" : ""?>>Unisex</option>
                </select>

        </div>
    </div>

    <div class="col">
        <div class="col">
            <div class="mb-3">
                  <label for="" class="form-label">Category</label>

                    <select id="category">
                        <?php foreach ($categories as $value):?>

                            <option <?php if($products != null) echo $retVal = ($products->typeProduct->category->name == $value->name) ? "Selected" : ""?>><?php echo $value->id." - ".$value->name?></option>

                        <?php endforeach;?>
                    </select>

            </div>
        </div>
    </div>

    <div class="col">

        <div class="col">
            <div class="mb-3">
                  <label for="" class="form-label">Type</label>

                    <select id="type">
                            
                        <?php foreach ($types as $value):?>
                        
                            <option <?php if($products != null) echo $retVal = ($products->typeProduct->name == $value->name) ? "Selected" : ""?>><?php echo $value->id." - ".$value->name ?></option>

                        <?php endforeach;?>

                    </select>

            </div>
        </div>

    </div>

    <div class="col">

        <div class="col">
            <div class="mb-3">
                  <label for="" class="form-label">Status</label>

                    <select id="status">

                        <option <?php if($products != null) echo $retVal = ($products->status->value == 1) ? "Selected" : ""?>>1 - IN_STOCK</option>
                        <option <?php if($products != null) echo $retVal = ($products->status->value == 2) ? "Selected" : ""?>>2 - OUT_OF_STOCK</option>
                        <option <?php if($products != null) echo $retVal = ($products->status->value == 3) ? "Selected" : ""?>>3 - DISCONTINUED</option>
                        <option <?php if($products != null) echo $retVal = ($products->status->value == 4) ? "Selected" : ""?>>4 - ON_SALE</option>
                        <option <?php if($products != null) echo $retVal = ($products->status->value == 5) ? "Selected" : ""?>>5 - NEW_ARRIVAL</option>

                    </select>

            </div>
        </div>

    </div>

</div>

<div class="row">
    <label for="form-label">Discreption</label>
    <textarea class="form-control" name="" id="description" cols="30" rows="10">
        <?php echo $retVal = ($products != null) ? $products->description : ""?>
    </textarea>
</div>

<div class = "row" id="table"></div>

<?php if($productVariants == null) $productVariants=[];?>

<script>
    class temptProductVariants{
        constructor(color,quantity,urlImage,size,quantityPurchased){
            this.color = color;
            this.quantity =quantity;
            this.urlImage= urlImage;
            this.size = size;
            this.quantityPurchased =quantityPurchased;
        }
    }   

</script>

<script>
    var arr = <?php echo json_encode($productVariants) ?>;

    function changeFile(index){
        var filename = $("#file"+index).val().replace(/^.*[\\\/]/, '');
        $("#lb"+index).html(filename);
    }

    function UpdateData(){
        var indexU = 0;
        arr = [];
        var check;
        while ($("#color"+indexU).length) {
            arr.push(new temptProductVariants($("#color"+indexU).val(),
                                              $("#quantity"+indexU).val(),
                                              $("#lb"+indexU).html(),
                                              $("#size"+indexU).val(),
                                              $("#quantityPurchased"+indexU).html()));
            indexU++;
        }
    }

    function Delete(index) {
        UpdateData();
        arr.splice(index,1);
        arr.splice(arr.length-1,1);
        console.log(arr);
        DrawTable(arr);
    }

    function AddNew(){
        UpdateData();
        DrawTable(arr);
    }

    function DrawTable(datas) {
        var html = "";
        html += '<table class="table" id="tableDetail">';
        html += '<thead>';
        html += '<tr>';
        html += '<th scope="col">#</th>';
        html += '<th scope="col">Color</th>';
        html += '<th scope="col">Size</th>';
        html += '<th scope="col">Quantity</th>';
        html += '<th scope="col">Quantity Purchased</th>';
        html += '<th scope="col">Image</th>';
        html += '<th scope="col">Action</th>';
        html += '</tr>';
        html += '</thead>';

        var length =datas.length;
        for (let index = 0; index <= length; index++) {
            if(index == length){
                html += '<tr>';
                html += '<td>'+index+'</td>'
                html += '<td><input id="color'+index+'" class="color"></td>';
                html += '<td><input id="size'+index+'" class="size"></td>';
                html += '<td><input id="quantity'+index+'" class="quantity"></td>';
                html += '<td id = "quantityPurchased'+index+'">0</td>';
                html += '<td>';
                html += '<label id="lb'+index+'">no-image</label><br>';
                html += '<input type="file" id="file'+index+'" onchange="changeFile('+index+')" style="width:100px;">';
                html += '</td>';
                html += '<td><id="btnAddNew" onclick="AddNew()" button class="btn btn-outline-success button">Add</button></td>';
                html += '</tr>';
                break;
            }

            html += '<tr>';
            html += '<td>'+index+'</td>'
            html += '<td><input id="color'+index+'" class="color" value="'+datas[index].color+'"></td>';
            html += '<td><input id="size'+index+'" class="size" value="'+datas[index].size+'"></td>';
            html += '<td><input id="quantity'+index+'" class="quantity" value="'+datas[index].quantity+'"></td>';
            html += '<td id = "quantityPurchased'+index+'">'+datas[index].quantityPurchased+'</td>'
            html += '<td>';
            html += '<label id="lb'+index+'">'+datas[index].urlImage+'</label><br>';
            html += '<input type="file" id="file'+index+'" onchange="changeFile('+index+')" style="width:100px;">';
            html += '</td>';
            html += '<td><button id="btnAdd" onclick="Delete('+index+')" class="btn btn-outline-danger button">Delete</button></td>';
            html += '</tr>';
        }
        html += '</table>'

        $("#table").html(html);
    }

    DrawTable(arr);
</script>

<div class="row" style="text-align:center;">
    <?php if($products != null): ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Add">Add</button>
        </form>
    <?php endif; ?>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
</script>

<script>
    function checkError(){
        if($("#name").val() == "") return "name + Please enter the name of product!";
        if($("#price").val() == "") throw "price + Please enter the price of product";
        if($("#material").val() == "") throw "material + Please enter the material of product!";
        if($("#made_by").val() == "") throw "made_by + Please fill up made by!";
        
        return null;
    }

    $(document).ready(function(){

        $("#Add").click(function(e){
            e.preventDefault();
            try {
            
            var check =checkError();
            // if(check != null) throw check;

            var mode = "Product";
            var name = $("#name").val();
            var material = $("#material").val();
            var made_by = $("#made_by").val();
            var price = $("#price").val();
            var gender = $("#gender").val();
            var category = $("#category").val().split("-")[0];
            var type = $("#type").val().split("-")[0];
            var status = $("#status").val().split("-")[0];
            var description = $("#description").val();

            

            var formData = new FormData();
            formData.append("mode",mode);
            formData.append("name",name);
            formData.append("material",material);
            formData.append("made_by",made_by);
            formData.append("price",price);
            formData.append("gender",gender);
            formData.append("category",category);
            formData.append("type",type);
            formData.append("status",status);
            formData.append("description",description);

            $.ajax({
                url:"administrator/manage-products/product-page/add",
                type: 'post',
                data:formData,
                processData:false,
                contentType:false,
                success: function(result){
                    if(result.split("+")[0].trim() == "false"){
                        $("#"+result.split("+")[1].trim()).focus();
                        alert(result.split("+")[2].trim());
                    }
                }
            })
            } catch (error) {
                idError = "#" + error.split("+")[0];
                messageError = error.split("+")[1];

                $(idError).focus();
                alert(messageError);
            }
        })

    })

</script>