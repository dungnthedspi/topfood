<div class="layout-sidebar">
    <div class="layout-sidebar-backdrop"></div>
    <div class="layout-sidebar-body">
        <div class="custom-scrollbar">
            <nav id="sidenav" class="sidenav-collapse collapse">
                <ul class="sidenav">
                    <li id="admin-action" class="sidenav-item has-subnav active open">
                        <a href="<?php echo site_url("admin") ?>" aria-haspopup="true">
                            <span class="sidenav-icon icon icon-home"></span>
                            <span class="sidenav-label">Tổng Quan</span>
                        </a>
                        <ul class="sidenav-subnav collapse">
                            <li class="sidenav-subheading"><a href="<?php echo site_url("admin") ?>">Tổng Quan</a></li>
													<?php
													$log_in_data = $this->session->userdata("LogInData");
													$uri = '';
													$uri = trim($this->uri->uri_string(3));
													if ($log_in_data->role == 1):?>
                              <li class="<?php echo ($uri == 'admin') ? 'active' : '' ?>"><a
                                          href="<?php echo site_url("admin") ?>">Danh sách thành viên</a></li>
                              <li class="<?php echo ($uri == 'admin/member/admin') ? 'active' : '' ?>"><a
                                          href="<?php echo site_url("admin/member/admin") ?>">Quản trị viên</a></li>
                              <li class="<?php echo ($uri == 'admin/member/restaurant') ? 'active' : '' ?>"><a
                                          href="<?php echo site_url("admin/member/restaurant") ?>">Tài khoản nhà
                                      hàng</a></li>
                              <li class="<?php echo ($uri == 'admin/member/customer') ? 'active' : '' ?>"><a
                                          href="<?php echo site_url("admin/member/customer") ?>">Tài khoản khách
                                      hàng</a></li>
													<?php endif; ?>
													<?php if ($log_in_data->role == 2): ?>
                              <li class="<?php echo ($uri == 'admin/bill') ? 'active' : '' ?>"><a
                                          href="<?php echo site_url("admin/bill") ?>">Quản lí đơn hàng</a></li>
                              <li class="<?php echo ($uri == 'admin/menu') ? 'active' : '' ?>"><a
                                          href="<?php echo site_url("admin/menu") ?>">Quản lí thực đơn</a></li>
                              <li class="<?php echo ($uri == 'admin/article') ? 'active' : '' ?>"><a
                                          href="<?php echo site_url("admin/article") ?>">Quản lí bình luận</a></li>
													<?php endif; ?>
													<?php if ($log_in_data->role >= 3): ?>
                              <li class="<?php echo ($uri == 'admin/bill') ? 'active' : '' ?>"><a
                                          href="<?php echo site_url("admin/bill") ?>">Quản lí đơn hàng</a></li>
													<?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
