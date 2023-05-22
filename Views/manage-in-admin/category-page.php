<div class="container" style="text-align:center;">
    <h5>ADD Roles</h5>
</div>
<div class="mb-3">
  <label for="" class="form-label">Name</label>
  <input type="text"
    class="form-control" name="" id="name" aria-describedby="helpId" placeholder="" 
        value="<?php echo $retVal = ($categories != null) ? $categories->name : ""?>">
</div>

<div class="row" style="text-align:center;">
    <?php if($categories != null): ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Add">Add</button>
        </form>
    <?php endif; ?>

</div>  