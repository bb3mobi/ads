<?php
/**
*
* @package phpBB3 Advertisement Management
* @copyright (c) 2008 EXreaction, Lithium Studios
* @version $Id: listener.php 2015-07-06 13:45:17 $
* @port in phpBB3.1 BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace bb3mobi\ads\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \bb3mobi\ads\core\helper */
	protected $core;

	var $ads;

	public function __construct(
		\phpbb\template\template $template,
		\phpbb\config\config $config,
		\phpbb\user $user,
		\phpbb\controller\helper $helper,
		$core)
	{
		$this->template = $template;
		$this->config = $config;
		$this->user = $user;
		$this->helper = $helper;
		$this->core = $core;

	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'			=> 'load_language_on_setup',
			'core.page_header_after'	=> 'setup_ads',
			'core.page_footer'			=> 'my_ads',
			'core.permissions'			=> 'add_permission',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'bb3mobi/ads',
			'lang_set' => 'ads',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function setup_ads($event)
	{
		global $forum_id;

		if (!isset($this->config['ads_version']))
		{
			return;
		}

		if (!$this->config['ads_enable'])
		{
			return;
		}

		$forum_id = ($forum_id) ? $forum_id : request_var('f', 0);
		$this->ads = $this->core->get_ads($this->user->data['user_id'], $forum_id);

		if (sizeof($this->ads))
		{
			foreach ($this->ads as $position_id => $code)
			{
				$this->template->assign_vars(array(
					'ADS_ID_' . $position_id	=> $position_id,
					'ADS_' . $position_id		=> $code)
				);
			}
		}
	}

	public function my_ads()
	{
		if (sizeof($this->ads) || (isset($this->user->data['ad_owner']) && $this->user->data['ad_owner']))
		{
			global $phpbb_container;

			$context = $phpbb_container->get('template_context');
			$this->tpldata = $context->get_data_ref();

			$my_ads = '';
			if ($this->user->data['ad_owner'])
			{
				$u_my_ads = $this->helper->route("bb3mobi_controller_ads", array('action' => 'my'));
				$my_ads .= '<a href="' . $u_my_ads . '" class="button">' . $this->user->lang['MY_ADS'] . '</a>';
			}

			$my_ads .= (!$my_ads) ? '<br />' . $this->user->lang['ADVERTISEMENT_MANAGEMENT_CREDITS'] : '';
			if (!empty($this->tpldata['.'][0]['ADS_8']))
			{
				$this->tpldata['.'][0]['ADS_8'] .= '<br /><br />' . $my_ads;
			}
			else
			{
				$this->tpldata['.'][0]['ADS_8'] = $my_ads;
			}

			$this->template->assign_vars(array(
				'ADS_CLICK_FILE'	=> $this->helper->route('bb3mobi_controller_ads', array('action' => 'click')),
				'ADS_VIEW_FILE'		=> $this->helper->route('bb3mobi_controller_ads', array('action' => 'view')),
				)
			);
		}
	}
	
		/**
	 * Add permissions
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_ads'] = array('lang' => 'ACL_A_ADS', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}
