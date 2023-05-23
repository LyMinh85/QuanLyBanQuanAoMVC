<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="<?php echo Config::getUrl('/') ?>">ClothingShop</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo Config::getUrl('/') ?>">Trang
                        chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#!">Bán chạy</a>
                </li>

            </ul>

            <form id="search-form" class="d-flex me-2" role="search">
                <div class="">
                    <div class="input-group">
                        <input
                            class="form-control border"
                            type="Search"
                            placeholder="Search"
                            id="search-input"
                        />
                        <div class="d-flex">
                            <button
                                class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5"
                                id="btn-search"
                                type="submit"
                            >
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="d-flex">


                <button class="btn btn-outline-dark mx-1">
                    <i class="bi-cart-fill me-1"></i>
                    Giỏ hàng
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </button>
                <?php if ($user != null): ?>
                    <!-- Khi đã đăng nhập hiện phần này -->
                    <button class="btn nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            id="navbarDropdown"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-person-circle me-1"></i>
                            <?php echo $user['username'] ?>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo Config::getUrl('/logout') ?>">Logout</a></li>

                            <?php if($user['id_group_role'] != 1000 ):?>
                                <li><a class="dropdown-item" href="<?php echo Config::getUrl('/administrator') ?>">Admin</a></li>
                            <?php endif;?>

                        </ul>

                    </button>
                <?php else: ?>
                    <!-- Khi chưa đăng nhập hiện phần này -->
                    <a href="<?php echo Config::getUrl('/login') ?>" class="btn btn-outline-primary mx-1"> Đăng
                        nhập </a>
                    <a href="<?php echo Config::getUrl('/sign-up') ?>" class="btn btn-primary mx-1"> Đăng ký </a>
                <?php endif; ?>


            </div>
        </div>
    </div>
</nav>
<!-- Header-->
<!--<header class="bg-dark py-5">-->
<!--    <div class="container px-4 px-lg-5 my-5">-->
<!--        <div class="text-center text-white">-->
<!--            <h1 class="display-4 fw-bolder">Shop in style</h1>-->
<!--        </div>-->
<!--    </div>-->
<!--</header>-->
<!-- Section-->
<section class="py-5" style="background-color: #eee">
    <div class="row">

        <div class="col-12 col-md-3 ps-md-5 mb-3">
            <div class="container px-4 px-lg-2 overflow-scroll" style="background-color: white; height: 800px;">
                <div class="d-flex flex-column justify-content-center">
                    <div class="list-group list-group-flush">
                        <h3 class="list-group-item">Phân loại</h3>
                        <div class="ms-3 mb-2">

                            <a
                                <?php if (isset($queries) && $queries == []): ?>
                                    class="btn btn-primary"
                                <?php else: ?>
                                    class="btn btn-outline-primary"
                                <?php endif; ?>
                                href="<?php echo Config::getUrl("/") ?>"
                            >
                                Tất cả
                            </a>
                        </div>

                        <?php if (isset($categories)): ?>
                            <?php foreach ($categories

                                           as $category): ?>
                                <div class="ms-3">
                                    <!--   category                                 -->
                                    <?php if (isset($queries['category'])): ?>
                                        <?php if ($queries['category'] == $category->id || isset($queries['type'])): ?>
                                            <a class="ms-2 btn btn-primary"
                                               href="<?php echo Config::getUrl("/&category=$category->id") ?>"
                                            >
                                                <?php echo $category->name ?>
                                            </a>
                                        <?php else: ?>
                                            <a class="ms-2 btn btn-primary-outline"
                                               href="<?php echo Config::getUrl("/&category=$category->id") ?>"
                                            >
                                                <?php echo $category->name ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a class="ms-2 btn btn-primary-outline"
                                           href="<?php echo Config::getUrl("/&category=$category->id") ?>"
                                        >
                                            <?php echo $category->name ?>
                                        </a>
                                    <?php endif; ?>

                                    <!--  types                          -->
                                    <?php foreach ($category->typeProducts as $typeProduct): ?>
                                        <?php $idTypeProduct = $typeProduct->id; ?>
                                        <div class="ms-3">
                                            <?php if (isset($queries['type'])): ?>
                                                <?php if ($queries['type'] == $idTypeProduct): ?>
                                                    <a class="ms-2 btn btn-secondary"
                                                       href="<?php echo Config::getUrl("/&type=$idTypeProduct") ?>"
                                                    >
                                                        <?php echo $typeProduct->name ?>
                                                    </a>
                                                <?php else: ?>
                                                    <a class="ms-2 btn btn-secondary-outline"
                                                       href="<?php echo Config::getUrl("/&type=$idTypeProduct") ?>"
                                                    >
                                                        <?php echo $typeProduct->name ?>
                                                    </a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <a class="ms-2 btn btn-secondary-outline"
                                                   href="<?php echo Config::getUrl("/&type=$idTypeProduct") ?>"
                                                >
                                                    <?php echo $typeProduct->name ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>


                    </div>
                </div>

                <div class="d-flex flex-column justify-content-center mt-3">
                    <form id="form-advantage-search" class="list-group list-group-flush">
                        <h3 class="list-group-item">Tìm kiếm nâng cao</h3>

                        <h5 class="ms-3 fs-5 fw-semibold">Tìm kiếm theo tên</h5>
                        <div class="d-flex ms-3 mb-2" role="search">
                            <div class="">
                                <div class="input-group">
                                    <input
                                        class="form-control border"
                                        type="Search"
                                        placeholder="Search"
                                        id="advantage-search-input"

                                        <?php if (isset($queries['name'])): ?>
                                            <?php if ($queries['name'] != ''): ?>
                                                value="<?php echo $queries['name'] ?>"
                                            <?php endif; ?>
                                        <?php endif; ?>


                                    />
                                </div>
                            </div>
                        </div>

                        <?php if (isset($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <p class="ms-3 fs-5 fw-semibold">
                                    <?php echo $category->name ?>
                                </p>
                                <?php foreach ($category->typeProducts as $typeProduct): ?>
                                    <?php $idTypeProduct = $typeProduct->id; ?>
                                    <div class="ms-3 form-check">
                                        <input
                                            name="type-product" value="<?php echo $idTypeProduct ?>"
                                            class="form-check-input" type="radio" id="flexRadioDefault1"
                                            <?php if (isset($queries['type'])): ?>
                                                <?php if ($queries['type'] == $idTypeProduct): ?>
                                                    checked
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        >
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            <?php echo $typeProduct->name ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>


                        <div class="text-center">
                            <button class="btn btn-primary w-50 mb-3" type="submit">
                                Tìm kiếm
                            </button>
                        </div>


                    </form>
                </div>

            </div>
        </div>

        <div class="col-12 col-md-9">
            <div class="px-4 px-lg-5 pt-5" style="background-color: white;">
                <div
                    class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center"
                >
                    <?php if (isset($products)) : ?>
                        <?php foreach ($products as $product) : ?>
                            <div class="col mb-5">
                                <div class="card h-100">
                                    <!-- Product image-->
                                    <img
                                        class="card-img-top"
                                        src="https://image.uniqlo.com/UQ/ST3/vn/imagesgoods/450524/item/vngoods_30_450524.jpg?width=750"
                                        alt="..."
                                    />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder"><?php echo $product->name ?> </h5>
                                            <!-- Product price-->
                                            <?php echo number_format($product->price, 0) . ' VND' ?>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center">
                                            <a class="btn btn-outline-dark mt-auto" href="#"
                                            >Add to cart</a
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>


                </div>

                <div class="d-flex w-100 justify-content-center">
                    <nav aria-label="Page navigation example">
                        <?php if (isset($pagination)): ?>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $pagination['numberOfPage']; $i++): ?>
                                    <?php
                                        $tempQuery = $queries;
                                        $tempQuery['page'] = $i;
                                    ?>
                                    <?php if ($i == $pagination['currentPage']): ?>
                                        <!-- Get url with query -->
                                        <li class="page-item active">
                                            <a class="page-link"
                                               href="<?php echo Config::getUrlWithQuery('/', $tempQuery) ?>">
                                                <?php echo $i ?>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo Config::getUrlWithQuery('/', $tempQuery) ?>">
                                                <?php echo $i ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </ul>
                        <?php endif; ?>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</section>


<script>
    searchInput = document.querySelector('#search-input');
    searchForm = document.querySelector('#search-form');
    searchForm.addEventListener('submit', (e) => {
        e.preventDefault()
        if (searchInput.value === '') {
            return;
        }
        window.location.href = '<?php echo Config::getUrl('/&name=')?>' + searchInput.value;
    });

    advantageSearchInput = document.querySelector('#advantage-search-input');
    advantageSearchForm = document.querySelector('#form-advantage-search');
    advantageSearchForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Count number of query
        count = 0;
        query = '/';

        if (advantageSearchInput.value !== '') {
            query += `&name=${advantageSearchInput.value}`;
        }

        typeProductRadioEle = document.querySelector("input[type='radio'][name='type-product']:checked");
        if (typeProductRadioEle !== null) {
            query += `&type=${typeProductRadioEle.value}`;
        }

        //console.log('<?php //echo Config::getUrl('/')?>//' + query);
        window.location.href = '<?php echo Config::getUrl('/')?>' + query;
    })

    fetch()
</script>