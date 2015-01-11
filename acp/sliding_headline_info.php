<?php
/**
*
* @package SLIDING HEADLINE
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tlg\sliding_headline\acp;

class sliding_headline_info
{
	function module()
	{
		return array(
			'filename'	=> '\tlg\sliding_headline\acp\sliding_headline_module',
			'title'		=> 'ACP_SLIDING_HEADLINE',
			'modes'		=> array(
				'sheadline'			=> array('title' => 'ACP_HEADLINE', 'auth' => 'ext_tlg/sliding_headline && acl_a_board', 'cat' => array('ACP_SLIDING_HEADLINE')),
				'sheadline_config'	=> array('title' => 'ACP_HEADLINE_CONFIG', 'auth' => 'ext_tlg/sliding_headline && acl_a_board', 'cat' => array('ACP_SLIDING_HEADLINE')),
			),
		);
	}
}
