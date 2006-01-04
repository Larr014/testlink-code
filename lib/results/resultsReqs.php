<?php
/** 
 * TestLink Open Source Project - http://testlink.sourceforge.net/
 * This script is distributed under the GNU General Public License 2 or later. 
 *  
 * @filesource $RCSfile: resultsReqs.php,v $
 * @version $Revision: 1.3 $
 * @modified $Date: 2006/01/04 11:29:33 $ by $Author: franciscom $
 * @author Martin Havlat
 * 
 * Report requirement based results
 *
 * 20060104 - fm - BUGID 0000311: Requirements based Report shows errors 
 *
 * 
 */
////////////////////////////////////////////////////////////////////////////////

require_once("../../config.inc.php");
require_once("common.php");
require_once('requirements.inc.php');
require_once('results.inc.php');

// init page 
testlinkInitPage();

$idSRS = isset($_GET['idSRS']) ? strings_stripSlashes($_GET['idSRS']) : null;
$prodID = isset($_SESSION['productID']) ? $_SESSION['productID'] : 0;

//get list of available Req Specification
$arrReqSpec = getOptionReqSpec($prodID);

//set the first ReqSpec if not defined via $_GET
if (!$idSRS && count($arrReqSpec)) {
	reset($arrReqSpec);
	$idSRS = key($arrReqSpec);
	tLog('Set a first available SRS ID: ' . $idSRS);
}

// collect REQ data
// 20060104 - fm - 
// BUGID 0000311: Requirements based Report shows errors 
//                when no SRS document is associated with Product
$arrCoverage = null;
$arrMetrics =  null;
if( !is_null($idSRS))
{
	$arrCoverage = getReqCoverage_testPlan($idSRS, $_SESSION['testPlanId']);
	$arrMetrics = getReqMetrics_testPlan($idSRS, $_SESSION['testPlanId']);
}

$smarty = new TLSmarty;
$smarty->assign('arrMetrics', $arrMetrics);
$smarty->assign('arrCoverage', $arrCoverage);
$smarty->assign('arrReqSpec', $arrReqSpec);
$smarty->assign('selectedReqSpec', $idSRS);
$smarty->display('resultsReqs.tpl');
?>
