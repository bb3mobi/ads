<?php
/**
*
* @package phpBB3 Advertisement Management
* @copyright (c) 2008 EXreaction, Lithium Studios
* @version $Id: helper.php 2015-07-06 13:46:17 $
* @port in phpBB3.1 BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace bb3mobi\ads\core;

class helper
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	public function __construct(
		\phpbb\template\template $template,
		\phpbb\config\config $config,
		\phpbb\user $user,
		\phpbb\request\request_interface $request,
		\phpbb\db\driver\driver_interface $db,
		$table_prefix)
	{
		$this->template = $template;
		$this->config = $config;
		$this->user = $user;
		$this->request = $request;
		$this->db = $db;

		if (!defined('ADS_TABLE'))
		{
			define('ADS_TABLE',					$table_prefix . 'ads');
			define('ADS_FORUMS_TABLE',			$table_prefix . 'ads_forums');
			define('ADS_GROUPS_TABLE',			$table_prefix . 'ads_groups');
			define('ADS_IN_POSITIONS_TABLE',	$table_prefix . 'ads_in_pos');
			define('ADS_POSITIONS_TABLE',		$table_prefix . 'ads_positions');
		}
	}

	public function my()
	{
		// HAX (don't add to the view count every time this page is viewed)
		// It doesn't look good to the advertisers since this is the only (in a vanilla install) page that would add to the view count but not display them it is fine
		$this->config['ads_count_views'] = false;

		$this->template->assign_vars(array(
			'S_POSITION_LIST'	=> true,
			'S_AD_LIST'			=> true,
		));

		// Positions
		$positions = array();
		$sql = 'SELECT position_id, lang_key FROM ' . ADS_POSITIONS_TABLE . ' ORDER BY position_id ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$positions[$row['position_id']] = (isset($this->user->lang[$row['lang_key']])) ? $this->user->lang[$row['lang_key']] : $row['lang_key'];
		}
		$this->db->sql_freeresult($result);

		// Forums
		$forums = array();
		$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' ORDER BY forum_id ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$forums[$row['forum_id']] = $row['forum_name'];
		}
		$this->db->sql_freeresult($result);

		// Advertisements
		$ads = array();
		$sql = 'SELECT * FROM ' . ADS_TABLE . '
			WHERE ad_owner = ' . $this->user->data['user_id'] . '
			ORDER BY ad_enabled DESC, ad_time DESC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ads[$row['ad_id']] = $row;
			$ads[$row['ad_id']]['positions'] = array();
			$ads[$row['ad_id']]['forums'] = array();
		}
		$this->db->sql_freeresult($result);

		if (sizeof($ads))
		{
			$sql = 'SELECT * FROM ' . ADS_IN_POSITIONS_TABLE . '
				WHERE ' . $this->db->sql_in_set('ad_id', array_keys($ads));
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ads[$row['ad_id']]['positions'][] = $positions[$row['position_id']];
			}
			$this->db->sql_freeresult($result);

			$sql = 'SELECT * FROM ' . ADS_FORUMS_TABLE . '
				WHERE ' . $this->db->sql_in_set('ad_id', array_keys($ads));
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ads[$row['ad_id']]['forums'][] = $forums[$row['forum_id']];
			}
			$this->db->sql_freeresult($result);
		}

		foreach ($ads as $row)
		{
			$ads_in_positions = implode('<br />', $row['positions']);
			$ads_in_forums = implode('<br />', $row['forums']);

			$this->template->assign_block_vars('ads', array(
				'AD_ID'				=> $row['ad_id'],
				'AD_ENABLED'		=> ($row['ad_enabled']) ? $this->user->lang['TRUE'] : $this->user->lang['FALSE'],
				'AD_CODE'			=> $row['ad_code'],
				'AD_CODE_DISPLAY'	=> htmlspecialchars_decode($row['ad_code']),
				'AD_TIME'			=> date('d F Y', $row['ad_time']),
				'AD_TIME_END'		=> ($row['ad_time_end']) ? date('d F Y', $row['ad_time_end']) : 0,
				'AD_VIEW_LIMIT'		=> $row['ad_view_limit'],
				'AD_VIEWS'			=> $row['ad_views'],
				'AD_CLICK_LIMIT'	=> $row['ad_click_limit'],
				'AD_CLICKS'			=> ($row['ad_clicks']) ? $row['ad_clicks'] : $this->user->lang['0_OR_NA'],
				'AD_IN_POSITIONS'	=> $ads_in_positions,
				'AD_IN_FORUMS'		=> ($row['all_forums']) ? $this->user->lang['ALL_FORUMS'] : $ads_in_forums,
			));
		}

		page_header($this->user->lang['MY_ADS']);

		$this->template->set_filenames(array(
			'body'	=> '@bb3mobi_ads/acp_ads.html',
		));

		page_footer();
	}

	/**
	*  Get ads
	*
	* @param mixed $user_id
	* @param mixed $forum_id
	* @param bool $accurate_view_count true will enable the accurate view counts, false will disable them (disable when not within phpBB).
	*/
	public function get_ads($user_id = 1, $forum_id = 0, $accurate_view_count = true)
	{
		$user_id = (int) $user_id;
		$forum_id = (int) $forum_id;

		// A built in cron-like function for disabling ads after they reach their end date.  Runs once every hour
		if ($this->config['ads_last_cron'] < (time() - 3600))
		{
			$ads_to_disable = array();
			$sql = 'SELECT ad_id FROM ' . ADS_TABLE . '
				WHERE ad_enabled = 1
				AND ad_time_end > 0
				AND ad_time_end < ' . time();
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ads_to_disable[] = $row['ad_id'];
			}
			$this->db->sql_freeresult($result);

			if (sizeof($ads_to_disable))
			{
				$this->db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_enabled = 0 WHERE ' . $this->db->sql_in_set('ad_id', $ads_to_disable));
				$this->db->sql_query('UPDATE ' . ADS_IN_POSITIONS_TABLE . ' SET ad_enabled = 0 WHERE ' . $this->db->sql_in_set('ad_id', $ads_to_disable));
			}
			$this->config->set('ads_last_cron', time(), true);
		}

		// Set some variables up
		$ads = $ignore_ads = $forum_ads = $available_ads = $id_list = $return_list = array();

		if ($this->config['ads_rules_groups'])
		{
			$sql = 'SELECT a.ad_id FROM ' . ADS_GROUPS_TABLE . ' a, ' . USER_GROUP_TABLE . ' ug
				WHERE ug.user_pending = 0
				AND ug.user_id = ' . $user_id . '
				AND a.group_id = ug.group_id';
			$result = $this->db->sql_query($sql, 60); // Cache this data for 1 minute
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ignore_ads[] = $row['ad_id'];
			}
			$this->db->sql_freeresult($result);
		}

		if ($this->config['ads_rules_forums'] && $forum_id)
		{
			$sql = 'SELECT ad_id FROM ' . ADS_FORUMS_TABLE . '
				WHERE forum_id = ' . (int) $forum_id;
			$result = $this->db->sql_query($sql, 60); // Cache this data for 1 minute
			while ($row = $this->db->sql_fetchrow($result))
			{
				$forum_ads[] = $row['ad_id'];
			}
			$this->db->sql_freeresult($result);
		}

		$sql = 'SELECT ad_id, position_id, ad_priority FROM ' . ADS_IN_POSITIONS_TABLE . '
			WHERE ad_enabled = 1' .
			((sizeof($forum_ads)) ? ' AND (all_forums = 1 OR ' . $this->db->sql_in_set('ad_id', $forum_ads) . ')' : (($this->config['ads_rules_forums']) ? ' AND all_forums = 1' : '')) .
			((sizeof($ignore_ads)) ? ' AND ' . $this->db->sql_in_set('ad_id', $ignore_ads, true) : '') . '
			ORDER BY ad_priority DESC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			// A simple way to set Advertisement Priority
			for ($i = 0; $i < $row['ad_priority']; $i++)
			{
				if (!isset($available_ads[$row['position_id']]))
				{
					$available_ads[$row['position_id']] = array();
				}

				$available_ads[$row['position_id']][] = $row['ad_id'];
			}
		}
		$this->db->sql_freeresult($result);

		if (sizeof($available_ads))
		{
			foreach ($available_ads as $position_id => $ary)
			{
				// Prevent duplicate advertisements from showing up in multiple locations
				foreach ($ary as $key => $ad_id)
				{
					if (in_array($ad_id, $id_list) && sizeof($ary) > 1)
					{
						unset($ary[$key]);
					}
				}

				$rand_key = array_rand($ary);
				$id_list[] = $available_ads[$position_id] = $ary[$rand_key];
			}
			$id_list = array_unique($id_list);

			$sql = 'SELECT ad_id, ad_code, ad_views, ad_view_limit, ad_clicks, ad_click_limit FROM ' . ADS_TABLE . '
				WHERE ' . $this->db->sql_in_set('ad_id', $id_list);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$ads[$row['ad_id']] = $row;

				if ($row['ad_view_limit'] != 0 && ($row['ad_views'] + 1) >= $row['ad_view_limit'])
				{
					$this->db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_enabled = 0 WHERE ad_id = ' . $row['ad_id']);
					$this->db->sql_query('UPDATE ' . ADS_IN_POSITIONS_TABLE . ' SET ad_enabled = 0 WHERE ad_id = ' . $row['ad_id']);
				}
			}
			$this->db->sql_freeresult($result);

			foreach ($available_ads as $position_id => $ad_id)
			{
				$code = htmlspecialchars_decode($ads[$ad_id]['ad_code']);
				$code = ($this->config['ads_count_clicks']) ? str_replace(array('{COUNT_CLICK}', '{COUNT_CLICKS}'), ' onclick="countAdClick(' . $ad_id . ');"', $code) : $code;

				if ($accurate_view_count && $this->config['ads_accurate_views'])
				{
					$code = '<script type="text/javascript" >countAdView(' . $ad_id . ')</script>' . $code;
				}

				$return_list[$position_id] = $code;
			}

			if ($this->config['ads_count_views'] && !$this->config['ads_accurate_views'])
			{
				$this->db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_views = ad_views + 1 WHERE ' . $this->db->sql_in_set('ad_id', $id_list));
			}
		}

		return $return_list;
	}

	public function stats($action)
	{
		$ad_id = $this->request->variable('a', 0);

		if ($ad_id <= 0)
		{
			exit('0');
		}

		$sql = 'SELECT * FROM ' . ADS_TABLE . ' WHERE ad_id = ' . $ad_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row)
		{
			$upadate = false;
			if ($action == 'click')
			{
				$this->db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_clicks = ad_clicks + 1 WHERE ad_id = ' . $row['ad_id']);
				if ($row['ad_click_limit'] != 0 && ($row['ad_clicks'] + 1) >= $row['ad_click_limit'])
				{
					$upadate = true;
				}
			}
			else if ($action == 'view')
			{
				$this->db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_views = ad_views + 1 WHERE ad_id = ' . $row['ad_id']);
				if ($row['ad_view_limit'] != 0 && ($row['ad_views'] + 1) >= $row['ad_view_limit'])
				{
					$upadate = true;
				}
			}
			if ($upadate)
			{
				$this->db->sql_query('UPDATE ' . ADS_TABLE . ' SET ad_enabled = 0 WHERE ad_id = ' . $row['ad_id']);
				$this->db->sql_query('UPDATE ' . ADS_IN_POSITIONS_TABLE . ' SET ad_enabled = 0 WHERE ad_id = ' . $row['ad_id']);
			}
		}

		// Make sure the browser does not cache this
		header('Content-type: text/html; charset=UTF-8');
		header('Cache-Control: private, no-cache="set-cookie"');
		header('Expires: 0');
		header('Pragma: no-cache');

		garbage_collection();
		exit('1');
	}

	public function viewlink()
	{
		global $position_id, $forum_id, $user_id;
		/**
		* Send the following variables
		*
		* $position_id
		* $forum_id
		* $user_id
		*/
		$position_id = (!empty($position_id)) ? (int) $position_id : $this->request->variable('p', 0);
		$forum_id = (!empty($forum_id)) ? (int) $forum_id : $this->request->variable('f', 0);
		$user_id = (!empty($user_id)) ? (int) $user_id : $this->request->variable('u', 0);

		if (!$position_id)
		{
			exit;
		}

		$ads = $this->get_ads($user_id, $forum_id, false);

		if ($this->config['gzip_compress'])
		{
			if (@extension_loaded('zlib') && !headers_sent())
			{
				ob_start('ob_gzhandler');
			}
		}

		// application/xhtml+xml not used because of IE
		header('Content-type: text/html; charset=UTF-8');

		header('Cache-Control: private, no-cache="set-cookie"');
		header('Expires: 0');
		header('Pragma: no-cache');

		if (isset($ads[$position_id]))
		{
			$display = $this->request->variable('display', '');
			if ($display == 'js')
			{
				echo 'document.write(\'' . $ads[$position_id] . '\');';
			}
			else
			{
				echo $ads[$position_id];
			}
		}

		garbage_collection();

		exit_handler();
	}
}
