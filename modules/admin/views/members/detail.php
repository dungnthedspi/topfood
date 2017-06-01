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
<div class="row gutter-xs detail-user">
    <div class="row">
			<?php if ($this->session->flashdata('serror') != '') : ?>
          <div class="alert alert-danger alert-dismissable fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>ERROR! </strong> <?php echo $this->session->flashdata('serror'); ?>
          </div>
			<?php endif; ?>

        <form disabled="disabled" readonly="readonly">
            <div class="col-md-3 col-md-offset-1 col-xs-12">
                <div class="form-group avatar-wrap">
									<?php echo image($member->avatar, array('id' => 'avatarPreview')) ?>
                </div>
            </div>
            <div class="col-md-7 col-xs-12">
                <div class="demo-form-wrapper">
                    <div class="form-group">
                        <label for="first-name" class="control-label">Tên</label>
                        <p class="form-control"><?php echo $member->first_name ?></p>
                    </div>
                    <div class="form-group">
                        <label for="last-name" class="control-label">Họ</label>
                        <p class="form-control"><?php echo $member->last_name ?></p>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <p class="form-control"><?php echo $member->email ?></p>
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <p class="form-control"><?php echo $member->username ?></p>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Số điện thoại</label>
                        <p class="form-control"><?php echo $member->phone ?></p>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Địa chỉ</label>
                        <textarea id="address" class="form-control" name="address" rows="3"
                                  readonly="readonly"><?php echo $member->address ?></textarea>
                    </div>
                    <div class="form-group custom-controls-stacked">
                        <label class="control-label">Phân quyền:</label>
											<?php echo show_role($member->role) ?>
                    </div>
                    <div class="form-group custom-controls-stacked">
                        <label class="control-label">Trang thái:</label>
											<?php echo show_status($member->status) ?>
                    </div>

									<?php if ($member->role == 2): ?>
                      <fieldset>
                          <legend>Thông tin tài khoản nhà hàng:</legend>
                          <div class="panel panel-body" data-toggle="match-height">
                              <div class="form-group">
                                  <label for="username" class="control-label">Tên nhà hàng</label>
                                  <p class="form-control"><?php echo $member->account_name ?></p>
                              </div>
                              <div class="form-group">
                                  <label for="area" class="control-label">Khu Vực</label>
                                  <p class="form-control"><?php echo $member->name ?></p>
                              </div>
                              <div class="form-group">
                                  <label for="shipping_fee" class="control-label">Phí ship(x 1000đ/km) </label>
                                  <p class="form-control"><?php echo $member->shipping_fee ?></p>
                              </div>
                              <div class="form-group">
                                  <label for="location" class="control-label">Vị trí chính xác(Sử dụng cho Google
                                      Map) </label>
                                  <p class="form-control"><?php echo $member->location ?></p>
                              </div>
                              <div class="form-group">
                                  <label for="location" class="control-label">Giờ làm việc </label>

                                  <div id="timerangepicker" class="row gutter-xs">
                                      <div class="col-xs-6">
                                          <div class="input-with-icon">
                                              <p class="form-control ui-timepicker-input"><?php echo $member->open_time ?></p>
                                              <span class="icon icon-clock-o input-icon"></span>
                                          </div>
                                      </div>
                                      <div class="col-xs-6">
                                          <div class="input-with-icon">
                                              <p class="form-control ui-timepicker-input"><?php echo $member->close_time ?></p>
                                              <span class="icon icon-clock-o input-icon"></span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </fieldset>
									<?php endif; ?>
                    <br>
                    <!--                    --><?php //if($member->role == 3 ):?>
                    <fieldset>
                        <legend>Thông tin tài khoản khách hàng:</legend>
                        <div class="row gutter-xs">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Giới tính</label>
                                    <select id="gender" class="custom-select" name="gender" readonly="readonly"
                                            disabled="disabled">
                                        <option value="" disabled="disabled" selected="selected">Chọn...</option>
                                        <option value="1" <?php echo(($member->gender == 1) ? 'selected="selected"' : '') ?>>
                                            Nam
                                        </option>
                                        <option value="2" <?php echo(($member->gender == 2) ? 'selected="selected"' : '') ?>>
                                            Nữ
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1 col-xs-12 form-group form-actions">
                <button type="reset" class="btn btn-danger" onclick="goBack()">Quay Lại</button>
                <button type="button" class="btn btn-primary"
                        onclick="redirectTo('<?php echo(site_url("admin/member/edit/" . $member->id)) ?>')">Chỉnh Sửa
                </button>
            </div>
        </form>
    </div>
</div>
