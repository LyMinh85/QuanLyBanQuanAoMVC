<ul class="list-group">
  <?php foreach ($products as $product) : ?>
    <li class="list-group-item"><?php echo $product->name ?></li>
  <?php endforeach; ?>
</ul>


<form action="./?products/add" method="post">
  <div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">@</span>
    <input name="name" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
  </div>
  <button class="btn btn-primary" type="submit">Add</button>
</form>