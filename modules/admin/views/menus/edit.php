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

    <form data-toggle="validator" id="menu-item-uploader"
          action="<?php echo site_url('admin/menu/update/' . $data->item_id) ?>" method="post"
          enctype="multipart/form-data">
      <div class="col-md-6 col-md-offset-1 col-xs-12">
        <div class="form-group item-photo-wrap">
          <label class="file-upload-btn btn btn-outline-primary">
            <input id="avatar" type='file' name="photo" onchange="readURL(this);" multiple="multiple"/>
						<?php echo product_image($data->photo, array('class' => 'item-preview', 'id' => 'avatarPreview')) ?>
          </label>
        </div>
      </div>
      <div class="col-md-4 col-xs-12">
        <div class="demo-form-wrapper">
          <div class="form-group">
            <label class="control-label">Mã sản phẩm</label>
            <p class="form-control" readonly="readonly"><?php echo $data->item_id ?></p>
          </div>
          <div class="form-group has-feedback">
            <label for="name" class="control-label">Tên</label>
            <input id="name" class="form-control" type="text" name="name" value="<?php echo $data->name ?>"
                   required>
            <span class="form-control-feedback" aria-hidden="true">
              <span class="icon"></span>
            </span>
          </div>
          <div class="form-group has-feedback">
            <label for="price" class="control-label">Giá</label>
            <input id="price" class="form-control" type="text" name="price" value="<?php echo $data->price ?>"
                   required>
            <span class="form-control-feedback" aria-hidden="true">
              <span class="icon"></span>
            </span>
          </div>
          <br>
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