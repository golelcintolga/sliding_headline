<?php
/**
*
* @package SLIDING HEADLINE
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tlg\sliding_headline\event;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/* @var \tlg\sliding_headline\core\sliding_headline */
	protected $sh_functions;

	public function __construct(\tlg\sliding_headline\core\sliding_headline $functions)
	{
		$this->sh_functions = $functions;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'           => 'manset_index',
		);
	}

	public function manset_index()
	{
		$this->sh_functions->display_manset('manset', true);
	}
}
