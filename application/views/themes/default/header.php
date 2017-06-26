<?php
$log_in_data = $this->session->userdata("LogInData");
?>
<header>
    <nav class="navbar">
        <div class="container-fluid">
            <ul class="nav navbar-nav navbar-right">
                  <li><a href="<?php echo site_url() ?>">Trang chủ</a></li>
                  <li><a href="<?php echo site_url("home/map") ?>">Bản đồ</a></li>
							<?php if ($log_in_data): ?>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                         aria-expanded="false">
                          <img class="client-avatar"
                               src="<?php echo site_url((($log_in_data->avatar) ? $log_in_data->avatar : DEFAULT_AVATAR)) ?>"
                               alt="">
												<?php echo $log_in_data->first_name ?> <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu">
                          <li><a href="<?php echo site_url("admin/member/detail/" . $log_in_data->id) ?>">Thông tin tài
                                  khoản</a></li>
                          <li><a href="<?php echo site_url("auth/logout") ?>">Đăng xuất</a></li>
                      </ul>
                  </li>
							<?php else: ?>
                  <li><a href="<?php echo site_url("auth/") ?>">Đăng nhập</a></li>
                  <li><a href="<?php echo site_url("auth/register") ?>">Đăng ký</a></li>
							<?php endif; ?>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>
</header>