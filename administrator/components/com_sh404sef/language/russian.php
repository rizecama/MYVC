<?php
//
// Copyright (C) 2004 W.H.Welch
// All rights reserved.
//
// This source file is part of the 404SEF Component, a Mambo 4.5.1
// custom Component By W.H.Welch - http://sef404.sourceforge.net/
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// Please note that the GPL states that any headers in files and
// Copyright notices as well as credits in headers, source files
// and output (screens, prints, etc.) can not be removed.
// You can extend them with your own credits, though...
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Additions by Yannick Gaultier (c) 2006-2010
// RUS Translation by Keycolor | http://www.keycolor.ru | Apr 2010
// 
// Dont allow direct linking
defined( '_JEXEC' ) or die( 'Доступ запрещен.' );

define('COM_SH404SEF_404PAGE','404');
define('COM_SH404SEF_ADD','Добавить');
define('COM_SH404SEF_ADDFILE','Файл индекса по умолчанию');
define('COM_SH404SEF_ASC',' (asc) ');
define('COM_SH404SEF_BACK','Вернуться в Панель Управления sh404SEF');
define('COM_SH404SEF_BADURL','Старая, не SEF ссылка, должна начинаться с index.php');
define('COM_SH404SEF_CHK_PERMS','Пожалуйста, проверьте разрешения на ваш файл и убедитесь, что этот файл может быть прочитан.');
define('COM_SH404SEF_CONFIG','sh404SEF<br/>Конфигурация');
define('COM_SH404SEF_CONFIG_DESC','Настройка функционирования sh404SEF');
define('COM_SH404SEF_CONFIG_UPDATED','Конфигурация обновлена');
define('COM_SH404SEF_CONFIRM_ERASE_CACHE','Вы уверены, что хотите ОЧИСТИТЬ кэш ссылок (URL)?   Это рекомендуется сделать после изменения конфгурации. Для создания кэша снова, необходимо вновь зайти на свой сайт и проийти по ссылкам, или же лучше(!) создать карту сайта.');
define('COM_SH404SEF_COPYRIGHT','Copyright');
define('COM_SH404SEF_DATEADD','Дата добавления');
define('COM_SH404SEF_DEBUG_DATA_DUMP','ДЕБАГ ДАМПА ДАННЫХ ЗАВЕРШЕН: Загрузка Страницы Завершена');
define('COM_SH404SEF_DEF_404_MSG','<h1>Плохи дела: мы не можем найти эту страницу!</h1><p>Вы запросили<strong>{%sh404SEF_404_URL%}</strong>, но как наши серверы ни старались, мы не смогли ее найти. Что случилось?</p><ul><li>ссылка, на которую Вы щелкнули чтобы прибыть сюда, содержит опечатку</li><li>или эта страница была каким-то образом либо удалена, либо переименована нами</li><li>или, что конечно же маловероятно, Вы вводили ее вручную и при этом допустили небольшую ошибку?</li></ul><h4>{sh404sefSimilarUrlsCommentStart}Впрочем, на этом мир не кончается: Вас, возможно, заинтересуют следующие страницы на нашем сайте:{sh404sefSimilarUrlsCommentEnd}</h4><p>{sh404sefSimilarUrls}</p><p> </p>');
define('COM_SH404SEF_DEF_404_PAGE','Страница ошибки 404');
define('COM_SH404SEF_DESC',' (desc) ');
define('COM_SH404SEF_DISABLED',"<p class='error'>ПРИМЕЧАНИЕ: Поддержка SEF в Joomla/Mambo выключена. Для использования SEF, пожалуйста, включите ее из страницы SEO<a href='".$GLOBALS['shConfigLiveSite']."/administrator/index.php?option=com_config'>Глобальная Конфигурация</a></p>");
define('COM_SH404SEF_EDIT','Редактировать');
define('COM_SH404SEF_EMPTYURL','Необходимо ввести Ссылку (URL) для перенаправления.');
define('COM_SH404SEF_ENABLED','Включено');
define('COM_SH404SEF_ERROR_IMPORT','Ошибка при импорте');
define('COM_SH404SEF_EXPORT','Зарезервир. Выборочные ссылки (URLs)');
define('COM_SH404SEF_EXPORT_FAILED','Экспорт закончился неудачно!!!');
define('COM_SH404SEF_FATAL_ERROR_HEADERS','FATAL ERRPR: Заголовок уже отправлен');
define('COM_SH404SEF_FRIENDTRIM_CHAR','Допустимые символы');
define('COM_SH404SEF_HELP','sh404SEF<br/>Поддержка');
define('COM_SH404SEF_HELPDESC','Нужна помощь по sh404SEF?');
define('COM_SH404SEF_HELPVIA','<b>Поддержка доступна через слудующие форумы</b>');
define('COM_SH404SEF_HIDE_CAT','Убрать Категории');
define('COM_SH404SEF_HITS','Просмотры');
define('COM_SH404SEF_IMPORT','Импортир. Выборочные ссылки (URLs)');
define('COM_SH404SEF_IMPORT_EXPORT','Импорт/Экспорт ссылок');
define('COM_SH404SEF_IMPORT_OK','Выборочные ссылки (URLs) успешно импортированы!');
define('COM_SH404SEF_INFO','sh404SEF<br/>Документация');
define('COM_SH404SEF_INFODESC','Посмотреть Сводку и Документацию по sh404SEF');
define('COM_SH404SEF_INSTALLED_VERS','Установленная версия');
define('COM_SH404SEF_INVALID_SQL','Неверные данные в файле SQL');
define('COM_SH404SEF_INVALID_URL','НЕВЕРНЫЙ URL: данная ссылка требует правильный Itemid, но он не найден.<br/>РЕШЕНИЕ: Создайте пункт меню для данного элемента. Вам ненужно его публиковать, просто создайте его.');
define('COM_SH404SEF_LICENSE','Лицензия');
define('COM_SH404SEF_LOWER','В нижнем регистре');
define('COM_SH404SEF_MAMBERS','Форум Участников');
define('COM_SH404SEF_NEWURL','Старые Non-SEF ссылки');
define('COM_SH404SEF_NO_UNLINK','Невозможно переместить загруженный файл из каталога медиа');
define('COM_SH404SEF_NOACCESS','Доступ невозможен');
define('COM_SH404SEF_NOCACHE','Не кэшировать');
define('COM_SH404SEF_NOLEADSLASH','В Новой ссылке (URL) недолжно быть Слэша впереди.');
define('COM_SH404SEF_NOREAD','ОШИБУКА: Невозможно прочитать файл ');
define('COM_SH404SEF_NORECORDS','Записи не найдены.');
define('COM_SH404SEF_OFFICIAL','Оффициальный Форум Проекта');
define('COM_SH404SEF_OK',' OK ');
define('COM_SH404SEF_OLDURL','Новая SEF ссылка');
define('COM_SH404SEF_PAGEREP_CHAR','<nobr>Символ разделителя страниц</nobr>');
define('COM_SH404SEF_PAGETEXT','Текст страницы');
define('COM_SH404SEF_PROCEED',' Продолжить ');
define('COM_SH404SEF_PURGE404','Очистить<br/>404 логи');
define('COM_SH404SEF_PURGE404DESC','Очистка лога ошибок 404');
define('COM_SH404SEF_PURGECUSTOM','Очистить<br/>Выборочные переадресаци');
define('COM_SH404SEF_PURGECUSTOMDESC','Очитска Выборочных переадресаций');
define('COM_SH404SEF_PURGEURL','Очистить<br/>SEF ссылки');
define('COM_SH404SEF_PURGEURLDESC','Очистка SEF ссылок');
define('COM_SH404SEF_REALURL','Реальные ссылки');
define('COM_SH404SEF_RECORD',' запись');
define('COM_SH404SEF_RECORDS',' записи');
define('COM_SH404SEF_REPLACE_CHAR','Символ замены');
define('COM_SH404SEF_SAVEAS','Сохранить как Выборочную Переадресацию');
define('COM_SH404SEF_SEFURL','SEF ссылки');
define('COM_SH404SEF_SELECT_DELETE','Выберите элемент для удаления');
define('COM_SH404SEF_SELECT_FILE','Пожалуйста, выберите сначала файл');
define('COM_SH404SEF_ACTIVATE_IJOOMLA_MAG','Активировать магазин iJoomla в содержимом');
define('COM_SH404SEF_ADV_INSERT_ISO','Вставить код ISO');
define('COM_SH404SEF_ADV_MANAGE_URL','Обработки URL');
define('COM_SH404SEF_ADV_TRANSLATE_URL','Переводить URL');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID','Всегда прибавлять Itemid к SEF ссылке');
define('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX','ID Меню');
define('COM_SH404SEF_ALWAYS_INSERT_MENU_TITLE','Всегда добавлять заголовок меню');
define('COM_SH404SEF_CACHE_TITLE','Управление Кэшированием');
define('COM_SH404SEF_CAT_TABLE_SUFFIX','Tabla');
define('COM_SH404SEF_CB_INSERT_NAME','Добавить название Community Builder');
define('COM_SH404SEF_CB_INSERT_USER_ID','Добавить ID пользователя');
define('COM_SH404SEF_CB_INSERT_USER_NAME','Добавить Имя пользователя');
define('COM_SH404SEF_CB_NAME','Название CB по умолчанию');
define('COM_SH404SEF_CB_TITLE','Параметры Community Builder ');
define('COM_SH404SEF_CB_USE_USER_PSEUDO','Вставить Алиас пользователя');
define('COM_SH404SEF_CONF_TAB_ADVANCED','Расширенные');
define('COM_SH404SEF_CONF_TAB_BY_COMPONENT','Компоненты');
define('COM_SH404SEF_CONF_TAB_MAIN','Основные');
define('COM_SH404SEF_CONF_TAB_PLUGINS','Плагины');
define('COM_SH404SEF_DEFAULT_MENU_ITEM_NAME','Стандартный заголовок меню');
define('COM_SH404SEF_DO_NOT_INSERT_LANGUAGE_CODE','Не вставлять код');
define('COM_SH404SEF_DO_NOT_OVERRIDE_SEF_EXT','Не замещать sef_ext файл');
define('COM_SH404SEF_DO_NOT_TRANSLATE_URL','Не переводить');
define('COM_SH404SEF_ENCODE_URL','Преобразовать URL');
define('COM_SH404SEF_FB_INSERT_CATEGORY_ID','Добавить ID категории');
define('COM_SH404SEF_FB_INSERT_CATEGORY_NAME','Вставить Название категории');
define('COM_SH404SEF_FB_INSERT_MESSAGE_ID','Вставить ID сообщения');
define('COM_SH404SEF_FB_INSERT_MESSAGE_SUBJECT','Вставить предмент сообщения');
define('COM_SH404SEF_FB_INSERT_NAME','Вставить название Fireboard');
define('COM_SH404SEF_FB_NAME','Название Fireboard по умолчанию');
define('COM_SH404SEF_FB_TITLE','Параметры Fireboard ');
define('COM_SH404SEF_FILTER','Фильтр');
define('COM_SH404SEF_FORCE_NON_SEF_HTTPS','Использовать non-Sef, если HTTPS');
define('COM_SH404SEF_GUESS_HOMEPAGE_ITEMID','Предполагать Itemid на Главной');
define('COM_SH404SEF_IJOOMLA_MAG_NAME','Название магазина по умолчанию');
define('COM_SH404SEF_IJOOMLA_MAG_TITLE','Параметры Магазина iJoomla');
define('COM_SH404SEF_INSERT_GLOBAL_ITEMID_IF_NONE','Вставить Itemid меню, если нет');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ARTICLE_ID','Добавить ID материала в URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_ISSUE_ID','Добавить исходный ID в URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_MAGAZINE_ID','Добавить ID магазина в URL');
define('COM_SH404SEF_INSERT_IJOOMLA_MAG_NAME','Добавить название магазина в URL');
define('COM_SH404SEF_INSERT_LANGUAGE_CODE','Вставить Код языка в URL');
define('COM_SH404SEF_INSERT_NUMERICAL_ID','Добавить номерной ID в URL');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_ALL_CAT','Все категории');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_CAT_LIST','Применить ко всем категориям');
define('COM_SH404SEF_INSERT_NUMERICAL_ID_TITLE','Уникальный ID');
define('COM_SH404SEF_INSERT_PRODUCT_ID','Добавить ID продукта в URL');
define('COM_SH404SEF_INSERT_TITLE_IF_NO_ITEMID','Вставить заголовок меню, если нет Itemid');
define('COM_SH404SEF_ITEMID_TITLE','Параметры Управления Itemid');
define('COM_SH404SEF_LETTERMAN_DEFAULT_ITEMID','Itemid для страницы Letterman по умолчанию');
define('COM_SH404SEF_LETTERMAN_TITLE','Параметры Letterman');
define('COM_SH404SEF_LIVE_SECURE_SITE','URL защищенного SSL соединения');
define('COM_SH404SEF_LOG_404_ERRORS','Логи ошибок 404');
define('COM_SH404SEF_MAX_URL_IN_CACHE','Размер кэша');
define('COM_SH404SEF_OVERRIDE_SEF_EXT','Заместить sef_ext файл');
define('COM_SH404SEF_REDIR_404','404');
define('COM_SH404SEF_REDIR_CUSTOM','Выборочные');
define('COM_SH404SEF_REDIR_SEF','SEF');
define('COM_SH404SEF_REDIR_TOTAL','Всего');
define('COM_SH404SEF_REDIRECT_JOOMLA_SEF_TO_SEF','Перенаправление (код 301) с Joomla SEF в sh404SEF');
define('COM_SH404SEF_REDIRECT_NON_SEF_TO_SEF','Перенаправление (код 301) из НЕ-Sef в SEF URL');
define('COM_SH404SEF_REPLACEMENTS','Список заменяемых символов');
define('COM_SH404SEF_SHOP_NAME','Название магазина по умолчанию');
define('COM_SH404SEF_TRANSLATE_URL','Перевести ссылку');
define('COM_SH404SEF_TRANSLATION_TITLE','Управление переводом');
define('COM_SH404SEF_USE_URL_CACHE','Включить кэш ссылок (URL)');
define('COM_SH404SEF_VM_ADDITIONAL_TEXT','Дополнительный текст');
define('COM_SH404SEF_VM_DO_NOT_SHOW_CATEGORIES','Нет');
define('COM_SH404SEF_VM_INSERT_CATEGORIES','Добавить категории');
define('COM_SH404SEF_VM_INSERT_CATEGORY_ID','Вставить ID категории в URL');
define('COM_SH404SEF_VM_INSERT_FLYPAGE','Вставить Имя flypage');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_ID','Добавить ID производителя');
define('COM_SH404SEF_VM_INSERT_MANUFACTURER_NAME','Добавить название производителя в URL');
define('COM_SH404SEF_VM_INSERT_SHOP_NAME','Добавить название магазина в ссылку (URL)');
define('COM_SH404SEF_VM_SHOW_ALL_CATEGORIES','Все входящие категории');
define('COM_SH404SEF_VM_SHOW_LAST_CATEGORY','Только одна последняя');
define('COM_SH404SEF_VM_TITLE','Параметры VirtueMart');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU','Использовать SKU продукта для названия');
define('COM_SH404SEF_SHOW_CAT', 'Показать Категорию');
define('COM_SH404SEF_SHOW_SECT','Показать Разделы');
define('COM_SH404SEF_SHOW0','Показать SEF ссылки');
define('COM_SH404SEF_SHOW1','Показать 404 логи');
define('COM_SH404SEF_SHOW2','Показать Выборочные переадресации');
define('COM_SH404SEF_SKIP','Пропустить');
define('COM_SH404SEF_SORTBY','Сортировать по');
define('COM_SH404SEF_STRANGE','Произошло что-то странное. Этого недолжно быть<br />');
define('COM_SH404SEF_STRIP_CHAR','Удаляемые символы');
define('COM_SH404SEF_SUCCESSPURGE','Записи успешно очищены');
define('COM_SH404SEF_SUFFIX','Расширение файлов');
define('COM_SH404SEF_SUPPORT','Поддержка<br/>Веб');
define('COM_SH404SEF_SUPPORT_404SEF','Поддержите нас');
define('COM_SH404SEF_SUPPORTDESC','Перейти на сайт sh404SEF (в новом окне)');
define('COM_SH404SEF_TITLE_ADV','Дополнительные Параметры компонента');
define('COM_SH404SEF_TITLE_BASIC','Основная Конфигурация');
define('COM_SH404SEF_TITLE_CONFIG','Конфигурация sh404SEF ');
define('COM_SH404SEF_TITLE_MANAGER','sh404SEF Менеджер ссылок (URL)');
define('COM_SH404SEF_TITLE_PURGE','База Данных Очистки sh404SEF');
define('COM_SH404SEF_TITLE_SUPPORT','sh404SEF Поддержка');
define('COM_SH404SEF_TT_404PAGE','Статичная странца для 404 ошибок - Не найдено (состояние публикации не имеет значения)');
define('COM_SH404SEF_TT_ADDFILE','Имя файла для добавления к ссылкам, имеющим в конце символ слэша - /. Полезен для поисковых роботов, ожидающих определенный файл, но которым возвращается ошибка 404, если файла нет.');
define('COM_SH404SEF_TT_ADV','<b>исп. заголовок по умолчанию</b><br/>идет нормально, если расширение SEF Advanced присутствует, то оно будет использовано.<br/><b>не кэшировать</b><br/>не сохранять в БД и создавать SEF ссылки в старом стиле<br/><b>пропустить</b><br/>не создавать SEF ссылки для этого компонента<br/>');
define('COM_SH404SEF_TT_ADV4','Дополнительные Параметры для ');
define('COM_SH404SEF_TT_ENABLED','Если выбрано Нет, то будет использован стандартный SEF для Joomla/Mambo');
define('COM_SH404SEF_TT_FRIENDTRIM_CHAR','Символы, которые можно использовать в ссылках (URL). Введите, разделяя их символом |. Warning: if you change this from its default value, make sure to not leave it empty. At least use a space. Due to a small bug in Joomla, this cannot be left empty.');
define('COM_SH404SEF_TT_LOWER','Преобразовать все символы в нижний регистр в ссылке (URL)');
define('COM_SH404SEF_TT_NEWURL','Эта ссылка (URL) должна начинаться с index.php');
define('COM_SH404SEF_TT_OLDURL','Только относительное перенаправление из Joomla/Mambo каталога <i>без</i> слэш впереди');
define('COM_SH404SEF_TT_PAGEREP_CHAR','Символ, используемый для отделения номеров страниц от названия ссылки (URL)');
define('COM_SH404SEF_TT_PAGETEXT','Текст, добавляемый к ссылке для многостраничных материалов. Используется %s для вставки номера страницы в конце ссылки. Если суффикс определен, он будет добавлен в конец строки.');
define('COM_SH404SEF_TT_REPLACE_CHAR','Символ, используемый для замены неизвестных символов в ссылке (URL)');
define('COM_SH404SEF_TT_ACTIVATE_IJOOMLA_MAG','Если <strong>Да</strong>, то ed параметр, если присутствует в компоненте com_content, будет интерпретирован как ID iJoomla магазина.');
define('COM_SH404SEF_TT_ADV_INSERT_ISO','Для каждого установленного компонента и если Ваш сайт многоязыковый, выберите вставлять или нет код ISO в SEF ссылку. Например: www.monsite.com/<b>fr</b>/introduction.html. fr для Французского. Данный код не будет добавлен в ссылку языка по умолчанию.');
define('COM_SH404SEF_TT_ADV_MANAGE_URL','Для каждого установленного компонента:<br /><b>заголовок по умолчанию</b><br/>обычная обработка, если присутствует компонент SEF Advanced, то он будет использован. <br/><b>не кэшировать</b><br/>не сохранять в БД and создавать SEF ссылки в старом стиле<br/><b>пропустить</b><br/>не делать SEF ссылки для данного компонента<br/>');
define('COM_SH404SEF_TT_ADV_OVERRIDE_SEF','Некоторые компоненты идут со своими файлами sef_ext предназначенными для имспользования с OpenSEF или SEF Advanced. Если параметр Да - (Заместить sef_ext), то файл данного расширения не будет использован и плагин sh404SEF будет использован вместо него (при условии, что он один для этого компонента). Если Нет, тогда sef_ext файл компонента будет использован.');
define('COM_SH404SEF_TT_ADV_TRANSLATE_URL','Для каждого установленного компонента. Выберите, если URL будет переводиться. Не даст эффекта, если сайт имеет только один язык.');
define('COM_SH404SEF_TT_ALWAYS_INSERT_ITEMID','Если Да, то не-SEF Itemid (или Itemid текущго пункта меню, если установлено Нет в не-sef URL) будет добавлен к SEF ссылке. Это может быть использоано вместо постоянной вставки параметра заголовка меню, если у Вас есть несколько пунктов меню с одинаковым заголовком (как, например, один в Главном меню и один в верхнем меню)');
define('COM_SH404SEF_TT_ALWAYS_INSERT_MENU_TITLE','Если Да, заголовок меню соответствующий Itemid устанавленный в не-Sef URL, или текущем элементе заголовка меню, если не установлен Itemid, будет добавлен в SEF ссылку.');
define('COM_SH404SEF_TT_CB_INSERT_NAME','Если <strong>Да</strong>, заголовое меню впереди основной страницы Community Builder будет добавлен ко всем CB SEF URL');
define('COM_SH404SEF_TT_CB_INSERT_USER_ID','Если <strong>Да</strong>, ID пользоателя будет добавлен к его имени <strong>при условии, что предыдущией параметрв активен (Да)</strong>, в случае, если два пользователя имеют одно имя.');
define('COM_SH404SEF_TT_CB_INSERT_USER_NAME','Если <strong>Да</strong>, имя пользователя будет добавлено в SEF ссылки. <strong>ВНИМАНИЕ:</strong> это может основательно увеличить размер БД и затормозить работу сайт, если у Вас много зарегистрированных пользователей. Если выбрано Нет, то будет использован ID пользователя в следующем вормате: ..../send-user-email.html?user=245');
define('COM_SH404SEF_TT_CB_NAME','Когда предыдущий параметр - Да, Вы здесь Вы можете вставить текст замены в SEF URL. Имейте ввиду, что этот текст будет постояенен и не будет переведен.');
define('COM_SH404SEF_TT_CB_USE_USER_PSEUDO','Если <strong>Да</strong>, то псевдоним пользователя будет добавлен к SEF ссылке вместо его настоящего имени, если Вы выбрали данную опцию выше.');
define('COM_SH404SEF_TT_DEFAULT_MENU_ITEM_NAME','Когда параметр выше выбран (Да), вы можете здесь отвергнуть текст добавленный в SEF ссылку. Имейте ввиду, что этот текст будет неизменным и не будет переведен');
define('COM_SH404SEF_TT_ENCODE_URL','Если Да, то URL будет преобразован так, чтобы быть совместимым с языками, имеющими не латниские символы. Преобразованный URL будет выглядеть: mysite.com/%34%56%E8%67%12.....');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_ID','Если <strong>Да</strong>, то ID категории будет добавлено к его названию, <strong>когда предыдущий параметр также выбран (Да)</strong>, к примеру, если две категрии имеют одно и тоже название.');
define('COM_SH404SEF_TT_FB_INSERT_CATEGORY_NAME','Если Да, то название категории будет добавлено во все SEF ссылки сообщений');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_ID','Если <strong>Да</strong>, ID сообщения будет добавлен к предмету сообщения <strong>когда предыдущий параметр также выбран (Да)</strong>, к примеру, если два сообщения имеют одинаковое название предмета.');
define('COM_SH404SEF_TT_FB_INSERT_MESSAGE_SUBJECT','Если <strong>Да</strong>, предмет сообщения будет вставлен в SEF ссылку впереди сообщения.');
define('COM_SH404SEF_TT_FB_INSERT_NAME','Если <strong>Да</strong>, то пункт заголовка меню впереди основной страницы Fireboard будет присоединен ко всем Fireboard SEF ссылкам');
define('COM_SH404SEF_TT_FB_NAME','Если <strong>Да<strong>, название Fireboard (как определено в заголовке пункат меню Fireboard) всегда будет добавляться к SEF ссылкам.');
define('COM_SH404SEF_TT_FORCE_NON_SEF_HTTPS','If set to Yes, URL will be forced to non sef after switching to SSL mode(HTTPS). This allows operation with some shared SSL servers causing problems otherwise.');
define('COM_SH404SEF_TT_GUESS_HOMEPAGE_ITEMID','If set to yes, and on homepage only, Itemid of com_content URLs will be removed and replaced by the one sh404SEF guestimates. This is useful when some content elements can be viewed on the frontpage (in blog view for instance), and also on other pages on the site.');
define('COM_SH404SEF_TT_IJOOMLA_MAG_NAME','Когда предыдущий параметр - Да, Вы можете здесь заменить текст добавленный в SEF ссылку. Имейте ввиду, что текст будет постоянен и не будет переведен');
define('COM_SH404SEF_TT_INSERT_GLOBAL_ITEMID_IF_NONE','Если Itemid не установлен в не-SEF URL перед его преобразованием в SEF и Вы включите данную опцию, текущий пункт меню Itemid будет добавлен к нему. Это гарантирует, что если кликнуть, ссылка приведент на туже страницу (т.е. тоже, что и отображают модули)');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ARTICLE_ID','Если <strong>Да</strong>, ID материала будет добавлен к каждому заголовку материала в URL, как в: <br /> mysite.com/Joomla-magazine/<strong>56</strong>-Good-article-title.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_ISSUE_ID','Если <strong>Да</strong>, то уникальный внутренний исходный ID будет добавлен к каждому исходному названию, чтобы быть уверенным, что оно уникально.');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_MAGAZINE_ID','Если <strong>Да</strong>, ID магазина будет добавлен к каждому названию магазина в URL, как в: <br /> mysite.com/<strong>4</strong>-Joomla-magazine/Good-article-title.html');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_MAG_NAME','Если <strong>Да<strong>, то название магазина (как определено в заголовке магазина) всегда будет добавляться к SEF ссылке');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE','Если <strong>Да</strong>, то будет вставлен ISO код языка в SEF ссылку, кроме, если язык является языком по умолчанию для сайта.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID','Если <strong>Да</strong>, номерной ID будет добавлен к URL в целях облегчения включения в сервис, такой как Google новости. ID будет соответствовать формату: 2007041100000, где 20070411 дата создания и 00000  - внутренний уникальный ID элемента содержания. В итоге, Вам нужно установить дату создания, когда содержимое готово к публикации. Имейте ввиду, что в дальнейшем Вы не сможете ее изменить.');
define('COM_SH404SEF_TT_INSERT_NUMERICAL_ID_CAT_LIST','Номерной ID будет добавлен только в SEF ссылки элеменов содержания представленных здесь. Вы можете выбрать множество категорий нажатием и удержанием клавиши CTRL перед нажатием на название категории.');
define('COM_SH404SEF_TT_INSERT_PRODUCT_ID','Если Да, ID продукта будет добавлен к названию продукта в ссылке SEF<br />Например: mysite.com/3-my-very-nice-product.html.<br />Это полезно, если вы не добавляете названия категорий в URL, так как различниые продукты могут иметь схожие названия в различных категориях. Имейте ввиду, что это не продукт SKU, но лучше, чем встроенный ID продукта, который все время однозначен.');
define('COM_SH404SEF_TT_INSERT_TITLE_IF_NO_ITEMID','Если Itemid не установлен в не-SEF URL перед его before преобразованием в SEF и Вы включите данную опцию, текущий элемент Заголовка меню будет добавлен в SEF ссылку. Это стоит задействовать, если параметр выше также задействован, так как это предотвратит -2, -3, -... добавление к SEF ссылке, если материал просматривается из разных мест.');
define('COM_SH404SEF_TT_LETTERMAN_DEFAULT_ITEMID','Введите Itemid страницы, которая будет добавлена в ссылки Letterman (отписаться, сообщения подтверждения, ...');
define('COM_SH404SEF_TT_LIVE_SECURE_SITE','Задайте это к <strong>полному URL бызы вашего сайте когда он в режиме SSL</strong>.<br />Необходимо только если Вы используете https доступ. Если нет, то по умолчанию будет httpS://normalSiteURL.<br />Пожалуйста введите полный url без слеша впереди. Например: <strong>https://www.mysite.com</strong> или <strong>https://sharedsslserveur.com/myaccount</strong>.');
define('COM_SH404SEF_TT_LOG_404_ERRORS','Если <strong>Да</strong>, 404 ошибки будут записаны в БД. Это может помочь найти ошибки в ссылках сайта. Это также займет место в БД, поэтому Вы можете отключить данный параметр, когда сайт протестирован.');
define('COM_SH404SEF_TT_MAX_URL_IN_CACHE','Когда кэш ссылок (URL) активирован данный параметр устанавливает его максимальный размер. Введите максимальное число ссылок (URL), которые могут быть сохранены в кэш (дополнительные ссылки будут обработаны, но не будут сохранены в кэш, отчего время загрузки страницы увеличится). Грубо говоря, каждая ссылки (URL) занимает примерно 200 байт (100 для SEF ссылки and 100 для не-SEF ссылки). Например, 5000 ссылок займут, примерно, 1 Мб на диске.');
define('COM_SH404SEF_TT_REDIRECT_JOOMLA_SEF_TO_SEF','Если <strong>Да</strong>, то стандартные ссылки JOOMLA SEF будут перенаправлены по коду 301 в sh404SEF эквивалент, если они есть в БД. Если их нет в БД, то они будут созданы налету.');
define('COM_SH404SEF_TT_REDIRECT_NON_SEF_TO_SEF','Если <strong>Да</strong>, не-Sef URL уже присутствующие в БД будут перенаправлены в их SEF часть используя код 301 - Постоянно перемещенное перенаправление. Если SE-URL не существует, оно будет создано, если кроме этого там есть POST информация в запросе страницы.');
define('COM_SH404SEF_TT_REPLACEMENTS','Символы не принятые для ссылки (URL), такие как не латинские или подчеркнутые, могут быть заменены исходя из данной таблицы замены. <br />Формат xxx | yyy для каждого заменяемого символа. xxx - заменяемый символ, а yyy - новый, заменяющий символ. <br />Может быть создано множество таких правил разделенных запятыми (,). Между старым и новым символами, используйте символ разделения | <br />Учтите также, что xxx или yyy могут быть многосимвольными, например _|oe ');
define('COM_SH404SEF_TT_SHOP_NAME','Если параметр выше - Да, Вы можете здесь отвергнуть текст добавленный в SEF ссылку. Имейте ввиду, что этот текст будет неизменным и не будет переведен');
define('COM_SH404SEF_TT_TRANSLATE_URL','Если Да и сайт многоязычный, значения SEF ссылок будут переведены в язык посетителя сайта, как решено в Joomfish. Если Нет, ссылки будут на языке сайта. Не используйте, если сайт не многоязычный.');
define('COM_SH404SEF_TT_USE_URL_CACHE','Если Да, SEF ссылки (URL) будут записаны в кэш на диск, что существенно увеличит скорость загрузки страниц. Однако это потребует использования дисковой памяти!');
define('COM_SH404SEF_TT_VM_ADDITIONAL_TEXT','Если <strong>Да</strong>, то дополнительный текст будет добавлен к категориям URL. Например: ..../category-A/View-all-products.html VS ..../category-A/ .');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORIES','Если <strong>Нет</strong>, название категории не будет добавлено в URL впереди продукта, как в: <br /> mysite.com/joomla-cms.html<br />Если <strong>Только одна последняя</strong> - название категории, к которой относится продукт, будет добавлено в SEF ссылку, как в: <br /> mysite.com/joomla/joomla-cms.html<br />Если <strong>Все входящие категории</strong>, то будут добавлены все категории, к которым относится продукт, как в: <br /> mysite.com/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_CATEGORY_ID','Если Да, ID категории будет добавлено к каждому названию категории в URL перед название продукта, как в: <br /> mysite.com/1-software/4-cms/1-joomla/joomla-cms.html');
define('COM_SH404SEF_TT_VM_INSERT_FLYPAGE','Если Да, то название flypage будет добавлено в URL впереди описания продукта. Может быть неактивно, если Вы используете лишь одну flypage.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_ID','Если Да, ID производителя будет добавлено перед названием производителя в SEF ссылке<br />Например: mysite.com/6-manufacturer-name/3-my-very-nice-product.html.');
define('COM_SH404SEF_TT_VM_INSERT_MANUFACTURER_NAME','Если Да, название производителя, если есть, будет добавлено в SEF ссылку впереди продукта.<br />Например: mysite.com/manufacturer-name/product-name.html');
define('COM_SH404SEF_TT_VM_INSERT_SHOP_NAME','Если <strong>Да<strong>, название магазина (как определено в пункте меню заголовка магазина) будет всегда добавляться к SEF ссылке');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU','Если Да, SKU продукта, код продукта, которые Вы вводите для каждого продукта, будут использованы вместо полного названия продукта.');
define('COM_SH404SEF_TT_SHOW_CAT','Если Да, то категории будут исключены из ссылки');
define('COM_SH404SEF_TT_SHOW_SECT','Если Да, то будет добавлено название раздела в ссылку');
define('COM_SH404SEF_TT_STRIP_CHAR','Символы, удаляемые из ссылок (URL). Введите, разделяя их символом |');
define('COM_SH404SEF_TT_SUFFIX','Расширение для "files". Оставьте пустым, если не будет расширений. По умолчанию - ".html".');
define('COM_SH404SEF_TT_USE_ALIAS','Выберите Да, чтобы использовать Алиасы зоголовков вместо Текста заголовка в ссылке (URL)');
define('COM_SH404SEF_UNWRITEABLE',' <b><font color="red">Закрыта для записи</font></b>');
define('COM_SH404SEF_UPLOAD_OK','Файл успешно загружен');
define('COM_SH404SEF_URL','Ссылки');
define('COM_SH404SEF_URLEXIST','Ссылка (URL) уже существует в базе данных!');
define('COM_SH404SEF_USE_ALIAS','Использовать Алиасы');
define('COM_SH404SEF_USE_DEFAULT','Заголовок по умолчанию');
define('COM_SH404SEF_USING_DEFAULT',' <b><font color="red">Использование Значений по умолчанию</font></b>');
define('COM_SH404SEF_VIEW404','Просмотреть/Изменить<br/>404 логи');
define('COM_SH404SEF_VIEW404DESC','Просмотреть/Изменить 404 логи');
define('COM_SH404SEF_VIEWCUSTOM','Просмотреть/Изменить<br/>Выборочные переадресации');
define('COM_SH404SEF_VIEWCUSTOMDESC','Просмотреть/Изменить Выборочные переадресации');
define('COM_SH404SEF_VIEWMODE','Режим просмотра');
define('COM_SH404SEF_VIEWURL','Просмотреть/Изменить<br/>SEF ссылки');
define('COM_SH404SEF_VIEWURLDESC','Просмотреть/Изменить SEF ссылки');
define('COM_SH404SEF_WARNDELETE','ВНИМАНИЕ!!!  Вы собираетесь удалить ');
define('COM_SH404SEF_WRITE_ERROR','Ошибка при записи конфигурации');
define('COM_SH404SEF_WRITE_FAILED','Невозможно записать загруженный файл в дерикторию медиа');
define('COM_SH404SEF_WRITEABLE',' <b><font color="green">Открыта для записи</font></b>');

// V 1.2.4.s
define('COM_SH404SEF_DOCMAN_TITLE','Параметры DOCMan');
define('COM_SH404SEF_DOCMAN_INSERT_NAME','Вставлять имя DOCMan');
define('COM_SH404SEF_TT_DOCMAN_INSERT_NAME','Если <strong>Да</strong>, элемент заголовка меню принадлежащий Главной странице DOCMan будет добавлен ко всем DOCMan ссылкам SEF URL');
define('COM_SH404SEF_DOCMAN_NAME','Имя DOCMan по умолчанию');
define('COM_SH404SEF_TT_DOCMAN_NAME','Когда предыдущий параметр - Да, здесь Вы можете указать отбрасываемый текст, добавленный в SEF URL. Имейте ввиду, что этот текст будет постоянен и не будет переведен.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_ID','Вставлять ID документа');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_ID','Если <strong>Да</strong>, то ID материала будет добавляться к его имени, что необходимо, так как некоторые материалы могут иметь одинаковые названия.');
define('COM_SH404SEF_DOCMAN_INSERT_DOC_NAME','Вставить Имя документа');
define('COM_SH404SEF_TT_DOCMAN_INSERT_DOC_NAME','Если <strong>Да</strong>, имя материала будет добавлено во все SEF ссылки (URL) указыающие на данный материал.');
define('COM_SH404SEF_MYBLOG_TITLE','Параметры MyBlog');
define('COM_SH404SEF_MYBLOG_INSERT_NAME','Вставлять имя MyBlog');
define('COM_SH404SEF_TT_MYBLOG_INSERT_NAME','Если <strong>Да</strong>, заголовое элемента меню указывающий на Главную страницу MyBlog будет добавлен ко всем MyBlog SEF ссылкам (URL).');
define('COM_SH404SEF_MYBLOG_NAME','Имя Myblog по умолчанию');
define('COM_SH404SEF_TT_MYBLOG_NAME','Когда предыдущий параметр - Да, здесь Вы можете указать отбрасываемый текст, добавленный в SEF URL. Имейте ввиду, что этот текст будет постоянен и не будет переведен.');
define('COM_SH404SEF_MYBLOG_INSERT_POST_ID','Вставлять ID поста');
define('COM_SH404SEF_TT_MYBLOG_INSERT_POST_ID','Если <strong>Да</strong>, внутренний ID поста будет добавлен к его заголовку, что необходимо, так как некоторые посты могут иметь одинаковые заголовки.');
define('COM_SH404SEF_MYBLOG_INSERT_TAG_ID','Вставлять ID тег');
define('COM_SH404SEF_TT_MYBLOG_INSERT_TAG_ID','Если <strong>Да</strong>, внутренний ID тег будет добавлен к его имени, что необходимо, так как некоторые теги идентичны или пересекаются с другими категориями имени.');
define('COM_SH404SEF_MYBLOG_INSERT_BLOGGER_ID','Вставлять Blogger ID');
define('COM_SH404SEF_TT_MYBLOG_INSERT_BLOGGER_ID','Если <strong>Да</strong>, внутренни ID Blogger будет добавлен к его имени, что необходимо, так как некоторые из Blogger могут иметь одинаковые имена.');
define('COM_SH404SEF_RW_MODE_NORMAL','.htaccess ( mod_rewrite )');
define('COM_SH404SEF_RW_MODE_INDEXPHP','Без .htaccess ( index.php )');
define('COM_SH404SEF_RW_MODE_INDEXPHP2','Без .htaccess ( index.php? )');
define('COM_SH404SEF_SELECT_REWRITE_MODE','Режим Перезаписи (Rewriting)');
define('COM_SH404SEF_TT_SELECT_REWRITE_MODE','Выберите режим Перезаписи (Rewriting) для sh404SEF.<br /><strong>исп. .htaccess (mod_rewrite)</strong><br />Режим по умолчанию: у Вас должен быть файл .htacces, правильно настроен, чтобы соответствовать конфигурации сервера<br /><strong>без .htaccess (index.php)</strong><br /><strong>В РАЗРАБОТКЕ:</strong> Вам не понадобится файл .htaccess. Данный режим использует функцию PathInfo серверов Apache. К ссылкам (URL) будет добавлено /index.php/ в начале. Возможно, чтобы и IIS сервера также поддерживали данные ссылки (URL)<br /><strong>без .htaccess (index.php?)</strong><br /><strong>В РАЗРАБОТКЕ:</strong> Вам не понадобится файл .htaccess. Этот режим идентичен предыдущему, кроме того, что используется /index.php?/ вместо /index.php/. И снова, сервера IIS могут поддерживать данные ссылки (URL)<br />');
define('COM_SH404SEF_RECORD_DUPLICATES','Сохранять дубликаты ссылок (URL)');
define('COM_SH404SEF_TT_RECORD_DUPLICATES','Если <strong>Да</strong>, sh404SEF будет записывать в БД все не-Sef ссылки (URL), которые добавляют аналогичные SEF ссылки. Это позволит Вам выбирать ту, что предпочтительнее, используя функцию Менеджера Дубликатов в списке SEF ссылок (URL).');
define('COM_SH404SEF_META_TITLE','Тег Заголовка (title)');
define('COM_SH404SEF_TT_META_TITLE','Введите текст, который будет вставлен в тег <strong>META Title</strong> для текущей выбранной ссылки (URL).');
define('COM_SH404SEF_META_DESC','Тег Описания (description)');
define('COM_SH404SEF_TT_META_DESC','Введите текст, который будет вставлен в тег <strong>META Description</strong> для текущей выбранной ссылки (URL).');
define('COM_SH404SEF_META_KEYWORDS','Тег Ключевых слов (keywords)');
define('COM_SH404SEF_TT_META_KEYWORDS','Введите текст, который будет вставлен в тег <strong>META Keywords</strong> для текущей выбранной ссылки (URL). Каждое слова или группа слова должны быть разделены запятыми.');
define('COM_SH404SEF_META_ROBOTS','Тег роботов (robots)');
define('COM_SH404SEF_TT_META_ROBOTS','Введите текст, который бедут вставлен в тег <strong>META Robots</strong> для текущей выбранной ссылки (URL). Данный тег сообщает поисковым машинам куда они должны проследовать по ссылкам на текущей странице и что делать с содержанием на текущей странице. Общие параметры:<br /><strong>INDEX,FOLLOW</strong> : index - проиндексировать содержание текущей страницы и проследовать по всем ссылкам найденным на странице<br /><strong>INDEX,NO FOLLOW</strong> : index - проиндексировать текущую страницу, но не идти по ссылками найденным на странице<br /><strong>NO INDEX, NO FOLLOW</strong> : не индексировать текущую страницу и не идти по ссылкам найденным на ней.<br />');
define('COM_SH404SEF_META_LANG','Тег Языка (language)');
define('COM_SH404SEF_TT_META_LANG','Введите текст, который будет вставлен в тег <strong>META http-equiv= Content-Language</strong> для текущей выбранной ссылки (URL). ');
define('COM_SH404SEF_CONF_TAB_META','Meta/SEO');
define('COM_SH404SEF_CONF_META_DOC','sh404SEF имеет несколько плагинов для <strong>автоматического</strong> создания META тегов для некоторых компонентов.<br/>Не создавайте их вручную, пока автоматически создаваемые не перестануть Вас удовлетворять!<br>');
define('COM_SH404SEF_REMOVE_JOOMLA_GENERATOR','Убрать тег Joomla Generator');
define('COM_SH404SEF_TT_REMOVE_JOOMLA_GENERATOR','Если <strong>Да</strong>, мета тег Generator = Joomla будет убираться со всех страниц.');
define('COM_SH404SEF_PUT_H1_TAG','Вставлять теги h1');
define('COM_SH404SEF_TT_PUT_H1_TAG','Если <strong>Да</strong>, обычные заголовки содержимого будут помещаться между тегов h1. Эти заголовки в основном размещаются в CSS классе Joomla, название которого начинается с <strong>contentheading</strong>.');
define('COM_SH404SEF_META_MANAGEMENT_ACTIVATED','Активировать Meta менеджмент');
define('COM_SH404SEF_TT_META_MANAGEMENT_ACTIVATED','Если <strong>Да</strong>, то META теги Title, Description, Keywords, Robots и Language будут управляться sh404SEF (и его модулем shCustomTags). Иными словами, оригинальные значения созданные Joomla и/или другими компонентами будут оставлены без изменений. ');
define('COM_SH404SEF_TITLE_META_MANAGEMENT','Менеджмент Meta тегов');
define('COM_SH404SEF_META_EDIT','Изменить теги');
define('COM_SH404SEF_META_ADD','Добавить теги');
define('COM_SH404SEF_META_TAGS','META теги');
define('COM_SH404SEF_META_TAGS_DESC','Создать/изменить Meta теги');
define('COM_SH404SEF_PURGE_META_DESC','Удалить Meta теги');
define('COM_SH404SEF_PURGE_META','Очистить META');
define('COM_SH404SEF_IMPORT_EXPORT_META','Импорт/ экспорт META');
define('COM_SH404SEF_NEW_META','Новый META');
define('COM_SH404SEF_NEWURL_META','Не-SEF ссылка');
define('COM_SH404SEF_TT_NEWURL_META','Введите не-Sef ссылку (URL), для который Вы хотите установить Meta теги. ВНИМАНИЕ: она должна с <strong>index.php</strong>!');
define('COM_SH404SEF_BAD_META','Пожалуйста, проверьте информацию: что-то из введенного неверно.');
define('COM_SH404SEF_META_TITLE_PURGE','Стереть Meta теги');
define('COM_SH404SEF_META_SUCCESS_PURGE','Meta теги успешно стерты');
define('COM_SH404SEF_IMPORT_META','Импорт Meta тегов');
define('COM_SH404SEF_EXPORT_META','Экспорт Meta тегов');
define('COM_SH404SEF_IMPORT_META_OK','Meta теги успешно импортированы');
define('COM_SH404SEF_SELECT_ONE_URL','Пожалуйста, выберите одну (и только одну) ссылку (URL).');
define('COM_SH404SEF_MANAGE_DUPLICATES','URL менеджмент для ');
define('COM_SH404SEF_MANAGE_DUPLICATES_RANK','Класс');
define('COM_SH404SEF_MANAGE_DUPLICATES_BUTTON','Дубликат ссылки');
define('COM_SH404SEF_MANAGE_MAKE_MAIN_URL','Главная ссылка (URL)');
define('COM_SH404SEF_BAD_DUPLICATES_DATA','Ошибка: неверные данные ссылки (URL)');
define('COM_SH404SEF_BAD_DUPLICATES_NOTHING_TO_DO','Данная ссылка (URL) уже является Главной');
define('COM_SH404SEF_MAKE_MAIN_URL_OK','Операция успешно завершена');
define('COM_SH404SEF_MAKE_MAIN_URL_ERROR','Произошла ошибка, действие прекращено');
define('COM_SH404SEF_CONTENT_TITLE','Параметры Содержания');
define('COM_SH404SEF_INSERT_CONTENT_TABLE_NAME','Вставить имя таблицы содержания');
define('COM_SH404SEF_TT_INSERT_CONTENT_TABLE_NAME','Если <strong>Да</strong>, заголовок элемента меню впереди таблицы материалов (категории или раздела), который будет добавлен к его SEF ссылке. Это позволяет разделять отображение таблицы из блога.');
define('COM_SH404SEF_CONTENT_TABLE_NAME','Имена ссылок таблицы по умолчанию');
define('COM_SH404SEF_TT_CONTENT_TABLE_NAME','Когда предыдущий параметр - Да, здесь вы можете добавить текст замещения в SEF ссылке (URL). Имейте в виду, что данный текст будет поятоянен и не будет переведен.');
define('COM_SH404SEF_REDIRECT_WWW','Перенаправление www/не-www (код 301)');
define('COM_SH404SEF_TT_REDIRECT_WWW','Если Да, то sh404SEF будет выполнять перенаправление (код 301), если название сайта запрошено без www. Если URL сайта начинается с www, или если сайт запросшен с www, в то время, как его название без www - это предотвратит дублирование содержания и некоторые проблемы, зависящие от конфигурации вашего сервера Apache, такие как проблемы с WYSYWIG редакторами в Joomla');
define('COM_SH404SEF_INSERT_PRODUCT_NAME','Вставить название продукта');
define('COM_SH404SEF_TT_INSERT_PRODUCT_NAME','Если Да, то название продукта будет вставлено в URL');
define('COM_SH404SEF_VM_USE_PRODUCT_SKU_124S','Вставить код продукта');
define('COM_SH404SEF_TT_VM_USE_PRODUCT_SKU_124S','Если Да, то код продукта (названный SKU в VirtueMart) будет добавлен в URL.');

// V 1.2.4.t
define('COM_SH404SEF_DOCMAN_INSERT_CAT_ID','Вставить ID категории');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CAT_ID','Если <strong>Да</strong>, то ID категории будет добавлен к ее названию, <strong>когда предыдущий параметр также установлен в Да</strong>, в случае если две категории имеют одинаковое название.');
define('COM_SH404SEF_DOCMAN_INSERT_CATEGORIES','Вставить название категории?');
define('COM_SH404SEF_TT_DOCMAN_INSERT_CATEGORIES','Если <strong>Нет</strong>, название категории не будет вставлено в URL, как в: <br /> mysite.com/joomla-cms.html<br />Если <strong>Только один последний</strong>, название категории будет добавлено в SEF URL, как в: <br /> mysite.com/joomla/joomla-cms.html<br />Если <strong>Все группы категорий</strong>, то будут добавлены названия всех категорий, как в: <br /> mysite.com/software/cms/joomla/joomla-cms.html');
define('COM_SH404SEF_FORCED_HOMEPAGE','URL Главной страницы');
define('COM_SH404SEF_TT_FORCED_HOMEPAGE','Здесь вы можете добавить URL Главной страницы принудительно. Необходимо, если вы установили `splash page` обычно как файл index.html, который отображается, когды вы вводите адрес, например, http://www.mysite.com. Если так, введите URL так: http://www.mysite.com/index.php (без / на конце), также как отображался сайт Joomla, когда выбиралась Главная страница в Главном меню или пути.');
define('COM_SH404SEF_INSERT_CONTENT_BLOG_NAME','Вставить название отображаемого блога');
define('COM_SH404SEF_TT_INSERT_CONTENT_BLOG_NAME','Если <strong>Да</strong>, заголовок пункта меню, относящегося к блогу (категории или раздела) будет добавлен к его SEF URL. Это позволяет разделить отображаемые таблицы от отображаемых блогов.');
define('COM_SH404SEF_CONTENT_BLOG_NAME','Название отображаемого блога по умолчанию');
define('COM_SH404SEF_TT_CONTENT_BLOG_NAME','Когда предыдущий параметр Да, вы можете отвергнуть текст добавленный здесь в SEF URL. Имейте ввиду, что данный текст будет постоянен и не будет переведен.');
define('COM_SH404SEF_MTREE_TITLE','Параметры Mosets Tree');
define('COM_SH404SEF_MTREE_INSERT_NAME','Вставить название MTree');
define('COM_SH404SEF_TT_MTREE_INSERT_NAME','Если <strong>Да</strong>, заголовок пункта меню принадлежащий Mosets Tree будет добавлен к его SEF URL.');
define('COM_SH404SEF_MTREE_NAME','Название MTree по умолчанию');
define('COM_SH404SEF_MTREE_INSERT_LISTING_ID','Вставить ID списка');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_ID','Если <strong>Да</strong>, ID списка будет добавлен к его названию, в случае, если два списка имеют одинаковые названия.');
define('COM_SH404SEF_MTREE_PREPEND_LISTING_ID','Добавить ID к названию');
define('COM_SH404SEF_TT_MTREE_PREPEND_LISTING_ID','Если <strong>Да</strong>, когда предыдущий параметр также Да, то ID будет <strong>присоединено</strong> к названию списка. Если Нет, то оно будет <strong>добавлено</strong>.');
define('COM_SH404SEF_MTREE_INSERT_LISTING_NAME','Добавить название списка');
define('COM_SH404SEF_TT_MTREE_INSERT_LISTING_NAME','Если <strong>Да</strong>, то название списка будет добавлено во все URL относящиеся к данному списку.');
define('COM_SH404SEF_IJOOMLA_NEWSP_TITLE','Параметры News Portal');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_NAME','Вставить название News Portal');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_NAME','Если <strong>Да</strong>, элемент меню заголовка, относящийся к iJoomla News Portal будет добавлен к его SEF URL.');
define('COM_SH404SEF_IJOOMLA_NEWSP_NAME','Название News Portal по умолчанию');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_CAT_ID','Вставить ID категории');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_CAT_ID','Если <strong>Да</strong>, ID категории будет добавлен к ее названию, в случае, если два списка имеют одинаковое название.');
define('COM_SH404SEF_INSERT_IJOOMLA_NEWSP_SECTION_ID','Вставить ID раздела');
define('COM_SH404SEF_TT_INSERT_IJOOMLA_NEWSP_SECTION_ID','Если <strong>Да</strong>, ID раздела будет добавлен к его названию, в случае, если два списка имеют одинаковое название.');
define('COM_SH404SEF_REMO_TITLE','Параметры Remository');
define('COM_SH404SEF_REMO_INSERT_NAME','Вставить название Remository');
define('COM_SH404SEF_TT_REMO_INSERT_NAME','Если <strong>Да</strong>, то элемент заголовка меню относящийся к Remository будет добавлен к его SEF URL.');
define('COM_SH404SEF_REMO_NAME','Название Remository по умолчанию');
define('COM_SH404SEF_CB_SHORT_USER_URL','Короткий URL к профилю пользователя');
define('COM_SH404SEF_TT_CB_SHORT_USER_URL','Если <strong>Да</strong>, то пользователь сможет обратиться к своему профилю через короткий URL, похожий на www.mysite.com/имя пользователя. Перед включением данной опции убедитесь, что это не создаст проблем с существующим URL на сайте.');
define('COM_SH404SEF_NEW_HOME_META','Meta Домашней страницы');
define('COM_SH404SEF_CONF_ERASE_HOME_META','Вы действительно хотите удалить заголовое домашней страницы и мета-теги?');
define('COM_SH404SEF_UPGRADE_TITLE','Сохранение конфигурации');
define('COM_SH404SEF_UPGRADE_KEEP_URL','Сохранить автоматические URL');
define('COM_SH404SEF_TT_UPGRADE_KEEP_URL','Если <strong>Да</strong>, SEF URL автоматически созданные sh40SEF будут записаны и сохранены, когда вы деинсталлируете компонент. Таким образом, вы сможете вернуть их, когда установите новую версию, буз необходимости в дополнительных действиях.');
define('COM_SH404SEF_UPGRADE_KEEP_CUSTOM','Сохранить выборочные URL, aliases, shURLs');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CUSTOM','Если <strong>Да</strong>, то выборочные SEF URL, которые были введены, будут записаны и сохранены, когда вы деинсталлируете компонент. Таким образом, вы сможете вернуть их, когда установите новую версию, буз необходимости в дополнительных действиях.');
define('COM_SH404SEF_UPGRADE_KEEP_META','Сохранить Title и Meta');
define('COM_SH404SEF_TT_UPGRADE_KEEP_META','Если <strong>Да</strong>, то выборочные Title и Meta теги, которые были введены, будут записаны и сохранены, когда вы деинсталлируете компонент. Таким образом, вы сможете вернуть их, когда установите новую версию, буз необходимости в дополнительных действиях.');
define('COM_SH404SEF_UPGRADE_KEEP_MODULES','Сохранить параметры модулей');
define('COM_SH404SEF_TT_UPGRADE_KEEP_MODULES','Если <strong>Да</strong>, то текущие параметры публикации такие как: позиция, порядок, заголовки и т.д. из shJoomfish и shCustomtags модулей  которые были введены, будут записаны и сохранены, когда вы деинсталлируете компонент. Таким образом, вы сможете вернуть их, когда установите новую версию, буз необходимости в дополнительных действиях.');
define('COM_SH404SEF_IMPORT_OPEN_SEF','Импортировать перенаправления из OpenSEF');
define('COM_SH404SEF_IMPORT_ALL','Импорт перенаправлений');
define('COM_SH404SEF_EXPORT_ALL','Экспорт перенаправлений');
define('COM_SH404SEF_IMPORT_EXPORT_CUSTOM','Импорт/Экспорт выборочных перенаправлений');
define('COM_SH404SEF_DUPLICATE_NOT_ALLOWED','Данный URL уже существует, в то время, как вы не разрешаете дубликаты URL');
define('COM_SH404SEF_INSERT_CONTENT_MULTIPAGES_TITLE','Активировать умные заголовки многостраничных материалов');
define('COM_SH404SEF_TT_INSERT_CONTENT_MULTIPAGES_TITLE','Если Да, то для многостраничных материалов (тех, что с оглавлением), sh404SEF будет использовать заголовки страниц, вставленных с использованием команды mospagebreak: {mospagebreak title=Заголовок_Следующей_Страницы & heading=Заголовое_Предыдущей_Страницы}, вместо номера страницы<br />Например SEF URL похожий на www.mysite.com/user-documentation/<strong>Page-2</strong>.html будет заменен на www.mysite.com/user-documentation/<strong>Getting-started-with-sh404SEF</strong>.html.');

// v x
define('COM_SH404SEF_UPGRADE_KEEP_CONFIG','Сохраненить конфигурацию?');
define('COM_SH404SEF_TT_UPGRADE_KEEP_CONFIG','Если Да, то все конфигурационные параметры будут записаны и сохранены, когда вы деинсталлируете компонент. Таким образом вы сможете использовать старые настройки, когда ставите новую версию.');
define('COM_SH404SEF_CONF_TAB_SECURITY','Безопасность');
define('COM_SH404SEF_SECURITY_TITLE','Параметры безопасности');
define('COM_SH404SEF_HONEYPOT_TITLE','Параметры Проекта Honey Pot');
define('COM_SH404SEF_CONF_HONEYPOT_DOC','Проект Honey Pot - это инициатива, направленная на защиту web сайтов от спам-ботов. Она предусматривает БД для проверки IP адреса посетителя, защищая от известных роботов.<br/>Использование данной БД требует ключ доступа (бесплатно), который можно получить <a href="http://www.projecthoneypot.org/httpbl_configure.php">с сайта проекта</a>. Перед запросом ключа сначала необходимо зарегистрироваться - это также бесплатно.<br/>Если возможно, примите участие в помощи проекту, установив `ловушку` у себя на сайте для лучшей идентификации спам роботов.');
define('COM_SH404SEF_ACTIVATE_SECURITY','Вкл. функции безопасности');
define('COM_SH404SEF_TT_ACTIVATE_SECURITY','Если Да, sh404SEF будет производить некоторые основные проверки запросов URL на вашем сайте в целях защиты от распространенных атак.');
define('COM_SH404SEF_LOG_ATTACKS','Вести Логи атак');
define('COM_SH404SEF_TT_LOG_ATTACKS','Если Да, идентифицированные атаки будут записаны в текстовый файл, который будет включать IP адрес атакующего и сделанный запрос страницы.<br />На один месяц один файл. Располагаются они в <root сайта>/administrator/com_sh404sef/logs directory. Скачать их можно используя FTP или используя утилиту Joomla, например, как Joomla Explorer для их просмотра. В файле текст разделен TAB`ами, чтобы ваш текстовый процессор смог легче его открыть.');
define('COM_SH404SEF_CHECK_HONEY_POT','Использовать Проект Honey Pot');
define('COM_SH404SEF_TT_CHECK_HONEY_POT','Если Да, то IP адрес ваших посетителей будет проверен по БД Проекта Hoeny Pot, используя их HTTP:BL сервис. Это бесплатно, но требуется получить ключ доступа с их сайта.');
define('COM_SH404SEF_HONEYPOT_KEY','Ключ доступа Проекта Honey Pot');
define('COM_SH404SEF_TT_HONEYPOT_KEY','Если использование Проекта Honey Pot активировано, вам необходимо получить ключ достпа от P.H.P. Тип полученного ключа здесь же. Это 12-ти символьная строка.');
define('COM_SH404SEF_HONEYPOT_ENTRANCE_TEXT','Текст альтернативного входа');
define('COM_SH404SEF_TT_HONEYPOT_ENTRANCE_TEXT','Если IP адрес посетителя был обозначен, как подозрительный Проектом Honey Pot, то доступ будет запрещен (403 код ошибки). <br />Однако, на случай ошибочного определения, текст, введенный здесь, будет отображен посетителю со ссылкой, на которую ему/ей надо кликнуть, чтобы попасть на сайт. Лишь человек сможет прочитать и понять этот текст, а робот нет. <br />Вобщем, вы можете ввести текст для вашей ссылки.');
define('COM_SH404SEF_SMELLYPOT_TEXT','Текст-ловушка для робота');
define('COM_SH404SEF_TT_SMELLYPOT_TEXT','Когда спамерский робот определен с помощью Проекта Honey Pot и доступ был запрещен, добавляется ссылка внизу запрещающей доступ страницы в целях записи действий робота Проектом Honey Pot. Также добавляется сообщение для предотвращения нажатия на ссылку человеком, чтобы не было ложных занесений в список. ');
define('COM_SH404SEF_ONLY_NUM_VARS','Числовые параметры');
define('COM_SH404SEF_TT_ONLY_NUM_VARS','Названия параметров, помещенные в данный список, будут проверяться, чтобы они были лишь числовыми: только цифры от 0 по 9. Вводить по одному параметру на строку.');
define('COM_SH404SEF_ONLY_ALPHA_NUM_VARS','Альфа-числовые параметры');
define('COM_SH404SEF_TT_ONLY_ALPHA_NUM_VARS','Названия параметров, помещенные в данный список, будут проверяться, чтобы они были лишь альфа-числовыми: цифры от 0 по 9 и буквы от a по z. Вводить по одному параметру на строку.');
define('COM_SH404SEF_NO_PROTOCOL_VARS','Проверять гиперссылки в параметрах');
define('COM_SH404SEF_TT_NO_PROTOCOL_VARS','Название параметров, помещенные в данный список, будут проверяться на отсутствие в них гиперссылок, начинающихся с http://, https://, ftp:// ');
define('COM_SH404SEF_IP_WHITE_LIST','Белый IP лист');
define('COM_SH404SEF_TT_IP_WHITE_LIST','Любой запрос страницы, приходящий с IP адреса из данного списка, будет <stong>принят</strong>, с условием прохождения URL выше упоминаемых проверок. Вводить по одному IP на строку.<br />Можно использовать * как группвой символ, как в: 192.168.0.*. Это включит IP адреса с 192.168.0.1 по 192.168.0.255.');
define('COM_SH404SEF_IP_BLACK_LIST','Блэк IP лист');
define('COM_SH404SEF_TT_IP_BLACK_LIST','Любой запрос страницы, приходящий с IP адреса из данного списка, будет <strong>отклонен</strong>, с условием прохождения URL выше упоминаемых проверок. Вводить по одному IP на строку.<br />Можно использовать * как групповой символ, как в: 192.168.0.*. Это ключит IP адреса с 192.168.0.1 по 192.168.0.255.');
define('COM_SH404SEF_UAGENT_WHITE_LIST','Белый лист UserAgent`а');
define('COM_SH404SEF_TT_UAGENT_WHITE_LIST','Любой запрос, сделанный UserAgent строкой из этого списка, будет <stong>принят</strong>, с условием прохождения URL выше упоминаемых проверок. Вводить по одной UserAgent строке на линию (строку).');
define('COM_SH404SEF_UAGENT_BLACK_LIST','Блэк-лист UserAgent`а');
define('COM_SH404SEF_TT_UAGENT_BLACK_LIST','Любой запрос, сделанный UserAgent строкой из этого списка, будет <strong>отклонен</strong>, с условием прохождения URL выше упоминаемых проверок. Вводить по одному IP на строку.');
define('COM_SH404SEF_MONTHS_TO_KEEP_LOGS','Сколько месяцев хранить логи безопасности?');
define('COM_SH404SEF_TT_MONTHS_TO_KEEP_LOGS','Если логирование атак активно, то здесь можно задать количество месяцев хранения лог файлов. Например, задание 1 означает, что данный месяц ПЛЮС месяц до будут сохранены. Логи же за пердыдущие месяца будут удалены.');
define('COM_SH404SEF_ANTIFLOOD_TITLE','Параметры анти-флуда');
define('COM_SH404SEF_ACTIVATE_ANTIFLOOD','Активировать анти-флуд');
define('COM_SH404SEF_TT_ACTIVATE_ANTIFLOOD','Если Да, то sh404SEF будет проверять, чтобы любой IP адрес не смог делать слишком много запросов к сайту. Делая множественные запросы, хакер может сделать ваш сайт недоступным путем повышенной нагрузки.');
define('COM_SH404SEF_ANTIFLOOD_ONLY_ON_POST','Только если POST данные (формы)');
define('COM_SH404SEF_TT_ANTIFLOOD_ONLY_ON_POST','Если Да, то данный контроль проявится, если есть какие-либо POST данные в запросе страницы. Обычно это проявляется на страницах форм. Таким образом вы можете ограничиться анти-флуд контролем только к формам, чтобы оградить сайт от роботов создающих комменты.');
define('COM_SH404SEF_ANTIFLOOD_PERIOD','Анти-флуд контроль');
define('COM_SH404SEF_TT_ANTIFLOOD_PERIOD','Время (в секундах), сверх которго будут контролироваться запросы с одного и того же IP адреса.');
define('COM_SH404SEF_ANTIFLOOD_COUNT','Максимальное число запросов');
define('COM_SH404SEF_TT_ANTIFLOOD_COUNT','Число запросов, при котором сработает блокировка страниц для нарушающего IP адреса. Например, введение периода = 10 и кол-ва запросов = 4 заблокирует доступ (возвращение кода ошибки 403 и пустой страницы) как только 4 запроса будут приняты с нарушающего IP адреса менее чем за 10 секунд. Конечно же, доступ будет заблокирован только для этого IP адреса, а не для всех ваших посетителей.');
define('COM_SH404SEF_CONF_TAB_LANGUAGES','Языки');
define('COM_SH404SEF_DEFAULT','По умолчанию');
define('COM_SH404SEF_YES','Да');
define('COM_SH404SEF_NO','Нет');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_PER_LANG','Если Да, код языка будет добавлен в URL для <strong>данного языка</strong>. Если Нет, то код языка никогда не будет добавляться. Если по умолчанию, то код языка будет добавляться для всех языков, но в языке по умолчанию данного сайта.');
define('COM_SH404SEF_TT_TRANSLATE_URL_PER_LANG','Если Да, и ваш сайт мультиязычный, то ваш URL будет переведен для URL <strong>в данном языке</strong>, согласно настройкам Joomfish. Если Нет, URL никогда не будет переводитсья. Если по умолчанию, они также будут переведены. Не дает эффекта на одноязычных сайтах.');
define('COM_SH404SEF_TT_INSERT_LANGUAGE_CODE_GEN','Если Да, то код языка будет добавлен в URL сделанный sh404SEF. Вы также можете иметь и поязыковые настройки (см. ниже).');
define('COM_SH404SEF_TT_TRANSLATE_URL_GEN','Если Да, и ваш сайт мультиязычный, URL будет переведен на язык вашего посетителя, согласно настройкам Joomfish. Иначе URL останется в языке по умолчанию сайта. Вы также можете иметь и поязыковые настройки (см. ниже).');
define('COM_SH404SEF_ADV_COMP_DEFAULT_STRING','Имя по умолчанию');
define('COM_SH404SEF_TT_ADV_COMP_DEFAULT_STRING','Если вы введете здесь текстовую строку, то она будет добавлена в начало всех URL для этого компонента. В основном используется только для обратной совместимости со старыми URL из других SEF компонентов.');
define('COM_SH404SEF_TT_NAME_BY_COMP','. <br />В имени вы можете ввести то, что будет использвано вместо имени элемента меню. Чтобы это проделать, пожалуйста, обратитесь к табу <strong>Компоненты</strong>. Имейте ввиду, что этот текст будет постоянен и не будет переведен.');
define('COM_SH404SEF_STANDARD_ADMIN','Перейти в режим Минимального отображения (только основные параметры)');
define('COM_SH404SEF_ADVANCED_ADMIN','Перейти в режим Расширенного отображения (все доступные параметры)');
define('COM_SH404SEF_MULTIPLE_H1_TO_H2','Множестенное изменение h1 в h2');
define('COM_SH404SEF_TT_MULTIPLE_H1_TO_H2','Если Да и есть несколько тегов h1 на странице, то они будут преобразованы в теги h2.<br />Если же на странице только один тег h1, то он будет оставлен, как есть.');
define('COM_SH404SEF_INSERT_NOFOLLOW_PDF_PRINT','Вставлять тег nofollow в ссылки Печать и PDF');
define('COM_SH404SEF_TT_INSERT_NOFOLLOW_PDF_PRINT','Если Да, то атрубуты rel=nofollow будут добавлены ко всем ссылкам Печать и PDF, созданным Joomla. Это позволит снизить дублирование содержимого, видимого поисковиками.');
define('COM_SH404SEF_INSERT_READMORE_PAGE_TITLE','Вставлять Заголовок в ссылки Подробнее...');
define('COM_SH404SEF_TT_INSERT_READMORE_PAGE_TITLE','Если Да и ссылка Подробнее... отображена на странице, то соответствующий содержимому заголовок будет добавлен к ссылке для увелиения ее веса в поисковиках.');
define('COM_SH404SEF_VM_USE_ITEMS_PER_PAGE','Использование Элементов на постраничном ниспадающем списке');
define('COM_SH404SEF_TT_VM_USE_ITEMS_PER_PAGE','Если Да, то ссылки будут настроены так, чтобы, используя ниспадающие списки, пользователь мог выбрать номер элементов постранично. Если не используете такого рода ниспадающие списки, ИЛИ ваши ссылки уже проиндексированы поисковой системой, вы можете установить данный параметр в НЕТ для сохранения ваших существующих ссылок.');
define('COM_SH404SEF_CHECK_POST_DATA','Проверять также формы данных (POST)');
define('COM_SH404SEF_TT_CHECK_POST_DATA','Если Да, то данные, приходящие от форм будут проверяться на прохождение конфигурационных переменных или схожих угроз. Это может стать причиной ненужных блокировок, если у вас есть, например, форум, где пользователи могут обсуждать такие вопросы, как программирование на Joomla или схожие. Там же они могут захотеть обсудить по тексту строк именно то, что мы рассматриваем как возможную атаку. В таком случае, необходимо отключить данную фичу, если есть опыт в запрете доступа.');
define('COM_SH404SEF_SEC_STATS_TITLE','Статус Безопасности');
define('COM_SH404SEF_SEC_STATS_UPDATE','Обновить');
define('COM_SH404SEF_TOTAL_ATTACKS','Насчитано атак');
define('COM_SH404SEF_TOTAL_CONFIG_VARS','mosConfig var в ссылке');
define('COM_SH404SEF_TOTAL_BASE64','Base64 инъекций');
define('COM_SH404SEF_TOTAL_SCRIPTS','Script инъекций');
define('COM_SH404SEF_TOTAL_STANDARD_VARS','Направомерные стандартные переменные (vars)');
define('COM_SH404SEF_TOTAL_IMG_TXT_CMD','Дистанционное включение файла');
define('COM_SH404SEF_TOTAL_IP_DENIED','Запрещенных IP адресов');
define('COM_SH404SEF_TOTAL_USER_AGENT_DENIED','Запрещенных User agent`ов');
define('COM_SH404SEF_TOTAL_FLOODING','Слишком много запросов (флуд)');
define('COM_SH404SEF_TOTAL_PHP','Отвергнутых Проектом Honey Pot');
define('COM_SH404SEF_TOTAL_PER_HOUR',' /h');
define('COM_SH404SEF_SEC_DEACTIVATED','Функции безопасности НЕ активированы');
define('COM_SH404SEF_TOTAL_PHP_USER_CLICKED','PHP, но по нажатию пользователей');
define('COM_SH404SEF_PREPEND_TO_PAGE_TITLE','Вставлять перед заголовком страницы');
define('COM_SH404SEF_TT_PREPEND_TO_PAGE_TITLE','Текст, введенный здесь, будет добавлен ко всем тегам заголовка страницы.');
define('COM_SH404SEF_APPEND_TO_PAGE_TITLE','Добавить к заголовку страницы');
define('COM_SH404SEF_TT_APPEND_TO_PAGE_TITLE','Текст, введенный здесь, будет добавлен ко всем тегам заголовка страницы.');
define('COM_SH404SEF_DEBUG_TO_LOG_FILE','Записывать Лог в файл');
define('COM_SH404SEF_TT_DEBUG_TO_LOG_FILE','Если Да, то sh404SEF будет записывать Лог в текстовый файл множество внутренней информации. Данная информация необходима для анализа решения проблем работы sh404SEF. <br/>ВНИМАНИЕ: данный файл может быстро стать большим. Также побочным эффектом данной функции является снижение скорости работы сайта. Используйте данную функцию только когда это действительно необходимо. В этой связи, данная функция автоматически отключается через час после включения. Выкл./вкл. для повторной ее активации. Лог файл находится здесь: /administrator/components/com_sh404sef/logs/ ');
define('COM_SH404SEF_ALIAS_LIST','Список Алиасов');
define('COM_SH404SEF_TT_ALIAS_LIST','Добавьте сюда список алиасов для Данной ссылки. По одному алиасу на строку, т.е.:<br/>old-url.html<br/>или<br/>my-other-old-url.php?var=12&test=15<br> и sh404SEF сделает перенаправление (код 301) на верную SEF ссылку, если какой-либо из введенных алиасов будет запрошен.');
define('COM_SH404SEF_HOME_ALIAS','Алиас Главной страницы');
define('COM_SH404SEF_TT_HOME_PAGE_ALIAS_LIST','Добавьте сюда список алиасов для Главной страницы. По одному алиасу на строку, т.е.:<br/>old-url.html<br/>или<br/>my-other-old-url.php?var=12&test=15<br>и sh404SEF сделает перенаправление (код 301) на Главную страницу, если какой-либо из алиасов будет запрошен.');
define('COM_SH404SEF_INSERT_OUTBOUND_LINKS_IMAGE','Вставить символ Внешних ссылок');
define('COM_SH404SEF_TT_INSERT_OUTBOUND_LINKS_IMAGE','Если Да, то визуализирующий символ будет добалвен ко всем ссылкам, ссылающимся на другой сайт, для обеспечения легкой идентификации этих ссылок.');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_BLACK','Темный');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE_WHITE','Светлый');
define('COM_SH404SEF_OUTBOUND_LINKS_IMAGE','Оттенок символа Внешних ссылок');
define('COM_SH404SEF_TT_OUTBOUND_LINKS_IMAGE','Обе картинки содержат полупрозрачный фон. Выберите темный, если фон сайта светлый. Если же фон светлый, выберите темный символ. Картинки находятся здесь: /administrator/components/com_sef/images/external-white.png и external-black.png. Из размер 15x16 пикселей.');

// V 1.3.3
define('COM_SH404SEF_DEFAULT_PARAMS_TITLE','Специализированное');
define('COM_SH404SEF_DEFAULT_PARAMS_WARNING','ВНИМАНИЕ: изменяйте данные значения только в том случае, если вы знаете к чему это приведет!<br/>В случае неверных действий, вы можете нанести непоравимые нарушения в работе сайта.');

// V 1.0.12
define('COM_SH404SEF_USE_CAT_ALIAS','Использовать алиасы Категории');
define('COM_SH404SEF_TT_USE_CAT_ALIAS','Если <strong>Да</strong>, то sh404sef будет использовать алиас Категории вместо ее актуального названия каждый раз, когда оно потребуется для создания ссылки.');
define('COM_SH404SEF_USE_SEC_ALIAS', 'Использовать алиасы Раздела');
define('COM_SH404SEF_TT_USE_SEC_ALIAS', 'Если <strong>Да</strong>, то sh404sef будет использовать алиас Раздела вмето его актуального названия каждый раз, когда оно потребуется для создания ссылки.');
define('COM_SH404SEF_USE_MENU_ALIAS','Использовать алиасы Меню');
define('COM_SH404SEF_TT_USE_MENU_ALIAS','Если <strong>Да</strong>, то sh404sef будет использовать алиас элемента Меню вместо его актуального заголовка каждый раз, когда он понадобится для создания ссылки.');
define('COM_SH404SEF_ENABLE_TABLE_LESS','Использовать безтабличный вывод');
define('COM_SH404SEF_TT_ENABLE_TABLE_LESS','Если <strong>Да</strong>, то sh404sef заставит использовать Joomla только div теги (т.е. никаких тегов table) при выводе материалов в соответствии шаблону, который вы используете. Шаблон Beez при этом необходимо оставить, чтобы все работало корректно. Он установлен по умолчанию.<br /><strong>ВНИМАНИЕ</strong>: необходимо будет подстроить ваш шаблон для соответствия таком (div) формату вывода.');

// V 1.0.13
define('COM_SH404SEF_JC_MODULE_CACHING_DISABLED','Кэширование для языкового модуля Joomfish было отключено!');

// V 1.5.3
define('COM_SH404SEF_ALWAYS_APPEND_ITEMS_PER_PAGE','Всегда добавлять постранично элементы #items');
define('COM_SH404SEF_TT_ALWAYS_APPEND_ITEMS_PER_PAGE','Если <strong>Да</strong>, то sh404sef всегда будет добавлять номер постраничных элементов в пронумерованных ссылках. Например, .../Page-2.html станет .../Page2-10.html, если данная настройка приведет к отображению 10-ти элементов на страницу. Данное отображение необходимо, например, если используются выпадающие списки, чтобы пользователи могли выбрать кол-во отображаемых элементов на страницу.');
define('COM_SH404SEF_REDIRECT_CORRECT_CASE_URL','Перенаправление 301 для исправления регистра');
define('COM_SH404SEF_TT_REDIRECT_CORRECT_CASE_URL','Если <strong>Да</strong>, то sh404sef будет осуществлять перенаправление 301 из SEF ссылки, если она не обладает тем же регистром, который обнаружится в БД. Например, example.com/My-page.html будет перенаправлен на example.com/my-page.html, если последняя сохранена в БД. И наоборот, example.com/my-page.html будет перенаправлен на example.com/My-page.html, если последняя ссылка исп. на сайте и поэтому сохранена в БД.');

// V 1.5.5
define('COM_SH404SEF_JOOMLA_LIVE_SITE','Joomla live_site');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE','Здесь вы видите основную ссылку вашего веб сайта. Например:<br />http://www.example.com<br/>или<br/> http://example.com<br />(без завершающего слэша)<br />Это не sh404sef установка, а скорее <b>Joomlы</b>. Она сохранена в собственном конфигурационном файле Joomlы (configuration.php).<br />Обычно Joomla нормально определяет основной адрес сайта автоматически. Однако, если отобажаемый здесь адрес неверен, задайте его вручную самостоятельно. Сделать это можно изменением содержимого configuration.php (обычно, используя FTP).<br/>Симптомами неверного значения являются: не оторажаются шаблон или изображения, не функционируют кнопки, потеряны все стили (цвета, шрифты и т.д.), или подобное...');
define('COM_SH404SEF_TT_JOOMLA_LIVE_SITE_MISSING','ВНИМАНИЕ: $live_site потерян из файла configuration.php Joomla или же не начинается с "http://" или "https://" !');
define('COM_SH404SEF_JCL_INSERT_EVENT_ID','Вставлять ID события');
define('COM_SH404SEF_TT_JCL_INSERT_EVENT_ID','Если Да, внутренний ID события будет присоединен к заголовку события в ссылках, чтобы сделать их уникальными.');
define('COM_SH404SEF_JCL_INSERT_CATEGORY_ID','Вставлять ID катигории');
define('COM_SH404SEF_TT_JCL_INSERT_CATEGORY_ID','Если Да, то при присутствии категории в ссылке, внутренний ID категории будет присоединен, чтобы сделать ее уникальной.');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_ID','Вставлять ID календаря');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_ID','Если Да, то при использовании названия календаря, внутренний ID календаря будет присоединен, чтобы сделать его уникальным.');
define('COM_SH404SEF_JCL_INSERT_CALENDAR_NAME','Вставлять название Календаря');
define('COM_SH404SEF_TT_JCL_INSERT_CALENDAR_NAME','Если Да, то все ссылки, где задан определенный календарь, будут иметь название календаря в ссылке. Если календарь в ссылке не определен, то будет добавлен заголовок меню.');
define('COM_SH404SEF_JCL_INSERT_DATE','Вставлять Дату');
define('COM_SH404SEF_TT_JCL_INSERT_DATE','Если Да, то дата целевой страницы будет добавляться к каждой ссылке.');
define('COM_SH404SEF_JCL_INSERT_DATE_IN_EVENT_VIEW','Вставлять дату в ссылку События');
define('COM_SH404SEF_TT_JCL_INSERT_DATE_IN_EVENT_VIEW','Если Да, то каждая дата события будет присоединяться к ссылкам на странице детализации события.');
define('COM_SH404SEF_JCL_TITLE','Конфигурация JCal Pro');
define('COM_SH404SEF_PAGE_TITLE_TITLE','Конфигурация Заголовка страницы');
define('COM_SH404SEF_CONTENT_TITLE_TITLE','Конф. стр. Заголовка содержимого Joomla');
define('COM_SH404SEF_CONTENT_TITLE_SHOW_SECTION','Вставлять Раздел');
define('COM_SH404SEF_TT_CONTENT_TITLE_SHOW_SECTION','Если Да, то раздел статьи будет вставлен в заголовок страницы статьи');
define('COM_SH404SEF_CONTENT_TITLE_SHOW_CAT', 'Вставлять Категорию');
define('COM_SH404SEF_TT_CONTENT_TITLE_SHOW_CAT', 'Если Да, то категория раздела будет вставлена в заголовок страницы статьи');
define('COM_SH404SEF_CONTENT_TITLE_USE_ALIAS','Исп. алиас заголовка статьи');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_ALIAS','Если Да, алиас статьи будет использован в заголовке страницы вместо актуального заголовка статьи.');
define('COM_SH404SEF_CONTENT_TITLE_USE_CAT_ALIAS','Исп. алиас Категории');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_CAT_ALIAS','Если Да, то алиас категории будет использован в заголовке страницы вместо актуального заголовка категории.');
define('COM_SH404SEF_CONTENT_TITLE_USE_SEC_ALIAS','Исп. алиас Раздела');
define('COM_SH404SEF_TT_CONTENT_TITLE_USE_SEC_ALIAS','Если Да, то алиас раздела будет использован в заголовке страницы вместо актуального заголовка раздела.');
define('COM_SH404SEF_PAGE_TITLE_SEPARATOR','Разделитель заголовка стр.');
define('COM_SH404SEF_TT_PAGE_TITLE_SEPARATOR','Введите символ или строку для отделения различных частей заголовка стр. По умолчанию символ | окружен единичным отступом.');

// V 1.5.7
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS_TITLE','Дубликаты');
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS_NOT','Отображать только основную ссылку');
define('COM_SH404SEF_DISPLAY_DUPLICATE_URLS','Отображать основную и дублированную ссылки');
define('COM_SH404SEF_INSERT_ARTICLE_ID_TITLE','Вставить ID статьи в ссылку');
define('COM_SH404SEF_TT_INSERT_ARTICLE_ID_TITLE','Если <strong>Да</strong>, то внутренний ID статьи будет добавлен к заголовку статьи в ссылках, чтобы быть уверенным в том, что каждая из статей может быть доступна индивидуально, т.е. даже, если 2 статьи имеют одинаковые заголовки articles, или же заголовки, создающие одинаковые ссылки (после очистки от неверных символов и подобного). Данный ID привнесет не СЕО значение и лучше убедиться, что у вас нет статей с идентичным заголовком в том же разделе и категории.<br />Если же ввод статей вам неподконтролен, данная настройка поможет быть уверенным в том, что статьи будут доступны articles в угоду хорошей поисковой оптимизации.');

// V 1.5.8

define('COM_SH404SEF_JS_TITLE','Конфигурация JomSocial ');
define('COM_SH404SEF_JS_INSERT_NAME','Вставлять Имя JomSocial');
define('COM_SH404SEF_TT_JS_INSERT_NAME','Если <strong>Да</strong>, элемент заголовка меню предшествующий JomSocial главной страницы, будет добавлен ко всем SEF ссылкам JomSocial.');
define('COM_SH404SEF_JS_INSERT_USER_NAME','Вставлять Краткое имя польз.');
define('COM_SH404SEF_TT_JS_INSERT_USER_NAME','Если <strong>Да</strong>, краткое имя пользователя будет добавлено в SEF ссылки. <strong>ВНИМАНИЕ</strong>: это может послужить причиной серьезного увеличения размера БД и затормозить работу сайта при наличии большого числа зарегистрированных пользователей.');
define('COM_SH404SEF_JS_INSERT_USER_FULL_NAME','Вставлять Полное имя польз.');
define('COM_SH404SEF_TT_JS_INSERT_USER_FULL_NAME','Если <strong>Да</strong>, молное имя пользователя будет добавлено в SEF ссылки. <strong>ВНИМАНИЕ</strong>: это может послужить причиной серьезного увеличения размера БД и затормозить работу сайта при наличии большого числа зарегистрированных пользователей.');
define('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY','Вставлять Категорию группы');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY','Если <strong>Да</strong>, категория групп пользователей будет добавлена в SEF ссылки туда, где используется имя группы.');
define('COM_SH404SEF_JS_INSERT_GROUP_CATEGORY_ID','Вставлять ID категории группы');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_CATEGORY_ID','Если <strong>Да</strong>, ID категории группы пользователей будет добавлен к имени категории, <strong>когда предыдущий параметр также установлен в Да</strong>, в случае, если две категории имеют сходные названия.');
define('COM_SH404SEF_JS_INSERT_GROUP_ID','Вставлять ID группы');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_ID','Если <strong>Да</strong>, ID группы пользователей будет добавлен к названию группы, в случае, если две группы имеют сходные названия.');
define('COM_SH404SEF_JS_INSERT_GROUP_BULLETIN_ID','Вставлять ID бюллетеня гуппы');
define('COM_SH404SEF_TT_JS_INSERT_GROUP_BULLETIN_ID','Если <strong>Да</strong>, ID бюллетеня группы пользователей будет добавлен к названию бюллетеня, в случае, если два бюллетеня имеют сходные названия.');
define('COM_SH404SEF_JS_INSERT_DISCUSSION_ID','Вставлять ID группы обсуждения');
define('COM_SH404SEF_TT_JS_INSERT_DISCUSSION_ID','Если <strong>Да</strong>, ID группы обсуждения пользователей будет добавлен к названию обсуждения, в случае, если две дискуссии имеют сходные названия.');
define('COM_SH404SEF_JS_INSERT_MESSAGE_ID','Вставлять ID сообщения');
define('COM_SH404SEF_TT_JS_INSERT_MESSAGE_ID','Если <strong>Да</strong>, ID сообщения будет добавлен к названию сообщения, в случае, если два сообщения имеют сохдные названия.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM','Вставлять Имя фотоальбома');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM','Если <strong>Да</strong>, название альбома к которому оно относится и будет вставлено в SEF ссылки фотографии или партии фотографий.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ALBUM_ID','Вставлять ID фотоальбома');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ALBUM_ID','Если <strong>Да</strong>, ID альбома, которое будет добавлено к его названию, в случае, если два альбома имеют сходное название.');
define('COM_SH404SEF_JS_INSERT_PHOTO_ID','Вставлять ID фотографии');
define('COM_SH404SEF_TT_JS_INSERT_PHOTO_ID','Если <strong>Да</strong>, ID фотографии будет добавлено к ее названию, в случае, если две фотографии имеют сходные названия.');
define('COM_SH404SEF_JS_INSERT_VIDEO_CAT','Вставлять Имя категории видео');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT','Если <strong>Да</strong>, название категории к которой оно относится и будет вставлено в SEF ссылки видео или партии видеофрагментов.');
define('COM_SH404SEF_JS_INSERT_VIDEO_CAT_ID','Вставлять ID категории видео');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_CAT_ID','Если <strong>Да</strong>, ID категории видео, которое будет добавлено к названию категории, в случае, если категории имеют сходные названия.');
define('COM_SH404SEF_JS_INSERT_VIDEO_ID','Вставлять ID видео');
define('COM_SH404SEF_TT_JS_INSERT_VIDEO_ID','Если <strong>Да</strong>, ID видео, которое будет добавлено к названию видео, в случае, если два видеофграгмента имеют сходные названия.');
define('COM_SH404SEF_FB_INSERT_USERNAME','Вставлять Имя польз.');
define('COM_SH404SEF_TT_FB_INSERT_USERNAME','Если <strong>Да</strong>, имя пользователя будет добавлено в SEF ссылки постов или профилей.');
define('COM_SH404SEF_FB_INSERT_USER_ID','Вставлять ID польз.');
define('COM_SH404SEF_TT_FB_INSERT_USER_ID','Если <strong>Да</strong>, ID пользователя будет добалвено к его имени, если предыдущий параметр установлен в Да, в случае, если два пользователя имеют сходное имя.');
define('COM_SH404SEF_PAGE_NOT_FOUND_ITEMID','Элемент для стр. 404');
define('COM_SH404SEF_TT_PAGE_NOT_FOUND_ITEMID','Если значение, введенно здесь, если не равно 0, то будет отображено на странице 404. Joomla будет использовать Itemid для определения шаблона и модулей для отображения. Itemid представляет элемент меню, таким образом вы сможете определить Itemids в перечне меню.');