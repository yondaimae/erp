<?php
$order = isset( $_GET['id_order'] ) ? new order( $_GET['id_order'] ) : new order();
$hide = ( $order->status == 0 OR $order->hasNotSaveDetail === TRUE ) ? '' : 'hide';
?>
<div class="row top-row">
	<div class="col-sm-4 top-col"><h4 class="title"><i class="fa fa-shopping-bag"></i> <?php echo $pageTitle; ?></h4></div>
    <div class="col-sm-8">
    	<p class="pull-right top-p">
        	<button type="button" class="btn btn-sm btn-warning" onclick="goBack()"><i class="fa fa-arrow-left"></i>  กลับ</button>
			<?php if( $order->isOnline == 1 ) : ?>
            <?php $payed = ( $order->status == 0 || $order->hasPayment == 1) ? 'disabled' : '' ;	?>
            <button type="button" class="btn btn-sm btn-primary" onClick="payOrder()" <?php echo $payed; ?>><i class="fa fa-credit-card"></i> แจ้งชำระเงิน</button>

            <?php $shiped = ( $order->status == 0 || $order->hasPayment == 0) ? 'disabled' : '' ;	?>
    		<button type="button" class="btn btn-sm btn-info" onClick="updateShipping()" <?php echo $shiped; ?>><i class="fa fa-truck"></i> บันทึกการจัดส่ง</button>

            <?php $disabled = $order->status == 0 ? 'disabled' : '' ;	?>
        	<button type="button" class="btn btn-sm btn-success" onClick="getSummary()" <?php echo $disabled; ?>><i class="fa fa-list"></i> สรุปข้อมูล</button>
            <?php endif; ?>
        	<button type="button" class="btn btn-sm btn-default" onClick="printOrder()"><i class="fa fa-print"></i> พิมพ์</button>



			<?php if( ($add && $order->status == 0 && $order->id_employee == getCookie('user_id') ) OR ($edit && $order->status == 1 && $order->state < 4 ) ) : ?>
				<?php if( $order->isExpire == 0 && ($order->isOnline == 0 OR $order->hasPayment == FALSE )) : ?>

            		<button type="button" class="btn btn-sm btn-warning" onclick="goAddDetail(<?php echo $order->id; ?>)"><i class="fa fa-pencil"></i> แก้ไขรายการ</button>

				<?php endif; ?>
            <?php endif; ?>

			<button type="button" class="btn btn-sm btn-success <?php echo $hide; ?>" id="btn-save-order" onclick="saveOrder(<?php echo $order->id; ?>)">
            	<i class="fa fa-save"></i> บันทึก
            </button>
        </p>
    </div>
</div>
<hr class="margin-bottom-10" />
<?php if( $order->id < 1 ) : ?>
<?php 	include 'include/page_error.php'; ?>
<?php else : //--- isset $_GET['id_order'] ?>

<?php

	include 'include/order_consignment/consignment_edit_header.php';

?>

<?php include 'include/order/order_panel.php'; ?>


<!--- Order Detail ----------------->

<!--- ปุ่มแก้ไขราคาและส่วนลด ------------->
<?php
if( ( $allowEditDisc == 1 OR $allowEditPrice == 1 ) && $order->state < 4 )
{
 	include 'include/order/order_discount_bar.php';
}
?>
<!--- / ปุ่มแก้ไขราคาและส่วนลด / ------------->

<?php include 'include/order/order_detail.php'; ?>
<!--- End order detail -------------------------------->


<script src="script/order/order_edit.js?token=<?php echo date('Ymd'); ?>"></script><!--- ใช้ของ order เพราะเหมือนกัน --->
<script src="script/order/order_add.js?token=<?php echo date('Ymd'); ?>"></script>
<?php endif; //--- isset $_GET['id_order']  ?>
