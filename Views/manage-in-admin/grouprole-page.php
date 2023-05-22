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

<div class="row" style="text-align:center;">
    <?php if($groles != null): ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary">Update</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-primary" id="Add">Add</button>
        </form>
    <?php endif; ?>

</div>
