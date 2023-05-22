<div class="mb-3">
  <label for="" class="form-label">Name</label>
  <input type="text"
    class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
        value="<?php echo $retVal = ($type != null) ? $type->name : ""?>">
</div>
<div class="row justify-content-center align-items-center g-2">
    <div class="col">
        <div class="mb-3">
              <label for="" class="form-label">Gender</label>
              
                <select id="gender">
                    <option <?php if($type != null) echo $retVal = ($type->gender->value == "female") ? "selected" : ""?>>Female</option>
                    <option <?php if($type != null) echo $retVal = ($type->gender->value == "male") ? "selected" : ""?>>Male</option>
                    <option <?php if($type   != null) echo $retVal = ($type->gender->value == "unisex") ? "selected" : ""?>>Unisex</option>
                </select>

        </div>
    </div>
    <div class="col">
        <div class="col">
            <div class="mb-3">
                  <label for="" class="form-label">Category</label>

                    <select id="category">
                        <?php foreach ($categories as $value):?>

                            <option <?php if($type != null) echo $retVal = ($type->category->name == $value->name) ? "Selected" : ""?>><?php echo $value->id." - ".$value->name?></option>

                        <?php endforeach;?>
                    </select>

            </div>
        </div>
    </div>

<div class="row" style="text-align:center;">
    <?php if($type != null): ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Add">Add</button>
        </form>
    <?php endif; ?>

</div>