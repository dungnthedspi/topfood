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
                        <th>Người Đăng</th>
                        <th>Tiêu đề</th>
                        <th>Đánh Giá</th>
                        <th>Ngày Tạo</th>
                        <th id="admin-cog-action"></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Người Đăng</th>
                        <th>Tiêu đề</th>
                        <th>Đánh Giá</th>
                        <th>Ngày Tạo</th>
                        <th align="center"></th>
                    </tr>
                    </tfoot>
                    <tbody>
										<?php foreach ($articles as $article) { ?>
                        <tr valign="midle">
                            <td valign="midle"><?php echo $article->customer_name ?></td>
                            <td valign="midle"><?php echo $article->title ?></td>
                            <?php $avg_vote = number_format(($article->vote_price + $article->vote_service + $article->vote_quality + $article->vote_space + $article->vote_location) / 5, 1); ?>
                            <td valign="midle"><?php echo $avg_vote ?></td>
                            <td valign="midle"><?php echo $article->date_created ?></td>
                            <td valign="midle" align="center">
                                <a class="member-cog" title="View"
                                   href="<?php echo site_url("admin/article/detail/" . $article->article_id) ?>"><i
                                            class="fa fa-eye fa-2x" aria-hidden="true"></i></a>
                                <a class="member-cog" title="Delete"
                                                                     href="<?php echo site_url("admin/article/delete/" . $article->article_id) ?>"
                                                                     onclick="confirmDelete(event, this.href)"><i
                                              class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
                            </td>
                        </tr>
										<?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



