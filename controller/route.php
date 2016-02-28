<?php
/**
*
* @package phpBB3 Advertisement Management
* @copyright (c) 2008 EXreaction, Lithium Studios
* @version $Id: route.php 2015-07-06 13:48:19 $
* @port in phpBB3.1 BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace bb3mobi\ads\controller;

class route
{
	/** @var \bb3mobi\ads\core\helper */
	protected $core;

	public function __construct($core)
	{
		$this->core = $core;
	}

	public function route($action)
	{
		switch ($action)
		{
			case 'click':
			case 'view':
				/* Counter update stats */
				$this->core->stats($action);
			break;

			case 'position':
				/* Notes:
				*  Accurate ad views does not work when linking to this file to show the ads.
				*  The URL should look something like:
				*   http://bb3.mobi/ads/position?p=position_id&f=forum_id&u=user_id
				*  The Javascript code should look like this:
				*	<script src="http://bb3.mobi/ads/position?display=js&p=position_id&f=forum_id&u=user_id"></script>
				*
				* Be warned that this won't work with certain advertisements (like ones that already output via javascript such as Adsense).
				*/
				$this->core->viewlink();
			break;

			case 'my':
				$this->core->my();
			break;
		}
	}
}
