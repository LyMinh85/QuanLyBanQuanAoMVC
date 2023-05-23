<section class="h-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <!-- Form -->
                    <?php if($accounts == null): ?>
                        <form action="<?php echo Config::getUrl('/administrator/action/add') ?>" method="post" class="row g-0">
                    <?php else:?>
                        <form action="<?php echo Config::getUrl('/administrator/action/update') ?>" method="post" class="row g-0">
                    <?php endif; ?>
                        <input name="mode" value="Account" style="visibility: hidden;">
                        <input name="id" value="<?php echo $retVal = ($accounts!= null) ? $accounts->id_account : ""?>" style="visibility: hidden;">

                        <div class="col-lg-6 border-end">
                            <div class="card-body mx-md-4">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example11">Tên đăng nhập</label>
                                    <input required type="text" name="username" class="form-control" placeholder="Enter username"
                                    value="<?php echo $retVal = ($accounts != null) ? $accounts->username : ""?>"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Mật khẩu</label>
                                    <input required type="password" name="password" class="form-control"
                                    value="<?php echo $retVal = ($accounts != null) ? $accounts->password : ""?>"/>
                                </div>

                                <?php if($accounts == null): ?>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example22">Nhập lại mật khẩu</label>
                                        <input required type="password" name="re-enter-password" class="form-control"/>
                                    </div>
                                <?php endif; ?>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Email</label>
                                    <input required type="email" name="email" class="form-control"
                                    value="<?php echo $retVal = ($accounts != null) ? $accounts->email : ""?>"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Full name</label>
                                    <input required type="text" name="name" class="form-control"
                                    value="<?php echo $retVal = ($accounts != null) ? $accounts->name : ""?>"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Group roles</label>
                                    <select required name="groupRole" class="form-select" aria-label="Default select example">
                                        <?php foreach ($groupRoles as  $value):?>
                                            <option <?php if($accounts != null) echo $retVal = ($accounts->id_group_roles == $value->id_group_roles) ? "Selected" : ""?>><?php echo $value->id_group_roles."-".$value->name_group_role ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card-body mx-md-4">

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Số điện thoại</label>
                                    <input required type="number" name="phone" class="form-control"
                                    value="<?php echo $retVal = ($accounts != null) ? $accounts->phone : ""?>"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Ngày sinh</label>
                                    <input required type="date" name="birthday" class="form-control"
                                    value="<?php echo $retVal = ($accounts != null) ? $accounts->birthday->format("Y-m-d"): ""?>"
                                    <?php echo $retVal = ($accounts != null) ? "disabled": ""?>/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Giới tính</label>
                                    <select required name="gender" class="form-select" aria-label="Default select example">
                                        <option <?php if($accounts!=null) echo $retVal = ($accounts->gender == "male") ? "selected" : ""?> value="male">Nam</option>
                                        <option <?php if($accounts!=null) echo $retVal = ($accounts->gender == "female") ? "selected" : ""?>  value="female">Nữ</option>
                                    </select>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form2Example22">Địa chỉ</label>
                                    <textarea required name="address" rows="5" class="form-control"><?php echo $retVal = ($accounts != null) ? $accounts->address : "" ; ?></textarea>
                                </div>


                            </div>
                        </div>

                        <div class="d-flex flex-column text-center pt-5 pb-1">
                            <div>
                                <button class="btn btn-primary fa-lg mb-3" type="submit">
                                    <?php if($accounts == null): ?>
                                        Đăng ký
                                    <?php else: ?>
                                        Sửa
                                    <?php endif; ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>