<?php
/**
 *
 * Search Topic Starter. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Ger
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
        'STS_SEARCH_USER_TOPICS'		=> 'Search user’s topics',
        'STS_TOPICS_STARTED'			=> 'Total topics',
));
