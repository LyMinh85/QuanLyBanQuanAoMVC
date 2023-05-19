<section class="h-100 vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <form action="<?php echo Config::getUrl('/login') ?>" method="post" class="row g-0">
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <img style="width: 100%; height: 100%; object-fit: cover;"
                                 src="<?php echo Config::getUrl('/resources/images/gradient-background-1280x720-10974.jpg') ?>"/>
                        </div>

                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <h4 class="mt-1 mb-5 pb-1">Login</h4>
                                </div>

                                <form>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Tên đăng nhập</label>
                                        <input type="text" name="username" id="form2Example11" class="form-control"
                                               placeholder="Enter username"/>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Mật khẩu</label>
                                        <input type="password" name="password" id="form2Example22" class="form-control"/>
                                    </div>

                                    <?php if (isset($error)): ?>
                                    <div class="d-flex">
                                        <p class="text-danger"><?php echo '*' . $error ?></p>
                                    </div>
                                    <?php endif; ?>

                                    <div class="d-flex flex-column text-center pt-1 mb-5 pb-1">
                                        <div>
                                            <button class="btn btn-primary w-25 fa-lg mb-3" type="submit">
                                                Login
                                            </button>
                                        </div>
                                        <a class="text-muted" href="#!">Forgot password?</a>
                                    </div>


                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Don't have an account?</p>
                                        <a href="<?php echo Config::getUrl('/sign-up') ?>"
                                           class="btn btn-outline-primary">
                                            Create new
                                        </a>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>




