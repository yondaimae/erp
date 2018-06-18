<?php

  $order = new order($_GET['id_order']);
  $reference = $order->reference;
	$id_address	 = isset( $_GET['id_address'] ) ? $_GET['id_address'] : getIdAddress($order->id_customer);
	$id_sender   = isset( $_GET['id_sender'] )  ? $_GET['id_sender'] : getMainSender($order->id_customer);
	$sd				   = getSender($id_sender);
	$ad				   = getAddress($id_address);
	$cusName	   = $ad['company'] == '' ? $ad['first_name'].' '.$ad['last_name'] : $ad['company'];
	$cName			 = getConfig('COMPANY_FULL_NAME');
	$cAddress		= getConfig('COMPANY_ADDRESS');
	$cPhone			= getConfig('COMPANY_PHONE');
  


	/*********  Sender  ***********/
	$sender			= '<div class="col-lg-12" style="font-size:18px; padding-top:15px; padding-bottom:30px;">';
	$sender			.= '<span style="display:block; margin-bottom:10px;">'.$cName.'</span>';
	$sender			.= '<span style="width:70%; display:block;">'.$cAddress.' '.getConfig('COMPANY_POST_CODE').'</span>';
	$sender			.= '<span style="display:block"> โทร. '.$cPhone.'</span>';
	$sender			.= '</div>';
	/********* / Sender *************/



	/*********** Receiver  **********/
	$receiver		= '<div class="col-lg-12" style="font-size:18px; padding-left: 250px; padding-top:15px; padding-bottom:40px;">';
	$receiver		.= '<span style="display:block; margin-bottom:10px;">'.$cusName.'</span>';
	$receiver		.= '<span style="display:block;">'.$ad['address1'].'</span>';
	$receiver		.= '<span style="display:block;">'.$ad['address2'].'</span>';
	$receiver		.= '<span style="display:block;">จ. '.$ad['city'].' '.$ad['postcode'].'</span>';
	$receiver		.= $ad['phone'] == '' ? '' : '<span style="display:block;">โทร. '.$ad['phone'].'</span>';
	$receiver		.= '</div>';
	/********** / Receiver ***********/

	/********* Transport  ***********/
	$transport = '';
	if( $sd !== FALSE )
	{
		$transport	= '<table style="width:100%; border:0px; margin-left: 30px; position: relative; bottom:1px;">';
		$transport	.= '<tr style="font-18px;"><td>'. $sd['name'] .'</td></tr>';
		$transport	.= '<tr style="font-18px;"><td>'. $sd['address1'] .' '.$sd['address2'].'</td></tr>';
		$transport	.= '<tr style="font-18px;"><td>โทร. '. $sd['phone'] .' เวลาทำการ : '.date('H:i', strtotime($sd['open'])).' - '.date('H:i', strtotime($sd['close'])).' น. - ( '.$sd['type'].')</td></tr>';
		$transport 	.= '</table>';
	}

	/*********** / transport **********/

	$boxes 			= countBoxes($order->id);
	$total_page		= $boxes <= 1 ? 1 : ($boxes+1)/2;
	$Page = '';

	$printer = new printer();
	$config = array("row" => 16, "header_row" => 0, "footer_row" => 0, "sub_total_row" => 0);
	$printer->config($config);


	$Page .= $printer->doc_header();
	$n = 1;
	while($total_page > 0 )
	{
		$Page .= $printer->page_start();

		if( $n < ($boxes+1) )
		{
			$Page .= $printer->content_start();
			$Page .= '<table style="width:100%; border:0px;"><tr><td style="width:50%;">';
			$Page .= $sender;
			$Page .= '</td><td style=" vertical-align:text-top; text-align:right; font-size:18px; padding-top:25px; padding-right:15px;">'.$reference.' : กล่องที่ '.$n.' / '.$boxes.'</td></tr></table>';
			$Page .= $receiver;
			$Page .= $transport;
			$Page .= $printer->content_end();
			$n++;
		}
		if( $n < ($boxes+1) )
		{
			$Page .= $printer->content_start();
			$Page .= '<table style="width:100%; border:0px;"><tr><td style="width:50%;">';
			$Page .= $sender;
			$Page .= '</td><td style=" vertical-align:text-top; text-align:right; font-size:18px; padding-top:25px; padding-right:15px;">'.$reference.' : กล่องที่ '.$n.' / '.$boxes.'</td></tr></table>';
			$Page .= $receiver;
			$Page .= $transport;
			$Page .= $printer->content_end();
			$n++;
		}
		if( $n > $boxes ){
			if( $n > $boxes && ($n % 2) == 0 )
			{
				$Page .= '
				<style>.table-bordered > tbody > tr > td { border : solid 1px #333 !important;  }</style>
				<table class="table table-bordered" >
					<tr style="font-size:10px">
						<td style="width:8%;">ใบสั่งงาน</td>
						<td style="width:25%;"><input type="checkbox" style="margin-left:10px; margin-right:5px;"> รับ <input type="checkbox" checked style="margin-left:10px; margin-right:5px;"> ส่ง</td>
						<td style="width:27%;">วันที่ '.date("d/m/Y").' <input type="checkbox" style="margin-left:10px; margin-right:5px;">เช้า <input type="checkbox" style="margin-left:10px; margin-right:5px;"> บ่าย</td>
						<td style="width:20%;">จำนวน '.$boxes.' กล่อง</td>
						<td style="width:20%;">ออเดอร์ :  '.$reference.'</td>
					</tr>
					<tr style="font-size:10px;"><td>ขนส่ง</td><td>'.$sd['name'].'</td><td colspan="3">'.$sd['address1'].' '.$sd['address2'].' ('.$sd['phone'].')</td></tr>
					<tr style="font-size:10px;"><td>ผู้รับ</td><td>'.$cusName.'</td><td colspan="3">'.$ad['address1'].' '.$ad['address2'].' '.$ad['city'].' '.$ad['postcode'].'</td></tr>
					<tr style="font-size:10px;"><td>ผู้ติดต่อ</td><td>'.$ad['first_name'].'</td><td>โทร. '.$ad['phone'].'</td><td>ผู้สั่งงาน '.$_COOKIE['UserName'].'</td><td>โทร. </td></tr>
				</table>';
			}
			$n++;
		}
		$Page .= $printer->page_end();

		$total_page--;
	}
	$Page .= $printer->doc_footer();
	echo $Page;
