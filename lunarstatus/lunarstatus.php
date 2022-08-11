<?php
/**
 * @package	Lunar Status Plugin for Hikashop
 * @author	lunar.app
 * @copyright (C) 2022-2022 Lunar. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');

include_once( JPATH_SITE.DS.'plugins/hikashoppayment/lunar/Lunar/Client.php' );

class plgHikashopLunarStatus extends JPlugin
{
	var $message = '';

	function __construct(&$subject, $config){
		parent::__construct($subject, $config);
		$this->order = hikashop_get('class.order');
		$this->db = JFactory::getDBO();
	}


	function onAfterOrderUpdate(&$order,&$send_email){

		$db = JFactory::getDbo();

		$o = clone $order;
		if(!empty($order->old)) {
			if($order->old->order_status!=$order->order_status && $order->order_status=="refunded")
			{
				$this->lunarRefunded($order);
			}
			if($order->old->order_status!=$order->order_status && $order->order_status=="shipped")
			{
				$this->lunarCaptured($order);
			}
		}
	}

	function lunarRefunded($order) {

		$db = JFactory::getDbo();

		$sql ="select * from #__hikashop_payment_plg_lunar where order_id='$order->order_id' limit 1";
		$db->setQuery($sql);
		$row = $db->loadObject();

		$txtid = $row->txnid;

		$params = $this->getLunarConfig();


		\Lunar\Client::setKey( $params->private_key );

		$response    = \Lunar\Transaction::fetch( $txtid );

		/* refund payment if already captured */
		if ( $response['transaction']['capturedAmount'] > 0 ) {
				$amount   = $response['transaction']['capturedAmount'];
				$data     = array(
					'amount'     => $amount,
					'descriptor' => ""
				);
				$response = \Lunar\Transaction::refund( $txtid, $data );
				// update payment to refunded
				$sql ="update #__hikashop_payment_plg_lunar set status='refunded' where order_id='$order->order_id'";
		} else {
				/* void payment if not already captured */
				$data     = array(
					'amount' => $response['transaction']['amount']
				);
				$response = \Lunar\Transaction::void( $txtid, $data );
				// update payment to voided
				$sql ="update #__hikashop_payment_plg_lunar set status='voided' where order_id='$order->order_id'";
		}

		$db->setQuery( $sql );
		$db->execute();

	}

	function lunarCaptured($order) {

		$db = JFactory::getDbo();

		$sql ="select * from #__hikashop_payment_plg_lunar where order_id='$order->order_id' limit 1";
		$db->setQuery($sql);
		$row = $db->loadObject();

		$txtid = $row->txnid;

		$params = $this->getLunarConfig();


		\Lunar\Client::setKey( $params->private_key );

		$response    = \Lunar\Transaction::fetch( $txtid );



		/* refund payment if already captured */
		if ( $response['transaction']['capturedAmount'] > 0 ) {
				// already captured
		} else {
			$data        = array(
				'amount'   => get_lunar_amount( $row->amount, $row->mode),
				'currency' => $row->mode
			);
			\Lunar\Client::setKey( $params->private_key );
			$response = \Lunar\Transaction::capture( $txtid, $data );

			if($response['transaction']['capturedAmount'] > 0):
				$sql ="update #__hikashop_payment_plg_lunar set status='captured' where order_id='$order->order_id'";
				$db->setQuery( $sql );
				$db->execute();
			endif;
		}


	}

	function getLunarConfig() {

		$db = JFactory::getDbo();

		$db->setQuery("select * from #__hikashop_payment where payment_type='lunar' ");
		$row = $db->loadObject();

		$params = hikashop_unserialize($row->payment_params);

		return $params;


	}



}
