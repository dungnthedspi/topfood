<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$login_data = $this->session->userdata("LogInData");
?>
<div class="text-center m-b">
    <h3 class="m-b-0"><?php echo $header_title ?></h3>
</div>
<div class="row gutter-xs">
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
                        <th>Mã Đơn Hàng</th>
                        <th>Nhà Hàng</th>
                        <th>Khách Hàng</th>
                        <th>Tổng Đơn Giá</th>
                        <th>Ngày Tạo</th>
                        <th>Trạng thái</th>
                        <th id="admin-cog-action"></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Nhà Hàng</th>
                        <th>Khách Hàng</th>
                        <th>Tổng Đơn Giá</th>
                        <th>Ngày Tạo</th>
                        <th>Trạng thái</th>
                        <th align="center"></th>
                    </tr>
                    </tfoot>
                    <tbody>
										<?php foreach ($bills as $bill) { ?>
                        <tr valign="midle">
                            <td valign="midle">
                                <div class="avartar-wrap"><?php echo $bill->name ?></div>
                            </td>
                            <td valign="midle"><?php echo(($bill->account_name) ? $bill->account_name : $bill->account_base_name) ?></td>
                            <td valign="midle"><?php echo $bill->customer_name ?></td>
                            <td valign="midle"><?php echo $bill->total_price ?></td>
                            <td valign="midle"><?php echo $bill->date_created ?></td>
                            <td valign="midle"
                                align="center"><?php echo show_bill_status($bill->bill_id, $bill->status, $login_data->role) ?></td>
                            <td valign="midle" align="center">
                                <a class="member-cog" title="View"
                                   href="<?php echo site_url("admin/bill/detail/" . $bill->bill_id) ?>"><i
                                            class="fa fa-eye fa-2x" aria-hidden="true"></i></a>
                                <!--                                <a class="member-cog" title="Edit" href="-->
															<?php //echo site_url("admin/bill/edit/".$bill->bill_id)?><!--"><i class="fa fa-wrench fa-2x" aria-hidden="true"></i></a>-->
															<?php if ($login_data->role < 3): ?><a class="member-cog" title="Delete"
                                                                     href="<?php echo site_url("admin/bill/delete/" . $bill->bill_id) ?>"
                                                                     onclick="confirmDelete(event, this.href)"><i
                                              class="fa fa-trash fa-2x" aria-hidden="true"></i></a><?php endif; ?>
                            </td>
                        </tr>
										<?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



