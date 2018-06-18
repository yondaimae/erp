<?php
class bill
{
  public function __construct(){}

  //------------- สำหรับใช้ในการบันทึกขาย ---------//
  //--- รายการสั้งซื้อ รายการจัดสินค้า รายการตรวจสินค้า
  //--- เปรียบเทียบยอดที่มีการสั่งซื้อ และมีการตรวจสอนค้า
  //--- เพื่อให้ได้ยอดที่ต้องเปิดบิล บันทึกขายจริงๆ
  //--- ผลลัพธ์จะไม่ได้ยอดที่มีการสั่งซื้อแต่ไม่มียอดตรวจ หรือ มียอดตรวจแต่ไม่มียอดสั่งซื้อ (กรณีมีการแก้ไขออเดอร์)
  public function getBillDetail($id_order)
  {
    $qr = "SELECT o.id, o.id_product, o.product_code, o.product_name, o.qty AS order_qty, ";
    $qr .= "o.price, o.discount, ";
    $qr .= "(o.discount_amount / o.qty) AS discount_amount, ";
    $qr .= "(o.total_amount/o.qty) AS final_price, ";
    $qr .= "(SELECT SUM(qty) FROM tbl_prepare WHERE id_order = ".$id_order." AND id_product = o.id_product) AS prepared, ";
    $qr .= "(SELECT SUM(qty) FROM tbl_qc WHERE id_order = ".$id_order." AND id_product = o.id_product) AS qc ";
    $qr .= "FROM tbl_order_detail AS o ";
    $qr .= "WHERE o.id_order = ".$id_order." GROUP BY o.id_product ";
    $qr .= "HAVING qc IS NOT NULL";

    return dbQuery($qr);
  }


  //------------------ สำหรับแสดงยอดที่มีการบันทึกขายไปแล้ว -----------//
  //--- รายการสั้งซื้อ รายการจัดสินค้า รายการตรวจสินค้า
  //--- เปรียบเทียบยอดที่มีการสั่งซื้อ และมีการตรวจสอนค้า
  //--- เพื่อให้ได้ยอดที่ต้องเปิดบิล บันทึกขายจริงๆ
  //--- ผลลัพธ์จะได้ยอดสั่งซื้อเป็นหลัก หากไม่มียอดตรวจ จะได้ยอดตรวจ เป็น NULL
  public function getBilledDetail($id_order)
  {
    $qr = "SELECT o.id_product, o.product_code, o.product_name, o.qty AS order_qty, ";
    $qr .= "o.price, o.discount, ";
    $qr .= "(o.discount_amount / o.qty) AS discount_amount, ";
    $qr .= "(o.total_amount/o.qty) AS final_price, ";
    $qr .= "(SELECT SUM(qty) FROM tbl_prepare WHERE id_order = ".$id_order." AND id_product = o.id_product) AS prepared, ";
    $qr .= "(SELECT SUM(qty) FROM tbl_qc WHERE id_order = ".$id_order." AND id_product = o.id_product) AS qc ";
    $qr .= "FROM tbl_order_detail AS o ";
    $qr .= "WHERE o.id_order = ".$id_order." GROUP BY o.id_product";

    return dbQuery($qr);
  }


} //--- End class

 ?>
