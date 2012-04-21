<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=page.add.add.done,page.edit.update.done
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
	$rtwitter = $rpage['page_title'];
}
if (!empty($rtwitter))
{
	global $rpage;
	$page_pageurl = (empty($rpage['page_alias'])) ? cot_url('page', 'id='.$id, '', true) : cot_url('page', 'al='.$rpage['page_alias'], '', true);		
	$page_pageurl = $cfg['mainurl']. '/'.$page_pageurl;
	require_once $cfg['plugins_dir'].'/twitter/inc/twitter.class.php';
	require_once $cfg['plugins_dir'].'/twitter/inc/googl.class.php';
	$twitter = new Twitter($cfg['plugin']['twitter']['consumerKey'], $cfg['plugin']['twitter']['consumerSecret'], $cfg['plugin']['twitter']['accessToken'], $cfg['plugin']['twitter']['accessTokenSecret']);

	if ($twitter->authenticate())
	{

		$page_pageurl = GoogleURL::shortURL($page_pageurl);
		$twitter->send($rtwitter . ' '. $page_pageurl . ' '. $cfg['plugin']['twitter']['postfix']);
	}
}

?>