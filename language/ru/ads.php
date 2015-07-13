<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id: ads.php 92 2009-11-02 16:26:43Z exreaction@gmail.com $
* @copyright (c) 2008 EXreaction, Lithium Studios
* @port in phpBB3.1 BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* Translation by Serhij http://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1189655
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
	'ADVERTISEMENT_MANAGEMENT_CREDITS'		=> '<a href="http://bb3.mobi/">Advertisements</a> by <a href="http://www.lithiumstudios.org/">Advertisement Management</a>',
	'MY_ADS'								=> 'Менеджер рекламы',

	// Default Positions
	'ABOVE_FOOTER'			=> 'Над нижним колонтитулом',
	'ABOVE_HEADER'			=> 'Над верхним колонитулом',
	'ABOVE_POSTS'			=> 'Над сообщениями',
	'AFTER_EVERY_POST'		=> 'После каждого сообщения за исключением первого',
	'AFTER_FIRST_POST'		=> 'После первого сообщения',
	'BELOW_FOOTER'			=> 'Под нижним колонтитулом',
	'BELOW_HEADER'			=> 'Под верхним колонтитулом',
	'BELOW_POSTS'			=> 'Под сообщениями',
	'SIDEBAR_RIGHT'			=> 'Правый сайдбар форума',
	'EXTERNAL_BLOCK'		=> 'Внешний блок (Для интеграции с CMS)',

	// ACP
	'0_OR_NA'									=> '0 или N/A',

	'ACP_ADVERTISEMENT_MANAGEMENT_EXPLAIN'		=> 'Настройка параметров Менеджера рекламы. <br>Добавление/Редактирование/Удаление рекламы и/или ее расположения.',
	'ACP_ADVERTISEMENT_MANAGEMENT_SETTINGS'		=> 'Параметры менеджера рекламы',
	'ADS_ACCURATE_VIEWS'						=> 'Точный подсчет просмотров',
	'ADS_ACCURATE_VIEWS_EXPLAIN'				=> 'Повышает точность подсчета просмотра рекламы, но увеличивает нагрузку сервера.',
	'ADS_COUNT_CLICKS'							=> 'Считать клики',
	'ADS_COUNT_CLICKS_EXPLAIN'					=> 'При выборе "Нет" - рекламые клики не подсчитываются (меньшая нагрузка сервера)',
	'ADS_COUNT_VIEWS'							=> 'Считать показы',
	'ADS_COUNT_VIEWS_EXPLAIN'					=> 'При выборе "Нет" - показы не подсчитываются (меньшая нагрузка сервера)',
	'AD_CREATED'								=> 'Создана',
	'ADS_ENABLE'								=> 'Разрешить',
	'ADS_GROUP'									=> 'Группа рекламных владельцев',
	'ADS_GROUP_EXPLAIN'							=> 'Группа в которую добавлять владельца (не обязательно, только при необходимости добавлять в специальную группу для отслеживания)',
	'ADS_RULES_FORUMS'							=> 'Использовать Форумные права',
	'ADS_RULES_FORUMS_EXPLAIN'					=> 'Активирует настройку показа рекламы для форумов. <br> Если не планируется использование этой особенности, отключить для экономии ресурсов.',
	'ADS_RULES_GROUPS'							=> 'Использовать Права групп',
	'ADS_RULES_GROUPS_EXPLAIN'					=> 'Активирует настройку показа рекламы для Групп. <br> Если не планируется использование этой особенности, отключить для экономии ресурсов.',
	'ADS_VERSION'								=> 'Версия Менеджера рекламы',
	'ADVERTISEMENT'								=> 'Реклама',
	'ADVERTISEMENT_MANAGEMENT_UPDATE_SUCCESS'	=> 'Параметры Менеджера рекламы сохранены',
	'AD_ADD_SUCCESS'							=> 'Реклама добавлена!',
	'AD_CLICK_LIMIT'							=> 'Лимит рекламных кликов',
	'AD_CLICK_LIMIT_EXPLAIN'					=> 'Количество кликов до отключения рекламы. Установите 0 для снятия ограничений.',
	'AD_CLICKS'									=> 'Рекламные клики',
	'AD_CLICKS_EXPLAIN'							=> 'Текущее количество кликов для указанной рекламы (при корректной настройке)',
	'AD_CODE'									=> 'Код рекламы',
	'AD_CODE_EXPLAIN'							=> 'HTML-код рекламы. BBcodes не поддерживаются.<br> <strong>Для включения счетчика кликов поместите {COUNT_CLICK} в любом месте кода, где разрешены атрибуты on-click</strong> (например <em>a tag</em>).',
	'AD_EDIT_SUCCESS'							=> 'Реклама изменена',
	'AD_ENABLED'								=> 'Разрешить рекламу',
	'AD_ENABLED_EXPLAIN'						=> 'Снять пометку для отключения показа рекламы',
	'AD_FORUMS'									=> 'Форумы',
	'AD_FORUMS_EXPLAIN'							=> 'Выберите форумы для показа рекламы. Удерживайте CTRL для выбора нескольких форумов.',
	'AD_GROUPS'									=> 'Группы',
	'AD_GROUPS_EXPLAIN'							=> 'Укажите группы для которых <strong>НЕ ПОКАЗЫВАТЬ</strong> рекламу. Удерживайте CTRL для выбора нескольких групп.',
	'AD_LIST_NOTICE'							=> 'Подсчет рекламных кликов будет доступен только при использовании {COUNT_CLICK} в месте где разрешены атрибуты on-click',
	'AD_MAX_VIEWS'								=> 'Максимум показов',
	'AD_MAX_VIEWS_EXPLAIN'						=> 'Количество показов до отключения рекламы. Установите 0 для снятия ограничений.',
	'AD_NAME'									=> 'Имя',
	'AD_NAME_EXPLAIN'							=> 'Для обозначения рекламы',
	'AD_NOT_EXIST'								=> 'Выбранная реклама не существует.',
	'AD_NOTE'									=> 'Примечание',
	'AD_NOTE_EXPLAIN'							=> 'Примечание. Отображается только в ACP',
	'AD_OWNER'									=> 'Владелец',
	'AD_OWNER_EXPLAIN'							=> 'Пользователь которому разрешается видеть панель управления рекламой.',
	'AD_POSITIONS'								=> 'Области показа',
	'AD_POSITIONS_EXPLAIN'						=> 'Укажите области показа рекламы',
	'AD_PRIORITY'								=> 'Приоритет',
	'AD_PRIORITY_EXPLAIN'						=> 'Чем выше значение приоритета, тем чаще показ рекламы. Например реклама с приоритетом 2 будет показана в 2 раза чаще чем с приоритетом 1.',
	'AD_TIME_END'								=> 'Показывать до',
	'AD_TIME_END_BEFORE_NOW'					=> 'Дата завершения показа (в формате strtotime).',
	'AD_TIME_END_EXPLAIN'						=> 'Дата завершения показа рекламы. <br><b><u>Важно!</u></b> фотмат даты должен соответсвовать требованям функции PHP <a href="http://us2.php.net/manual/en/function.strtotime.php"><b>strtotime</b></a> иначе дата завершения показа установлена не будет. <br><i>Эта дата не является точной, т.к. не учитывает разницу временных зон. Рекомендуется учитывать погрешность в 1 день.</i>',
	'AD_VIEW_LIMIT'								=> 'Лимит показов рекламы',
	'AD_VIEW_LIMIT_EXPLAIN'						=> 'Количество показов до отключения рекламы. Установите 0 для снятия ограничений.',
	'AD_VIEWS'									=> 'Показы',
	'AD_VIEWS_EXPLAIN'							=> 'Количество показов рекламы',
	'ALL_FORUMS_EXPLAIN'						=> 'Выбрать для показа во всех форумах. Реклама не показывается на страницах не относящихся к форуму, например FAQ и т.д.',
	'CREATE_AD'									=> 'Создать рекламу',
	'CREATE_POSITION'							=> 'Создать область показа',
	'COPY'										=> 'Копировать',
	'DELETE_AD'									=> 'Удалить рекламу',
	'DELETE_AD_CONFIRM'							=> 'Удаление рекламы, продолжить?',
	'DELETE_AD_SUCCESS'							=> 'Реклама удалена',
	'DELETE_POSITION'							=> 'Удалить область показа',
	'DELETE_POSITION_CONFIRM'					=> 'Удаление области показа, продолжить?',
	'DELETE_POSITION_SUCCESS'					=> 'Область показа удалена',
	'FALSE'										=> 'Нет',
	'NO_ADS_CREATED'							=> 'Реклама не создана',
	'NO_AD_NAME'								=> 'Необходимо указать имя рекламы',
	'NO_POSITIONS_CREATED'						=> 'Область показа не создана',
	'POSITION'									=> 'Область показа',
	'POSITION_CODE'								=> 'Код области показа',
	'POSITION_EDIT_SUCCESS'						=> 'Область показа изменена',
	'POSITION_NAME'								=> 'Имя области показа',
	'POSITION_NAME_EXPLAIN'						=> 'Название области показа',
	'POSITION_NOT_EXIST'						=> 'Указанная область показа не существует',
	'POSTITION_ADD_SUCCESS'						=> 'Область показа добавлена!',
	'POSTITION_ALREADY_EXIST'					=> 'Имя области показа уже существует',

	'TRUE'										=> 'Да',
));
