<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
                        <th>User Name</th>
                        <th>Phân Quyền</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th>Ngày Tham Gia</th>
                        <th>Trạng thái</th>
                        <th id="admin-cog-action"><a class="btn btn-outline-primary admin-add-btn"
                                                     href="<?php echo site_url("admin/member/add") ?>"
                                                     title="Thêm thành viên"><i class="fa fa-user-plus fa-2x"
                                                                                 aria-hidden="true"></i></a></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>User Name</th>
                        <th>Phân Quyền</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th>Ngày Tham Gia</th>
                        <th>Trạng thái</th>
                        <th align="center"><a class="btn btn-outline-primary admin-add-btn"
                                              href="<?php echo site_url("admin/member/add") ?>"
                                              title="Thêm thành viên"><i class="fa fa-user-plus fa-2x"
                                                                          aria-hidden="true"></i></a></th>
                    </tr>
                    </tfoot>
                    <tbody>
										<?php foreach ($members as $member) { ?>
                        <tr valign="midle">
                            <td valign="midle">
                                <div class="avartar-wrap"><?php echo image($member->avatar, array('class' => 'avatar avatar-small', 'width' => '40', 'height' => '40')) ?><?php echo $member->username ?></div>
                            </td>
                            <td valign="midle"><?php echo show_role($member->role) ?></td>
                            <td valign="midle"><?php echo $member->first_name . " " . $member->last_name ?></td>
                            <td valign="midle"><?php echo $member->email ?></td>
                            <td valign="midle"><?php echo $member->date_created ?></td>
                            <td valign="midle" align="center"
                                class="td-staus"><?php echo $member->status ?><?php echo show_status($member->status) ?></td>
                            <td valign="midle" align="center">
                                <a class="member-cog" title="View"
                                   href="<?php echo site_url("admin/member/detail/" . $member->id) ?>"><i
                                            class="fa fa-eye fa-2x" aria-hidden="true"></i></a>
                                <a class="member-cog" title="Edit"
                                   href="<?php echo site_url("admin/member/edit/" . $member->id) ?>"><i
                                            class="fa fa-wrench fa-2x" aria-hidden="true"></i></a>
                                <a class="member-cog" title="Delete"
                                   href="<?php echo site_url("admin/member/delete/" . $member->id) ?>"
                                   onclick="confirmDelete(event, this.href)"><i class="fa fa-trash fa-2x"
                                                                                aria-hidden="true"></i></a>
                            </td>
                        </tr>
										<?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



