<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="uploads/gallery/slide_1.jpg" alt="Los Angeles" style="width:100%;">
    </div>

    <div class="item">
      <img src="uploads/gallery/slide_2.jpg" alt="Chicago" style="width:100%;">
    </div>

    <div class="item">
      <img src="uploads/gallery/slide_3.jpg" alt="New york" style="width:100%;">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="clear"></div>
<div class="row product-wrap text-center" style="background-color: white; padding-top: 10px">
  <form data-toggle="validator" action="<?php echo site_url('/home/search/')?>">
    <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
      <div class="demo-form-wrapper">
        <div class="form-group has-feedback">
          <select name="area_id" class="form-control search-select">
              <option value="">Chọn Khu Vực</option>
            <?php foreach ($areas as $area) { ?>
              <option value= "<?php echo $area->area_id ?>"><?php echo $area->name ?></option>
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
  <div class="col-md-2">
  <form id="form" action="<?php echo site_url('/home/map2/')?>" method="post">
    <input type="text" id="lat" value="" hidden="" name="lat">
    <input type="text" id="lng" value="" hidden="" name="lng">
  </form>
  <button class="btn btn-success form-control" onclick="getLocation()">Tìm quanh đây</button>
  </div>
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

<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script>

function getLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
  console.log(position);
  var x = position.coords.latitude;
  var y = position.coords.longitude;
  document.getElementById("lat").value = x;
  document.getElementById("lng").value = y;
  var form = document.getElementById("form");
  form.submit();
}

</script>
