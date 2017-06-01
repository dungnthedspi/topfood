<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<article>
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
</article>
<article class="row">
  <div class="col-xs-6 account-image-wrap">
		<?php echo product_image($account->avatar, array('class' => 'account-image')) ?>
  </div>
  <div class="col-xs-6 account-meta">
    <span
        class="product-vote"><?php echo number_format(($account->vote_price + $account->vote_service + $account->vote_quality + $account->vote_space + $account->vote_location) / 5, 1); ?></span>
    <h3><?php echo $account->account_name ?></h3>
    <p><i class="fa fa-location-arrow" aria-hidden="true"></i><?php echo $account->address ?></p>
    <p><i class="fa fa-clock-o houricon"
          aria-hidden="true"></i><?php echo $account->open_time . " - " . $account->close_time ?></p>
    <p><i class="fa fa-phone" aria-hidden="true"></i><?php echo $account->phone ?></p>
    <p><i class="fa fa-envelope" aria-hidden="true"></i><?php echo $account->email ?></p>
    <p><i class="fa fa-comments" aria-hidden="true"></i><?php echo intval($account->num_comment) ?> bình luận</p>

  </div>
</article>
<h3 class="col-md-12 text-center">
  <a id="showMenuBtn" href="#menu" class="col-md-3 col-md-offset-3 switch-tab">Thực đơn(<?php echo count($menus) ?>)</a>
  <a id="showArticleBtn" href="#menu" class="col-md-3 switch-tab">Bình luận(<?php echo count($articles) ?>)</a>
  <br>
</h3>

<article class="row menu-wrap" id="menu">
  <section id="menu-list">
		<?php if (count($menus)): ?>
      <div class="col-md-12 row menu-box no-pad-right">
        <div class="col-md-8">
          <ul class="row menu-list">
						<?php foreach ($menus as $menu): ?>
              <li class="col-md-4 menu-item">
                <div class="menu-item-wrap">
                  <div class="menu-item-image">
										<?php echo product_image($menu->photo, array('class' => 'menu-image')) ?>
                  </div>
                  <div class="item-name"><?php echo $menu->name ?></div>
                  <strong class="item-price text-red"><?php echo number_format($menu->price) ?>&nbsp;<small>đ</small>
                  </strong>
                  <a href="<?php echo site_url("account/cart/add/" . $account->account_id . "/" . $menu->item_id) ?>"
                     class="menu-item-add-btn text-red"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a>
                </div>
              </li>
						<?php endforeach; ?>
          </ul>
        </div>
        <div class="col-md-4 no-pad-right">
          <div id="menu-book">
            <form action="" method="post">
              <fieldset>
                <legend>Thưc đơn tự chọn của bạn</legend>
								<?php
								$session_cart = $this->session->userdata("cart");
								$sub_sum = 0;
								$sum = 0;
								if (is_array($session_cart)):?>
									<?php foreach ($session_cart as $k => $v):
										$sub_sum += ($v['quantity'] * $v['price']);
										?>
                    <div class="booking-item">
                      <label class="booking-item-value">
                        <a class="book-action"
                           href="<?php echo site_url("account/cart/add/" . $account->account_id . "/" . $v['item_id']) ?>"><i
                              class="fa fa-plus-square-o" aria-hidden="true"></i></a>
												<?php echo $v['quantity'] ?>
                        <a class="book-action"
                           href="<?php echo site_url("account/cart/reduce/" . $account->account_id . "/" . $v['item_id']) ?>"><i
                              class="fa fa-minus-square-o" aria-hidden="true"></i></a>
                      </label>
                      <input type="hidden" class="booking-item-base-price" value="<?php echo $v['price'] ?>">
                      <label class="booking-item-name"><?php echo $v['name'] ?></label>
                      <a class="book-action booking-item-delete-btn right"
                         href="<?php echo site_url("account/cart/delete/" . $account->account_id . "/" . $v['item_id']) ?>"><i
                            class="fa fa-window-close-o" aria-hidden="true"></i></a>
                      <strong
                          class="booking-item-price right text-red"><?php echo number_format($v['quantity'] * $v['price']) ?></strong>
                    </div>
									<?php endforeach; ?>
								<?php endif; ?>
                <br>
                <p><label>Tổng: </label> <strong
                      class="booking-item-sum-price right text-red"><?php echo number_format($sub_sum) ?>
                    <small>đ</small>
                  </strong></p>
                <p><label>Phí vận chuyển: </label> <strong
                      class="booking-item-sum-price right"><?php echo number_format($account->shipping_fee * 1000) ?>
                    <small>đ</small>
                    /km</strong></p>
                <p class="text-red">
                  <label>Tạm tính: </label>
                  <strong class="booking-item-sum-price right text-red"><?php echo number_format($sub_sum) ?>
                    <small>đ</small>
                  </strong>
                </p>
              </fieldset>
							<?php if (is_array($session_cart)): ?>
                <div class="text-center">
                  <a href="<?php echo site_url("account/cart/checkout/" . $account->account_id) ?>"
                     class="btn btn-success"> Đặt món</a>
                  <a href="<?php echo site_url("account/cart/reset/" . $account->account_id) ?>"
                     class="btn btn-danger"> Đặt lại</a>
                </div>
							<?php endif; ?>
            </form>
          </div>

        </div>
      </div>
		<?php endif; ?>
  </section>

  <section id="articles" style="display: none">
    <?php if($this->session->userdata("LogInData")):?>
    <div class="col-md-10 col-md-offset-1 form-wrap" id="comment-form-wrap">
      <h4 class="control-label text-right" style="padding-right: 13%;">Xin vui lòng chia sẻ đánh giá của bạn về
        nhà hàng! </h4>
      <form action="<?php echo site_url("article/post") ?>" enctype="multipart/form-data" class="form-horizontal"
            role="form"
            data-toggle="validator" method="post">
        <input type="hidden" name="account_id" value="<?php echo $account->account_id ?>">
        <div class="form-group col-md-6 vote-box">
          <div class="col-md-12"><label class="control-label">Giá cả</label>
            <div id="star_price" class="starrr" data-rating='0'></div>
            <input id="vote_price" class="point_value" type="hidden" name="vote_price" value="">
          </div>
          <div class="col-md-12"><label class="control-label">Chất lượng phục vụ</label>
            <div id="star_service" class="starrr" data-rating='0'></div>
            <input id="vote_service" class="point_value" type="hidden" name="vote_service" value="">
          </div>
          <div class="col-md-12"><label class="control-label">Chất lượng món ăn</label>
            <div id="star_quality" class="starrr" data-rating='0'></div>
            <input id="vote_quality" class="point_value" type="hidden" name="vote_quality" value="">
          </div>
          <div class="col-md-12"><label class="control-label">Không gian nhà hàng</label>
            <div id="star_space" class="starrr" data-rating='0'></div>
            <input id="vote_space" class="point_value" type="hidden" name="vote_space" value="">
          </div>
          <div class="col-md-12"><label class="control-label">Vị trí nhà hàng</label>
            <div id="star_location" class="starrr" data-rating='0'></div>
            <input id="vote_location" class="point_value" type="hidden" name="vote_location" value="">
          </div>

        </div>
        <div class="form-group col-md-6">
          <input id="title" type="text" name="title" class="form-control col-md-5"
                 placeholder="Nhập tiêu đề nhận xét tại đây">
        </div>
        <div class="form-group col-md-6">
                    <textarea id="description" type="text" name="description" class="form-control col-md-5"
                              placeholder="Nhập mô tả tại đây" cols="8" rows="4" style="resize:none"></textarea>
        </div>
        <div class="form-actions col-md-12">
          <label class="btn btn-warning btn-file col-md-2 col-md-offset-6"><input name="image[]" type="file" multiple="multiple"></label>
          <input class="btn btn-success btn-md col-md-2 col-md-offset-1" type="submit" name="submit" value="Gửi nhận xét">

        </div>
      </form>

    </div>
    <?php else:?>
      <p class="col-md-10 col-md-offset-1 text-left">Vui lòng <a href="<?php echo site_url("auth")?>">đăng nhập</a> để bình  luận!</p>
    <?php endif;?>
    <div class="col-md-10 col-md-offset-1" id="comment-list-wrap">
			<?php if (count($articles)): ?>
				<?php foreach ($articles as $article): ?>
          <div class="comment-box">
            <div class="head-box">
							<?php echo image($article->avatar, array('class' => 'avatar-sm', 'width' => '50', 'height' => 50)) ?>
              <div class="author">
                <p><strong><?php echo $article->user_full_name ?></strong></p>
                <small class="text-muted"><?php echo date("Y/m/d H:i", strtotime($article->date_created)) ?></small>
              </div>
              <span
                  class="product-vote"><?php echo number_format(($article->vote_price + $article->vote_service + $article->vote_quality + $article->vote_space + $article->vote_location) / 5, 1) ?></span>
            </div>
            <div class="content-box">
              <blockquote>
                <strong><?php echo $article->title ?></strong>
                <small><?php echo $article->description ?></small>
              </blockquote>
              <div class="image-box">
								<?php
                if($article->article_image!=''):
                 $images = explode(";", $article->article_image);
                  foreach ($images as $img): ?>
                    <div class="img-wrap">
                      <a href="<?php echo site_url($img)?>" target="_blank">
                      <img src="<?php echo site_url($img)?>" alt="" width="100%"/>
                      </a>
                    </div>
                <?php
                  endforeach;
                endif;
                ?>
              </div>
            </div>
          </div>
				<?php endforeach; ?>
			<?php endif; ?>
    </div>
  </section>
</article>
<script type="text/javascript">
  $(document).ready(function () {
    $(".switch-tab").bind('click', function (e) {
      e.preventDefault();
      var self = $(this);
      if (self.attr("id") == 'showMenuBtn') {
        $("#showMenuBtn").addClass('active');
        $("#showArticleBtn").removeClass('active');
        $("#articles").slideUp();
        $("#menu-list").slideDown();
      } else {
        $("#showArticleBtn").addClass('active');
        $("#showMenuBtn").removeClass('active');
        $("#articles").slideDown();
        $("#menu-list").slideUp();
      }
    })
  })
</script>