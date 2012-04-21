<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=index.tags
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

if (!$twitterchanel && $cfg['plugin']['twitter']['index'])
{
	require_once cot_langfile('twitter', 'plug');
	require_once $cfg['plugins_dir'].'/twitter/inc/twitter.class.php';
	$twitter = new Twitter($cfg['plugin']['twitter']['consumerKey'], $cfg['plugin']['twitter']['consumerSecret'], $cfg['plugin']['twitter']['accessToken'], $cfg['plugin']['twitter']['accessTokenSecret']);

	if ($twitter->authenticate())
	{
		$t_tw = new XTemplate(cot_tplfile('twitter', 'plug'));
		//	$twitter->send('I am fine today.');
		if ($cfg['plugin']['twitter']['mode'] == 3)
		{
			$channel = $twitter->load(Twitter::REPLIES);
		}
		if ($cfg['plugin']['twitter']['mode'] == 2)
		{
			$channel = $twitter->load(Twitter::ME_AND_FRIENDS);
		}
		else
		{
			$channel = $twitter->load(Twitter::ME);
		}
		$ii = 0;
		foreach ($channel->status as $status)
		{
			$ii++;
			$t_tw->assign(array(
				'TWITTER_ROW_TEXT' => Twitter::clickable($status->text),
				'TWITTER_ROW_NUM' => $ii,
				'TWITTER_ROW_DATESTAMP' => strtotime($status->created_at),
				'TWITTER_ROW_USER' => $status->user->name
			));
			$t_tw->parse('MAIN.ROW');
			if((int)$cfg['plugin']['twitter']['maxcount'] > 0 && $ii >= (int)$cfg['plugin']['twitter']['maxcount'])
			{
				break;
			}
		}
		if ($ii == 0)
		{
			$t_tw->parse('MAIN.NOROW');
		}
		$t_tw->parse('MAIN');
		$twitterchanel = $t_tw->text('MAIN');
		$cache && $cache->db->store('twitterchanel', $twitterchanel, 'system', 3600);
	}
}
$t->assign('TWITTER', $twitterchanel);
?>