SyntaxError: JSON.parse: unexpected character at line 1 column 1 of the JSON data

OK

<b>Warning</b>: fsockopen(): php_network_getaddresses: getaddrinfo failed: Name or service not known in <b>/var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc/system/library/mail.php</b> on line <b>167</b><b>Warning</b>: fsockopen(): unable to connect to :25 (php_network_getaddresses: getaddrinfo failed: Name or service not known) in <b>/var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc/system/library/mail.php</b> on line <b>167</b><br />
<b>Fatal error</b>:  Uncaught exception 'Exception' with message 'Error: php_network_getaddresses: getaddrinfo failed: Name or service not known (0)' in /var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc/system/library/mail.php:170
Stack trace:
#0 /var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc/catalog/model/checkout/order.php(823): Mail-&gt;send()
#1 [internal function]: ModelCheckoutOrder-&gt;addOrderHistory('1', '3', '', '1', '0')
#2 /var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc/system/engine/loader.php(178): call_user_func_array(Array, Array)
#3 [internal function]: Loader-&gt;{closure}(Array, Array)
#4 /var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc/system/engine/proxy.php(25): call_user_func_array(Object(Closure), Array)
#5 /var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc/catalog/controller/api/order.php(847): Proxy-&gt;__call('addOrderHistory', Array)
#6 /var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc in <b>/var/www/vhosts/u0304785.plsk.regruhosting.ru/httpdocs/kittishop.pw/oc/system/library/mail.php</b> on line <b>170</b><br />