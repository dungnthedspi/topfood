<div class="signup">
    <div class="signup-body">
        <a class="signup-brand" href="<?php echo site_url() ?>">
            <img class="img-responsive" src="<?php echo site_url("assets/themes/default/images/restaurant-icon.png") ?>"
                 alt="Foody">
        </a><br>
        <div class="signup-form">
					<?php if ($this->session->flashdata('serror') != '') : ?>
              <div class="alert alert-danger alert-dismissable fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Lỗi! </strong> <?php echo $this->session->flashdata('serror'); ?>
              </div>
					<?php endif; ?>
            <form data-toggle="validator" action="<?php echo site_url("auth/signup") ?>" method="post">
                <div class="row gutter-xs">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="first-name">Tên</label>
                            <input id="first-name" class="form-control" type="text" name="first_name" spellcheck="false"
                                   data-msg-required="Vui lòng nhập tên." required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="last-name">Họ</label>
                            <input id="last-name" class="form-control" type="text" name="last_name" spellcheck="false">
                        </div>
                    </div>
                </div>
                <div class="row gutter-xs">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" class="form-control" type="email" name="email" spellcheck="false"
                                   autocomplete="off" data-msg-required="Vui lòng nhập email." required>
                        </div>
                    </div>
                </div>
                <div class="row gutter-xs">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập</label>
                            <input id="username" class="form-control" type="text" name="username" spellcheck="false"
                                   autocomplete="off" data-msg-required="Vui lòng nhập tên đăng nhập." required>
                        </div>
                    </div>
                </div>
                <div class="row gutter-xs">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input id="password" class="form-control" type="password" name="password" minlength="6"
                                   data-msg-minlength="Mật khẩu phải có ít nhất 6 ký tự."
                                   data-msg-required="Vui lòng nhập mật khẩu." required>
                            <small class="help-block">Ít nhất 6 ký tự.</small>
                        </div>
                    </div>
                </div>
                <div class="row gutter-xs">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="account_type">Loại tài khoản</label>
                            <select id="account_type" class="custom-select" name="role"
                                    data-msg-required="Please indicate your gender." required>
                                <option value="3" selected="selected">Khách hàng</option>
                                <option value="2">Nhà hàng</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Đăng ký</button>
            </form>
        </div>
    </div>
    <div class="signup-footer">
        Bạn đã có tài khoản? <a href="<?php echo site_url("auth") ?>">Đăng nhập tại đây</a>
    </div>
</div>
