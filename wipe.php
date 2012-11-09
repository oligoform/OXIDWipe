<?php
/* OXID Core */
ob_implicit_flush(true);
$sOxidConfigDir = dirname(__FILE__).'/';

function getShopBasePath() {
    global $sOxidConfigDir;
    return $sOxidConfigDir . "/";
}
require_once(getShopBasePath(). "core/oxfunctions.php");
require_once(getShopBasePath(). "core/oxsupercfg.php");
require_once(getShopBasePath(). "core/oxutilsfile.php");
require_once(getShopBasePath(). "core/oxconfig.php");
require_once(getShopBasePath(). "core/oxsession.php");
require_once(getShopBasePath() ."core/adodblite/adodb.inc.php");

oxSession::getInstance()->start();

/* Styles/Scripts */
echo '<style type="text/css">
body, html { margin:0;padding:5px 7px 20px;background-color:#000000;font-size:12px;font-family:Monaco, monospace;white-space:pre; }
h1, h2 { color:#FFFFFF; }
div { color:#FFFFFF; }
span.title { font-weight:bold; }
</style>';

echo '
<script type="text/javascript">
  var x = null;
  function moveWin()
  {  
    window.scroll(0,1000000);
    x = setTimeout(\'moveWin();\',200);
  }
  moveWin();
</script>';

/* Output */
echo '<body>';
echo '<h1>Wipe</h1>';

echo '<div class="articles">';
echo '<h2>Artikel</h2>';
$oDb = oxDb::getDb( oxDb::FETCH_MODE_ASSOC );
$sQ = "select oxid, oxartnum, oxtitle from oxarticles order by oxtitle";
$oRs = $oDb->select( $sQ );
if ( $oRs != false && $oRs->recordCount() > 0 ) {
    while (!$oRs->EOF) {
        $art = oxNew('oxarticle');
        $art->load($oRs->fields['oxid']);
        echo $oRs->fields['oxid']." - ".$oRs->fields['oxartnum'];
        if ($oRs->fields['oxtitle'] != '') {
            echo " - <span class=\"title\">".$oRs->fields['oxtitle']."</span>";
        }
        echo "\n";
        $art->delete();
        $oRs->moveNext();
    }
}
echo '</div>';


echo '<div class="categories">';
echo '<h2>Kategorien</h2>';
$oDb = oxDb::getDb( oxDb::FETCH_MODE_ASSOC );
$sQ = "select oxid, oxtitle from oxcategories order by oxleft desc";
$oRs = $oDb->select( $sQ );
if ( $oRs != false && $oRs->recordCount() > 0 ) {
    while (!$oRs->EOF) {
        $cat = oxNew('oxcategory');
        $cat->load($oRs->fields['oxid']);
        echo $oRs->fields['oxid'];
        echo " - <span class=\"title\">".$oRs->fields['oxtitle']."</span>";
        echo "\n";
        $cat->delete();
        $oRs->moveNext();
    }
}
echo '</div>';


echo '<div class="orders">';
echo '<h2>Bestellungen</h2>';
$oDb = oxDb::getDb( oxDb::FETCH_MODE_ASSOC );
$sQ = "select oxid, oxordernr, oxorderdate from oxorder order by oxordernr";
$oRs = $oDb->select( $sQ );
if ( $oRs != false && $oRs->recordCount() > 0 ) {
    while (!$oRs->EOF) {
        $order = oxNew('oxorder');
        $order->load($oRs->fields['oxid']);
        echo $oRs->fields['oxid']." - ".$oRs->fields['oxordernr'];
        echo " - <span class=\"title\">".$oRs->fields['oxorderdate']."</span>";
        echo "\n";
        $order->delete();
        $oRs->moveNext();
    }
}
echo '</div>';


echo '<div class="users">';
echo '<h2>Benutzer</h2>';
$oDb = oxDb::getDb( oxDb::FETCH_MODE_ASSOC );
$sQ = "select oxid, oxcustnr, oxusername from oxuser WHERE oxid <> \"oxdefaultadmin\" order by oxcustnr";
$oRs = $oDb->select( $sQ );
if ( $oRs != false && $oRs->recordCount() > 0 ) {
    while (!$oRs->EOF) {
        $user = oxNew('oxuser');
        $user->load($oRs->fields['oxid']);
        echo $oRs->fields['oxid']." - ".$oRs->fields['oxcustnr'];
        echo " - <span class=\"title\">".$oRs->fields['oxusername']."</span>";
        echo "\n";
        $user->delete();
        $oRs->moveNext();
    }
}
echo '</div>';


echo '
<script type="text/javascript">
setTimeout(function(){
    clearTimeout(x);
}, 2000);
</script>';

echo '</body>';
?>