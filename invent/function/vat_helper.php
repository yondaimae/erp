<?php

function removeVAT($amount, $vat=7)
{
	if( $vat != 0 )
	{
		$re_vat	= ($vat + 100) / 100;
		return $amount/$re_vat;
	}
	else
	{
		return $amount;
	}
}






function addVAT($amount, $vat = 7)
{
	if( $vat != 0 )
	{
		$re_vat = $vat * 0.01;
		$sc = ($amount * $re_vat) + $amount;
	}
	else
	{
		$sc = $amount;
	}
	return $sc;
}







function getVatRate($vatType=1)
{
	switch( $vatType )
	{
		case 1 :
			$VAT = 7;
		break;
		case 2 :
			$VAT = 1.5;
		break;
		case 3 :
			$VAT = 0;
		break;
		case 4 :
			$VAT = 0;
		break;
		case 5 :
			$VAT = 10;
		break;
		default :
			$VAT = 7;
		break;
	}
	return $VAT;
}






function getVatAmount($amount, $VAT, $exVAT = TRUE)
{
	$sc = 0;
	if( $VAT != 0 )
	{
		if( $exVAT === TRUE ) //--- กรณีแยกนอก
		{
			$sc = $amount * ( $VAT * 0.01 );
		}
		else
		{
			$sc = $amount - ( $amount / ( ( 100 + $VAT ) * 0.01 ) );
		}
	}
	return $sc;
}



?>
