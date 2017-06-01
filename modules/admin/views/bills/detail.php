<div class="panel">
    <div class="panel-body p-a-lg">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center">
                    Hóa đơn
                </h1>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-6">
                <p class="account_name">Nhà hàng: <strong><?php echo $bill[0]->account_name ?></strong></p>
                <div class="p-a">
									<?php echo $bill[0]->account_address ?>
                    <br><?php echo $bill[0]->account_phone ?>
                </div>
            </div>
            <div class="col-sm-6">

                <p class="account_name">Khách hàng: <strong><?php echo $bill[0]->customer_name ?></strong></p>
                <div class="p-a">
									<?php echo $bill[0]->customer_address ?>
                    <br><?php echo $bill[0]->customer_phone ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-sm-push-0">
                <div class="p-a">
                    Mã số hóa đơn:
                    <br> <?php echo $bill[0]->name ?>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-sm-push-6">
                <div class="p-a">
                    Customer ID:
                    <br> <?php echo(($bill[0]->customer_id) ? $bill[0]->customer_id : "#") ?>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-sm-pull-4">
                <div class="p-a">
                    Ngày lập:
                    <br> <?php echo $bill[0]->date_created ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>

                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá thành</th>
                            <th>Tổng</th>
                        </tr>
                        </thead>
                        <tbody>
												<?php
												$bill_subtotal = 0;
												foreach ($bill as $item):
													$bill_subtotal += ($item->quantity * $item->price);
													?>
                            <tr>
                                <th scope="row"><?php echo $item->item_id ?></th>
                                <td><?php echo $item->item_name ?></td>
                                <td><?php echo $item->quantity ?></td>
                                <td><?php echo show_currency($item->price) ?></td>
                                <td><?php echo show_currency($item->quantity * $item->price); ?></td>
                            </tr>
												<?php endforeach; ?>
                        <tr>
                            <th scope="row" colspan="4">
                                <div class="text-right">
                                    Tổng tiền
                                    <br> Phí Ship
                                    <br> Tổng tiền phải trả
                                </div>
                            </th>
                            <td>
															<?php echo show_currency($bill_subtotal) ?>
                                <br> <?php echo show_currency($bill[0]->shipping_fee) ?>
                                <br>
                                <strong><?php echo show_currency($bill_subtotal + $bill[0]->shipping_fee) ?>
                                    VND</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row hidden">
            <div class="col-sm-12">
                <div class="text-center hidden-print">
                    <div class="p-y-lg">
                        <a class="btn btn-success btn-sm" href="javascript:window.print()">
                            <span class="fa fa-print fa-2x" aria-hidden="true"></span>
                            Print
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
