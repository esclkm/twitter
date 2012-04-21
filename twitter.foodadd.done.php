<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=food.add.add.done,food.edit.update.done
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Twitter Plugin for Cotonti
 * 
 * @package twitter
 * @version 1.0.0
 * @author esclkm
 * @copyright Copyright (c) esclkm 2008-2011
 * @license BSD
 */

$rtwitter = cot_import('rtwitter', 'P', 'TXT');
require_once cot_langfile('twitter', 'plug');
if (empty($rtwitter) && ($cfg['plugin']['twitter']['autotweet'] && $m == 'add'))
{
	$rtwitter = $rfood['food_title'];
}
if (!empty($rtwitter))
{
	require_once $cfg['plugins_dir'].'/twitter/inc/twitter.class.php';
	require_once $cfg['plugins_dir'].'/twitter/inc/googl.class.php';
	$twitter = new Twitter($cfg['plugin']['twitter']['consumerKey'], $cfg['plugin']['twitter']['consumerSecret'], $cfg['plugin']['twitter']['accessToken'], $cfg['plugin']['twitter']['accessTokenSecret']);

	if ($twitter->authenticate())
	{
		$food_pageurl = (empty($rfood['food_alias'])) ? cot_url('food', 'id='.$rfood['food_id']) : cot_url('food', 'al='.$rfood['food_alias']);
		$food_pageurl = $cfg['mainurl']. '/'.$food_pageurl;
		$food_pageurl = GoogleURL::shortURL($food_pageurl);
		
		$twitter->send($rtwitter . ' '. $food_pageurl);
	}
}

?>