<?php

/**
 *
 * Magic OGP - add blacklist option
 *
 * @copyright (c) 2016 Ger Bruinsma
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace ger\searchts\migrations;

use phpbb\db\migration\container_aware_migration;

class v1 extends container_aware_migration
{

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('ger_sts_attachments', 0)),
		);
	}
}