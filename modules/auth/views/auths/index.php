<div class="login">
    <div class="login-body">
        <a class="login-brand" href="<?php echo site_url() ?>">
            <img class="img-responsive" src="<?php echo site_url("assets/themes/default/images/restaurant-icon.png") ?>"
                 alt="Topfood">
        </a>
			<?php if ($this->session->flashdata('smsg') != '') : ?>
          <div class="alert alert-success alert-dismissable fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Chúc mừng!</strong> <?php echo $this->session->flashdata('smsg'); ?>
          </div>
			<?php endif; ?>
			<?php if ($this->session->flashdata('serror') != '') : ?>
          <div class="alert alert-danger alert-dismissable fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Lỗi! </strong> <?php echo $this->session->flashdata('serror'); ?>
          </div>
			<?php endif; ?>
        <div class="login-form">
            <form action="auth/login" method="post" data-toggle="validator" enctype=="text/plain">
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input id="username" class="form-control" type="text" name="username" spellcheck="false"
                           autocomplete="off" data-msg-required="Vui lòng nhập tên đăng nhập." required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input id="password" class="form-control" type="password" name="password" minlength="6"
                           data-msg-minlength="Mật khẩu phải có ít nhất 6 ký tự."
                           data-msg-required="Vui lòng nhập mật khẩu." required>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Sign in</button>
            </form>
        </div>
    </div>
    <div class="login-footer">
        Bạn không có tài khoản? Vui lòng <a href="<?php echo site_url('auth/register') ?>">Đăng ký tài khoản</a>
    </div>
</div>
