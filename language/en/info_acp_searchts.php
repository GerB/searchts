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
	'STS_ATTACHMENTS'           => 'Search topics started by author only for attachments',
	'STS_ATTACHMENTS_EXPLAIN'   => 'This will limit the “Search user’s topics” function to look for topics started by the author that have attachements in the first post.',
));
