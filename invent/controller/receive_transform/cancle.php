<?php
//--- Cancle Received transform product
$sc         = TRUE;
$id         = $_POST['id_receive_transform'];
$cs         = new receive_transform($id);
$mv         = new movement();
$stock      = new stock();
$transform  = new transform();
$order      = new order();
$id_order   = $order->getId($cs->order_code);
$product    = new product();
$zone       = new zone();
$cost       = new product_cost();
$emp        = getCookie('user_id');

//---- ดึงรายการรับเข้าตามเอกสาร
$qs = $cs->getDetail($id);

if( dbNumRows($qs) > 0)
{
  startTransection();

  while( $rs = dbFetchObject($qs))
  {

    if($sc === FALSE)
    {
      break;
    }

    //--- ตรวจสอบว่าโซนที่ต้องเอายอดสินค้าออกติดลบได้หรือไม่
    $auz = $zone->isAllowUnderZero($rs->id_zone);

    $isEnough = $stock->isEnough($rs->id_zone, $rs->id_product, $rs->qty);

    $pdCode = $product->getCode($rs->id_product);

    if( $isEnough === FALSE && $auz === FALSE )
    {
      //--- ถ้ายอดคงเหลือน้อยกว่ายอดที่จะยกเลิก และ โซนไม่สามารถติดลบได้
      $sc = FALSE;
      $message = $pdCode.' : สินค้าคงเหลือไม่พอให้ยกเลิก';
      break;
    }
    else
    {
      //--- ถ้ายอดคงเหลือพอให้ยกเลิกได้

      //--- Update stock
      if( $stock->updateStockZone($rs->id_zone, $rs->id_product, ($rs->qty * -1)) !== TRUE )
      {
        $sc = FALSE;
        $message = 'ตัดยอด '. $pdCode.' จากโซนต้นทางไม่สำเร็จ';
        break;
      }

      //---- ลดจำนวนวรายการต้นทุนสินค้าใน tbl_product_cost
      if($cost->deleteCostList($rs->id_product, $product->getCost($rs->id_product), $rs->qty) !== TRUE)
      {
        $sc = FALSE;
        $message = 'ปรับปรุงต้นทุน '.$pdCode.' ไม่สำเร็จ';
        break;
      }

      if( $cs->cancleDetail($rs->id) === FALSE)
      {
        $sc = FALSE;
        $message = 'ยกเลิกรายการรับเข้า '.$pdCode.' ไม่สำเร็จ';
        break;
      }


      //--- บันทึกยอดรับใน tbl_order_transform_detail
      $qa = $transform->getDetail($id_order, $rs->id_product);

      //---	ยอดสินค้าที่จะเอาออก
      $received_qty = $rs->qty;

      //---	มีรายการที่ต้อง update กี่รายการ
      $row = dbNumRows($qa);

      //---	วนลูป update ทีละรายการ
      while( $res = dbFetchObject($qa))
      {
        //---	ถ้าเป็นรายการเดียว หรือ เป็นรอบสุดท้าย ใช้ยอดที่เหลือ รับเข้ารายการสุดท้ายเลย
        //---	ถ้าไมใช่รอบสุดท้าย ให้ใช้ยอดไม่เกินที่เปิดบิลมา
        $received = $row == 1 ? $received_qty  : ($res->received <= $received_qty ? $res->received : $received_qty);
        if( $transform->received( $res->id, ($received * -1) ) == FALSE )
        {
          $sc = FALSE;
          $message = 'ปรับปรุงยอดรับไม่สำเร็จ';
        }

        $row--;
        $received_qty -= $received;
      }	//--- endwhile $res
    }

  }

  //--- ถ้าสต็อกคงเหลือพอและไม่มีรายการไหนผิดพลาด
  if( $sc === TRUE)
  {
    //--- ลบ movement ทั้งหมด
    if( $mv->dropMovement($cs->reference) === FALSE )
    {
      $sc = FALSE;
      $message = 'ลบการเคลื่อนไหวไม่สำเร็จ';
    }

    //--- cancle เอกสาร
    if( $cs->cancleReceived($cs->id, $emp) === FALSE)
    {
      $sc = FALSE;
      $message = 'ยกเลิกเอกสารไม่สำเร็จ';
    }
  }

  if($sc === TRUE)
  {
    $transform->unClosed($id_order);
  }


  //--- ตรวจสอบความถูกต้องทั้งหมดก่อน commitTransection
  if( $sc === TRUE )
  {
    commitTransection();
  }
  else
  {
    dbRollback();
  }

  endTransection();

  //echo $sc === TRUE ? $sc : ($pdCode == '' ? $sc : 'สินค้าคงเหลือไม่พอให้ยกเลิก : '.$pdCode);
}
else
{
  $sc = FALSE;
  $message = 'ไม่พบรายการรับเข้า';
}

echo $sc === TRUE ? 'success' : $message;


 ?>
