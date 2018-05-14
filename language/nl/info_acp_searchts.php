<?php
/**
 *
 * Search Topic Starter. An extension for the phpBB Forum Software package.
 * [Dutch]
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
	'STS_ATTACHMENTS'           => 'Zoek onderwerpen van auteur alleen met bijlagen',
	'STS_ATTACHMENTS_EXPLAIN'   => 'Dit zal de functie  “Zoek onderwerpen van gebruiker” limiteren tot onderwerpen waarvan het eerste bericht bijlagen bevat.',
));
