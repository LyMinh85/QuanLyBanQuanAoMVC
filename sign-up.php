<section class="h-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <!-- Form -->
                    <form action="<?php echo Config::getUrl('/sign-up') ?>" method="post" class="row g-0">
                        <div class="text-center">
                            <h4 class="mt-3 mb-3 pb-1">Đăng ký</h4>
                        </div>

                        <div class="col-lg-6 border-end">
                            <div class="card-body mx-md-4">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example11">Tên đăng nhập</label>
                                    <input required
                                           value="<?php if(isset($username)) echo $username ?>"
                                           type="text" name="username" class="form-control" placeholder="Enter username"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Mật khẩu</label>
                                    <input required
                                           value="<?php if(isset($password)) echo $password ?>"
                                           type="password" name="password" class="form-control"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Nhập lại mật khẩu</label>
                                    <input required
                                           value="<?php if(isset($re_password)) echo $re_password ?>"
                                           type="password" name="re-password" class="form-control"/>
                                    <?php if (isset($incorrectPass)): ?>
                                        <div class="d-flex">
                                            <p class="text-danger"><?php echo '*' . $incorrectPass ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Email</label>
                                    <input
                                        value="<?php if(isset($email)) echo $email ?>"
                                        required name="email" class="form-control"/>
                                    <?php if (isset($incorrectEmail)): ?>
                                        <div class="d-flex">
                                            <p class="text-danger"><?php echo '*' . $incorrectEmail ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Full name</label>
                                    <input
                                        value="<?php if(isset($name)) echo $name ?>"
                                        required type="text" name="name" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card-body mx-md-4">

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Số điện thoại</label>
                                    <input
                                        value="<?php if(isset($phone)) echo $phone ?>"
                                        required name="phone" class="form-control"/>
                                    <?php if (isset($incorrectPhone)): ?>
                                        <div class="d-flex">
                                            <p class="text-danger"><?php echo '*' . $incorrectPhone ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Ngày sinh</label >
                                    <input
                                        value="<?php if(isset($input_birthday)) echo $input_birthday?>"
                                        required type="date" name="birthday" class="form-control"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Giới tính</label>
                                    <select required name="gender" class="form-select" aria-label="Default select example">
                                        <option selected value="male">Nam</option>
                                        <option value="female">Nữ</option>
                                    </select>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Địa chỉ</label>
                                    <textarea required name="address" rows="5" class="form-control"></textarea>
                                </div>


                            </div>
                        </div>

                        <div class="d-flex flex-column text-center pt-5 pb-1">
                            <div>
                                <button class="btn btn-primary fa-lg mb-3" type="submit">
                                    Đăng ký
                                </button>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center pb-4">
                            <p class="mb-0 me-2">Đã có tài khoản?</p>
                            <a href="<?php echo Config::getUrl('/login')  ?>"
                               class="btn btn-outline-primary">Đăng nhập
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>





