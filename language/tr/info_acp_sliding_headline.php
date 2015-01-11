<?php
/** 
*
* This file is part of the phpBB Forum Software package.
*
* @copyright (c) phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* For full copyright and license information, please see
* the docs/CREDITS.txt file.
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
// 
// Some characters you may want to copy&paste: 
// ’ » “ ” … 
// 

$lang = array_merge($lang, array(
    'ACP_SLIDING_HEADLINE'	=> 'Manşet',
	'ACP_HEADLINE'			=> 'Manşetler',
	'ACP_HEADLINE_CONFIG'	=> 'Manşet ayarları',
	'MANSET_EXPLAIN'		=> 'Forum ana sayfasında, sağa ve sola hareket eden resimli konu bağlantıları eklemenizi sağlar.',

    'EKSIK_BILGI'	=> 'Bilgiler Eksik Lütfen Tamamlayınız',
	'ISIM_EKSIK'	=> 'Manşet İsmini Girmediniz!',
	'RESIM_EKSIK'	=> 'Manşet Resmini Girmediniz!',
	'URL_EKSIK'		=> 'Manşet Bağlantı Adresini Girmediniz!',
	'HATA'			=> 'Hata Oluştu.',
	'MANSET_EKLENDI'=> 'Yeni Bir Manşet Eklendiniz.',
	'MANSET_SILINDI'=> 'Manşeti Silindiniz.',
	'MANSET_GUNCELLENDI'=> 'Manşeti Güncellendiniz.',
    'AYARLAR_GUNCELLENDI'=>'Ayarlar Güncellendi.',
	
	'MANSET_EKLE'		=> 'Manşet ekle',
	'MANSET_NAME'		=> 'Manşet ismi',
    'MANSET_ID'			=> 'Manşet numarası',
    'MANSET_PIC'		=> 'Manşet resmi',
	'MANSET_PIC_EXPLAIN'=> 'Gösterilecek resmin konumunu giriniz. <br /><br />Örnek : http://siteismi.com/resim.jpg',
	'MANSET_URL'		=> 'Manşet URL adresi',
	'MANSET_URL_EXPLAIN'=> 'Resime tıklandığında gidilecek olan adresi giriniz. <br /><br />Örnek : http://siteismi.com',
	
	'MANSET_ENABLE'		=> 'Manşet Durumu',
	'MANSET_MAX_SIZE'	=> 'Manşet Resiminin Boyutları',
	'MANSET_MAX_SIZE_EXPLAIN'=>'Piksel cinsinden Yükseklik. <strong>Not:</strong> Genişlik otomatik ayarlanacaktır.',
	
	'MOD_ADD'			=> 'Manşet ekle',
	'MOD_EDIT'			=> 'Manşet düzenle',
	
	'LOG_MANSET_EKLENDI'				=> '<strong>Manşet Eklendi</strong><br />» %s',
	'LOG_MANSET_SILINDI'				=> '<strong>Manşet Silindi</strong><br />» %s',
	'LOG_MANSET_GUNCELLENDI'			=> '<strong>Manşet Güncellendi</strong><br />» %s',
));
