<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.tags,page.add.tags,food.edit.tags,food.add.tags
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

$t->assign('TWITTER_TEXT', cot_inputbox('text', 'rtwitter', $rwitter, array('size' => '56', 'maxlength' => '120')));

?>