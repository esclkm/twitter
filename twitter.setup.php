<?php
/* ====================
[BEGIN_COT_EXT]
Code=twitter
Name=Twitter Plugin
Description=twitter description
Version=1.0.0
Date=2011-april-02
Author=esclkm
Copyright=Copyright (c) esclkm
Notes=
Auth_guests=RW
Lock_guests=12345A
Auth_members=RW
Lock_members=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
intro=01:separator:::Register 
consumerKey=02:string:::consumerKey
consumerSecret=03:string:::consumerSecret
accessToken=04:string:::accessToken
accessTokenSecret=05:string:::accessTokenSecret
index=06:radio::1:Index Tweet
postfix=07:string:::postfix
mode=99:select:1,2,3:1:Mode 
autotweet=98:radio::1:autotweet
maxcount=95:string::5:Max count 
[END_COT_EXT_CONFIG]
==================== */
/**
 * Twitter Plugin for Cotonti
 * 
 * @package twitter
 * @version 1.1.0
 * @author esclkm
 * @copyright Copyright (c) esclkm 2008-2011
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

?>