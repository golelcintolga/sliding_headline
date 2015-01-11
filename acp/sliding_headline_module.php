<?php
/**
*
* @package SLIDING HEADLINE
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
namespace tlg\sliding_headline\acp;

class sliding_headline_module
{
	var $u_action;
	var $new_config = array();

	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $cache;
		global $phpbb_root_path, $phpbb_admin_path, $table_prefix, $phpEx;

		add_form_key('acp_manset');

		switch ($mode)
		{
		   case 'sheadline':
				$this->title = $user->lang['ACP_HEADLINE'];
				$this->tpl_name = 'sliding_headline';
				$this->sheadline();
			break;
			
			case 'sheadline_config':
				$this->title = $user->lang['ACP_HEADLINE_CONFIG'];
				$this->tpl_name = 'sliding_headline';
				$this->sheadline_config();
			break;
		}
	}

	function sheadline()
	{
		global $config, $db, $user, $auth, $template, $cache, $u_action, $SID;
		global $phpbb_root_path, $phpbb_admin_path, $table_prefix, $phpEx;
		
		$action = request_var('action', '');
		$submit = (isset($_POST['submit'])) ? true : false;
		$mark	= request_var('mark', array(0));
		$manset_id	= request_var('id', 0);

		if (isset($_POST['add']))
		{
			$action = 'add';
		}
		
		$default_key = 'a';
		$sort_key = request_var('sk', $default_key);
		$sort_dir = request_var('sd', 'a');

		$error = array();
		
		if ($submit && !check_form_key('acp_manset'))
		{
			$error[] = $user->lang['FORM_INVALID'];
		}
		$manset_id = (int) $manset_id;
		switch ($action)
		{
			case 'delete':
				if ($manset_id || sizeof($mark))
				{
					if (confirm_box(true))
					{
						$sql = 'SELECT manset_name, manset_id 
							FROM ' . $table_prefix . 'sliding_headline 
							WHERE ' . $db->sql_in_set('manset_id', ($manset_id) ? array($manset_id) : $mark);
						$result = $db->sql_query($sql);

						$manset_name_ary = array();
						while ($row = $db->sql_fetchrow($result))
						{
							$manset_name_ary[] = (string) $row['manset_name'];
						}
						$db->sql_freeresult($result);

						$sql = 'DELETE FROM ' . $table_prefix . 'sliding_headline 
							WHERE ' . $db->sql_in_set('manset_id', ($manset_id) ? array($manset_id) : $mark);
						$db->sql_query($sql);

						add_log('admin', 'LOG_MANSET_SILINDI', implode(', ', $manset_name_ary));
						trigger_error($user->lang['MANSET_SILINDI'] . adm_back_link($this->u_action));
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'id'		=> $manset_id,
							'mark'		=> $mark,
							'action'	=> $action))
						);
					}
				}
			break;

			case 'edit':
			case 'add':

				$manset_row = array(
					'manset_name'			=> utf8_normalize_nfc(request_var('manset_name', '', true)),
					'manset_pic'			=> utf8_normalize_nfc(request_var('manset_pic', '', true)),
					'manset_url'			=> utf8_normalize_nfc(request_var('manset_url', '', true)),
					
				);

				if ($submit)
				{
				
					if (!$manset_row['manset_name'] || !$manset_row['manset_pic'] || !$manset_row['manset_url'])
					{
						if (!$manset_row['manset_name']){$error[] = $user->lang['ISIM_EKSIK'];}
						if (!$manset_row['manset_pic']){$error[] = $user->lang['RESIM_EKSIK'];}
						if (!$manset_row['manset_url']){$error[] = $user->lang['URL_EKSIK'];}
						$error[] = $user->lang['EKSIK_BILGI'];
					}
					if (!sizeof($error))
					{	
						if ($action == 'add')
						{
							$sql = 'INSERT INTO ' . $table_prefix . 'sliding_headline ' . $db->sql_build_array('INSERT', array(
								'manset_name'	=> (string) $manset_row['manset_name'],
								'manset_pic'	=> (string) $manset_row['manset_pic'],
								'manset_url'	=> (string) $manset_row['manset_url'],
							));
							$db->sql_query($sql);

							$log = 'EKLENDI';
						}
						else if ($manset_id)
						{
							$sql = 'SELECT *
								FROM ' . $table_prefix . "sliding_headline  
								WHERE manset_id = $manset_id";
							$result = $db->sql_query($sql);
							$row = $db->sql_fetchrow($result);
							$db->sql_freeresult($result);

							if (!$row)
							{
								trigger_error($user->lang['HATA'] . adm_back_link($this->u_action . "&amp;id=$manset_id&amp;action=$action"), E_USER_WARNING);
							}

							$sql = 'UPDATE ' . $table_prefix . 'sliding_headline SET ' . $db->sql_build_array('UPDATE', array(
								'manset_name'	=> (string) $manset_row['manset_name'],
								'manset_pic'	=> (string) $manset_row['manset_pic'],
								'manset_url'	=> (string) $manset_row['manset_url'],
							)) . " WHERE manset_id = $manset_id";
							$db->sql_query($sql);

							$log = 'GUNCELLENDI';
						}
							add_log('admin', 'LOG_MANSET_' . $log, $manset_row['manset_name']);
							trigger_error($user->lang['MANSET_' . $log] . adm_back_link($this->u_action));
					}
				}
				else if ($manset_id)
				{
					$sql = 'SELECT * 
						FROM ' . $table_prefix . "sliding_headline
						WHERE manset_id = $manset_id";
					$result = $db->sql_query($sql);
					$manset_row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					if (!$manset_row)
					{
						trigger_error($user->lang['HATA'] . adm_back_link($this->u_action . "&amp;id=$manset_id&amp;action=$action"), E_USER_WARNING);
					}
				}

				$l_title = ($action == 'edit') ? 'EDIT' : 'ADD';

				$template->assign_vars(array(
					'L_TITLE'			=> $user->lang['MOD_' . $l_title],
					'U_ACTION'			=> $this->u_action . "&amp;id=$manset_id&amp;action=$action",
					'U_BACK'			=> $this->u_action,
					'ERROR_MSG'			=> (sizeof($error)) ? implode('<br />', $error) : '',
					
					'MANSET_NAME'		=> $manset_row['manset_name'],
					'MANSET_PIC'		=> $manset_row['manset_pic'],
					'MANSET_URL'		=> $manset_row['manset_url'],

						
					'S_EDIT_MOD'		=> true,
					'S_MANSETLER'		=> true,
					'S_MANSET_SETTINGS'	=> false,
					'S_ERROR'			=> (sizeof($error)) ? true : false,
					)
				);

				return;

			break;
		}
		$s_options = '';
		$_options = array('delete' => 'DELETE');
		foreach ($_options as $value => $lang)
		{
			$s_options .= '<option value="' . $value . '">' . $user->lang[$lang] . '</option>';
		}

		$sort_key_sql = array('a' => 'manset_name');

		if (!isset($sort_key_sql[$sort_key]))
		{
			$sort_key = $default_key;
		}

		$sql = 'SELECT * 
			FROM ' . $table_prefix . 'sliding_headline 
			ORDER BY manset_name ASC ';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('manset', array(
				'MANSET_ID'		=> $row['manset_id'],
				'MANSET_NAME'	=> $row['manset_name'],

				'U_EDIT'		=> $this->u_action . "&amp;id={$row['manset_id']}&amp;action=edit",
				'U_DELETE'		=> $this->u_action . "&amp;id={$row['manset_id']}&amp;action=delete",
			));
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,

			'S_MOD_OPTIONS'		=> $s_options,
			'S_MANSETLER'		=> true,
			'S_MANSET_SETTINGS'	=> false,
		));		
	}
	function sheadline_config()
	{
		global $config, $template, $user;

	  	$submit 	= (isset($_POST['submit'])) ? true : false;

		if ($submit)
		{
			if (!check_form_key('acp_manset'))
			{
				trigger_error('FORM_INVALID');
			}
			set_config('manset_index', request_var('manset_index', 1));
			set_config('manset_height', request_var('manset_height', 102));
			set_config('manset_width', request_var('manset_width', 150));
			
			trigger_error($user->lang['AYARLAR_GUNCELLENDI'] . adm_back_link($this->u_action));
		}
		$template->assign_vars(array(
			'MANSET_INDEX'		=> $config['manset_index'],
			'MANSET_HEIGHT'		=> $config['manset_height'],
			'MANSET_WIDTH'		=> $config['manset_width'],
			
			'U_ACTION'			=> $this->u_action,
			
			'S_MANSETLER'		=> false,
			'S_MANSET_SETTINGS'	=> true,
		));
	}

}