<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#avatarPreview')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<div class="text-center m-b">
    <h3 class="m-b-0"><?php echo $header_title ?></h3>
</div>
<div class="row gutter-xs edit-user">
    <div class="row">
			<?php if ($this->session->flashdata('serror') != '') : ?>
          <div class="alert alert-danger alert-dismissable fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>ERROR! </strong> <?php echo $this->session->flashdata('serror'); ?>
          </div>
			<?php endif; ?>

        <form data-toggle="validator" id="demo-uploader"
              action="<?php echo site_url('admin/member/insert/') ?>" method="post"
              enctype="multipart/form-data">
            <div class="col-md-3 col-md-offset-1 col-xs-12">
                <div class="form-group avatar-wrap">
                    <label class="file-upload-btn btn btn-outline-primary">
                        <input id="avatar" type='file' name="avatar" onchange="readURL(this);" multiple="multiple"/>
											<?php echo image('', array('id' => 'avatarPreview')) ?>
                    </label>
                </div>
            </div>
            <div class="col-md-7 col-xs-12">
                <div class="demo-form-wrapper">
                    <div class="form-group has-feedback">
                        <label for="first-name" class="control-label">Tên</label>
                        <input id="first-name" class="form-control" type="text" name="first_name" value=""
                               data-msg-required="Vui lòng nhập tên." required>
                        <span class="form-control-feedback" aria-hidden="true">
                            <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="last-name" class="control-label">Họ</label>
                        <input id="last-name" class="form-control" type="text" name="last_name" value="">
                        <span class="form-control-feedback" aria-hidden="true">
                            <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="email" class="control-label">Email</label>
                        <input id="email" class="form-control" type="email" name="email" autocomplete="off" value=""
                               data-msg-required="Vui lòng nhập email." required
                               data-msg-email="Tên email không hợp lệ.">
                        <span class="form-control-feedback" aria-hidden="true">
                          <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Tên đăng nhập</label>
                        <input id="username" class="form-control" type="text" name="username" autocomplete="off"
                               value="" data-msg-required="Vui lòng nhập tên đăng nhập." required>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="password" class="control-label">Mật khẩu</label>
                        <input id="password" class="form-control" type="password" name="password" autocomplete="off"
                               value="" minlength="6" data-msg-minlength="Mật khẩu phải có ít nhất 6 ký tự."
                               data-msg-required="Vui lòng nhập mật khẩu." required>
                        <span class="form-control-feedback" aria-hidden="true">
                          <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="phone" class="control-label">Số điện thoại</label>
                        <input id="phone" class="form-control" type="text" name="phone"
                               value="">
                        <span class="form-control-feedback" aria-hidden="true">
                            <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Địa chỉ</label>
                        <textarea id="address" class="form-control" name="address"
                                  rows="3"></textarea>
                    </div>
                    <div class="form-group custom-controls-stacked">
                        <label class="control-label">Phân quyền:</label>
                        <label class="custom-control custom-control-primary custom-radio">
                            <input class="custom-control-input" type="radio" name="role" value="1"
                                   data-msg-required="Vui lòng phân quyền cho tài khoản." required>
                            <span class="custom-control-indicator"></span>
                            <small class="custom-control-label">Quản trị viên</small>
                        </label>
                        <label class="custom-control custom-control-primary custom-radio">
                            <input class="custom-control-input" type="radio" name="role" value="2"
                                   data-msg-required="Vui lòng phân quyền cho tài khoản." required>
                            <span class="custom-control-indicator"></span>
                            <small class="custom-control-label">Nhà hàng</small>
                        </label>
                        <label class="custom-control custom-control-primary custom-radio">
                            <input class="custom-control-input" type="radio" name="role" value="3"
                                   data-msg-required="Vui lòng phân quyền cho tài khoản." required>
                            <span class="custom-control-indicator"></span>
                            <small class="custom-control-label">Thành viên</small>
                        </label>
                    </div>
                    <div class="form-group custom-controls-stacked">
                        <label class="control-label">Trang thái:</label>
                        <label class="switch switch-primary">

                            <input name="status" class="switch-input" checked="checked" type="checkbox" value="1">
                            <span class="switch-track"></span>
                            <span class="switch-thumb"></span>
                        </label>
                    </div>

                </div>
            </div>
            <div class="col-md-10 col-md-offset-1 col-xs-12 form-group form-actions">
                <button type="reset" class="btn btn-danger" onclick="goBack()">Quay Lại</button>
                <button type="submit" value="1" class="btn btn-primary">Thêm Mới</button>
            </div>
        </form>
    </div>
</div>
