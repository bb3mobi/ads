<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id$
* @copyright (c) 2008 EXreaction, Lithium Studios
* @port in phpBB3.1.x (c) 2015 Anvar, BB3.Mobi
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace bb3mobi\ads\migrations;

class v_1_1_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['ads_version']) && version_compare($this->config['ads_version'], '1.1.0', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	/**
	* Add the phpbb_ads table schema to the database:
	*
	* @return array Array of table schema
	* @access public
	*/
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'ads'	=> array(
					'COLUMNS'		=> array(
						'ad_id'				=> array('UINT:11', null, 'auto_increment'),
						'ad_name'			=> array('VCHAR', ''),
						'ad_code'			=> array('TEXT', ''),
						'ad_views'			=> array('BINT', 0),
						'ad_priority'		=> array('TINT:1', 5),
						'ad_enabled'		=> array('BOOL', 1),
						'all_forums'		=> array('BOOL', 0),
						'ad_clicks'			=> array('BINT', 0),
						'ad_note'			=> array('MTEXT_UNI', ''),
						'ad_time'			=> array('TIMESTAMP', 0),
						'ad_time_end'		=> array('TIMESTAMP', 0),
						'ad_view_limit'		=> array('BINT', 0),
						'ad_click_limit'	=> array('BINT', 0),
						'ad_owner'			=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'ad_id',
					'KEYS'		=> array(
						'ad_priority'	=> array('INDEX', array('ad_priority')),
						'ad_enabled'	=> array('INDEX', array('ad_enabled')),
						'ad_owner'		=> array('INDEX', array('ad_owner')),
					),
				),
				$this->table_prefix . 'ads_forums'	=> array(
					'COLUMNS'		=> array(
						'ad_id'		=> array('UINT', 0),
						'forum_id'	=> array('UINT', 0),
					),
					'KEYS'	=> array(
						'ad_forum'	=> array('INDEX', array('ad_id', 'forum_id')),
					),
				),
				$this->table_prefix . 'ads_groups'	=> array(
					'COLUMNS'		=> array(
						'ad_id'			=> array('UINT', 0),
						'group_id'		=> array('UINT', 0),
					),
					'KEYS'			=> array(
						'ad_group'		=> array('INDEX', array('ad_id', 'group_id')),
					),
				),
				$this->table_prefix . 'ads_in_pos'	=> array(
					'COLUMNS'		=> array(
						'ad_id'			=> array('UINT', 0),
						'position_id'	=> array('UINT', 0),
						'ad_priority'	=> array('TINT:1', 5),
						'ad_enabled'	=> array('BOOL', 1),
						'all_forums'	=> array('BOOL', 0),
					),
					'KEYS'			=> array(
						'ad_position'	=> array('INDEX', array('ad_id', 'position_id')),
						'ad_priority'	=> array('INDEX', 'ad_priority'),
						'ad_enabled'	=> array('INDEX', 'ad_enabled'),
						'all_forums'	=> array('INDEX', 'all_forums'),
					),
				),
				$this->table_prefix . 'ads_positions'	=> array(
					'COLUMNS'		=> array(
						'position_id'	=> array('UINT', null, 'auto_increment'),
						'lang_key'		=> array('TEXT_UNI', ''),
					),
					'PRIMARY_KEY'	=> 'position_id',
				),
			),
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'ad_owner'	=> array('BOOL', 0),
				),
			),
		);
	}

	/**
	* Drop the phpbb_ads table schema from the database
	*
	* @return array Array of table schema
	* @access public
	*/
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'ads',
				$this->table_prefix . 'ads_forums',
				$this->table_prefix . 'ads_groups',
				$this->table_prefix . 'ads_in_pos',
				$this->table_prefix . 'ads_positions',
			),
		);
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('ads_enable', '1')),
			array('config.add', array('ads_rules_groups', '1')),
			array('config.add', array('ads_rules_forums', '1')),
			array('config.add', array('ads_count_clicks', '1')),
			array('config.add', array('ads_count_views', '1')),
			array('config.add', array('ads_accurate_views', '0')),
			array('config.add', array('ads_group', '0')),
			array('config.add', array('ads_last_cron', '0')),

			// Current version
			array('config.add', array('ads_version', '1.1.0')),

			// Add permission
			array('permission.add', array('a_ads', true)),

			// Set permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_ads')),

			// Add ACP modules
			array('module.add', array('acp', 'ACP_BOARD_CONFIGURATION', array(
				'module_basename'	=> '\bb3mobi\ads\acp\acp_ads_module',
				'module_langname'	=> 'ACP_ADVERTISEMENT_MANAGEMENT',
				'module_mode'		=> 'default',
				'module_auth'		=> 'ext_bb3mobi/ads && acl_a_ads',
			))),

			array('custom', array(array(&$this, 'ads_install'))),
		);
	}

	public function revert_data()
	{
		return array(
			// Remove configs
			array('config.remove', array('ads_enable')),
			array('config.remove', array('ads_rules_groups')),
			array('config.remove', array('ads_rules_forums')),
			array('config.remove', array('ads_count_clicks')),
			array('config.remove', array('ads_count_views')),
			array('config.remove', array('ads_accurate_views')),
			array('config.remove', array('ads_group')),
			array('config.remove', array('ads_last_cron')),

			// Remove version
			array('config.remove', array('ads_version')),

			// Remove permission
			array('permission.remove', array('a_ads')),

			// Remove from ACP modules
			array('module.remove', array('acp', 'ACP_ADVERTISEMENT_MANAGEMENT')),
		);
	}

	public function ads_install()
	{
		// Insert the default positions
		$positions = array(
			'ABOVE_HEADER',
			'BELOW_HEADER',
			'ABOVE_POSTS',
			'BELOW_POSTS',
			'AFTER_FIRST_POST',
			'AFTER_EVERY_POST',
			'ABOVE_FOOTER',
			'BELOW_FOOTER',
			'SIDEBAR_LEFT',
			'SIDEBAR_RIGHT',
			'EXTERNAL_BLOCK'
		);

		foreach ($positions as $position)
		{
			$this->db->sql_query('INSERT INTO ' . $this->table_prefix . 'ads_positions ' . $this->db->sql_build_array('INSERT', array('lang_key' => $position)));
		}
	}
}
