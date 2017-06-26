<?php
$location = explode(",", $restaurant->location);
$login_data = $this->session->userdata("LogInData");
//debug($restaurant);
?>
<div class="order-form container" id="order-form-container">

  <div id="gMap"></div>

  <div id="right-panel">
    <p>Khoảng cách (dự tính): <span id="totalDistance"></span></p>
  </div>
  <strong class="text-center">Đặt hàng tại: <?php echo $restaurant->account_name ?> </strong>
  <form action="<?php echo site_url("account/cart/finish") ?>" id="gmapChange" class="form-horizontal" role="form"
        data-toggle="validator" method="post">
    <div class="row">
      <input id="shipping_rate" type="hidden" name="shipping_rate" value="<?php echo $restaurant->shipping_fee ?>"
             class="form-control" readonly="readonly">
      <input id="shippingFee" type="hidden" name="shipping_fee" class="form-control" readonly="readonly">
      <input type="hidden" name="account_id" value="<?php echo $restaurant->account_id ?>" class="form-control"
             readonly="readonly">
      <input type="hidden" name="account_address" value="<?php echo $restaurant->address ?>" class="form-control"
             readonly="readonly">
      <div class="form-group col-md-12" style="padding-left: 15px;padding-right: 45px;">
        <label class="control-label col-sm-2" for="destimation">Địa chỉ /tọa độ <span
              class="text-red">*</span></label>
        <div class="col-sm-10"><input id="destimation" name="destination" type="text" class="form-control"
                                      required="true"
                                      value="<?php (isset($login_data->address) ? $login_data->last_name : '') ?>">
        </div>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label col-sm-4" for="first_name">Họ tên <span class="text-red">*</span></label>
        <div class="col-sm-8">
          <input id="full_name" name="full_name" type="text" class="form-control"
                 value="<?php echo(isset($login_data->last_name) ? $login_data->last_name . " " . $login_data->first_name : '') ?>"
                 required="true"
                 data-error="Before you wreck yourself">
        </div>


      </div>
      <div class="form-group col-md-6">
        <label class="control-label col-sm-4" for="phone">Số điện thoại <span
              class="text-red">*</span></label>
        <div class="col-sm-8"><input id="phone" name="phone" type="text" class="form-control"
                                     value="<?php echo(isset($login_data->phone) ? $login_data->phone : '') ?>"
                                     required="true"></div>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label col-sm-4" for="email">Email</label>
        <div class="col-sm-8"><input id="email" name="email" type="email" class="form-control"
                                     value="<?php echo(isset($login_data->email) ? $login_data->email : '') ?>"></div>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label col-sm-4" for="datetimepicker5">Giờ nhận/đặt hàng <span
              class="text-red">*</span></label>
        <div class='input-group date col-sm-8' id='datetimepicker5'>
          <input id="order_date_time" type='text' name="order_date_time" class="form-control" required/>
          <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
        </div>
        <script type="text/javascript">
          var hoursDisabled = [];
          for (var i = 0; i <= parseInt('<?php echo $restaurant->open_time ?>'.replace(/\:/g, '').substring(0, 2)); i++) {
            hoursDisabled.push(i);
          }
          for (var i = parseInt('<?php echo $restaurant->close_time ?>'.replace(/\:/g, '').substring(0, 2)); i <= 24; i++) {
            hoursDisabled.push(i);
          }
          $(function () {
            $('#datetimepicker5').datetimepicker({
              todayBtn: 1,
              autoclose: 1,
              minView: 1,
              hoursDisabled: hoursDisabled
            });
          });
        </script>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <fieldset>
          <legend>Chi tiết đơn hàng:</legend>
					<?php
					$session_cart = $this->session->userdata("cart");
					$sub_sum = 0;
					$sum = 0;
					if (is_array($session_cart)):?>

						<?php foreach ($session_cart as $k => $v):
							$sub_sum += ($v['quantity'] * $v['price']);
							?>
              <div class="booking-item">
                <label class="booking-item-name"><?php echo $v['name'] ?></label>
                <label class="booking-item-value"><?php echo $v['quantity'] ?></label>
                <strong
                    class="booking-item-price right text-red"><?php echo number_format($v['quantity'] * $v['price']) ?></strong>
              </div>
						<?php endforeach; ?>
					<?php endif; ?>
          <br>
          <p><label>Tổng: </label> <strong class="booking-item-sum-price right text-red"><span
                  id="subSumBill"><?php echo number_format($sub_sum) ?></span>
              <small>đ</small>
            </strong></p>
          <p><label>Phí vận chuyển: </label> <strong class="booking-item-sum-price right"><span
                  id="sumShippingFee"></span>
              <small>đ</small>
              /km</strong></p>
          <p class="text-red"><label>Tạm tính: </label> <strong
                class="booking-item-sum-price right text-red"><span
                  id="sumBill"><?php echo number_format($sub_sum) ?></span>
              <small>đ</small>
            </strong></p>
        </fieldset>
      </div>
    </div>
    <div class="form-actions text-center hidden-print">
      <input type="submit" name="submit" class="btn btn-success" value="Hoàn tất"/>
      <input type="button" name="back" class="btn btn-danger" value="Quay lại" onclick="goBack();"/>
    </div>

  </form>
</div>
<script>

  Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
      c = isNaN(c = Math.abs(c)) ? 2 : c,
      d = d == undefined ? "." : d,
      t = t == undefined ? "," : t,
      s = n < 0 ? "-" : "",
      i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
      j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
  };

  var originLat = <?php echo floatval($location[0])?>;
  var originLng = <?php echo floatval($location[1])?>;
  var map, marker, customerMarker, directionsService, directionsDisplay;
  function initMap() {
    // Create a map object and specify the DOM element for display.
    map = new google.maps.Map(document.getElementById('gMap'), {
      center: {lat: originLat, lng: originLng},
      scrollwheel: false,
    });
    google.maps.event.addListener(map, 'bounds_changed', boundsChanged);
    infoWindow = new google.maps.InfoWindow;

    var image = new google.maps.MarkerImage(
      '<?php echo site_url(DEFAULT_RESTAURANT_MARKER)?>',
      new google.maps.Size(70, 70),
      new google.maps.Point(0, 0),
      new google.maps.Point(17, 34),
      new google.maps.Size(70, 70));

    marker = new google.maps.Marker({
      position: new google.maps.LatLng(originLat, originLng),
      map: map,
      label: ' ',
      icon: image,
    });
    image = new google.maps.MarkerImage(
      '<?php echo isset($login_data->avatar) ? site_url($login_data->avatar) : site_url(DEFAULT_CUSTOMER_MARKER)?>',
      new google.maps.Size(70, 70),
      new google.maps.Point(0, 0),
      new google.maps.Point(17, 34),
      new google.maps.Size(70, 70)
    );
    customerMarker = new google.maps.Marker({
      map: map,
      icon: image,
      label: ' ',
    });

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        document.getElementById("destimation").value = pos.lat + "," + pos.lng;
        //get direction

        directionsService = new google.maps.DirectionsService;
        directionsDisplay = new google.maps.DirectionsRenderer({
          draggable: true,
          map: map
        });

        directionsDisplay.addListener('directions_changed', function () {
          computeTotalDistance(directionsDisplay.getDirections());
        });
        if (originLng !== '' && originLng !== '') {
          displayRoute(marker.getPosition(), pos, directionsService, directionsDisplay);
        } else {
          displayRoute('<?php echo $restaurant->address ?>', pos, directionsService, directionsDisplay);
        }


        // end get direction

      }, function () {
        handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
  }
  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
      'Lỗi: Vui lòng tải lại trang sau đó cho phép truy cập vị trí.' :
      'Lỗi: Trình duyệt không hỗ trợ.');
    infoWindow.open(map);
  }

  function displayRoute(origin, destination, service, display) {
    service.route({
      origin: origin,
      destination: destination,
      waypoints: [],
      travelMode: 'DRIVING',
      avoidTolls: true
    }, function (response, status) {
      if (status === 'OK') {
        display.setDirections(response);

      } else {
        alert('Không thể tìm chỉ đường.');
      }
    });
  }

  function computeTotalDistance(result) {
    //get direction info
    var total = 0;
    var myroute = result.routes[0];
    for (var i = 0; i < myroute.legs.length; i++) {
      total += myroute.legs[i].distance.value;
    }
    total = total / 1000;
    var shippingRate = '<?php echo $restaurant->shipping_fee?>';
    var subSumBill = parseInt(document.getElementById('subSumBill').innerHTML.replace(/\,/g, ''));

    document.getElementById('totalDistance').innerHTML = total + ' km';
    document.getElementById('shippingFee').value = Math.round(total * shippingRate * 1000);
    document.getElementById('sumShippingFee').innerHTML = Math.round(total * shippingRate * 1000).formatMoney(0, '.', ',');
    document.getElementById('sumBill').innerHTML = (total * shippingRate * 1000 + subSumBill).formatMoney(0, '.', ',');

    var customerLatLng = new google.maps.LatLng(parseFloat(result.routes[0].legs[0].end_location.lat()), parseFloat(result.routes[0].legs[0].end_location.lng()))
    var markerLatLng = new google.maps.LatLng(parseFloat(result.routes[0].legs[0].start_location.lat()), parseFloat(result.routes[0].legs[0].start_location.lng()))

    customerMarker.setPosition(customerLatLng);
    marker.setPosition(markerLatLng);

    document.getElementById("destimation").value = result.routes[0].legs[0].end_address;
  }

  function displayNewRoute(newDestination) {
    displayRoute(marker.getPosition(), newDestination, directionsService, directionsDisplay);
  }
  function boundsChanged() {
    map.setCenter(map.getCenter());
    map.setZoom(map.getZoom());
  }

  $(document).ready(function () {
    $("#destimation").on('change', function (e) {
      e.preventDefault();
      var newDestination = $(this).val();
      displayNewRoute(newDestination);
    });

    $("#gmapChange").bind('submit', function (e) {

      var self = $(this);
      if ($("#full_name").val() == '') {
        alert("Vui lòng nhập Họ tên");
        return false;
      }
      if ($("#phone").val() == '') {
        alert("Vui lòng nhập Số điện thoại");
        return false;
      }
      if ($("#destimation").val() == '') {
        alert("Vui lòng nhập Địa chỉ");
        return false;
      }
      if ($("#order_date_time").val() == '') {
        alert("Vui lòng nhập Ngày giờ");
        return false;
      }
      self.unbind('submit').trigger('submit');
    })

    $('#map-print').on('click',

      // printAnyMaps :: _ -> HTML
      function printAnyMaps() {
        var $body = $('body');
        var $mapContainer = $('#gMap');
        var $mapContainerParent = $mapContainer.parent();
        var $printContainer = $('<div style="position:relative;">');

        $printContainer
          .height($mapContainer.height())
          .append($mapContainer)
          .prependTo($body);

        var $content = $body
          .children();

        /**
         * Needed for those who use Bootstrap 3.x, because some of
         * its `@media print` styles ain't play nicely when printing.
         */
        var $patchedStyle = $('<style media="print">')
          .text(
            'img { max-width: none !important; }' +
            'a[href]:after { content: ""; }'
          )
          .appendTo('head');

        window.print();

        $body.prepend($content);
        $mapContainerParent.prepend($mapContainer);

        $printContainer.remove();
        $patchedStyle.remove();
      });
  })
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXoXFr_1GjfPyozh-6uDZKBRHLKYNAHms&callback=initMap" async
        defer></script>
