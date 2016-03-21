<?php
/*
 **********************************************
 JCal Pro
 Copyright (c) 2006-2010 Anything-Digital.com
 **********************************************
 JCal Pro is a fork of the existing Extcalendar component for Joomla!
 (com_extcal_0_9_2_RC4.zip from mamboguru.com).
 Extcal (http://sourceforge.net/projects/extcal) was renamed
 and adapted to become a Mambo/Joomla! component by
 Matthew Friedman, and further modified by David McKinnis
 (mamboguru.com) to repair some security holes.

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This header must not be removed. Additional contributions/changes
 may be added to this header as long as no information is deleted.
 **********************************************

 $Id: theme.php 714 2011-03-31 17:56:25Z jeffchannell $

 Revision date: 10/11/2008

 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com/
 **********************************************
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

global $option, $template_header, $template_footer, $meta_content, $lang_general;

$mosConfig_live_site = JString::rtrim( JURI::base(), '/');

// Theme information
$theme_info = array (
	'name' => 'default'
	,'author' => 'Anything Digital'
	,'author_email' => 'admin@anything-digital.com'
	,'author_url' => 'http://www.anything-digital.com'
	,'datemade' => '07/19/2008'
);

$isPrint = JRequest::getInt( 'print', 0) == 1;
if ($isPrint) {
	$todayclr = '#FFFFFF'; # color today
	$sundayclr = '#FFFFFF'; # color calendarsunday
	$weekdayclr = '#FFFFFF'; # color calendarweekday

	// Highlighted colors
	$todayclrHl = '#FFFFFF';
	$weekdayclrHl = '#FFFFFF';
	$sundayclrHl = '#FFFFFF';
} else {
	$todayclr = '#D0E6F6'; # color today
	$sundayclr = '#DDE0E0'; # color calendarsunday
	$weekdayclr = '#EEF0F0'; # color calendarweekday

	// Highlighted colors
	$todayclrHl = '#C0D6E6';
	$weekdayclrHl = '#CDD0D0';
	$sundayclrHl = '#DEE0E0';
}
// event icons array
$event_icons = array(
'eventfull' => 'icon-event-onedate.gif'
,'eventfullrepeat' => 'icon-event-onedate.gif'
,'eventfullrepeatchild' => 'icon-recur-event.gif'
,'eventfullrepeatdetached' => 'icon-recur-event-detached.gif'

,'eventstart' => 'icon-event-startdate.gif'
,'eventstartrepeat' => 'icon-event-startdate.gif'
,'eventstartrepeatchild' => 'icon-event-startdate.gif'
,'eventstartrepeatdetached' => 'icon-event-startdate.gif'

,'eventmiddle' => 'icon-event-middate.gif'
,'eventmiddlerepeat' => 'icon-event-middate.gif'
,'eventmiddlerepeatchild' => 'icon-event-middate.gif'
,'eventmiddlerepeatdetached' => 'icon-event-middate.gif'

,'eventend' => 'icon-event-enddate.gif'
,'eventendrepeat' => 'icon-event-enddate.gif'
,'eventendrepeatchild' => 'icon-event-enddate.gif'
,'eventendrepeatdetached' => 'icon-event-enddate.gif'
);

$template_main_menu = <<<EOT
						<table border="0" cellpadding="0" cellspacing="0">
								<tr>
<!-- BEGIN add_event -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
								<a href="{ADD_EVENT_TGT}" {ADD_EVENT_POPUP} title="{ADD_EVENT_LNK}" class="buttontext">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-addevent.gif" border="0" alt="{ADD_EVENT_LNK}" /><br />
						{ADD_EVENT_LNK}</a>
						</td>
<!-- END add_event -->
<!-- BEGIN monthly_view -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
								<a href="{CAL_VIEW_TGT}" title="{CAL_VIEW_LNK}" class="buttontext">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-calendarview.gif" border="0" alt="{CAL_VIEW_LNK}" /><br />
						{CAL_VIEW_LNK}</a>
						</td>
<!-- END monthly_view -->
<!-- BEGIN flyer_view -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
								<a href="{FLYER_VIEW_TGT}" title="{FLYER_VIEW_LNK}" class="buttontext">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-flyer.gif" border="0" alt="{FLYER_VIEW_LNK}" /><br />
						{FLYER_VIEW_LNK}</a>
						</td>
<!-- END flyer_view -->
<!-- BEGIN weekly_view -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
								<a href="{WEEKVIEW_TGT}" title="{WEEKVIEW_LNK}" class="buttontext">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-weekly.gif" border="0" alt="{WEEKVIEW_LNK}" /><br />
						{WEEKVIEW_LNK}</a>
						</td>
<!-- END weekly_view -->
<!-- BEGIN daily_view -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
								<a href="{DAYVIEW_TGT}" title="{DAYVIEW_LNK}" class="buttontext">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-daily.gif" border="0" alt="{DAYVIEW_LNK}" /><br />
						{DAYVIEW_LNK}</a>
						</td>
<!-- END daily_view -->
<!-- BEGIN cat_view -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
								<a href="{CAT_VIEW_TGT}" title="{CAT_VIEW_LNK}" class="buttontext">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-cats.gif" border="0" alt="{CAT_VIEW_LNK}" /><br />
						{CAT_VIEW_LNK}</a>
						</td>
<!-- END cat_view -->
<!-- BEGIN search_view -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
								<a href="{SEARCH_TGT}" title="{SEARCH_LNK}" class="buttontext">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-search.gif" border="0" alt="{SEARCH_LNK}" /><br />
						{SEARCH_LNK}</a>
						</td>
<!-- END search_view -->
<!-- BEGIN ical_view -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
								<a href="{ICAL_TGT}" title="{ICAL_LNK}" class="buttontext">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-ical.gif" border="0" alt="{ICAL_LNK}" /><br />
						{ICAL_LNK}</a>
						</td>
<!-- END ical_view -->
<!-- BEGIN print_view -->
						<td class="buttontext" align="center" valign="middle" nowrap='nowrap'>
						<a href="{PRINT_TGT}" rel="nofollow" onclick="jclPrintWindow=window.open('{PRINT_TGT}','jclPrintWindow','toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,width=800,height=600'); return false;" target="_blank">
						<img src="{URL}themes/{$CONFIG_EXT['theme']}/images/icon-print.gif" border="0" alt="{PRINT_LNK}" /><br />
						{PRINT_LNK}</a>
						</td>
<!-- END print_view -->
								</tr>
								<!-- BEGIN cal_select_view -->
						{CALENDAR_SELECT_SUB_TEMPLATE}
								<!-- END cal_select_view -->
						</table>
EOT;

// HTML template for the calendar selection list
$template_calendar_select_sub_template = '
						<tr><td colspan="9" align="center">
						<form name="calendar_selector" method="post" action="{SEL_CALS_URL}">
						<select name="cal_id_selector" class="listbox" onchange="document.location.href=this.options[this.selectedIndex].value;">
						{SEL_CALS_VAL}
						</select>
						<noscript>
						<input type="submit" value="Select calendar" class="button" /><input type="hidden" name="extmode" value="calendar_select" /></noscript></form>
						</td></tr>
						';

// HTML template for a generic message dialog box
$template_caption_dialog = <<<EOT
<!-- BEGIN message_row -->
								<tr class="tableb">
						<td align="center" class="tableb">
						<br /><br />
						{MESSAGE}
						<br /><br /><br />
						</td>
								</tr>
<!-- END message_row -->
<!-- BEGIN redirect_row -->
								<tr class="tablec">
						<td align='center' colspan='2' height='40' valign='middle' nowrap='nowrap' class="tablec">
						<form action="{URL}" method="post">
								<input type='submit' value="&nbsp;&nbsp;{BUTTON}&nbsp;&nbsp;" {CLOSE_WINDOW} class='button' />
						</form>
						</td>
								</tr>
<!-- END redirect_row -->
EOT;

// HTML template to display an event form
$template_add_event_form = <<<EOT
						<tr><td>
						<form name="eventform" action="{TARGET}" method="post" enctype="multipart/form-data">
						<input name="extmode" type="hidden" value="{MODE}" />
						<input name="extid" type="hidden" value="{EVENT_ID}" />

						<input name="rec_id" type="hidden" value="{REC_ID}" />
						<input name="detached_from_rec" type="hidden" value="{DETACHED_FROM_REC}" />
						<input name="owner_id" type="hidden" value="{OWNER_ID}" />
						<input name="registration_url" type="hidden" value="{REGISTRATION_URL}" />
						<input name="previous_recur_type" type="hidden" value="{RECUR_TYPE_1}" />
						{COMMON_EVENT_ID}
						{DO_NOT_SHOW_CALENDAR_SUB_TEMPLATE}

						<table class="jcl_add_event" >
						<!-- BEGIN errors_row -->
						<tr>
						<td class='tablec' colspan='2'>
						<img src='{$CONFIG_EXT['calendar_url']}themes/default/images/errormessage.gif' style='vertical-align: middle' alt='{ERRORS}'/>&nbsp;<strong>{ERRORS}</strong>
						</td>
						</tr>
						<tr>
						<td class='tableb' colspan='2'>
								<div class='atomic'>{ERROR_MSG}</div>
						</td>
						</tr>
<!-- END errors_row -->
<!-- BEGIN event_details_row -->
						<tr>
						<td class='tableh2' colspan='2'>{EVENT_DETAILS_CAPTION}</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{TITLE_LABEL}</td>
						<td class='tableb'><input type='text' name='title' class='textinput' value="{TITLE_VAL}" size='37' />
						</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{DESC_LABEL}</td>
						<td class='tableb'>

						{DESC_EDITOR}

						</td>
						</tr>
				{SHOW_CALENDAR_SUB_TEMPLATE}
						<tr>
						<td class='tableb' width='160'>{SEL_CATS_LABEL}</td>
						<td class='tableb'>
								<select name='cat' class='listbox'>
						<option value='0' style='color: #666666'>{SEL_CATS_DEF}</option>
						{SEL_CATS_VAL}
								</select>
						</td>
						</tr>
						<tr>
						<td rowspan='4' class='tableb' width='160'>{DATE_LABEL}</td>
						<td class='tablec'>{START_DATE_LABEL}:</td>
						</tr>
						<tr>
						<td class='tableb'>
								<select name='day' class='listbox'>
						<option value='0' style='color: #666666'>{DAY_LABEL}</option>
						{START_DAY_VAL}
								</select>&nbsp;
								<select name='month' class='listbox'>
						<option value='0' style='color: #666666'>{MONTH_LABEL}</option>
						{START_MONTH_VAL}
								</select>&nbsp;
								<select name='year' class='listbox'>
						<option value='0' style='color: #666666'>{YEAR_LABEL}</option>
						{START_YEAR_VAL}
								</select>&nbsp;&nbsp;
								{START_TIME_LABEL}:
								<select name='start_time_hour' class='listbox'>
						{START_HOUR_VAL}
								</select>
								<select name='start_time_minute' class='listbox'>
						{START_MINUTE_VAL}
								</select>
<!-- BEGIN 12hour_mode_row -->
								<select name='start_time_ampm' class='listbox'>
						{START_AMPM_VAL}
								</select>
<!-- END 12hour_mode_row -->
						</td>
						</tr>
						<tr>
						<td class='tablec'>{END_DATE_LABEL}:</td>
						</tr>
						<tr>
						<td class='tableb'>
								<input type='radio' name='duration_type' value='1' {DURATION_TYPE_NORMAL_CHECKED} />&nbsp;&nbsp;&nbsp;
								<input type='text' name='end_days' class='textinput' value='{DAYS_VAL}' size='3' />&nbsp;{DAYS_LABEL}&nbsp;&nbsp;
								<input type='text' name='end_hours' class='textinput' value='{HOURS_VAL}' size='3' />&nbsp;{HOURS_LABEL}&nbsp;&nbsp;
								<input type='text' name='end_minutes' class='textinput' value='{MINUTES_VAL}' size='3' />&nbsp;{MINUTES_LABEL}&nbsp;&nbsp;
								<br />
								<input type='radio' name='duration_type' value='2' {DURATION_TYPE_ALLDAY_CHECKED} />&nbsp;&nbsp;&nbsp;{ALL_DAY_LABEL}
								<br />
								<input type='radio' name='duration_type' value='0' {DURATION_TYPE_NONE_CHECKED} />&nbsp;&nbsp;&nbsp;{NO_DURATION_LABEL}
						</td>
						</tr>
<!-- END event_details_row -->
						<tr>
						<td class='tableh2' colspan='2'>{CONTACT_CAPTION}</td>
						</tr>
<!-- BEGIN contact_row -->
						<tr>
						<td class='tableb' width='160'>{CONTACT_LABEL}</td>
						<td class='tableb'>
								<textarea name='contact' cols='50' rows='5' class='textarea'>{CONTACT_VAL}</textarea>
						</td>
						</tr>
<!-- END contact_row -->
<!-- BEGIN email_row -->
						<tr>
						<td class='tableb' width='160'>{EMAIL_LABEL}</td>
						<td class='tableb'><input type='text' name='email' class='textinput' value="{EMAIL_VAL}" size='25' /></td>
						</tr>
<!-- END email_row -->
<!-- BEGIN url_row -->
						<tr>
						<td class='tableb' width='160'>{URL_LABEL}</td>
						<td class='tableb'><input type='text' name='url' class='textinput' value="{URL_VAL}" size='25' />
						</td>
						</tr>
<!-- END url_row -->
EOT;

$template_add_event_form .= <<<EOT
<!-- BEGIN recurrence_row -->
<tr>
		<td colspan='2'>

		<div style='{RECURRENCE_OPEN_SECTION}' id='recurrence_open'>
			<div class='tableh2'>
			<div style='float:right;width:auto'><a href='javascript:togglecategory("recurrence",1);'><img src='{THEME_DIR}/images/icon-plus.gif' border='0' alt='{EXPAND}' style='vertical-align: middle' /></a></div>
			<div class='tableh2_nobackground'>{RECUR_CAPTION}</div>
			</div>
			<div class='tableb' align="center" id="recur_message">
						{RECURRENCE_MESSAGE}
			</div>
		</div>


		<div style='{RECURRENCE_CLOSE_SECTION}' id='recurrence_close'>
						<div class='tableh2'>
						<div class='rightAuto'>
								<a href='javascript:togglecategory("recurrence",0);'><img src='{THEME_DIR}/images/icon-minus.gif' border='0' alt='{COLLAPSE}' style='vertical-align: middle' /></a>
						</div>
						<div class='tableh2_nobackground'>
								{RECUR_CAPTION}
						</div>
						</div>
						<table width='100%' cellpadding='4' cellspacing='0'>
						<!-- Recurrence method and options section -->
						<tr>
								<td class='tablec' colspan="2">{RECUR_METHOD_CAPTION}</td>
						</tr>
						<tr>
								<td class='tableb' width="25%">
						{REC_TYPE_SELECT}
						<br /><br />
								</td>
								<td class='tableb' valign="top">
						<div id="jcl_rec_none_options">
						</div>
						<div id="jcl_rec_daily_options">
								<ul><li>
						{REC_DAILY_PERIOD_LEADING_LABEL}&nbsp;
						<input type="text" name="rec_daily_period" value="{REC_DAILY_PERIOD}" size='3' class='textinput' />&nbsp;
						{REC_DAILY_PERIOD_TRAILING_LABEL}
								</li></ul>
						</div>
						<div id="jcl_rec_weekly_options">
								<ul><li>
						{REC_WEEKLY_PERIOD_LEADING_LABEL}&nbsp;
						<input type="text" name="rec_weekly_period" value="{REC_WEEKLY_PERIOD}" size='3' class='textinput' />&nbsp;
						{REC_WEEKLY_PERIOD_TRAILING_LABEL}&nbsp;{REC_WEEKLY_ON_DAY_CHECK_LABEL}<br /><br />
						{REC_WEEKLY_ON_DAY_CHECK_BOXES}
								</li></ul>
						</div>
						<div id="jcl_rec_monthly_options">
								<ul><li>
						{REC_MONTHLY_PERIOD_LEADING_LABEL}&nbsp;
						<input type="text" name="rec_monthly_period" value="{REC_MONTHLY_PERIOD}" size='3' class='textinput' />&nbsp;
						{REC_MONTHLY_PERIOD_TRAILING_LABEL}<br /><br />
						{REC_MONTHLY_ON_DAY_NUMBER}&nbsp;
						<input type="text" name="rec_monthly_day_number" value="{REC_MONTHLY_DAY_NUMBER}" size='3' class='textinput' /><br /><br />
						{REC_MONTHLY_ON_SPECIFIC_DAY}&nbsp;
						{REC_MONTHLY_DAY_ORDER}&nbsp;
						{REC_MONTHLY_DAY_TYPE}
								</li></ul>
						</div>
						<div id="jcl_rec_yearly_options">
								<ul><li>
						{REC_YEARLY_PERIOD_LEADING_LABEL}&nbsp;
						<input type="text" name="rec_yearly_period" value="{REC_YEARLY_PERIOD}" size='3' class='textinput' />&nbsp;
						{REC_YEARLY_PERIOD_TRAILING_LABEL}&nbsp;{REC_YEARLY_ON_MONTH_LABEL}&nbsp;{REC_YEARLY_ON_MONTH}<br /><br />
						{REC_YEARLY_ON_DAY_NUMBER}&nbsp;
						<input type="text" name="rec_yearly_day_number" value="{REC_YEARLY_DAY_NUMBER}" size='3' class='textinput' /><br /><br />
						{REC_YEARLY_ON_SPECIFIC_DAY}&nbsp;
						{REC_YEARLY_DAY_ORDER}&nbsp;
						{REC_YEARLY_DAY_TYPE}
								</li></ul>
						</div>
								</td>
						</tr>
						<!-- Recurrence end date options -->
						<tr>
								<td class='tablec' colspan="2">{RECUR_END_DATE_CAPTION}</td>
						</tr>
						<tr>
								<td class='tableb' colspan="2">
								<input type="radio" name="recur_end_type" id="recur_end_type_count" value="1" {RECUR_END_DATE_COUNT_CHECKED} />{RECUR_END_DATE_COUNT}
								</td>
						</tr>
						<tr>
								<td class='tableb' colspan="2">
						<input type="radio" name="recur_end_type" id="recur_end_type_until" value="2" {RECUR_END_DATE_UNTIL_CHECKED} />{RECUR_END_DATE_UNTIL}:
								&nbsp;
									{REC_RECUR_UNTIL}
								</td>
						</tr>
						</table>
		</div>

		</td>
</tr>
<!-- END recurrence_row -->
EOT;

$template_add_event_form .= <<<EOT
<!-- BEGIN admin_row -->
						<tr>
						<td class='tableh2' colspan='2'>{ADMIN_CAPTION}</td>
						</tr>
						<tr>
						{SHOW_APPROVE_EVENT_SUB_TEMPLATE}
						{SHOW_PRIVATE_EVENT_SUB_TEMPLATE}{DO_NOT_SHOW_PRIVATE_EVENT_SUB_TEMPLATE}
						</tr>
<!-- END admin_row -->
<!-- BEGIN captcha_row -->
<tr>
<td class='tablec' colspan='2' valign='middle'>
	{SHOW_CAPTCHA_SUB_TEMPLATE}
</td>
</tr>
<!-- END captcha_row -->
<!-- BEGIN submit_row -->
						<tr>
						<td class='tablec' colspan='2' align='center' valign='middle' height='40'>
								<input name='submit' type='submit' value="&nbsp;&nbsp;{SUBMIT}&nbsp;&nbsp;" class='button' />
								<input name='{CANCEL_NAME}' type='submit' value="&nbsp;&nbsp;{CANCEL_MSG}&nbsp;&nbsp;" class='button' />
								</form>
						</td>
						</tr>
<!-- END submit_row -->
</table>
		</form>
</td></tr>

EOT;

// sub-template for displaying calendar select list
$template_add_event_form_show_calendar =
"<tr>
						<td class='tableb' width='160'>{SEL_CALS_LABEL}</td>
						<td class='tableb'>
								<select name='cal_id' class='listbox'>
						{SEL_CALS_VAL}
								</select>
						</td>
						</tr>";

// sub template when not displaying calendar select list
$template_add_event_form_do_not_show_calendar =
"<input name=\"cal_id\" type=\"hidden\" value=\"{SEL_CALS_VAL}\" />";

// sub template for private events : shows only if user logged in
$template_add_event_form_show_private = '
						<td class="tableb">{PRIVATE_LABEL}&nbsp;
								<select name="private" class="listbox">
						{PRIVATE_VAL}
								</select>
						</td>


						';
$template_add_event_form_do_not_show_private = '
						<td class="tableb">
						<input name="private" type="hidden" value="{PRIVATE_VAL}" />
						</td>
						';


$template_add_event_form_show_auto_approve = '
								<td class="tableb" valign="middle" >
								<input name="autoapprove" type="checkbox" value="1" {AUTO_APPR_STATUS} />{AUTO_APPR_LABEL}
						</td>';

$template_add_event_form_do_not_show_auto_approve = '
							<td class="tableb" valign="middle" >
						</td>
';

// alternate recurrence section for detached events
$template_add_event_form_alt_rec_info = "

<!-- BEGIN recurrence_row -->
<tr>
		<td colspan='2'>

		<div style='{RECURRENCE_OPEN_SECTION}' id='recurrence_open'>
			<div class='tableh2'>
			<div class='tableh2_nobackground'>{RECUR_CAPTION}</div>
			<input type=\"hidden\" name=\"rec_type_select\" value=\"1\" />
<input type=\"hidden\" name=\"rec_daily_period\" value=\"{REC_DAILY_PERIOD}\" />
<input type=\"hidden\" name=\"rec_weekly_period\" value=\"{REC_WEEKLY_PERIOD}\" />
{REC_WEEKLY_ON_DAY_CHECK_BOXES}
<input type=\"hidden\" name=\"rec_monthly_period\" value=\"{REC_MONTHLY_PERIOD}\" />
<input type=\"hidden\" name=\"rec_monthly_day_number\" value=\"{REC_MONTHLY_DAY_NUMBER}\" />
{REC_MONTHLY_DAY_ORDER}
{REC_MONTHLY_DAY_TYPE}
<input type=\"hidden\" name=\"rec_yearly_period\" value=\"{REC_YEARLY_PERIOD}\" />
{REC_YEARLY_ON_MONTH}
<input type=\"hidden\" name=\"rec_yearly_day_number\" value=\"{REC_YEARLY_DAY_NUMBER}\" />
{REC_YEARLY_DAY_ORDER}
{REC_YEARLY_DAY_TYPE}
			<input type=\"hidden\" name=\"recur_end_type\" value=\"{RECUR_END_TYPE}\" />
			<input type=\"hidden\" name=\"recur_end_count\" value=\"{RECUR_END_COUNT}\" />
			{REC_RECUR_UNTIL}
			</div>
			<div class='tableb' align=\"center\" id=\"recur_message\">
						{RECURRENCE_MESSAGE}
			</div>
		</div>
		</td>
</tr>
<!-- END recurrence_row -->
";



$template_monthly_view_nav_row_sub_template = <<<EOT
<!-- BEGIN navigation_row -->
						<tr class='tablec'>
						<!-- BEGIN weeknumber_row -->
						<td rowspan='2' class='tablev1'>&nbsp;</td>
						<!-- END weeknumber_row -->
						<td colspan='2' class='previousmonth'>&nbsp;
						<!-- BEGIN previous_month_link_row -->
						<a href="{PREVIOUS_MONTH_URL}" rel="shajaxLinkPrevMonth extcalendar prefetch" >
						<span id='shajaxProgressPrevMonth'>
						</span>
						{PREVIOUS_MONTH}</a>
						<!-- END previous_month_link_row -->
						</td>
						<td colspan='3' class='{MONTHLY_VIEW_CLASS}'>
						{CURRENT_MONTH}
						</td>
						<td colspan='2' class='nextmonth'>
						<a href="{NEXT_MONTH_URL}" rel="shajaxLinkNextMonth extcalendar prefetch" >
						{NEXT_MONTH}
						</a>
						<span id='shajaxProgressNextMonth'>
						</span>
						</td>
						</tr>
<!-- END navigation_row -->
<!-- BEGIN weekday_header_row -->
						<tr>
<!-- END weekday_header_row -->
EOT;

$template_monthly_view_print_nav_row_sub_template = <<<EOT
<!-- BEGIN navigation_row -->
<!-- END navigation_row -->
<!-- BEGIN weekday_header_row -->
						<tr><td>&nbsp;</td>
<!-- END weekday_header_row -->
<!-- BEGIN weekday_header_row_no_weeknumber -->
						<tr>
<!-- END weekday_header_row_no_weeknumber -->
EOT;

// HTML template to display a monthly calendar view
$template_monthly_view = <<<EOT
<!-- BEGIN weekday_cell_row -->
						<td align="center" width="14%" height="18" valign="middle" class="{CSS_CLASS}">
								{WEEK_DAY}
						</td>
<!-- END weekday_cell_row -->
<!-- BEGIN weekday_footer_row -->
						</tr>
<!-- END weekday_footer_row -->

<!-- BEGIN day_cell_info_row -->
<!-- BEGIN day_cell_header_row -->
						<tr>
<!-- END day_cell_header_row -->
<!-- BEGIN weeknumber_cell_row -->
						<td class='tablev1' align='center'><a href="{URL_WEEK_VIEW}">{WEEK_NUMBER}</a></td>
<!-- END weeknumber_cell_row -->
<!-- BEGIN other_month_cell_row -->
						<td height='50' class='weekdayemptyclr' align='center' valign='middle'>{CELL_CONTENT}</td>
<!-- END other_month_cell_row -->
<!-- BEGIN day_cell_row -->
						<td height='50' class='{DAY_CLASS}' align='center' valign='top' onmouseover="cal_switchImage('add{DAY}', document.imageArray[0][1].src);cOn(this,'{HOVER_BG_COLOR}');showOnBar('{DATE_STRING}');return true;" onmouseout="cal_switchImage('add{DAY}', document.imageArray[0][0].src);cOut(this,'{BG_COLOR}');showOnBar('');return true;">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr>
						<td class="caldaydigits">&nbsp;
								{DAY_VIEW_LINK}
						</td>
						<td align="right">
								<a href="{ADD_EVENT_LINK}" rel="nofollow" >
						<img name="add{DAY}" src="{THEME_DIR}/images/addsign.gif" alt="Add new event on {DATE_STRING}" border="0" /></a>&nbsp;
						</td>
								</tr>
						</table>
						{CELL_CONTENT}
						</td>
<!-- END day_cell_row -->
<!-- BEGIN day_cell_row_no_plus_sign -->
						<td height='50' class='{DAY_CLASS}' align='center' valign='top' onmouseover="cOn(this,'{HOVER_BG_COLOR}');showOnBar('{DATE_STRING}');return true;" onmouseout="cOut(this,'{BG_COLOR}');showOnBar('');return true;">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr>
						<td class="caldaydigits">&nbsp;
								{DAY_VIEW_LINK}
						</td>
								</tr>
						</table>
						{CELL_CONTENT}
						</td>
<!-- END day_cell_row_no_plus_sign -->
<!-- BEGIN day_cell_footer_row -->
						</tr>
<!-- END day_cell_footer_row -->
<!-- END day_cell_info_row -->
EOT;

// HTML template to display a monthly calendar view
$template_mini_cal_view = <<<EOT
<!-- BEGIN header_row -->
		<table align="center" border="0" cellspacing="1" cellpadding="0" style="background-color: #FFFFFF; border: 1px solid #BEC2C3; width: 135">
						<tr>
						<td>
<!-- END header_row -->
<!-- BEGIN navigation_row -->
						<table border="0" cellspacing="0" cellpadding="2" width="100%" class="extcal_navbar">
								<tr>
<!-- BEGIN with_navigation_row -->
<!-- BEGIN no_previous_month_link_row -->
						<td align="center" height="18" valign="middle"></td>
<!-- END no_previous_month_link_row -->
<!-- BEGIN previous_month_link_row -->
						<td align="center" height="18" valign="middle"
								onmouseover="extcal_showOnBar('{PREVIOUS_MONTH}');return true;"
								onmouseout="extcal_showOnBar('');return true;">
								<a href="{PREVIOUS_MONTH_URL}"><img src="{THEME_DIR}/images/mini_arrowleft.gif" border="0" alt="{PREVIOUS_MONTH}" title="{PREVIOUS_MONTH}" /></a></td>
<!-- END previous_month_link_row -->
						<td align="center" height="18" valign="middle" width="98%" class='extcal_month_label' nowrap='nowrap'>{CURRENT_MONTH}</td>
						<td align="center" height="18" valign="middle"
								onmouseover="extcal_showOnBar('{NEXT_MONTH}');return true;"
								onmouseout="extcal_showOnBar('');return true;">
						<a href="{NEXT_MONTH_URL}"><img src="{THEME_DIR}/images/mini_arrowright.gif" border="0" alt="{NEXT_MONTH}" title="{NEXT_MONTH}" /></a></td>
<!-- END with_navigation_row -->
<!-- BEGIN without_navigation_row -->
						<td colspan="3" align="center" height="18" valign="middle" width="98%" class='extcal_month_label' nowrap='nowrap'>{CURRENT_MONTH}</td>
<!-- END without_navigation_row -->
								</tr>
						</table>
<!-- END navigation_row -->

<!-- BEGIN picture_row -->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							<td class="extcal_picture">
								<a href='{TODAY_URL}'
						onmouseover="extcal_showOnBar('{STATUS_MESSAGE}');return true;"
						onmouseout="extcal_showOnBar('');return true;">
						<img src='{PICTURE_URL}' width='135' alt='{PICTURE_MESSAGE}' border='0' /></a></td>
							</tr>
						</table>
<!-- END picture_row -->

<!-- BEGIN weekday_header_row -->
		<table align="center" border="0" cellspacing="0" cellpadding="0" width="135"  class="extcal_weekdays">
						<tr>
						<td></td>
<!-- END weekday_header_row -->
<!-- BEGIN weekday_cell_row -->
						<td height='24' class="{CSS_CLASS}" valign="top" align="center">
								{WEEK_DAY}
						</td>
<!-- END weekday_cell_row -->
<!-- BEGIN weekday_footer_row -->
						</tr>
<!-- END weekday_footer_row -->

<!-- BEGIN day_cell_info_row -->
<!-- BEGIN day_cell_header_row -->
						<tr>
<!-- END day_cell_header_row -->
<!-- BEGIN weeknumber_cell_row -->
						<td class='extcal_weekcell' align='center'
								onmouseover="extcal_showOnBar('{WEEK_NUMBER}');return true;"
								onmouseout="extcal_showOnBar('');return true;">
						<a href="{URL_WEEK_VIEW}" target="{TARGET}"><img src="{THEME_DIR}/images/icon-mini-week.gif" width="5" height="20" border="0" alt="{WEEK_NUMBER}" /></a></td>
<!-- END weeknumber_cell_row -->
<!-- BEGIN other_month_cell_row -->
						<td height='15' class='extcal_othermonth' align='center' valign='middle'>{CELL_CONTENT}</td>
<!-- END other_month_cell_row -->
<!-- BEGIN day_cell_row -->
						<td height='15' class='{DAY_CLASS}' align='center' valign='top' onmouseover="extcal_showOnBar('{DATE_STRING}');return true;" onmouseout="extcal_showOnBar('');return true;">
<!-- BEGIN linkable_row -->
						<a href="{URL_TARGET_DATE}" title="{CELL_CONTENT}" {NOFOLLOW} class="{DAY_LINK_CLASS}" target="{TARGET}">{DAY}</a>
<!-- END linkable_row -->
<!-- BEGIN static_row -->
						<span title="{CELL_CONTENT}" rel="nofollow" class="{DAY_CLASS}">{DAY}</span>
<!-- END static_row -->
						</td>
<!-- END day_cell_row -->

<!-- BEGIN day_cell_footer_row -->
						</tr>
<!-- END day_cell_footer_row -->
<!-- END day_cell_info_row -->
<!-- BEGIN footer_row -->
						</table>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							<td height="1" bgcolor="#D5D5D5"><img src="{THEME_DIR}/images/spacer.gif" ALT="" height="1" /></td>
							</tr>
						</table>
			</td>
</tr>
</table>
<table width="135" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td height="1" bgcolor="#EEEEEE"><img src="{THEME_DIR}/images/spacer.gif" height="1" ALT="" /></td>
</tr>
		<tr>
						<td align="center" nowrap='nowrap'>
<!-- BEGIN add_event_row -->
						<a href="{ADD_EVENT_URL}"
								onmouseover="extcal_showOnBar('{ADD_EVENT_TITLE}');return true;"
								onmouseout="extcal_showOnBar('');return true;">
								<img src="{THEME_DIR}/images/addsign_a.gif" align="middle" alt="{ADD_EVENT_TITLE}" border="0" /></a>
<!-- END add_event_row -->
						</td>
		</tr>
</table>
</div>
<!-- END footer_row -->
<!-- BEGIN inline_style_row -->
<style type="text/css">
.extcal_navbar {
		background-image: url({THEME_DIR}/images/bg1.gif);
		background-repeat: repeat-x;
		border-bottom: 1px solid #B4B4B6;
}

TABLE.extcal_weekdays {
		background-image: url({THEME_DIR}/images/bg1.gif);
		background-repeat: repeat-x;
		border-top: 1px solid #FFFFFF;
}
TD.extcal_weekdays {
		font-family: "Trebuchet MS", Verdana, Arial, "Microsoft Sans Serif";
		font-size: 9px;
		font-weight: normal;
		color: #333333;
		text-decoration: none;
		padding-top: 4px;
}
.extcal_small {
		font-family: Verdana;
		font-size: 9px;
		color:#575767;
		text-decoration: none;
}
.extcal_small:link,.extcal_small:visited {
		text-decoration: none;
}
.extcal_small:hover {
		text-decoration: underline;
}

.extcal_daycell,.extcal_todaycell,
.extcal_sundaycell,.extcal_othermonth {
		font-family: "Trebuchet MS", Verdana, Arial, "Microsoft Sans Serif";
		font-size: 9px;
		font-weight: bold;
		font-style: normal;
		text-decoration: none;
		color:#555555;
		background-repeat: no-repeat;
		background-position: center center;
		padding-top: 3px;
		padding-bottom: 3px;
		padding-right: 2px;
		padding-left: 2px;
}

.extcal_todaycell {
		color:#99AAAA;
		background-image: url({THEME_DIR}/images/rect.gif);
}

.extcal_sundaycell {
		color:#99AAAA;
}

.extcal_othermonth {
		color:#99AAAA;
}

.extcal_daylink, .extcal_sundaylink,
.extcal_busylink  {
		font-family: "Trebuchet MS", Verdana, Arial, "Microsoft Sans Serif";
		font-size: 9px;
		font-weight: bold;
		font-style: normal;
		text-decoration: none;
}

.extcal_daylink:link,.extcal_daylink:visited {
		color:#555555;
}

.extcal_busylink:link,.extcal_busylink:visited { 
		color:#2266EE;
		text-decoration: none;
}

.extcal_sundaylink:link,.extcal_sundaylink:visited {
		color:#99AAAA;
}

.extcal_month_label {
		font-family: Verdana, Arial, "Microsoft Sans Serif";
		font-size: 10px;
		font-weight: bold;
		color: #565666;
}
.extcal_picture {
}
.extcal_weekcell {
margin: 0px;
padding: 0px;
}
</style>
<script type="text/javascript">
		function extcal_showOnBar(Str)
		{
						window.status=Str;
						return true;
		}
</script>
<!-- END inline_style_row -->
EOT;

// HTML template to display a category form in the admin panel
$template_cat_form = <<<EOT
						<table class="adminheading">
						<tr>
						<th class="modules">
						{CAT_MAIN_CAPTION}
						</th>
						</tr>
						</table>

						<table width="100%">
						<tr>
						<td>
						<form name="adminForm" action="{TARGET}" method="post">
						<input name="extmode" type="hidden" value="{MODE}" />
						<input name="cat_id" type="hidden" value="{CAT_ID}" />
						<table class="adminform">
						<!-- BEGIN errors_row -->
						<tr>
						<td colspan='2'>
						<img src='{THEME_DIR}/images/errormessage.gif' ALT='{ERRORS}' style='vertical-align: middle' />&nbsp;<strong>{ERRORS}</strong>
						</td>
						</tr>
						<tr>
						<td class='tableb' colspan='2'>
						<div class='atomic'>{ERROR_MSG}</div>
						</td>
						</tr>
						<!-- END errors_row -->
						<!-- BEGIN cat_details_row -->
						<tr>
						<th colspan='2'>{CAT_DETAILS_CAPTION}</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{CAT_NAME_LABEL}</td>
						<td class='tableb'><input type='text' name='cat_name' class='textinput' value="{CAT_NAME_VAL}" size='25' />
						</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{DESC_LABEL}</td>
						<td class='tableb'><textarea name='description' cols='25' rows='3' class='textarea'>{DESC_VAL}</textarea>
						</td>
						</tr>
						<!-- END cat_details_row -->
						<tr>
						<td class='tableb' width='160'>{COLOR_LABEL}</td>
						<td class='tableb'><table cellpadding="0" cellspacing="0" border="0"><tr><td><input type='text' name='color' id='color' class='textinput' value="{COLOR}" onchange="getElement('colorpickerbg').style.backgroundColor= getElement('color').value;" size='12' />&nbsp;&nbsp;</td><td><table cellpadding="0" cellspacing="0" border="0" width="18" height="17"><tr><td id="colorpickerbg" bgcolor="{COLOR}" width="18" height="17"><a href='Javascript: //'
						onclick="MM_openBrWindow('{PICK_COLOR_LNK}','ColorPicker','location=no,toolbar=no,status=no,scrollbars=no,menubar=no,resizable=no',165,145,true)"><img src='{PICK_COLOR_ICON}' border='0' alt='' /></a></td></tr></table></td><td nowrap='nowrap'><span class='atomic'>&nbsp;&nbsp;{PICK_COLOR}</span></td></tr></table>
						</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{CATEGORY_LABEL}</td>
						<td class='tableb'>
						{CATEGORIES_SELECT}
						</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{STATUS_LABEL}</td>
						<td class='tableb'>
						<input name="published" type="checkbox" value="1" {STATUS_CHK} />{STATUS_ACTIVE_LABEL}
						</td>
						</tr>
						<input type="hidden" name="option" value="$option" />
						<input type="hidden" name="task" value="" />
									</table>
							</form>
						</tr>
						</td>
		</table>
EOT;


// HTML template to display a calendar form in the admin panel
$template_cal_form = <<<EOT
						<table class="adminheading">
						<tr>
						<th class="modules">
						{CAL_MAIN_CAPTION}
						</th>
						</tr>
						</table>

						<table width="100%">
						<tr>
						<td>
						<form name="adminForm" action="{TARGET}" method="post">
						<input name="extmode" type="hidden" value="{MODE}" />
						<input name="cal_id" type="hidden" value="{CAL_ID}" />
						<table class="adminform">
						<!-- BEGIN errors_row -->
						<tr>
						<td colspan='2'>
						<img src='{THEME_DIR}/images/errormessage.gif' style='vertical-align: middle' alt='{ERRORS_ALT}' />&nbsp;<strong>{ERRORS}</strong>
						</td>
						</tr>
						<tr>
						<td class='tableb' colspan='2'>
						<div class='atomic'>{ERROR_MSG}</div>
						</td>
						</tr>
						<!-- END errors_row -->
						<!-- BEGIN cal_details_row -->
						<tr>
						<th colspan='2'>{CAL_DETAILS_CAPTION}</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{CAL_NAME_LABEL}</td>
						<td class='tableb'><input type='text' name='cal_name' class='textinput' value="{CAL_NAME_VAL}" size='25' />
						</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{DESC_LABEL}</td>
						<td class='tableb'><textarea name='description' cols='25' rows='3' class='textarea'>{DESC_VAL}</textarea>
						</td>
						</tr>
						<!-- END cal_details_row -->
						<tr>
						<td class='tableb' width='160'>{CALENDAR_LABEL}</td>
						<td class='tableb'>
						{CALENDARS_SELECT}
						</td>
						</tr>
						<tr>
						<td class='tableb' width='160'>{STATUS_LABEL}</td>
						<td class='tableb'>
						<input name="published" type="checkbox" value="1" {STATUS_CHK} />{STATUS_ACTIVE_LABEL}
						</td>
						</tr>
						<input type="hidden" name="option" value="$option" />
						<input type="hidden" name="task" value="" />
									</table>
							</form>
						</tr>
						</td>
		</table>
EOT;


// HTML template for the search form
$template_search_form = <<<EOT
						<!-- BEGIN message_row -->
						<tr class="tableb_search">
						<td colspan="3" align="center" valign="middle" class="tableb_search">
						<form action="{$mosConfig_live_site}/{$CONFIG_EXT['calendar_calling_page']}" method="POST">
							<input type='text' name='extcal_search' class='textinput' value="{KEY_DESC}" onfocus="if(this.value == '{KEY_DESC}') this.value='';" onblur="if(!this.value) this.value = '{KEY_DESC}';" size='25' />
								<input name='submit' type='submit' value="Go" class='button' />
								<input name='extmode' type='hidden' value="extcal_search" />
				</form>
						</td>
						</tr>

EOT;

// HTML template to display a specific event
$template_event_view = <<<EOT
						<!-- BEGIN info_row -->
						<tr>
						<td class="tablec" width="50%" >
							<table width='100%' cellpadding='0' cellspacing='0' border='0'>
							<tr>
							<td width='6' bgcolor='{BG_COLOR}'>
							<img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='6' height='{CATEGORY_COLOR_SPACER_IMAGE_HEIGHT}' alt='' />
							</td>
							<td valign='middle' width='100%'>&nbsp;
							<a {CAT_LINK} class='cattitle'>{CAT_NAME}</a><br />
							<div class='catdesc'>{CAT_DESC}</div>
							</td>
							</tr>
							</table>
						</td>
						<td class="tablec" width="50%">
						<div class="atomic"><span class="label">{EVENT_START_DATE_LABEL}</span> {EVENT_START_DATE}</div>
						<!-- BEGIN duration_row -->
						<div class="atomic"><span class="label">{EVENT_DURATION_LABEL}</span> {EVENT_DURATION}</div>
						<!-- END duration_row -->
						<!-- BEGIN recurrence_row -->
						<div class="atomic"><span class="label">{EVENT_RECURRENCE_LABEL}</span> {EVENT_RECURRENCE}</div>
						<!-- END recurrence_row -->
						<!-- BEGIN private_row -->
						<div class="atomic"><span class="label">{EVENT_PRIVATE}</span></div>
						<!-- END private_row -->
						</td>
						</tr>
						<!-- END info_row -->
						<!-- BEGIN contact_row -->
						<tr class="tablec">
						<td class="tablec" colspan="2">
						<table width='100%' cellpadding='0' cellspacing='4' border='0' align="center">
						<td width="50%" valign="top">
						<div class="atomic"><span class="label">{CONTACT_INFO_LABEL}</span></div>
						<div class="atomic">{CONTACT_INFO}</div>
						</td>
						<td width="50%">
						<div class="atomic"><span class="label">{CONTACT_EMAIL_LABEL}</span> {CONTACT_EMAIL}</a></div>
						<div class="atomic"><span class="label">{CONTACT_URL_LABEL}</span> <a href="{CONTACT_URL}" target="{CONTACT_URL_TARGET}">{CONTACT_URL}</a></div>
						</td>
						</table>
						</td>
						</tr>
						<!-- END contact_row -->
						<!-- BEGIN result_row -->
						<tr class="tableb" style="height: 30px">
						<td class='tableb' colspan="2" valign='middle'>
						<img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='1' height='8' alt='' /><br />
						<div class='eventdesclarge'>{EVENT_DESC}</div>
						<br />
						</td>
						</tr>
<!-- END result_row -->
<!-- BEGIN nav_row -->
						<tr>
						<td class='tablec' colspan='2' align='center' valign='middle' height='40'>
								<input name='back' type='button' onclick="{BACK_LINK}" value="&nbsp;&nbsp;{BACK_BUTTON}&nbsp;&nbsp;" class='button' />
						</td>
						</tr>
<!-- END nav_row -->
EOT;


// HTML template for a list of events within a category
$template_cat_events_list = <<<EOT
						<!-- BEGIN info1_row -->
						<tr class="tablec">
						<td class="tablec" colspan="2" align="left" nowrap='nowrap'><img src='{$CONFIG_EXT['calendar_url']}themes/default/images/icon-cat-active.gif' alt='{CATEGORY_INFO}' style='vertical-align: middle' />&nbsp;<span class="atomic">{CATEGORY_DESC}</span></td>
						</tr>
<!-- BEGIN noevents_row -->
						<tr class="tableb">
						<td class="tableb" colspan="2" align="center"><span class="noevents">{NO_EVENTS}</span>&nbsp;&nbsp;</td>
						</tr>
<!-- END noevents_row -->
<!-- END info1_row -->
<!-- BEGIN info2_row -->
						<tr class="tableh2">
						<td class="tableh2" width="90%">{EVENT_NAME}</td>
						<td class="tableh2" align="center" nowrap='nowrap'>{EVENT_DATE}</td>
						</tr>
<!-- END info2_row -->
<!-- BEGIN result_row -->
						<tr class="tableb" style="height: 30px">
						<td class='tableb' valign='middle'><a {LINK} class='eventtitle'>{EVENT_NAME}</a>
						</td>
						<td class='tableb' align='center' valign='middle' nowrap='nowrap'><span class='atomic'>{EVENT_DATE}</span></td>
						</tr>
<!-- END result_row -->
<!-- BEGIN stats_row -->
						<tr class="tablec">
						<td class="tablec" colspan="2" align="right"><span class="atomic">{STATS}&nbsp;&nbsp;</span></td>
						</tr>
<!-- END stats_row -->
EOT;

// HTML template for a list of active categories
$template_cats_list = <<<EOT
						<!-- BEGIN info_row -->
						<tr class="tableh2">
						<td class="tableh2" width="90%">{CAT_NAME}</td>
						<td class="tableh2" align="center" nowrap='nowrap'>{UPCOMING_EVENTS}</td>
						<td class="tableh2" align="center" nowrap='nowrap'>{TOTAL_EVENTS}</td>
						</tr>
						<!-- END info_row -->
						<!-- BEGIN result_row -->
						<tr>
						<td>
						<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tr>
						<td width='6' bgcolor='{BG_COLOR}'>
						<img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='6' height='25' alt=''/>
						</td>
						<td class='tableb' valign='middle' width='100%'>
						<a href='{LINK}' class='cattitle'>{CAT_NAME}</a><br />
						<div class='catdesc'>{CAT_DESC}</div>
						</td>
								</tr>
						</table>
						</td>
						<td class='tableb' align='center' valign='middle'>{UPCOMING_EVENTS}</td>
						<td class='tableb' align='center' valign='middle'>{TOTAL_EVENTS}</td>
						</tr>
<!-- END result_row -->
<!-- BEGIN stats_row -->
						<tr class="tablec">
						<td class="tablec" colspan="3" align="right"><span class="atomic">{STATS}&nbsp;&nbsp;</span></td>
						</tr>
<!-- END stats_row -->
EOT;

// HTML template for the search results
$template_search_results = <<<EOT

						<!-- BEGIN no_results_row -->
						<tr class="tableb">
						<td class="tableb" colspan="4" align="center"><br /><br /><span class="noevents">{NO_RESULTS}</span><br /><br /><br /></td>
						</tr>
						<!-- END no_results_row -->
						<!-- BEGIN info_row -->
						<tr class="tableh2">
						<td width="80%" nowrap='nowrap' class="tableh2">
						<span class="jcsearch_results">{SEARCH_RESULTS}</span>
						</td>
						<td align='center' nowrap='nowrap' class="tableh2">
						<span class="jccat">{CATEGORY}</span>
						</td>
						<td align='center' nowrap='nowrap' class="tableh2">
						<span class="jcdate">{DATE}</span>
						</td>
						</tr>
						<!-- END info_row -->
						<!-- BEGIN result_row -->
						<tr class="tableb">
						<td width="80%" nowrap='nowrap' class="tableb">
						<a {SEARCH_LNK} class='searchlink'>{SEARCH_TITLE}</a><br />
						<img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='1' height='5' alt='' /><br />
						<div class='searchdesc'>{SEARCH_DESC}</div>
						<img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' width='1' height='8' alt='' /><br />
						</td>
						<td align='center' nowrap='nowrap' class="tableb">
						<a href='{CAT_LINK}'>{CAT_NAME}</a>
						</td>
						<td align='center' nowrap='nowrap' class="tableb">
						<span class='atomic'>{DATE}</span>
						</td>
						</tr>
						<!-- END result_row -->
						<!-- BEGIN stats_row -->
						<tr class="tablec">
						<td class="tablec" colspan="3" align="right"><span class="atomic">{STATS}&nbsp;&nbsp;</span></td>
						</tr>
						<!-- END stats_row -->
						<!-- BEGIN search_row -->

						<!-- BEGIN message_row -->
						<tr class="tableb_search">
						<td colspan="3" align="center" valign="middle" class="tableb_search">
						<form action="{$mosConfig_live_site}/{$CONFIG_EXT['calendar_calling_page']}" method="POST">
							<input type='text' id='cal_search_input' name='extcal_search' class='textinput' value="{KEY_DESC}" onfocus="if(this.value == '{KEY_DESC}') this.value='';" onblur="if(!this.value) this.value = '{KEY_DESC}';" size='25' />
								<input name='submit' type='submit' value="Go" class='button' />
								<input name='extmode' type='hidden' value="extcal_search" />
						</form>
						</td>
						</tr>
<!-- END search_row -->
EOT;

// HTML template for the legend of color-coded categories
$template_cat_legend = <<<EOT
						<!-- BEGIN header_row -->
						<tr>
						<td colspan="{ROWS}" class="tablec">
						<table border="0" cellspacing="5" cellpadding="0" width="100%">
						<!-- END header_row -->
						<!-- BEGIN start_col_row -->
						<tr>
						<!-- END start_col_row -->
						<!-- BEGIN today_row -->
						<td bgcolor="{COLOR}" class="legend-color-borders" width="20">
						<img src="$mosConfig_live_site/components/com_jcalpro/images/spacer.gif" width="5" height="5" alt="" />
						</td>
						<td class="legend">{TODAY}&nbsp;&nbsp;</td>
						<!-- END today_row -->
						<!-- BEGIN cats_row -->
						<td bgcolor="{COLOR}" class="legend-color-borders" width="20">
						<img src="$mosConfig_live_site/components/com_jcalpro/images/spacer.gif" width="5" height="5" alt="" />
						</td>
						<td class="legend">
						<a {CAT_LINK}>{CAT_NAME}</a>&nbsp;&nbsp;
						</td>
						<!-- END cats_row -->
						<!-- BEGIN empty_cell_row -->
						<td width="5" height="5">
						<img src="$mosConfig_live_site/components/com_jcalpro/images/spacer.gif" width="5" height="5" alt="" />
								</td>
								<td>&nbsp;</td>
<!-- END empty_cell_row -->
<!-- BEGIN end_col_row -->
						</tr>
<!-- END end_col_row -->
<!-- BEGIN footer_row -->
						</table>
		</td>
</tr>
<!-- END footer_row -->
EOT;

// HTML template for the events to approve
$template_admin_events = <<<EOT
						<!-- BEGIN filter_row -->
						<tr class="tablec">
						<td height="35" colspan="5" nowrap='nowrap' class="tablec" align="right" valign="middle"><span class="atomic">{EVENTS_FILTER_LABEL}:</span>&nbsp;
						<form name="filter" action="{FILTER_LINK}" method="post">
						<select name='eventfilter' class='listbox' onchange="this.form.submit()">
						{EVENTS_FILTER_OPTIONS}
						</select>
						</form>
						</td>
						</tr>
						<!-- END filter_row -->
						<!-- BEGIN noevents_row -->
						<tr class="tableb">
						<td class="tableb" colspan="5" align="center"><span class="noevents">{NO_EVENTS}</span>&nbsp;&nbsp;</td>
						</tr>
						<!-- END noevents_row -->
						<!-- BEGIN info_row -->
						<tr class="tableh2">
						<td colspan="1" width="90%" nowrap='nowrap' class="tableh2">{EVENT_STAT}</td>
						<td nowrap='nowrap' class="tableh2">
						&nbsp;
						</td>
						<td align='center' nowrap='nowrap' class="tableh2">{DATE}</td>
						<td align='center' nowrap='nowrap' class="tableh2">{ACTION}</td>
						</tr>
						<!-- END info_row -->
						<!-- BEGIN result_row -->
						<tr>
						<td width="90%" nowrap='nowrap'>
						<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tr>
						<td width='6' bgcolor='{BG_COLOR}'>
						<img src='$mosConfig_live_site/components/com_jcalpro/images/spacer.gif' alt="{CAT_NAME}" width='6' height='40' />
						</td>
						<td width='18' class='tablec'>
						<a href='{EVENT_LNK}'><img src="{STATUS_ICON}" alt="{STATUS}" border="0" /></a>
						</td>
						<td class='tableb' valign='middle' width='100%'>
						<a href='{EVENT_LNK}' class='eventtitle'>{EVENT_TITLE}</a>
						</td>
						</tr>
						</table>
						</td>
						<td align='center' class="tablec" valign="middle">
						{PICTURE}
						</td>
						<td align='center' nowrap='nowrap' class="tableb">
						<span class='atomic'>{DATE}</span>
						</td>
						<td align='center' nowrap='nowrap' class="tableb">
						<a href='{ADMIN_EDIT_EVENT_LINK}'><img src="{$CONFIG_EXT['calendar_url']}themes/default/images/icon-editevent.gif" alt="{EDIT}" hspace="2" border="0" /></a>
						<!-- BEGIN approve_row -->
						<a href='{ADMIN_APPROVE_EVENT_LINK}'><img src="{$CONFIG_EXT['calendar_url']}themes/default/images/icon-apprevent.gif" alt="{APPROVE}" hspace="2" border="0" /></a>
						<!-- END approve_row -->
						<a href='{ADMIN_DELETE_EVENT_LINK}' onclick="return verify('{DEL_MSG}')"><img src="{$CONFIG_EXT['calendar_url']}themes/default/images/icon-delevent.gif" alt="{DELETE}" hspace="2" border="0" /></a>
						</td>
						</tr>
<!-- END result_row -->
<!-- BEGIN stats_row -->
						<tr class="tablec">
						<td class="tablec" colspan="5" align="right"><span class="atomic">{STATS}&nbsp;&nbsp;</span></td>
						</tr>
<!-- END stats_row -->
EOT;

// HTML template for error strings in form validation
$template_error_string = <<<EOT
<div class='atomic'>
		<span style='color:red'>&middot;</span>&nbsp;{MESSAGE}
</div>
EOT;

// Custom template for the Admin Menu in Mambo installation
function theme_admin_menu() {
	global $CONFIG_EXT, $lang_event_admin_data, $event_mode;
	$db = &JFactory::getDBO();
	$my = &JFactory::getUser();
	/*  @comment_do_not_remove@ */
	$returnstring = '';
	if (has_priv("approve") && ($event_mode != 'view')) {
		// Only show that events need approval if user is administrator, if events actually exist,
		// and if you are not already viewing those events.
		$query = "SELECT extid FROM ".$CONFIG_EXT['TABLE_EVENTS']." WHERE approved = 0";
		$db->setQuery($query);
		$db->query();
		$rows = $db->getNumRows();
		if ($rows > 0) {
			define('ADMIN_EVENTS_PHP', true);
			include $CONFIG_EXT['LANGUAGES_DIR']."{$CONFIG_EXT['lang']}/index.php";
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&amp;extmode=event&amp;event_mode=view' );
			$linkstring = '<a href="'.$sef_href.'" class="button">&nbsp;'.$lang_event_admin_data['events_to_approve'].'&nbsp;('.$rows.')&nbsp;</a>';
			$returnstring = '
						<table class="toolbar">
						<tr>
							<td class="tableh1" align="center" nowrap="nowrap"><div class="atomic">'.$linkstring.'</div></td>
						</tr>
						</table>
';
		}
	}
	return $returnstring;
}

// HTML template for the page header
function jcPageHeader($section = '', $meta = '') {
	global $CONFIG_EXT, $THEME_DIR, $lang_event_admin_data, $event_mode, $mainframe;
	global $template_header, $meta_content, $lang_info, $lang_general, $lang_system;
	global $show_main_menu;

	// only display header for html pages
	/*  @comment_do_not_remove@ */
	$format = JRequest::getCmd( 'format');
	if ($format == 'ical') {
		return;
	}

	// when printing, don't display menu either
	$print = JRequest::getCmd( 'print', 0);
	// If this is a theme where the main menu bar is normally displayed, check with config
	// to see whether in fact to display it.
	if( $show_main_menu ) {
		$show_main_menu = empty( $print) && $CONFIG_EXT['show_top_navigation_bar'];
	}

	if(empty($section)) $section = $CONFIG_EXT['app_name'];

	if ($mainframe->isSite()) {
		$params = & $mainframe->getPageParameters( 'com_jcalpro');
		$isAPopup = JRequest::getCmd( 'tmpl', '') == 'component';
		$isShajax = JRequest::getCmd( 'shajax', false);
		$mustShowHeader = !$isShajax && !($isAPopup && $CONFIG_EXT['popup_event_mode']);
		$meta = $mustShowHeader && $params->def( 'show_page_title', 1 ) ? '<div class="componentheading' . $params->get( 'pageclass_sfx' ) . '"> '. htmlspecialchars($params->get('page_title')) . ' </div>' : '';
	} else {
		$meta = '';
	}

	$template_vars = array(
		'{META}' => $meta,
		'{CAL_NAME}' => $CONFIG_EXT['app_name'],
		'{MAIN_MENU}' => $show_main_menu ? theme_main_menu() : '',
		'{ADMIN_MENU}' => defined('IN_MAMBO_ADMIN_SECTION') ? '' : theme_admin_menu(),
		'{THEME_DIR}' => addslashes($THEME_DIR),
		'{MAIN_TABLE_WIDTH}' => $CONFIG_EXT['main_table_width']
	);

	echo template_eval($template_header, $template_vars);

	// add a section specific div
	global $extmode;
	if (!empty( $extmode)) {
		echo '<div class="jcl_'.  htmlspecialchars($extmode) . '">';
	}
}

// HTML template for the page footer
function pagefooter() {
	global $CONFIG_EXT, $THEME_DIR, $template_footer;

	$section = $CONFIG_EXT['app_name'];

	$template_vars = array(
		'{TITLE}' => $section,
		'{CAL_NAME}' => $CONFIG_EXT['app_name'],
		'{THEME_DIR}' => $THEME_DIR
	);

	// close section specific div
	global $extmode;
	if (!empty( $extmode)) {
		echo '</div>';
	}

	// now output footer
	echo template_eval($template_footer, $template_vars);

	//ob_end_flush();

}

// HTML template for pop-up page footer
function popup_pagefooter() {
	global $CONFIG_EXT, $THEME_DIR, $template_footer;

	$out =  '
						<div class="atomic"><span class="jcfooter">Powered by <a
						href="http://dev.anything-digital.com/" target="_blank">JCal
						Pro 2.x</a></span></div>
						</div>
						</div>
						</body>
						</html>
						<noscript><plaintext>
						';
	echo $out;
	ob_end_flush();
}

// Function to start a 'standard' table
function starttable($width = '-1', $title='', $title_colspan='1', $class = '', $date = '') {
	global $CONFIG_EXT;

	if ($width == '-1') $width = $CONFIG_EXT['main_table_width'];
	if ($width == '100%' ) $width = $CONFIG_EXT['main_table_width'];

	if (!empty($class)) {
		echo <<<EOT

								<!-- Start standard table -->
								<div class="jcl_center">
								<table class="$class">

EOT;
	} else {
		echo <<<EOT

								<!-- Start standard table -->
								<div class="jcl_center">
								<table class="maintable">

EOT;
	}

	if ($title) {
		echo <<<EOT
								<tr>
								<td class="tableh1" colspan="$title_colspan">
								<table class="jcl_basetable" >
								<tr>
								<td class="today">$title</td>
EOT;
		if ($date) {
			echo <<<EOT
									<td align="right" class="today">$date</td>
EOT;
		}
		echo <<<EOT
</tr>
						</table>
			</td>
		</tr>

EOT;
	}
}

function endtable() {
	echo <<<EOT
</table>
</div>
<!-- End standard table -->

EOT;
}

function theme_caption_dialog($title, $message, $menumessage = '', $width = "100%") {
	global $template_caption_dialog;

	if($menumessage) starttable($width,$title,1,'',$menumessage);
	else starttable($width,$title);

	template_extract_block($template_caption_dialog, 'redirect_row');
	$params = array('{MESSAGE}' => $message);
	echo template_eval($template_caption_dialog, $params);
	endtable();
}

function theme_redirect_dialog($title, $message, $button, $redirect) {

	jc_shRedirect( $redirect, $message);
}

function theme_calendar_locked() {
	global $lang_system;
	theme_caption_dialog($lang_system['system_caption'], $lang_system['calendar_locked'], '',450);
}

function theme_search_form($keyword, $button) {
	global $template_search_form, $lang_event_search_data;
	/*  @comment_do_not_remove@ */
	starttable('100%', $lang_event_search_data['section_title'], 1);
	$params = array(
		'{KEY_VAL}' => $keyword,
		'{KEY_DESC}' => $lang_event_search_data['search_caption'],
		'{SUBMIT}' => $button
	);
	echo template_eval($template_search_form, $params);
	endtable();
}

function theme_cat_events_list(&$results, $cat_info, $stats) {
	global $template_cat_events_list, $lang_cat_events_view, $today, $lang_date_format;
	$database = &JFactory::getDBO();

	$header1_row = template_extract_block($template_cat_events_list, 'info1_row');
	$header2_row = template_extract_block($template_cat_events_list, 'info2_row');
	$result_row = template_extract_block($template_cat_events_list, 'result_row');
	$stats_row = template_extract_block($template_cat_events_list, 'stats_row');

	// are we printing ?
	$isPrint = JRequest::getInt( 'print', 0) == 1;

	$today_date = jcTSToFormat( mktime(0,0,0,$today['month'],$today['day'],$today['year']), $lang_date_format['full_date']);
	$title = sprintf($lang_cat_events_view['section_title'],$cat_info['cat_name']);

	if ($isPrint) {
		echo jclGetPrintHeader($title);
	}

	/*  @comment_do_not_remove@ */
	starttable('100%', $title, 2, '', $today_date);

	$params = array(
		'{CATEGORY_INFO}' => $cat_info['cat_name'],
		'{CATEGORY_DESC}' => @$cat_info['description'].'',
		'{NO_EVENTS}' => $lang_cat_events_view['no_events']
	);
	if($stats['total_events']) template_extract_block($header1_row, 'noevents_row');
	echo template_eval($header1_row, $params);

	if($stats['total_events']) {
		$params = array(
			'{EVENT_NAME}' => $lang_cat_events_view['event_name'],
			'{EVENT_DATE}' => $lang_cat_events_view['event_date'],
		);
		echo template_eval($header2_row, $params);

		if (!empty( $results)) {
			foreach($results as $result) {

				$params = array(
					'{ID}' => $result['extid'],
					'{LINK}' => $result['link'],
					'{EVENT_NAME}' => $result['title'],
					//'{EVENT_DESC}' => $result['description'],
					'{EVENT_DATE}' => $result['date']
				);
				echo template_eval($result_row, $params);

			}
		}
	}
	$stats_string = sprintf($lang_cat_events_view['stats_string1'], $stats['total_events'], 1);
	$params = array(
		'{STATS}' => $stats_string
	);
	echo template_eval($stats_row, $params);

	endtable();
	echo "<br />";

	// set the page title
	$menu = & JSite::getMenu();
	$currentMenuItem = $menu->getActive();
	jclSetPageTitle($cat_info['cat_name'] . ' | ' . $currentMenuItem->name);
}

function theme_view_event(&$event, $is_popup = false, $feedsLink = '') {

	global $template_event_view, $lang_event_view, $lang_general, $lang_date_format, $lang_add_event_view, $extmode, $CONFIG_EXT, $REFERER, $THEME_DIR;
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	/*  @comment_do_not_remove@ */
	// insert rss feeds link in head if allowed
	jclInsertFeedsLinks( $feedsLink);

	$print_link = "<a href=\"Javascript://Print this Event\" title=\"Print this Event\" onclick=\"printDocument()\"><img src=\"$THEME_DIR/images/icon-print.gif\" border=\"0\" alt=\"Print\" /></a>";
	$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=event&amp;event_mode=edit&amp;extid=".$event->extid);
	if ($is_popup) {
		$edit_link_URL = "<a href=\"#\" onclick=\"javascript:window.parent.document.location.href='".$sef_href."'\" title=\"".$lang_event_view['edit_event']."\">" ;
	} else {
		$edit_link_URL = "<a href=\"".$sef_href."\" title=\"".$lang_event_view['edit_event']."\">" ;
	}
	$edit_link = jclCanModifyEvent( $event, $action = 'edit') ? $edit_link_URL."<img src='$THEME_DIR/images/icon-editevent.gif' alt='".$lang_event_view['edit_event']."' hspace='2' border='0' /></a>":"";;
	$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=event&amp;event_mode=del&amp;extid=".$event->extid . ( $is_popup ? '&amp;tmpl=component' : ''));
	$delete_link_URL = "<a href=\"".$sef_href."\" onclick=\"return verify('".$lang_event_view['delete_confirm']."')\" title=\"".$lang_event_view['delete_event']."\">" ;
	$delete_link = jclCanModifyEvent( $event, $action = 'delete') ? $delete_link_URL."<img src='$THEME_DIR/images/icon-delevent.gif' alt='".$lang_event_view['delete_event']."' hspace='2' border='0' /></a>":"";

	$width = $is_popup?(int)$CONFIG_EXT['popup_event_width']-20:'100%';
	starttable($width, sprintf($lang_event_view['display_event'],$event->title), 2, '', $print_link.$edit_link.$delete_link );

	if(empty($event->contact) && empty($event->email) && empty($event->url) ) {
		template_extract_block($template_event_view, 'contact_row');
	}

	$picture = empty($event->picture)?'':"<img src='".$CONFIG_EXT['UPLOAD_DIR_URL'].$event->picture."' border='0' align='right' hspace='8' alt='' />";

	$date_mask = $lang_date_format['full_date'];
	$startDateString = jcUTCDateToFormat( $event->start_date, $date_mask);
	// add time, except for all day events
	if (!jclIsAllDay( $event->end_date)) {
		$hour = jcUTCDateToFormat( $event->start_date, '%H');
		$minute = jcUTCDateToFormat( $event->start_date, '%M');
		$startDateString .= ' - ' . jcHourToDisplayString( $hour, $minute);
	}

	$duration_array = datestoduration ($event->start_date, $event->end_date);
	$days_string = $duration_array['days']?$duration_array['days']." ".$lang_general['day']. " ":'';
	$days_string = $duration_array['days']>1?$duration_array['days']." ".$lang_general['days']. " ":$days_string;
	$hours_string = $duration_array['hours']?$duration_array['hours']." ".$lang_general['hour']. " ":'';
	$hours_string = $duration_array['hours']>1?$duration_array['hours']." ".$lang_general['hours']. " ":$hours_string;
	$minutes_string = $duration_array['minutes']?$duration_array['minutes']." ".$lang_general['minute']:'';
	$minutes_string = $duration_array['minutes']>1?$duration_array['minutes']." ".$lang_general['minutes']:$minutes_string;

	$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=cat&amp;cat_id=".$event->cat );

	$connector = strpos( $sef_href, '?') !== false ? '&amp;' : '?';
	$sef_href .= $is_popup ? $connector . 'tmpl=component' : '';

	$cat_link_URL = $is_popup ? "href=\"".$sef_href."\" rel=\"{handler: \'iframe\'}\" title=\"".$event->catName."\""
	: "href='".$sef_href."'" ;

	// Does the event have a duration (or is "start date only" enabled in Settings):
	$noduration = ( jclIsNoEndDate($event->end_date) || $CONFIG_EXT['show_only_start_times'] ) ? true : false;

	if ( !$noduration ) {
		$durationString = jclIsAllDay( $event->end_date) ? EXTCAL_TEXT_ALL_DAY : $days_string.$hours_string.$minutes_string;
	}
	else { $durationString = ""; }

	// private attribute handling
	switch ($event->private) {
		case JCL_EVENT_PUBLIC:
		default:
			$private = '';
			break;
		case JCL_EVENT_PRIVATE:
			$private = $lang_add_event_view['private_event'];
			break;
		case JCL_EVENT_PRIVATE_READ_ONLY:
			$private = $lang_add_event_view['private_event_read_only'];
			break;
	}

	if (empty($private)) {
		// if nothing to display, remove row
		template_extract_block($template_event_view, 'private_row');
	}

	// chekc if a return url was set by referer of this request
	/*$returnTo = JRequest::getString( 'return_to');
	$returnTo = empty( $returnTo) ? get_referer() : base64_decode($returnTo);
	$returnTo = htmlentities( $returnTo, ENT_COMPAT, 'UTF-8');*/
	$returnTo = jclGetCookie( 'return_to');
	if (empty( $returnTo)) {
		jclSetCookie( 'return_to', get_referer());
	}

	// setup parameters to be sent to template
	$params = array(
		'{BACK_LINK}' => $is_popup?"self.close();":"location.href='". $returnTo ."'",
		'{BACK_BUTTON}' => $is_popup?$lang_general['close']:$lang_general['back'],
		'{PICTURE}' => $picture,
		'{BG_COLOR}' => $event->color,
		'{CAT_NAME}' => $event->catName,
		'{CAT_LINK}' => $cat_link_URL,
		'{CAT_DESC}' => $event->catDesc,
		'{CATEGORY_COLOR_SPACER_IMAGE_HEIGHT}' => ($event->isRecurrent() && $CONFIG_EXT['show_recurrence_info_event_view'] && !$noduration ) ? '60' : '40',
		'{EVENT_START_DATE_LABEL}' => $lang_event_view['event_start_date'].":",
		'{EVENT_DURATION_LABEL}' => $lang_event_view['event_duration'].":",
		'{EVENT_RECURRENCE_LABEL}' => $lang_add_event_view['repeat_event_label'].":",
		'{EVENT_START_DATE}' => $startDateString,
		'{EVENT_DURATION}' => $durationString,
		'{EVENT_RECURRENCE}' => mf_get_recurrence_info_string($event),
		'{CONTACT_INFO_LABEL}' => $lang_event_view['contact_info'].":",
		'{CONTACT_INFO}' => $event->contact,
		'{CONTACT_EMAIL_LABEL}' => $lang_event_view['contact_email'].":",
		'{CONTACT_EMAIL}' => $event->email,
		'{CONTACT_URL_LABEL}' => $lang_event_view['contact_url'].":",
		'{CONTACT_URL}' => htmlspecialchars($event->url),
		'{CONTACT_URL_TARGET}' => $CONFIG_EXT['url_target_for_events'],
		'{EVENT_DESC}' => str_replace( '<hr id="system-readmore" />', '<br />', $event->description),
		'{EVENT_PRIVATE}' => $private
	);

	if ( !$event->isRecurrent() || !$CONFIG_EXT['show_recurrence_info_event_view'] ) template_extract_block($template_event_view, 'recurrence_row');
	if ( $noduration ) template_extract_block($template_event_view, 'duration_row');
	if ( $CONFIG_EXT['popup_event_mode'] && $extmode == "view" ) template_extract_block($template_event_view, 'nav_row');
	echo template_eval($template_event_view, $params);

	endtable();
	echo "<br />";

	// set the page title
	jclSetPageTitle($event->title . ' | ' . $event->catName);

}

function theme_monthly_view($date, &$results, &$info_data) {
	global $template_monthly_view, $THEME_DIR, $lang_monthly_event_view, $lang_add_event_view;
	global $CONFIG_EXT, $today, $lang_date_format, $lang_general, $event_icons;
	global $todayclr, $weekdayclr, $sundayclr;
	global $sundayclrHl, $weekdayclrHl, $todayclrHl;
	global $option, $Itemid_Querystring;
	global $template_monthly_view_nav_row_sub_template, $template_monthly_view_print_nav_row_sub_template;

	// are we printing ?
	$isPrint = JRequest::getInt( 'print', 0) == 1;

	// insert rss feeds link in head if allowed
	/*  @comment_do_not_remove@ */
	if (!$isPrint) {
		jclInsertFeedsLinks( $info_data['feeds_main_link']);
	}

	// navigation row is different when printing
	if ($isPrint) {
		$navigation_row = template_extract_block($template_monthly_view_print_nav_row_sub_template, 'navigation_row');
		if ($CONFIG_EXT['cal_view_show_week']){
			$weekday_header_row = template_extract_block($template_monthly_view_print_nav_row_sub_template, 'weekday_header_row');
		} else {
			$weekday_header_row = template_extract_block($template_monthly_view_print_nav_row_sub_template, 'weekday_header_row_no_weeknumber');
		}
	} else {
		$navigation_row = template_extract_block($template_monthly_view_nav_row_sub_template, 'navigation_row');
		$weekday_header_row = template_extract_block($template_monthly_view_nav_row_sub_template, 'weekday_header_row');
	}

	// now rest of the template
	$weekday_cell_row = template_extract_block($template_monthly_view, 'weekday_cell_row');
	$weekday_footer_row = template_extract_block($template_monthly_view, 'weekday_footer_row');

	$day_cell_header_row = template_extract_block($template_monthly_view, 'day_cell_header_row');
	$weeknumber_cell_row = template_extract_block($template_monthly_view, 'weeknumber_cell_row');
	if (has_priv('add')) {
		$day_cell_row = template_extract_block($template_monthly_view, 'day_cell_row');
		template_extract_block($template_monthly_view, 'day_cell_row_no_plus_sign');
	} else {
		$day_cell_row = template_extract_block($template_monthly_view, 'day_cell_row_no_plus_sign');
		template_extract_block($template_monthly_view, 'day_cell_row');
	}
	$other_month_cell_row = template_extract_block($template_monthly_view, 'other_month_cell_row');
	$day_cell_footer_row = template_extract_block($template_monthly_view, 'day_cell_footer_row');

	//  make the days of week, consisting of seven days
	$firstday = jcTSToFormat( mktime(0,0,0,$date['month'],1,$date['year']), '%w');
	if ($CONFIG_EXT['day_start']) $firstday-=1;
	$firstday = ($firstday < 0)? $firstday + 7: $firstday%7;

	// number of days in selected month
	$nr = date( 't', TSServerToUser( mktime(0,0,0,$date['month'],5,$date['year'])));

	$today_date = jcTSToFormat( mktime(0,0,0,$today['month'],$today['day'],$today['year']), $lang_date_format['full_date']);

	$currentMonth = jcTSToFormat( mktime(0,0,0,$date['month'],1,$date['year']), $lang_date_format['month_year']);
	if ($isPrint) {
		// if printing echo current month name and a print button
		echo jclGetPrintHeader( $currentMonth);
	}

	starttable('100%', $lang_monthly_event_view['section_title'], $CONFIG_EXT['cal_view_show_week']?8:7, '', $today_date);

	$class = 'currentmonth' . ($date['month'] == $today['month'] && $date['year'] == $today['year'] ? ' currentmonthtoday' : '');

	if ($isPrint) {
		$params = array();
	} else {
		$params = array(
			'{PREVIOUS_MONTH}' => jcTSToFormat( mktime(0,0,0,$date['month']-1,1,$date['year']), $lang_date_format['month_year']),
			'{PREVIOUS_MONTH_URL}' => $info_data['previous_month_url'],
			'{CURRENT_MONTH}' => $currentMonth,
			'{BG_COLOR}' => $info_data['current_month_color'],
			'{NEXT_MONTH}' => jcTSToFormat( mktime(0,0,0,$date['month']+1,1,$date['year']), $lang_date_format['month_year']),
			'{NEXT_MONTH_URL}' => $info_data['next_month_url'],
			'{MONTHLY_VIEW_CLASS}' => $class
		);
		if(!$CONFIG_EXT['cal_view_show_week']) template_extract_block($navigation_row, 'weeknumber_row');
		if(!$info_data['show_past_months']) template_extract_block($navigation_row, 'previous_month_link_row');
	}
	// print navigation
	echo template_eval($navigation_row, $params);
	// print weekday labels
	echo $weekday_header_row;
	for ($i=0;$i<count($info_data['weekdays']);$i++) {
		$params = array(
			'{WEEK_DAY}' => $info_data['weekdays'][$i]['name'],
			'{CSS_CLASS}' => $info_data['weekdays'][$i]['class']
		);
		echo template_eval($weekday_cell_row, $params);
	}
	echo $weekday_footer_row;

	// print day cells
	$nbResults = count($results);
	for ($i=1-$firstday;$i<=$nbResults;$i+=7) {
		echo $day_cell_header_row;
		if($CONFIG_EXT['cal_view_show_week']) {
			$weeknumber_cell_row1 = str_replace('{WEEK_NUMBER}', $results[$i<1?1:$i]['week_number'], $weeknumber_cell_row);
			$week_stamp = mktime(0,0,0,$date['month'],$i + 6,$date['year']);
			$url_week_date = jcTSToFormat( $week_stamp, '%Y-%m-%d');
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=week&amp;date=".$url_week_date );
			echo str_replace('{URL_WEEK_VIEW}', $sef_href, $weeknumber_cell_row1);

		}
		for ($row=0;$row<7;$row++) {
			$day_stamp = mktime(0,0,0,$date['month'],$i + $row,$date['year']);
			$url_target_date = jcTSToFormat( $day_stamp, '%Y-%m-%d');
			if($i+$row<1 || $i+$row> $nr) {
				$date_string = jcTSToFormat( $day_stamp, $lang_date_format['month_year']);
				echo str_replace('{CELL_CONTENT}', $date_string,$other_month_cell_row);
			} else {
				$date_string = jcTSToFormat( $day_stamp, $lang_date_format['day_month_year']);
				if ($day_stamp == mktime(0,0,0,$today['month'],$today['day'],$today['year'])) {
					// higlight today's day
					$css_class = "todayclr";
					$hlColor = $todayclrHl;
					$regColor = $todayclr;
				} elseif (!(int)jcTSToFormat( $day_stamp, '%w')) {
					// use sunday colors
					$css_class = "sundayemptyclr";
					$hlColor = $sundayclrHl;
					$regColor = $sundayclr;
				} else {
					// use regular day colors
					$css_class = "weekdayclr";
					$hlColor = $weekdayclrHl;
					$regColor = $weekdayclr;
				}

				$event_list = '';
				if ( isset ( $results[($i + $row)]['events'] ) ) {
					$events = $results[($i + $row)]['events'];
					$noFollow = '';
				} else {
					$events = array();
					$noFollow = 'rel="nofollow"';
				}

				// Initialize the event object
				$nbEvents = count( $events);
				while (@is_array($events) && list(,$event_info) = each($events)) {

					$event = $event_info['eventdata'];

					$event_style = $event_info['style'];

					$event_icon = $event_info['icon'];
					// added private event icon
					$privateIcons = array( JCL_EVENT_PRIVATE => 'icon-private.gif', JCL_EVENT_PRIVATE_READ_ONLY => 'icon-private.gif');
					$privateMsgs = array( JCL_EVENT_PRIVATE => $lang_add_event_view['private_event'], JCL_EVENT_PRIVATE_READ_ONLY => $lang_add_event_view['private_event_read_only']);
					$privateIcon = $event_info['isPrivate'] != JCL_EVENT_PUBLIC ?
					"<img src='$THEME_DIR/images/{$privateIcons[$event_info['isPrivate']]}' hspace='2' alt='{$privateMsgs[$event_info['isPrivate']]}' title='{$privateMsgs[$event_info['isPrivate']]}'/>"
					: '';

					$event_list .= "<div class='$event_style'><div class='eventstyle' style='border-bottom-color: ".$event->color."'>" . $privateIcon . "<img src='$THEME_DIR/images/$event_icon' hspace='2' alt='' />";
					// popup or not

					if ($CONFIG_EXT['popup_event_mode']) {
						if ( isset( $event->cat_ext ) && $event->cat_ext == 'illbethere' ) {
							$non_sef_href = "index.php?option=com_illbethere&controller=events&task=view&id=".$event->extid . '&amp;tmpl=component'.getJomSocialItemid();
						} else if ( isset( $event->cat_ext ) && $event->cat_ext == 'community' ) {
							$non_sef_href = "index.php?option=com_community&amp;view=events&amp;task=viewevent&amp;eventid=".$event->extid . '&amp;tmpl=component'.getJomSocialItemid();
						} else {
							$non_sef_href = "index.php?option=" . $option . $Itemid_Querystring ."&amp;extmode=view&amp;extid=".$event->extid. '&amp;tmpl=component' . "&amp;date=$url_target_date";
						}
						$event_list .= '<a href="'.JRoute::_( $non_sef_href ).'" class="jcal_modal" rel="{handler: \'iframe\'}" >';
					} else {
						if ( isset( $event->cat_ext ) && $event->cat_ext == 'illbethere' ) {
							$sef_href = JRoute::_( "index.php?option=com_illbethere&controller=events&task=view&id=".$event->extid . getIllBeThereItemid() );
						} else if ( isset( $event->cat_ext ) && $event->cat_ext == 'community' ) {
							$sef_href = JRoute::_( "index.php?option=com_community&view=events&task=viewevent&eventid=".$event->extid . getJomSocialItemid());
						} else {
							$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=view&amp;extid=".$event->extid  . "&amp;date=$url_target_date" );
						}
						$event_list .= "<a href='".$sef_href."'>";
					}

					if ( $CONFIG_EXT['show_event_times_in_monthly_view'] ) {
						$event_date_string = ' ('.mf_get_timerange($event, $i + $row).')';
					} else {
						$event_date_string = '';
					}
					$title = format_text(sub_string($event->title,$CONFIG_EXT['cal_view_max_chars'],'...'),false,$CONFIG_EXT['capitalize_event_titles']).$event_date_string;

					$event_list .= $title."</a></div></div>";
				}
				$sef_href_1 = empty( $noFollow) ? '<a href="' . JRoute::_( $CONFIG_EXT['calendar_calling_page'] . "&amp;extmode=day&amp;date=$url_target_date" )
				. '" ' . $noFollow . ' >'
				. ($i + $row) . '</a>'
				: ($i + $row);
				//$sef_href_2 = JRoute::_( $CONFIG_EXT['calendar_calling_page'] . "&amp;extmode=event&amp;event_mode=add&amp;date=$url_target_date"  . (empty( $returnTo) ? '' : '&return_to=' . $returnTo));
				$sef_href_2 = JRoute::_( $CONFIG_EXT['calendar_calling_page'] . "&amp;extmode=event&amp;event_mode=add&amp;date=$url_target_date");
				$params = array(
					'{DAY}' => $i + $row,
					'{URL_TARGET_DATE}' => $url_target_date,
					'{DAY_CLASS}' => $css_class,
					'{CELL_CONTENT}' => $event_list,
					'{BG_COLOR}' => $regColor,
					'{HOVER_BG_COLOR}' => $hlColor,
					'{DATE_STRING}' => $date_string,
					'{THEME_DIR}' => addslashes($THEME_DIR),
					'{DAY_VIEW_LINK}' => $sef_href_1,
					'{ADD_EVENT_LINK}' => $sef_href_2,
					'{NOFOLLOW}' => $noFollow
				);
				echo template_eval($day_cell_row, $params);
			}
		}
		echo $day_cell_footer_row;
	}

	display_cat_legend ($CONFIG_EXT['cal_view_show_week']?8:7, 1);

	endtable();

	// set the page title
	$menu = & JSite::getMenu();
	$currentMenuItem = $menu->getActive();
	$currentMenuItemName = empty( $currentMenuItem ) ? '' : ' | ' . $currentMenuItem->name;
	jclSetPageTitle( $currentMonth . $currentMenuItemName, 'extcalendar');

	jclSetReturnValue( $date['month'],1,$date['year']);

}

function theme_mini_cal_view($date, &$results, &$info_data) {
	global $template_mini_cal_view, $THEME_DIR, $lang_mini_cal;
	global $CONFIG_EXT, $today, $lang_date_format, $lang_general, $event_icons, $extcal_code_insert;
	global $todayclr, $weekdayclr, $sundayclr;
	global $sundayclrHl, $weekdayclrHl, $todayclrHl;

	$template_mini_cal_view1 = $template_mini_cal_view;
	// replace global variables
	$template_mini_cal_view1 = str_replace('{THEME_DIR}', $THEME_DIR,$template_mini_cal_view1);
	$template_mini_cal_view1 = str_replace('{TARGET}', $info_data['target'],$template_mini_cal_view1);


	$header_row = template_extract_block($template_mini_cal_view1, 'header_row');
	$navigation_row = template_extract_block($template_mini_cal_view1, 'navigation_row');
	$picture_row = template_extract_block($template_mini_cal_view1, 'picture_row');
	$footer_row = template_extract_block($template_mini_cal_view1, 'footer_row');

	$weekday_header_row = template_extract_block($template_mini_cal_view1, 'weekday_header_row');
	$weekday_cell_row = template_extract_block($template_mini_cal_view1, 'weekday_cell_row');
	$weekday_footer_row = template_extract_block($template_mini_cal_view1, 'weekday_footer_row');

	$day_cell_header_row = template_extract_block($template_mini_cal_view1, 'day_cell_header_row');
	$weeknumber_cell_row = template_extract_block($template_mini_cal_view1, 'weeknumber_cell_row');
	$day_cell_row = template_extract_block($template_mini_cal_view1, 'day_cell_row');
	$other_month_cell_row = template_extract_block($template_mini_cal_view1, 'other_month_cell_row');
	$day_cell_footer_row = template_extract_block($template_mini_cal_view1, 'day_cell_footer_row');
	$inline_style_row = template_extract_block($template_mini_cal_view1, 'inline_style_row');

	if($info_data['day_link']) template_extract_block($day_cell_row, 'static_row');
	else template_extract_block($day_cell_row, 'linkable_row');

	//  make the days of week, consisting of seven days
	$firstday = jcTSToFormat(  mktime(0,0,0,$date['month'],1,$date['year']), '%w');
	if ($CONFIG_EXT['day_start']) $firstday-=1;
	//if (!$firstday && $CONFIG_EXT['day_start']) $firstday = 7;
	$firstday = ($firstday < 0)? $firstday + 7: $firstday%7;

	// number of days in asked month
	$nr = date( 't', TSServerToUser( mktime(0,0,0,$date['month'],5,$date['year'])));

	$today_date = jcTSToFormat(  mktime(0,0,0,$today['month'],$today['day'],$today['year']), $lang_date_format['full_date']);
	//starttable('100%', $lang_monthly_event_view['section_title'], $CONFIG_EXT['cal_view_show_week']?8:7, '', $today_date);
	echo $header_row;
	$params = array(
		'{PREVIOUS_MONTH}' => jcTSToFormat( mktime(0,0,0,$date['month']-1,1,$date['year']), $lang_date_format['month_year']),
		'{PREVIOUS_MONTH_URL}' => $info_data['previous_month_url'],
		'{CURRENT_MONTH}' => jcTSToFormat( mktime(0,0,0,$date['month'],1,$date['year']), $lang_date_format['month_year']),
		'{NEXT_MONTH}' => jcTSToFormat( mktime(0,0,0,$date['month']+1,1,$date['year']), $lang_date_format['month_year']),
		'{NEXT_MONTH_URL}' => $info_data['next_month_url'],
	);
	if(!$CONFIG_EXT['cal_view_show_week']) template_extract_block($navigation_row, 'weeknumber_row');
	if(!$info_data['show_past_months']) {
		template_extract_block($navigation_row, 'previous_month_link_row');
	} else {
		template_extract_block($navigation_row, 'no_previous_month_link_row');
	}
	if($info_data['navigation_controls']) {
		template_extract_block($navigation_row, 'without_navigation_row');
	} else {
		template_extract_block($navigation_row, 'with_navigation_row');
	}
	echo template_eval($navigation_row, $params);

	if(isset($info_data['picture_info'])) {
		$params = array(
			'{PICTURE_URL}' => $CONFIG_EXT['MINI_PICS_URL'].$info_data['picture_info']['picture_url'],
			'{PICTURE_MESSAGE}' => $info_data['picture_info']['picture_message'],
			'{STATUS_MESSAGE}' => jcTSToFormat( mktime(0,0,0,$date['month'],1,$date['year']), $lang_date_format['month_year']),
			'{TODAY_URL}' => $info_data['current_month_url']
		);

		echo template_eval($picture_row, $params);
	}

	//echo $weekdays_row;

	// print weekday labels
	echo $weekday_header_row;
	for ($i=0;$i<count($info_data['weekdays']);$i++) {
		$params = array(
			'{WEEK_DAY}' => $info_data['weekdays'][$i]['name'],
			'{CSS_CLASS}' => $info_data['weekdays'][$i]['class']
		);
		echo template_eval($weekday_cell_row, $params);
	}
	echo $weekday_footer_row;


	// print day cells
	for ($i=1-$firstday;$i<=count($results);$i+=7) {
		echo $day_cell_header_row;
		if($CONFIG_EXT['cal_view_show_week']) {
			$weeknumber_cell_row1 = $weeknumber_cell_row;
			$weeknumber = $results[$i<1?1:$i]['week_number'];
			$week_stamp = mktime(0,0,0,$date['month'],$i + 6,$date['year']);
			$url_week_date = jcTSToFormat( $week_stamp, '%Y-%m-%d');
			$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=week&amp;date=".$url_week_date );
			$params = array(
				'{URL_WEEK_VIEW}' => $sef_href,
				'{WEEK_NUMBER}' => sprintf($lang_mini_cal['selected_week'],$weeknumber)
			);
			echo template_eval( $weeknumber_cell_row1, $params);
		}
		for ($row=0;$row<7;$row++) {
			$day_stamp = mktime(0,0,0,$date['month'],$i + $row,$date['year']);
			if($i+$row<1 || $i+$row> $nr) {
				//$date_string = ucwords(strftime($lang_date_format['month_year'], $day_stamp));
				$date_string = '';
				echo str_replace('{CELL_CONTENT}', $date_string,$other_month_cell_row);
			} else {
				$url_target_date = $results[($i + $row)]['date_link'];
				$events = $results[($i + $row)]['num_events'];
				$num_events =  $info_data['day_link']?(int)$events:0;
				$date_string = jcTSToFormat( $day_stamp, $lang_date_format['day_month_year']);
				if ($day_stamp == mktime(0,0,0,$today['month'],$today['day'],$today['year'])) {
					// higlight today's day
					$css_class = "extcal_todaycell";
					$link_class = $num_events?"extcal_busylink":"extcal_daylink";
					$hlColor = $todayclrHl;
					$regColor = $todayclr;
				} elseif (!(int)jcTSToFormat( $day_stamp, '%w')) {
					// use sunday colors
					$css_class = "extcal_sundaycell";
					$link_class = $num_events?"extcal_busylink":"extcal_sundaylink";
					$hlColor = $sundayclrHl;
					$regColor = $sundayclr;
				} else {
					// use regular day colors
					$css_class = "extcal_daycell";
					$link_class = $num_events?"extcal_busylink":"extcal_daylink";
					$hlColor = $weekdayclrHl;
					$regColor = $weekdayclr;
				}

				$params = array(
					'{DAY}' => $i + $row,
					'{URL_TARGET_DATE}' => $url_target_date,
					'{DAY_CLASS}' => $css_class,
					'{DAY_LINK_CLASS}' => $link_class,
					'{CELL_CONTENT}' => sprintf($lang_mini_cal['num_events'],$num_events),
					'{BG_COLOR}' => $regColor,
					'{HOVER_BG_COLOR}' => $hlColor,
					'{DATE_STRING}' => $date_string
				);
				echo template_eval($day_cell_row, $params);
			}
		}
		echo $day_cell_footer_row;
	}
	if(!$CONFIG_EXT['add_event_view'] || !has_priv('add') ) template_extract_block($footer_row, 'add_event_row');
	$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] . "&amp;extmode=event&amp;event_mode=add" );
	$params = array(
		'{ADD_EVENT_URL}' => $sef_href ,
		'{ADD_EVENT_TITLE}' => $lang_mini_cal['post_event']
	);
	echo template_eval($footer_row, $params);
	if(!$extcal_code_insert) {
		//$extcal_code_insert = 1;
		echo $inline_style_row;
	}
}

function theme_cats_list(&$results, $stats_string) {
	global $template_cats_list, $lang_cats_view, $today, $lang_date_format;

	$header_row = template_extract_block($template_cats_list, 'info_row');
	$result_row = template_extract_block($template_cats_list, 'result_row');
	$stats_row = template_extract_block($template_cats_list, 'stats_row');

	$today_date = jcTSToFormat( mktime(0,0,0,$today['month'],$today['day'],$today['year']), $lang_date_format['full_date']);

	// are we printing ?
	$isPrint = JRequest::getInt( 'print', 0) == 1;

	// set the page title
	$menu = & JSite::getMenu();
	$currentMenuItem = $menu->getActive();
	jclSetPageTitle( $lang_cats_view['section_title'] . ' | ' . $currentMenuItem->name, 'extcalendar');
	/*  @comment_do_not_remove@ */

	if ($isPrint) {
		echo jclGetPrintHeader($lang_cats_view['section_title']);
	}

	starttable('100%', $lang_cats_view['section_title'], 3, '', $today_date);

	$params = array(
		'{CAT_NAME}' => $lang_cats_view['cat_name'],
		'{TOTAL_EVENTS}' => $lang_cats_view['total_events'],
		'{UPCOMING_EVENTS}' => $lang_cats_view['upcoming_events']
	);
	echo template_eval($header_row, $params);

	if (!empty($results)) {
		foreach($results as $result) {

			$params = array(
				'{CAT_ID}' => $result['cat_id'],
				'{LINK}' => $result['link'],
				'{CAT_NAME}' => $result['cat_name'],
				'{CAT_DESC}' => $result['description'],
				'{BG_COLOR}' => $result['color'],
				'{TOTAL_EVENTS}' => $result['total_events'],
				'{UPCOMING_EVENTS}' => $result['upcoming_events']
			);
			echo template_eval($result_row, $params);
		}
	}
	$params = array(
		'{STATS}' => $stats_string
	);
	echo template_eval($stats_row, $params);

	endtable();

}

function theme_search_results(&$results, $rows) {
	global $template_search_results, $lang_event_search_data;
	global $CONFIG_EXT;

	$search_row = template_extract_block($template_search_results, 'search_row');
	$no_results_row = template_extract_block($template_search_results, 'no_results_row');
	$header_row = template_extract_block($template_search_results, 'info_row');
	$result_row = template_extract_block($template_search_results, 'result_row');
	/*  @comment_do_not_remove@ */
	$stats_row = template_extract_block($template_search_results, 'stats_row');

	if(count($_POST)) {

		// set the page title
		$menu = & JSite::getMenu();
		$currentMenuItem = $menu->getActive();
		jclSetPageTitle( $lang_event_search_data['search_results'] . ' | ' . $currentMenuItem->name, 'extcalendar');

		starttable('100%', $lang_event_search_data['search_results'], 3);

		$params = array(
			'{NO_RESULTS}' => $lang_event_search_data['no_results']
		);
		if(!$rows) {
			echo template_eval($no_results_row, $params);
		} else {
			$params = array(
				'{SEARCH_RESULTS}' => sprintf($lang_event_search_data['stats_string1'],(int)$rows),
				'{CATEGORY}' => $lang_event_search_data['category_label'],
				'{DATE}' => $lang_event_search_data['date_label']
			);
			echo template_eval($header_row, $params);

			if (!empty( $results)) {
				foreach($results as $result) {

					$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&amp;extmode=cat&amp;cat_id='.$result['cat_id'] );
					$params = array(
						'{SEARCH_TITLE}' => $result['search_title'],
						'{SEARCH_LNK}' => $result['search_link'],
						'{SEARCH_DESC}' => $result['search_desc'],
						'{CAT_ID}' => $result['cat_id'],
						'{CAT_NAME}' => $result['cat_name'],
						'{CAT_LINK}' => $sef_href,
						'{DATE}' => $result['date']
					);
					echo template_eval($result_row, $params);

				}
			}
			$params = array(
				'{STATS}' => sprintf($lang_event_search_data['stats_string2'],(int)$rows, 1),
			);
			echo template_eval($stats_row, $params);
		}
	} else starttable('100%', $lang_event_search_data['section_title'], 3);

	$keyword = JRequest::getVar( 'extcal_search', $lang_event_search_data['search_caption'], 'POST');
	$button = (isset($_POST["extcal_search"]) && !empty($_POST["extcal_search"])) ?$lang_event_search_data['search_again']:$lang_event_search_data['search_button'];


	$params = array(
		'{KEY_VAL}' => $keyword,
		'{KEY_DESC}' => $lang_event_search_data['search_caption'],
		'{SUBMIT}' => $button
	);
	echo template_eval($search_row, $params);

	endtable();
	echo "<br />";
}

function theme_admin_events(&$results, $rows, $section_title, $filter=0) {
	global $CONFIG_EXT, $template_admin_events, $lang_event_admin_data, $THEME_DIR;

	$filter_row = template_extract_block($template_admin_events, 'filter_row');
	$noevents_row = template_extract_block($template_admin_events, 'noevents_row');
	$header_row = template_extract_block($template_admin_events, 'info_row');
	$result_row = template_extract_block($template_admin_events, 'result_row');
	$stats_row = template_extract_block($template_admin_events, 'stats_row');
	/*  @comment_do_not_remove@ */
	$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'] . "&amp;extmode=add" );
	starttable("100%",$section_title,5,"", "<img src='".$THEME_DIR."/images/icon-add.gif' style='vertical-align: alt='Add new' middle' hspace='4' /><a href='".$sef_href."'>".$lang_event_admin_data['add_event']."</a>");
	// generate filter options for event list select menu
	$event_filter_options = '';
	for ($i = 0;$i<sizeof($lang_event_admin_data['events_filter_options']);$i++) {
		$selected = ($filter==$i)?'selected="selected"':'';
		$event_filter_options .= "\t<option value='$i' $selected>".$lang_event_admin_data['events_filter_options'][$i]."</option>\n";
	}
	$sef_href = JRoute::_( $CONFIG_EXT['calendar_calling_page'].'&amp;extmode=event&amp;event_mode=view' );
	$params = array(
		'{FILTER_LINK}' => $sef_href,
		'{EVENTS_FILTER_LABEL}' => $lang_event_admin_data['events_filter_label'],
		'{EVENTS_FILTER_OPTIONS}' => $event_filter_options
	);
	echo template_eval($filter_row, $params);

	$params = array(
		'{NO_EVENTS}' => $lang_event_admin_data['no_events']
	);
	if(!$rows) echo template_eval($noevents_row, $params);
	else {

		$params = array(
			'{EVENT_STAT}' => sprintf($lang_event_admin_data['stats_string1'],$rows),
			'{DATE}' => $lang_event_admin_data['date_label'],
			'{ACTION}' => $lang_event_admin_data['actions_label']
		);
		echo template_eval($header_row, $params);

		foreach($results as $result) {
			$result_row1 = $result_row;
			$recur_ext = $result['event_recur_type']?"recur-":"";
			$status_icon = $result['event_status']?$THEME_DIR."/images/icon-".$recur_ext."event-active.gif":$THEME_DIR."/images/icon-".$recur_ext."event-inactive.gif";
			$params = array(
				'{EVENT_ID}' => $result['event_id'],
				'{EVENT_TITLE}' => $result['event_title'],
				'{EVENT_LNK}' => $result['event_link'],
				'{EVENT_DESC}' => $result['event_desc'],
				'{ADMIN_EDIT_EVENT_LINK}' => JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=event&amp;event_mode=edit&amp;extid=".$result['event_id'] ),
				'{ADMIN_APPROVE_EVENT_LINK}' => JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=event&amp;event_mode=apr&amp;extid=".$result['event_id'] ),
				'{ADMIN_DELETE_EVENT_LINK}' => JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=event&amp;event_mode=del&amp;extid=".$result['event_id'] ),
				'{STATUS}' => $result['event_status']?addslashes($lang_event_admin_data['active_label']):addslashes($lang_event_admin_data['not_active_label']),

				'{STATUS_ICON}' => $status_icon,
				'{PICTURE}' => $result['event_picture']?"<img
							src='".$THEME_DIR."/images/icon-photo.gif'
							alt='".addslashes($lang_event_admin_data['picture_attached'])."' />":"",
				'{CAT_ID}' => $result['cat_id'], '{CAT_NAME}' => $result['cat_name'],
				'{BG_COLOR}' => $result['color'], '{DATE}' => $result['date'],
				'{EDIT}' => $lang_event_admin_data['edit_event'], '{APPROVE}' =>
				$lang_event_admin_data['auto_approve'], '{DELETE}' =>
				$lang_event_admin_data['delete_event'], '{DEL_MSG}' =>
				$lang_event_admin_data['delete_confirm']
			);
			if($result['event_status']) template_extract_block($result_row1, 'approve_row');
			echo template_eval($result_row1, $params);

		}

	}

	$params = array(
		'{STATS}' => sprintf($lang_event_admin_data['stats_string2'],$rows,1)
	);
	echo template_eval($stats_row, $params);

	endtable();
	echo "<br />";
}

function theme_main_menu() {
	global $CONFIG_EXT, $REFERER, $HTTP_SERVER_VARS, $mainframe;
	global $template_main_menu, $lang_main_menu, $template_calendar_select_sub_template;

	static $main_menu = '';

	// if ($main_menu != '') return $main_menu;

	$template_main_menu1 = '
						<table class="toolbar" >
						<tr>
							<td class="tableh1" align="center">
							'. $template_main_menu .'
							</td>
						</tr>
						</table>
							';

	// JCal 2 : add a return to url, for cancelling some forms
	if (!$CONFIG_EXT['add_event_view'] || !has_priv('add')) {
		template_extract_block($template_main_menu1, 'add_event');
		$add_event_tgt = '';
	}
	// get current values for main parameters
	$current_extmode = JRequest::getCmd( 'extmode');
	$currentDate = JRequest::getString( 'date');
	$current_event_mode = JRequest::getCmd( 'event_mode');
	$current_extid = JRequest::getCmd( 'extid');
	$current_cat_id = JRequest::getCmd( 'cat_id');
	$current_cal_id = JRequest::getCmd( 'cal_id');
	$current_cal_id_query = empty( $current_cal_id) ? '' : '&amp;cal_id='.$current_cal_id;
	$add_event_tgt = JRoute::_( $CONFIG_EXT['calendar_calling_page']."&amp;extmode=event&amp;event_mode=add" );

	// preserve current date when moving from one view to the next
	$currentDatesByView = jclGetCurrentDatesByView( $currentDate);

	// current url without calendar id information
	$baseUrl = $CONFIG_EXT['calendar_calling_page']
	. (empty( $current_extmode) ? '' : '&amp;extmode='.$current_extmode)
	. (empty( $$current_event_mode) ? '' : '&amp;event_mode='.$current_event_mode)
	. (empty( $current_extid) ? '' : '&amp;extid='.$current_extid)
	. (empty( $current_cat_id) ? '' : '&amp;cat_id='.$current_cat_id)
	. (empty( $currentDate) ? '' : '&amp;date='.$currentDatesByView[$current_extmode]);

	// full return to url
	if ($current_extmode != 'event') {
		//$returnTo = base64_encode( $baseUrl . (empty( $current_cal_id) ? '' : $current_cal_id_query));
		$returnTo = $baseUrl . (empty( $current_cal_id) ? '' : $current_cal_id_query);
	} else {
		$returnTo = JRequest::getString( 'return_to');
	}
	/*if (!empty( $returnTo)) {
	$connector = strpos( $add_event_tgt, '?') !== false ? '&amp;' : '?';
	$add_event_tgt .= $connector . 'return_to=' . $returnTo;
	}*/
	//jclSetCookie( 'return_to', $returnTo);

	if (!$CONFIG_EXT['cats_view']) template_extract_block($template_main_menu1, 'cat_view');
	if (!$CONFIG_EXT['daily_view']) template_extract_block($template_main_menu1, 'daily_view');
	if (!$CONFIG_EXT['weekly_view']) template_extract_block($template_main_menu1, 'weekly_view');
	if (!$CONFIG_EXT['monthly_view']) template_extract_block($template_main_menu1, 'monthly_view');
	if (!$CONFIG_EXT['flyer_view']) template_extract_block($template_main_menu1, 'flyer_view');
	if (!$CONFIG_EXT['search_view']) template_extract_block($template_main_menu1, 'search_view');
	if (!$CONFIG_EXT['show_ical_export_menu_icon']) template_extract_block($template_main_menu1, 'ical_view');

	// added check : hide ical icon when not suitable to current display mode
	if ($CONFIG_EXT['show_ical_export_menu_icon'] && ($current_extmode == 'cats' || $current_extmode == 'extcal_search')) {
		template_extract_block($template_main_menu1, 'ical_view');
	}

	// added check : hide print icon when not suitable to current display mode
	if (!$CONFIG_EXT['show_print_menu_icon'] || ( $current_extmode == 'extcal_search')) {
		template_extract_block($template_main_menu1, 'print_view');
	}

	$param = array(
		'{URL}' => $CONFIG_EXT['calendar_url'],
		'{ADD_EVENT_TGT}' => $add_event_tgt,
		'{ADD_EVENT_POPUP}' => '',
		'{ADD_EVENT_LNK}' => $lang_main_menu['add_event'],
		'{CAL_VIEW_TGT}' => JRoute::_($CONFIG_EXT['calendar_calling_page']."&amp;extmode=cal" . $current_cal_id_query . $currentDatesByView['cal']),
		'{CAL_VIEW_LNK}' => $lang_main_menu['cal_view'],
		'{FLYER_VIEW_TGT}' => JRoute::_($CONFIG_EXT['calendar_calling_page']."&amp;extmode=flat" . $current_cal_id_query . $currentDatesByView['flat']),
		'{FLYER_VIEW_LNK}' => $lang_main_menu['flat_view'],
		'{WEEKVIEW_TGT}'=> JRoute::_($CONFIG_EXT['calendar_calling_page']."&amp;extmode=week" . $current_cal_id_query . $currentDatesByView['week']),
		'{WEEKVIEW_LNK}'=> $lang_main_menu['weekly_view'],
		'{DAYVIEW_TGT}' => JRoute::_($CONFIG_EXT['calendar_calling_page']."&amp;extmode=day" . $current_cal_id_query . $currentDatesByView['day']),
		'{DAYVIEW_LNK}' => $lang_main_menu['daily_view'],
		'{CAT_VIEW_TGT}'=> JRoute::_($CONFIG_EXT['calendar_calling_page']."&amp;extmode=cats"  . $current_cal_id_query),
		'{CAT_VIEW_LNK}'=> $lang_main_menu['categories_view'],
		'{SEARCH_TGT}'=> JRoute::_($CONFIG_EXT['calendar_calling_page']."&amp;extmode=extcal_search"  . $current_cal_id_query),
		'{SEARCH_LNK}'=> $lang_main_menu['search_view'],
		'{ICAL_TGT}'=> JRoute::_($baseUrl . '&amp;format=ical'),
		'{ICAL_LNK}'=> $lang_main_menu['ical_view'],
		'{PRINT_TGT}'=> JRoute::_($baseUrl . '&amp;print=1&amp;tmpl=component'),
		'{PRINT_LNK}'=> $lang_main_menu['print_view'],

	);

	// evaluate calendar selection sub-template

	// we must have a extmode, to decide to show or not the calendar select list
	// on direct links from menu, this may be missing ie : index.php?option=com_jcalpro&Itemid=12
	// however, be don't want to put it in the url if redirecting, that may cause duplicate content
	if (empty( $current_extmode)) {
		// get default vars set by admin either globally or on a menu item basis
		$pageParams = & $mainframe->getPageParameters( 'com_jcalpro');
		$current_extmode = JRequest::getCmd( 'extmode', $pageParams->get( 'extmode'));
	}
	// set a list of pages where the calendar list should be displayed, and display only on those
	/*  @comment_do_not_remove@ */
	$eventModes = array( 'cal', 'flat', 'week', 'day', 'cats', '');  // show cal select list only on some pages
	$values = array(
		'{SEL_CALS_LABEL}' =>  'Select calendar'
		,'{SEL_CALS_VAL}' =>  ($current_extmode == 'view' ? '' : jclBuildCalendarList( $current_cal_id, $baseUrl))
		,'{SEL_CALS_URL}' =>  ($current_extmode == 'view' ? '' : $CONFIG_EXT['calendar_calling_page'])
	);
	$sub_template = $CONFIG_EXT['enable_multiple_calendars'] && in_array($current_extmode, $eventModes) && $values['{SEL_CALS_VAL}'] != '' ? template_eval( $template_calendar_select_sub_template, $values) : '';
	$param['{CALENDAR_SELECT_SUB_TEMPLATE}'] = $sub_template;

	$main_menu = template_eval($template_main_menu1, $param);
	return $main_menu;
}