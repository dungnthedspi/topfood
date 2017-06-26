<?php defined('BASEPATH') OR exit('No direct script access allowed');
$login_data = $this->session->userdata("LogInData");
//debug($login_data);
?>
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
              action="<?php echo site_url('admin/member/update/' . $member->id) ?>" method="post"
              enctype="multipart/form-data">
            <div class="col-md-3 col-md-offset-1 col-xs-12">
                <div class="form-group avatar-wrap">
                    <label class="file-upload-btn btn btn-outline-primary">
                        <input id="avatar" type='file' name="avatar" onchange="readURL(this);" multiple="multiple"/>
											<?php echo image($member->avatar, array('id' => 'avatarPreview')) ?>
                    </label>
                </div>
            </div>
            <div class="col-md-7 col-xs-12">
                <div class="demo-form-wrapper">
                    <div class="form-group has-feedback">
                        <label for="first-name" class="control-label">Tên</label>
                        <input id="first-name" class="form-control" type="text" name="first_name"
                               value="<?php echo $member->first_name ?>" required>
                        <span class="form-control-feedback" aria-hidden="true">
                            <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="last-name" class="control-label">Họ</label>
                        <input id="last-name" class="form-control" type="text" name="last_name"
                               value="<?php echo $member->last_name ?>">
                        <span class="form-control-feedback" aria-hidden="true">
                            <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="email" class="control-label">Email</label>
                        <input id="email" class="form-control" type="email" name="email" autocomplete="off"
                               value="<?php echo $member->email ?>" required>
                        <span class="form-control-feedback" aria-hidden="true">
                          <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Tên đăng nhập</label>
                        <p class="form-control" readonly="readonly"><?php echo $member->username ?></p>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="password" class="control-label">
                            <input id="do_change_password" type="checkbox" name="do_change_password" value="1"/>Đổi
                            mật khẩu
                        </label>
                        <input id="password" class="form-control" type="password" name="password" autocomplete="off"
                               value="1111111111">
                        <span class="form-control-feedback" aria-hidden="true">
                          <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="phone" class="control-label">Số điện thoại</label>
                        <input id="phone" class="form-control" type="text" name="phone"
                               value="<?php echo $member->phone ?>">
                        <span class="form-control-feedback" aria-hidden="true">
                            <span class="icon"></span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Địa chỉ</label>
                        <textarea id="address" class="form-control" name="address"
                                  rows="3"><?php echo $member->address ?></textarea>
                    </div>
									<?php if ($login_data->role == 1): ?>
                      <div class="form-group custom-controls-stacked">
                          <label class="control-label">Phân quyền:</label>
                          <label class="custom-control custom-control-primary custom-radio">
                              <input class="custom-control-input" type="radio"
                                     name="role" <?php echo ($member->role == 1) ? 'checked="checked"' : '' ?> value="1"
                                     required>
                              <span class="custom-control-indicator"></span>
                              <small class="custom-control-label">Quản trị viên</small>
                          </label>
                          <label class="custom-control custom-control-primary custom-radio">
                              <input class="custom-control-input" type="radio" name="role"
                                     value="2" <?php echo ($member->role == 2) ? 'checked="checked"' : '' ?> required>
                              <span class="custom-control-indicator"></span>
                              <small class="custom-control-label">Nhà hàng</small>
                          </label>
                          <label class="custom-control custom-control-primary custom-radio">
                              <input class="custom-control-input" type="radio" name="role"
                                     value="3" <?php echo ($member->role == 3) ? 'checked="checked"' : '' ?> required>
                              <span class="custom-control-indicator"></span>
                              <small class="custom-control-label">Thành viên</small>
                          </label>
                      </div>
									<?php endif; ?>
                    <div class="form-group custom-controls-stacked">
                        <label class="control-label">Trang thái:</label>
                        <label class="switch switch-primary">

                            <input name="status"
                                   class="switch-input" <?php echo(($member->status == 1) ? 'checked="checked"' : "") ?>
                                   type="checkbox" value="1">
                            <span class="switch-track"></span>
                            <span class="switch-thumb"></span>
                        </label>
                    </div>
                    <br>
									<?php if ($member->role == 2): ?>
                      <fieldset>
                          <legend>Thông tin tài khoản nhà hàng</legend>
                          <div class="panel panel-body" data-toggle="match-height">
                              <div class="form-group">
                                  <label for="username" class="control-label">Tên nhà hàng</label>
                                  <input id="account_name" class="form-control" type="text" name="account_name"
                                         autocomplete="off"
                                         value="<?php echo $member->account_name ?>">
                              </div>
                              <div class="form-group">
                                  <label for="shipping_fee" class="control-label">Phí ship(x 1000đ/km) </label>
                                  <input id="shipping_fee" class="form-control" type="number" min="0"
                                         name="shipping_fee"
                                         value="<?php echo $member->shipping_fee ?>">
                              </div>
                              <div class="form-group">
                                  <label for="location" hidden="" class="control-label">Vị trí chính xác(Sử dụng cho Google
                                      Map) </label>
                                  <input id="location" class="form-control" type="hidden" name="location" required
                                         value="<?php echo $member->location ?>">
                              </div>
                              <div class="form-group">
                                  <label for="area" class="control-label">Khu vực</label>
                                  <select id="area" class="custom-select" name="area_id">
                                  <option value="<?php echo $member->area_id ?>"><?php echo $member->name ?></option>
                                  <?php foreach ($areas as $area) { ?>
                                    <option value="<?php echo $area->area_id ?>"><?php echo $area->name ?></option>
                                  <?php } ?>  
                                  </select>
                              </div>
                              <h5><b>Giờ làm việc</b></h5>
                              <p class="small text-muted">Chọn khoảng thời gian làm việc</p>
                              <div id="timerangepicker" class="row gutter-xs">
                                  <div class="col-xs-6">
                                      <div class="input-with-icon">
                                          <input name="open_time" class="form-control time start ui-timepicker-input"
                                                 placeholder="Giờ mở cửa" autocomplete="off" type="text"
                                                 value="<?php echo $member->open_time ?>">
                                          <span class="icon icon-clock-o input-icon"></span>
                                      </div>
                                  </div>
                                  <div class="col-xs-6">
                                      <div class="input-with-icon">
                                          <input name="close_time" class="form-control time end ui-timepicker-input"
                                                 placeholder="Giờ đóng cửa" autocomplete="off" type="text"
                                                 value="<?php echo $member->close_time ?>">
                                          <span class="icon icon-clock-o input-icon"></span>
                                      </div>
                                  </div>
                              </div>
                              <script>
                                  $(".time").timepicker({showDuration: !0, timeFormat: "H:i"});
                                  $("#timerangepicker").datepair();
                              </script>
                          </div>
                      </fieldset>
									<?php endif; ?>
                    <br>
                    <fieldset>
                        <legend>Thông tin tài khoản khách hàng</legend>
                        <div class="row gutter-xs">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Giới tính</label>
                                    <select id="gender" class="custom-select" name="gender">
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
                <button type="submit" value="1" class="btn btn-primary">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>
<script id="template-upload" type="text/x-tmpl">
      {% for (var i=0, file; file=o.files[i]; i++) { %}
      <li class="file template-upload fade">
        <div class="file-thumbnail">
          <div class="spinner spinner-default spinner-sm"></div>
        </div>
        <div class="file-info">
          <span class="file-ext">{%= file.ext %}</span>
          <span class="file-name">{%= file.name %}</span>
        </div>
      </li>
      {% } %}
    
</script>

<script id="template-download" type="text/x-tmpl">
      {% for (var i=0, file; file=o.files[i]; i++) { %}
      <li class="file template-download fade">
        <a class="file-link" href="http://demo.naksoid.com/elephant/flatistic-green-inverse-rounded/%7B%25=file.url%25%7D" title="{%=file.name%}" download="{%=file.name%}">
          {% if (file.thumbnailUrl) { %}
          <div class="file-thumbnail" style="background-image: url({%=file.thumbnailUrl%});"></div>
          {% } else { %}
          <div class="file-thumbnail {%=file.thumbnail%}"></div>
          {% } %}
          <div class="file-info">
          <span class="file-ext">{%=file.extension%}</span>
          <span class="file-name">{%=file.filename%}.</span>
          </div>
          </a>
        <button class="file-delete-btn delete" title="Delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" type="button">
          <span class="icon icon-remove"></span>
          </button>
      </li>
      {% } %}
    
</script>