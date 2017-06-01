<div class="container">
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">

            <form class="form form-horizontal" action="<?php echo site_url("/admin/menu/import") ?>" method="post"
                  enctype="multipart/form-data">
                <br>
                <h1 class="drive-uploader-heading">Vui lòng chọn file thực đơn</h1>
                <br>

							<?php if ($this->session->flashdata('serror') != '') : ?>
                  <div class="alert alert-danger alert-dismissable fade in">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>ERROR! </strong> <?php echo $this->session->flashdata('serror'); ?>
                  </div>
                  <br>
							<?php endif; ?>
                <label class="drive-uploader-btn btn btn-primary">
                    Click để chọn file
                    <input class="drive-uploader-input" type="file" name="file" accept=".xls,.xlsx, .csv">
                </label>
                <br>
                <!--                <div class="custom-controls-stacked m-t-md">-->
                <!--                    <label class="custom-control custom-control-primary custom-checkbox">-->
                <!--                        <input class="custom-control-input" type="checkbox" name="reset" value="1">-->
                <!--                        <span class="custom-control-indicator"></span>-->
                <!--                        <span class="custom-control-label">Xóa hết thực đơn cũ</span>-->
                <!--                    </label>-->
                <!--                </div>-->
                <br>
                <div class="text-left">
                    <button class="btn btn-success" type="submit">Nhập File</button>
                    <button class="btn btn-danger" type="reset"
                            onclick="redirectTo('<?php echo site_url("/admin/menu") ?>')">Quay Lại
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>