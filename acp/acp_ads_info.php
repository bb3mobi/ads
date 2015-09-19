<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id: acp_ads.php 61 2008-09-15 19:43:45Z exreaction@gmail.com $
* @copyright (c) 2008 EXreaction, Lithium Studios
* @port in phpBB3.1 BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace bb3mobi\ads\acp;

/**
* @package module_install
*/
class acp_ads_info
{
	function module()
	{
		return array(
			'filename'	=> '\bb3mobi\ads\acp\acp_ads',
			'title'		=> 'ACP_ADVERTISEMENT_MANAGEMENT',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'default'		=> array('title' => 'ACP_ADVERTISEMENT_MANAGEMENT', 'auth' => 'ext_bb3mobi/ads && acl_a_ads', 'cat' => array('ACP_BOARD_CONFIGURATION')),
			),
		);
	}
}
