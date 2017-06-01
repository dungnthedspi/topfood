<div class="row product-wrap text-center" style="background-color: white; padding-top: 10px">
  <form data-toggle="validator" action="<?php echo site_url('/home/search/')?>">
    <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-3">
      <div class="demo-form-wrapper">
        <div class="form-group has-feedback">
          <select name="area_id" class="form-control search-select">
            <option value="">Chọn Khu Vực</option>
            <?php foreach ($areas as $area) { ?>
            <option <?php if($area->area_id == $selected_id) echo "Selected" ?> value= "<?php echo $area->area_id ?>" >
              <?php echo $area->name ?>
            </option>
          <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
      <input type="text" name="account_name" class="form-control" placeholder="Tìm kiếm ....">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
      <button type="submit" value="1" class="btn btn-success form-control">Tìm nhà hàng</button>
    </div>
  </form>
</div>
<div class="row">
	<?php foreach ($restaurants as $r) { ?>
    <div class="col-xs-12 col-md-4 product-wrap">
      <div class="product">
        <div class="product-image">
          <a href="<?php echo site_url("account/" . $r->account_id) ?>">
						<?php echo product_image($r->avatar, array('class' => 'product-img')); ?>
          </a>
        </div>
        <div class="product-info">
					<?php $avg_vote = number_format(($r->vote_price + $r->vote_service + $r->vote_quality + $r->vote_space + $r->vote_location) / 5, 1);
					if (intval($avg_vote)) : ?>
            <div class="product-vote"><?php echo $avg_vote?></div>
					<?php endif; ?>
          <div class="product-meta">
            <p class="product-title">
              <strong><a href="<?php echo site_url("account/" . $r->account_id) ?>">
									<?php echo $r->account_name; ?>
                </a></strong>
            </p>
            <p class="product-address"><?php echo $r->address; ?></p>
          </div>

        </div>
      </div>

    </div>
	<?php } ?>

</div>