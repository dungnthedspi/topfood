<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="text-center m-b">
  <h3 class="m-b-0"><?php echo $header_title ?></h3>
</div>
<div class="row gutter-xs menu-list">
  <div class="col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
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
      </div>
      <div class="panel-body panel-collapse">
        <table id="demo-datatables-2"
               class="table table-striped table-bordered table-nowrap dataTable dataTable-admin"
               cellspacing="0" width="100%">
          <thead>
          <tr>
            <th>Mã Sản Phẩm</th>
            <th>Nhà Hàng</th>
            <th>Tên Sản Phẩm</th>
            <th>Giá Thành</th>
            <th>Ngày Tạo</th>
            <th id="admin-cog-action"><a class="btn btn-outline-primary admin-add-btn"
                                         href="<?php echo site_url("admin/menu/upload") ?>"
                                         title="Nhập file thực đơn"><i class="fa fa-file-excel-o fa-2x"
                                                                         aria-hidden="true"></i></a></th>
          </tr>
          </thead>
          <tfoot>
          <tr>
            <th>Mã Sản Phẩm</th>
            <th>Nhà Hàng</th>
            <th>Tên Sản Phẩm</th>
            <th>Giá Thành</th>
            <th>Ngày Tạo</th>
            <th align="center"><a class="btn btn-outline-primary admin-add-btn"
                                  href="<?php echo site_url("admin/menu/upload") ?>"
                                  title="Nhập file thực đơn"><i class="fa fa-file-excel-o fa-2x"
                                                                  aria-hidden="true"></i></a></th>
          </tr>
          </tfoot>
          <tbody>
					<?php foreach ($items as $item) { ?>
            <tr valign="midle">
              <td valign="midle"><?php echo $item->item_id ?></td>
              <td valign="midle"><?php echo $item->account_name ?></td>
              <td valign="midle">
                <div class="avartar-wrap">
									<?php echo product_image($item->photo, array('class' => 'img-product', 'width' => '280')) ?>
                  <p><?php echo $item->name ?></p>
                </div>
              </td>
              <td valign="midle"><?php echo $item->price ?></td>
              <td valign="midle"><?php echo $item->date_created ?></td>
              <td valign="midle" align="center">
                <a class="member-cog" title="Delete"
                   href="<?php echo site_url("admin/menu/delete/" . $item->item_id) ?>"
                   onclick="confirmDelete(event, this.href)">
                  <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                </a>
                <a class="member-cog" title="Delete"
                   href="<?php echo site_url("admin/menu/edit/" . $item->item_id) ?>">
                  <i class="fa fa-wrench fa-2x" aria-hidden="true"></i>
                </a>
              </td>
            </tr>
					<?php } ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



