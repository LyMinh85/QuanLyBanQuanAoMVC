<div class="container row">
    <div class="col-3">
        <button id="manager-product-button">Manager product</button>
    </div>

    <div class="col-9">
        <div id="content">
            Hello
        </div>
    </div>
</div>


<script>
    const managerProductButton = document.querySelector('#manager-product-button');
    managerProductButton.addEventListener('click', async () => {
        const response = await fetch("<?php echo Config::getUrl('/administrator/manager-product')?>");
        const html = await response.text();
        document.querySelector('#content').innerHTML = html;
    })
</script>



