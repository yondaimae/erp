

<form id="discount-form">
<div class="row">
	<div class="col-sm-12">
    	<table class="table table-striped border-1">
        <thead>
        	<tr class="font-size-12">
            	<th class="width-5 text-center">No.</th>
                <th class="width-5 text-center"></th>
                <th class="width-15">รหัสสินค้า</th>
                <th class="width-25">ชื่อสินค้า</th>
                <th class="width-10 text-center">ราคา</th>
                <th class="width-10 text-center">จำนวน</th>
                <th class="width-15 text-center">ส่วนลด</th>
                <th class="width-10 text-right">มูลค่า</th>
                <th class="width-5 text-center"></th>
            </tr>
        </thead>
        <tbody id="detail-table">
<?php $detail = $order->getDetails($order->id); ?>
<?php if( dbNumRows($detail) > 0 ) : ?>
<?php 	$no = 1; 							?>
<?php 	$total_qty = 0;		?>
<?php 	$total_discount = 0; ?>
<?php	$total_amount = 0; ?>
<?php	$order_amount = 0; ?>
<?php	$image = new image(); ?>
<?php	while( $rs = dbFetchObject($detail) ) : ?>
			<tr class="font-size-10" id="row_<?php echo $rs->id; ?>">
            	<td class="middle text-center"><?php echo $no; ?></td>
                <td class="middle text-center padding-0">
                	<img src="<?php echo $image->getProductImage($rs->id_product, 1); ?>" width="40px" height="40px"  />
                </td>
                <td class="middle"><?php echo $rs->product_code; ?></td>
                <td class="middle"><?php echo $rs->product_name; ?></td>
                <td class="middle text-center">
                <?php if( $allowEditPrice && $order->state < 4 ) : ?>

                	<input type="text" class="form-control input-sm text-center price-box hide" id="price_<?php echo $rs->id; ?>" name="price[<?php echo $rs->id; ?>]" value="<?php echo $rs->price; ?>" />
                    </div>
                <?php endif; ?>
                <span class="price-label" id="price-label-<?php echo $rs->id; ?>">	<?php echo number_format($rs->price, 2); ?></span>
                </td>
                <td class="middle text-center"><?php echo number_format($rs->qty); ?></td>
                <td class="middle text-center">
                <?php if( $allowEditDisc && $order->state < 4 ) : ?>
                    <input type="text" class="form-control input-sm text-center discount-box hide" id="disc_<?php echo $rs->id; ?>" name="disc[<?php echo $rs->id; ?>]" value="<?php echo $rs->discount; ?>" />
                <?php endif; ?>
                <span class="discount-label"><?php echo $rs->discount; ?></span>
                </td>
                <td class="middle text-right"><?php echo number_format($rs->total_amount, 2); ?></td>
                <td class="middle text-right">
                <?php if( ( $order->isPaid == 0 && $order->hasPayment == 0 ) && ($edit OR $add) ) : ?>
                	<button type="button" class="btn btn-xs btn-danger" onclick="removeDetail(<?php echo $rs->id; ?>, '<?php echo $rs->product_code; ?>')"><i class="fa fa-trash"></i></button>
                <?php endif; ?>
                </td>

            </tr>

<?php	$total_qty += $rs->qty;	?>
<?php 	$total_discount += $rs->discount_amount; ?>
<?php 	$order_amount += $rs->qty * $rs->price; ?>
<?php	$total_amount += $rs->total_amount; ?>
<?php		$no++; ?>
<?php 	endwhile; ?>
<?php 	$netAmount = ( $total_amount - $order->bDiscAmount ) + $order->shipping_fee + $order->service_fee;	?>
<?php	$rowspan = $order->isOnline == 1 ? 6 : 4;	?>
			<tr class="font-size-12">
            	<td colspan="6" rowspan="<?php echo $rowspan; ?>"></td>
                <td style="border-left:solid 1px #CCC;"><b>จำนวนรวม</b></td>
                <td class="text-right"><b><?php echo number_format($total_qty); ?></b></td>
                <td class="text-center"><b>Pcs.</b></td>
            </tr>
           <tr class="font-size-12">
                <td style="border-left:solid 1px #CCC;"><b>มูลค่ารวม</b></td>
                <td class="text-right" id="total-td" style="font-weight:bold;"><?php echo number_format($order_amount, 2); ?></td>
                <td class="text-center"><b>THB.</b></td>
            </tr>
            <tr class="font-size-12">
                <td style="border-left:solid 1px #CCC;"><b>ส่วนลดรวม</b></td>
                <td class="text-right" id="discount-td" style="font-weight:bold;"><?php echo number_format($total_discount, 2); ?></td>
                <td class="text-center"><b>THB.</b></td>
            </tr>
            <?php if( $order->isOnline == 1 ) : ?>
            <tr class="font-size-12">
                <td style="border-left:solid 1px #CCC;"><b>ค่าจัดส่ง</b></td>
                <td class="text-right" id="shipping-td" style="font-weight:bold;"><?php echo number_format($order->shipping_fee, 2); ?></td>
                <td class="text-center"><b>THB.</b></td>
            </tr>
            <tr class="font-size-12">
                <td style="border-left:solid 1px #CCC;"><b>อื่นๆ</b></td>
                <td class="text-right" id="service-td" style="font-weight:bold;"><?php echo number_format($order->service_fee, 2); ?></td>
                <td class="text-center"><b>THB.</b></td>
            </tr>
            <?php endif; ?>
            <tr class="font-size-12">
                <td style="border-left:solid 1px #CCC;"><b>สุทธิ</b></td>
                <td class="text-right" style="font-weight:bold;" id="netAmount-td"><?php echo number_format( $netAmount, 2); ?></td>
                <td class="text-center"><b>THB.</b></td>
            </tr>



<?php else : ?>
			<tr>
            	<td colspan="9" class="text-center"><h4>ไม่พบรายการ</h4></td>
            </tr>
<?php endif; ?>

        </tbody>
        </table>
    </div>
</div>
<!--------------------------------  End Order Detail ----------------->
</form>
<!------ order detail template ------>
<script id="detail-table-template" type="text/x-handlebars-template">
{{#each this}}
	{{#if @last}}
        <tr>
            	<td colspan="6" rowspan="4"></td>
                <td style="border-left:solid 1px #CCC;"><b>จำนวนรวม</b></td>
                <td class="text-right"><b>{{ total_qty }}</b></td>
                <td class="text-center"><b>Pcs.</b></td>
            </tr>
            <tr>
                <td style="border-left:solid 1px #CCC;"><b>มูลค่ารวม</b></td>
                <td class="text-right"><b>{{ order_amount }}</b></td>
                <td class="text-center"><b>THB.</b></td>
            </tr>
            <tr>
                <td style="border-left:solid 1px #CCC;"><b>ส่วนลดรวม</b></td>
                <td class="text-right"><b>{{ total_discount }}</b></td>
                <td class="text-center"><b>THB.</b></td>
            </tr>
            <tr>
                <td style="border-left:solid 1px #CCC;"><b>สุทธิ</b></td>
                <td class="text-right"><b>{{ total_amount }}</b></td>
                <td class="text-center"><b>THB.</b></td>
            </tr>
	{{else}}
        <tr class="font-size-10" id="row_{{ id }}">
            <td class="middle text-center">{{ no }}</td>
            <td class="middle text-center padding-0">
            	<img src="{{ imageLink }}" width="40px" height="40px"  />
            </td>
            <td class="middle">{{ productCode }}</td>
            <td class="middle">{{ productName }}</td>
            <td class="middle text-center">{{ price }}</td>
            <td class="middle text-center">{{ qty }}</td>
            <td class="middle text-center">{{ discount }}</td>
            <td class="middle text-center">{{ amount }}</td>
            <td class="middle text-right">
            <?php if( $edit OR $add ) : ?>
            	<button type="button" class="btn btn-xs btn-danger" onclick="removeDetail({{ id }}, '{{ productCode }}')"><i class="fa fa-trash"></i></button>
            <?php endif; ?>
            </td>
        </tr>
	{{/if}}
{{/each}}
</script>

<script id="nodata-template" type="text/x-handlebars-template">
	<tr>
          <td colspan="9" class="text-center"><h4>ไม่พบรายการ</h4></td>
    </tr>
</script>

<script src="script/order/order_detail.js"></script>
