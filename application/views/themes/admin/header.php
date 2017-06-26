<?php
$log_in_data = $this->session->userdata("LogInData");
?>
<div class="layout-header">
    <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand navbar-brand-center" href="<?php echo site_url() ?>">
                <img class="navbar-brand-logo"
                     src="<?php echo site_url("assets/themes/default/images/restaurant-icon.png") ?>" alt="Topfood">
            </a>
            <button class="navbar-toggler visible-xs-block collapsed" type="button" data-toggle="collapse"
                    data-target="#sidenav">
                <span class="sr-only">Toggle navigation</span>
                <span class="bars">
              <span class="bar-line bar-line-1 out"></span>
              <span class="bar-line bar-line-2 out"></span>
              <span class="bar-line bar-line-3 out"></span>
            </span>
                <span class="bars bars-x">
              <span class="bar-line bar-line-4"></span>
              <span class="bar-line bar-line-5"></span>
            </span>
            </button>
            <button class="navbar-toggler visible-xs-block collapsed" type="button" data-toggle="collapse"
                    data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="arrow-up"></span>
                <span class="ellipsis ellipsis-vertical">
              <img class="ellipsis-object" width="32" height="32"
                   src="<?php echo site_url(($log_in_data->avatar) ? $log_in_data->avatar : DEFAULT_AVATAR) ?>"
                   alt="<?php echo $log_in_data->first_name ?>">
            </span>
            </button>
        </div>
        <div class="navbar-toggleable">
            <nav id="navbar" class="navbar-collapse collapse">
                <button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" aria-expanded="true"
                        type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="bars">
                <span class="bar-line bar-line-1 out"></span>
                <span class="bar-line bar-line-2 out"></span>
                <span class="bar-line bar-line-3 out"></span>
                <span class="bar-line bar-line-4 in"></span>
                <span class="bar-line bar-line-5 in"></span>
                <span class="bar-line bar-line-6 in"></span>
              </span>
                </button>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo site_url() ?>">Trang chủ</a></li>
                    <li class="visible-xs-block">
                        <h4 class="navbar-text text-center">Xin chào, <?php echo $log_in_data->first_name ?>!</h4>
                    </li>
                    <li class="dropdown hidden-xs">
                        <button class="navbar-account-btn" data-toggle="dropdown" aria-haspopup="true">
                            <img class="rounded" width="36" height="36"
                                 src="<?php echo site_url(($log_in_data->avatar) ? $log_in_data->avatar : DEFAULT_AVATAR) ?>"
                                 alt="<?php echo $log_in_data->first_name ?>"> <?php echo $log_in_data->first_name; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">

                            <li><a href="<?php echo site_url("admin/member/detail/" . $log_in_data->id) ?>">Thông tin
                                    tài khoản</a></li>
                            <li><a href="<?php echo site_url("auth/logout") ?>">Đăng xuất</a></li>
                        </ul>
                    </li>
                    <li class="visible-xs-block">
                        <a href="<?php echo site_url("admin/member/detail/" . $log_in_data->id) ?>">
                            <span class="icon icon-user icon-lg icon-fw"></span>
                            Thông tin tài khoản
                        </a>
                    </li>
                    <li class="visible-xs-block">
                        <a href="<?php echo site_url("auth/logout") ?>">
                            <span class="icon icon-power-off icon-lg icon-fw"></span>
                            Đăng xuất
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>