<?php
$id_zone = $_GET['id_zone'];
$barcode = $_GET['barcode'];

$bc = new barcode();
$cs = new consign();
$st = new stock();
$id_pd = $bc->getProductId($barcode);
if( $id_pd !== FALSE )
{
  $pd = new product($id_pd);
  $gp = $cs->getProductGP($id_pd, $id_zone);
  $stock = $st->getStockZone($id_zone, $id_pd);

  $arr = array(
    'id_product' => $id_pd,
    'barcode'    => $barcode,
    'product'    => $pd->code,
    'price'      => $pd->price,
    'p_disc'     => $gp,
    'a_disc'     => 0,
    'stock'      => $stock
  );

  $sc = json_encode($arr);
}
else
{
  $sc = 'บาร์โค้ดไม่ถูกต้อง';
}

echo $sc;
 ?>
