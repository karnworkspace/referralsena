<br />
<b>Warning</b>:  session_save_path(): Cannot change save path when session is active in <b>/var/www/vhosts/sena.co.th/httpdocs/agent/includes/config.inc.php</b> on line <b>20</b><br />
<br />
<b>Warning</b>:  "continue" targeting switch is equivalent to "break". Did you mean to use "continue 2"? in <b>/var/www/vhosts/sena.co.th/httpdocs/agent/includes/classes/ia.core.mysqli.php</b> on line <b>828</b><br />
<?php
/*
 * Subrion Open Source CMS 4.2.1
 * Config file generated on 28 April 2020 03:24:13
 */

define('INTELLI_CONNECT', 'mysqli');
define('INTELLI_DBHOST', '203.146.107.98:3306');
define('INTELLI_DBUSER', 'sena_agent');
define('INTELLI_DBPASS', 'Sena_1775');
define('INTELLI_DBNAME', 'sena_agent');
define('INTELLI_DBPORT', '3306');
define('INTELLI_DBPREFIX', 'ag_');

define('IA_SALT', '#C9B9D562B2');

// debug mode: 0 - disabled, 1 - enabled
define('INTELLI_DEBUG', 0);

session_save_path('/var/www/vhosts/sena.co.th/httpdocs/agent/tmp');