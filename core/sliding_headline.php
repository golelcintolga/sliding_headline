<?php

/**
*
* @package SLIDING HEADLINE
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tlg\sliding_headline\core;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

class sliding_headline
{
	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\cache\service */
	protected $cache;
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	/** @var \phpbb\template\template */
	protected $template;
	/** @var string phpBB root path */
	protected $root_path;
	/** @var string PHP extension */
	protected $phpEx;

	public function __construct(\phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, $root_path, $phpEx)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->template = $template;
		$this->root_path = $root_path;
		$this->phpEx = $phpEx;
	}
	public function display_manset($tpl_loopname = 'manset')
	{
			if (!isset($this->config['manset_index']) || !$this->config['manset_index'])
		{
			return;
		}
		global /*$config, $db,*/ $table_prefix;/*, $phpEx;*/
		
			$sql = 'SELECT manset_id, manset_name, manset_pic, manset_url
			FROM ' . $table_prefix . 'sliding_headline
			ORDER BY manset_id DESC';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result)) {
			$manset_url = htmlspecialchars_decode($row['manset_url']);

			$yeni_genislik = $this->config['manset_height'] / 3 * 2;
			$yeni_genislik = round($yeni_genislik,0);

			$this->template->assign_block_vars('manset',array(
					'MANSET_ID'			=> $row['manset_id'],
					'MANSET_NAME'		=> $row['manset_name'],
					'MANSET_PIC'		=> $row['manset_pic'],
					'MANSET_URL'		=> $manset_url,
					'MANSET_LINK'		=> '<a href="'.$manset_url.'" target="_blank" style="height:'.$this->config['manset_height'].'px; width:'.$yeni_genislik.'px"><img src="'.$row['manset_pic'].'" height="'.$this->config['manset_height'].'" width="'.$yeni_genislik.'" /></a>',
					'MANSET_HEIGHT'		=> $this->config['manset_height'],
					'MANSET_WIDTH'		=> $this->config['manset_width'],
					'N_MANSET_WIDTH'	=> $yeni_genislik,
			));
			}$this->db->sql_freeresult($result);

			$this->template->assign_vars(array(
			strtoupper($tpl_loopname) . '_DISPLAY' => true,
		));
	}
}	