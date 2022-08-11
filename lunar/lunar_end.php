<?php
/**
 * @package	Lunar Payment Plugin for Hikashop
 * @author	lunar.app
 * @copyright	(C) 2022-2022 Lunar. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
$v = new JVersion();
$version = $v->getShortVersion();

$v2 = &hikashop_config();
$hikashop_version=$v2->get('version');

$lang = JFactory::getLanguage();
$locale = substr($lang->getTag(),0,2);

?>
<div class="hikashop_lunar_end" id="hikashop_lunar_end">
	<div class="lunar" id="lunar_paying">
		<h3><?php echo Jtext::_('HIKASHOP_ORDER_CREATED');?></h3>
		<p><?php echo Jtext::_('HIKASHOP_ORDER_CREATED_INFO');?></p>
		<p><a class="btn btn-default" id="PayNow"><?php echo Jtext::_('HIKASHOP_ORDER_CREATED_BUTTON');?></a></p>
		<div id="token">
		<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
	<div class="lunar" id="lunar_paid" style="display: none;">
		<h3><?php echo Jtext::_('HIKASHOP_ORDER_COMPLETED');?></h3>
		<p><a href="<?php echo $this->vars["history_url"];?>"><?php echo Jtext::_('HIKASHOP_ORDER_HISTORY');?></a></p>
	</div>
</div>

<script src="https://sdk.paylike.io/a.js"></script>
<script type="text/javascript">

	jQuery(document).ready(function(){
		var lunar = Paylike({key: '<?php echo $this->vars["public_key"];?>'});
		function pay(){
			window.lunarAmount = '<?php echo $this->vars["lunar_amount"];?>';
			lunar.pay({
				// locale: 'da',  // pin popup to a locale
				title: '<?php echo $this->vars["sitename"];?>',
				test: (1 == <?php echo $this->vars["test_mode"];?>) ? (true) : (false),
				amount: {
					currency: '<?php echo $this->vars["currency"];?>',
					exponent: (<?php echo $this->vars["exponent"];?>),
					value: (<?php echo $this->vars["lunar_amount"];?>)
				},
				locale: '<?php echo $locale;?>',
				// saved on transaction for retrieval from dashboard or API
				custom: {
					email: '<?php echo $this->vars["customer_email"];?>',
					orderId: '<?php echo $this->vars["order_id"];?>',
					// arrays are fine
					products: [
						// nested objects will do
						<?php echo $this->vars["custom"];?>
						],
					customer: {
                            name: '<?php echo $this->vars["customer_name"];?>',
                            email: '<?php echo $this->vars["customer_email"];?>',
                            phoneNo: '<?php echo $this->vars["customer_phone"];?>',
                            address: '<?php echo $this->vars["customer_address"];?>',
                            IP: '<?php echo $this->vars["customer_ip"];?>'
                            },
                    platform: {
                            name: 'Joomla',
                            version: '<?php echo $version;?>'
							},
					ecommerce: {
							name: 'Hikashop',
							version: '<?php echo $hikashop_version;?>'
							},
					lunarPluginVersion: {
							version: '<?php echo $this->vars["lunar_plugin_version"];?>'
							},
					}

			}, function( err, res ){
				if (err)
					return console.log(err);

				//console.log(res);
				savingTransaction(res.transaction.id);

			});
		}

		jQuery("#PayNow").on("click",function(){
			pay();
		});

		pay();

		function savingTransaction(transaction_id) {

			var id='<?php echo $this->vars["order_id"];?>';
			var number='<?php echo $this->vars["order_number"];?>';
			var amount='<?php echo $this->vars["amount"];?>';
			var method_id='<?php echo $this->vars["method_id"];?>';
			var token = jQuery("#token input").attr("name");
			var currency = '<?php echo $this->vars["currency"];?>';
			var url = '<?php echo HIKASHOP_LIVE.'index.php?option=com_hikashop&ctrl=checkout&task=notify&notif_payment=lunar&tmpl=component&act=savingTransaction';?>';
			jQuery.ajax({
				type: "POST",
				url: url,
				data: {'order_id':id,'order_number':number,'txnid':transaction_id,'amount':amount,'method_id':method_id,token:1,'currency':currency},
				success:function(){
					jQuery("#lunar_paying").hide();
					jQuery("#lunar_paid").show();
				}
			})

		}


	});

</script>