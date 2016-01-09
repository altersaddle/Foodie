<?php
/*
***************************************************************************
* CrisoftRicette is a GPL licensed free software sofware written
* by Lorenzo Pulici, Milano, Italy (Earth)
* You can read license terms reading COPYING file included in this
* package.
* In case this file is missing you can obtain license terms through WWW
* pointing your web browser at http://www.gnu.org or http:///www.fsf.org
* If you can't browse the web please write an email to the software author
* at snowdog@tiscali.it
****************************************************************************
*/
session_name("crisoftricette");
session_start();
require(dirname(__FILE__)."/crisoftlib.php");
$trans_sid = cs_IsTransSid();
cs_DestroyAdmin();
if ($trans_sid == 0)
{
	header ("Location: index.php?". SID);
}
if ($trans_sid == 1)
{
	header ("Location: index.php");
}
?>
