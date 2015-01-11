<?php
/**
*
* @package SLIDING HEADLINE
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tlg\sliding_headline\migrations;
		
class version_1_0_0 extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
			$this->table_prefix . 'sliding_headline'	=> array(
			'COLUMNS'	=> array(
			'manset_id'		=> array('UINT', NULL, 'auto_increment'),
			'manset_name'	=> array('VCHAR:255', ''),
			'manset_pic'	=> array('MTEXT_UNI', ''),
			'manset_url'	=> array('MTEXT_UNI', ''),
			),
				'PRIMARY_KEY'		=> 'manset_id',
			),),		
		);
	}
	
	public function revert_schema()
	{
		return array(
			'drop_tables'    => array(
				$this->table_prefix . 'sliding_headline',
			),		
		);
	}
	
	
	public function update_data()
	{
		return array(
			array('config.add', array('manset_index', '1')),
			array('config.add', array('manset_height', '150')),
			array('config.add', array('manset_width', '102')),
			// Add the ACP module
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_SLIDING_HEADLINE')),
			array('module.add', array(
				'acp', 'ACP_SLIDING_HEADLINE', array(
					'module_basename'	=> '\tlg\sliding_headline\acp\sliding_headline_module',
					'modes'				=> array('sheadline','sheadline_config'),
				),
			)),
		);
	}
}