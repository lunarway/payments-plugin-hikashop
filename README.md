# Joomla HikaShop plugin for Lunar

The software is provided “as is”, without warranty of any kind, express or implied, including but not limited to the warranties of merchantability, fitness for a particular purpose and noninfringement.


## Supported HikaShop versions

Hikashop version last tested on: 4.4.5 (& Joomla 4.0.5)

* The plugin has been tested with most versions of HikaShop at every iteration. We recommend using the latest version of HikaShop, but if that is not possible for some reason, test the plugin with your HikaShop version and it would probably function properly.


## Installation

  Once you have installed HikaShop on your Joomla setup, follow these simple steps:
  1. Signup at [lunar.app](https://lunar.app (it’s free)
  1. Create an account
  1. Create an app key for your Joomla website
  1. Upload the ```lunar.zip``` and ```lunarstatus.zip``` trough the Joomla Admin
  1. Activate both plugins through the 'Extensions' screen in Joomla.
  1. Under HikaShop payment methods create a new payment method and select Hikashop `Lunar Payment Plugin`.
  1. Insert the app key and your public key in the settings for the Lunar payment gateway you just created


## Updating settings

Under the Hikashop Lunar payment method settings, you can:
 * Update the payment method text in the payment gateways list
 * Update the payment method description in the payment gateways list
 * Update the title that shows up in the payment popup
 * Add public & app keys
 * Change the capture type (Instant/Delayed)

 ## How to capture / refund / void

These actions can be made from an order view, click Edit on order Main Information section and select the status indicated bellow from Order status field.

 1. Capture
 * In Instant mode, the orders are captured automatically
 * In delayed mode you can capture an order by moving the order to the `shipped` status.
 2. Refund
   * To refund an order move the order into `refunded` status.
 3. Void
   * To void an order you can move the order into `refunded` status. If its not captured it will get voided otherwise it will get refunded.

## Available features
1. Capture
   * Hikashop admin panel: full capture
   * Lunar admin panel: full/partial capture
2. Refund
   * Hikashop admin panel: full refund
   * Lunar admin panel: full/partial refund
3. Void
   * Hikashop admin panel: full void
   * Lunar admin panel: full/partial void
