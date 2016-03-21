<?php
/*
 **********************************************
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
 $Id: index.php 667 2011-01-24 21:02:32Z jeffchannell $
 **********************************************
 Get the latest version of JCal Pro at:
 http://dev.anything-digital.com//
 **********************************************
 */
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// New language structure
$lang_info = array (
	'name' => 'Danish'
	,'nativename' => 'Dansk' // Language name in native language. E.g: 'Français' for 'French'
	,'locale' => array('da_DK','dansk') // Standard locale alternatives for a specific language. For reference, go to: http://www.php.net/manual/en/function.setlocale.php
	,'charset' => 'UTF-8' // For reference, go to : http://www.w3.org/International/O-charset-lang.html
	,'direction' => 'ltr' // 'ltr' for Left to Right. 'rtl' for Right to Left languages such as Arabic.
	,'author' => 'mijji, wkn & Andyman'
	,'author_email' => 'none'
	,'author_url' => 'none'
	,'transdate' => '04/20/2005'
	);
	$lang_general = array (
	'yes' => 'Ja'
	,'no' => 'Nej'
	,'back' => 'Tilbage'
	,'continue' => 'Fortsæt'
	,'close' => 'Luk'
	,'errors' => 'Fejl'
	,'info' => 'Information'
	,'day' => 'Dag'
	,'days' => 'Dage'
	,'month' => 'Måned'
	,'months' => 'Måneder'
	,'year' => 'År'
	,'years' => 'År'
	,'hour' => 'Time'
	,'hours' => 'Timer'
	,'minute' => 'Minut'
	,'minutes' => 'Minutter'
	,'everyday' => 'Hver dag'
	,'everymonth' => 'Hver måned'
	,'everyyear' => 'Hvert år'
	,'active' => 'Aktiv'
	,'not_active' => 'Ikke aktiv'
	,'today' => 'I dag'
	,'signature' => 'Drevet af %s'
	,'expand' => 'Åbn'
	,'collapse' => 'Luk'
	,'any_calendar' => 'Show all calendars'
	,'noon' => 'noon'
	,'midnight' => 'midnight'
	,'am' => 'am'
	,'pm' => 'pm'
	);
	// Date formats, For reference, go to : http://www.php.net/manual/en/function.strftime.php
	$lang_date_format = array (
	'full_date' => '%A, %d %B, %Y' // e.g. Wednesday, June 05, 2002
	,'full_date_time_24hour' => '%A, %d %B, %Y kl. %H:%M' // e.g. Wednesday, June 05, 2002 At 21:05
	,'full_date_time_12hour' => '%A, %d %B, %Y kl. %I:%M %p' // e.g. Wednesday, June 05, 2002 At 9:05 pm
	,'day_month_year' => '%d-%b-%Y' // e.g 10-Sep-2004
	,'local_date' => '%c' // Preferred Dato and time representation for current language
	,'mini_date' => '%a. %d %b, %Y'
	,'month_year' => '%B %Y'
	,'day_of_week' => array('Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag')
	,'months' => array('Januar','Februar','Marts','April','Maj','Juni','Juli','August','September','Oktober','November','December')
	// Jcal Pro 2.1.x
	,'date_entry' => '%Y-%m-%d'
	);
	$lang_system = array (
	'system_caption' => 'Systembesked'
	,'page_access_denied' => 'Du har ikke adgang til at se denne side.'
	,'page_requires_login' => 'Du skal være logget ind for at se denne side.'
	,'operation_denied' => 'Du har ikke adgang til at udføre denne opgave.'
	,'section_disabled' => 'Denne del er ikke aktiv.'
	,'non_exist_cat' => 'Den valgte kategori eksisterer ikke.'
	,'non_exist_event' => 'Det valgte begivenhed eksisterer ikke.'
	,'param_missing' => 'De opgivne oplysninger er ikke korrekte.'
	,'no_event' => 'Der er ingen begivenheder i kalenderen.'
	,'config_string' => 'Du bruger p.t. \'%s\' på %s, %s and %s.'
	,'no_table' => 'Tabellen \'%s\' eksisterer ikke!'
	,'no_anonymous_group' => 'Tabellen %s indeholder ikke gruppen \'Anonym\'!'
	,'calendar_locked' => 'Kalenderen er midlertidigt lukket ned for vedligeholdelse. Vi beklager de gener det måtte medføre!'
	,'new_upgrade' => 'Systemet har registreret en ny version. Vi anbefaler at opgradere nu. Klik "Fortsæt" for at køre opgraderingsværktøjet.'
	,'no_profile' => 'Der skete en fejl, mens din profilinformation blev hentet.'
	,'unknown_component' => 'Ukendt komponent'
	// Mail messages
	,'new_event_subject' => 'En begivenhed kræver godkendelse i %s'
	,'event_notification_failed' => 'Der opstod en fejl i forsøget på at sende en påmindelse!'
	
	,'show_required_privileges' => 'Your user level is %s, while this requires to be %s'  // JCal 2.1
	,'template_block_not_found' => '<b>Template error<b><br />Failed to find block \'%s\' in :<br /><pre>%s</pre>'
	,'template_file_not_found' => '<b>JCAL Pro critical error</b>:<br />Unable to load template file %s!</b>'
	);
	// Message body for new event email notification
	$lang_system['Begivenhed_notification_body'] = <<<EOT
Den følgende begivenhed er netop blevet foreslået til {CALENDAR_NAME}
og kræver godkendelse:
Overskrift: "{TITLE}"
Dato: "{DATE}"
Varighed: "{DURATION}"
Du kan se denne begivenhed ved at klikke på linket herunder eller kopiere det til din browser
{LINK}
Bemærk at du skal være logget ind som administrator
for at linket skal virke.
Venlig hilsen
Administrationen for {CALENDAR_NAME}
EOT;
	// Admin menu entries
	$lang_admin_menu = array (
	'login' => 'Log ind'
	,'register' => 'Registrer'
	,'logout' => 'Log ud <span style="color:#FF9922">[<span style="color:#606F79">%s</span>]</span>'
	,'user_profile' => 'Min profil'
	,'admin_event' => 'Begivenheder'
	,'admin_categories' => 'Kategorier'
	,'admin_groups' => 'Grupper'
	,'admin_users' => 'Brugere'
	,'admin_settings' => 'Indstillinger'
	);
	// Main menu entries
	$lang_main_menu = array (
	'add_event' => 'Tilføj begivenhed'
	,'cal_view' => 'Månedlig'
	,'flat_view' => 'Flad visning'
	,'weekly_view' => 'Ugentlig'
	,'daily_view' => 'Daglig'
	,'yearly_view' => 'Årlig'
	,'categories_view' => 'Kategorier'
	,'search_view' => 'Søg'
	,'ical_view' => 'get as iCal'
	,'print_view' => 'Print'
	);
	// ======================================================
	// Add event view
	// ======================================================
	$lang_add_event_view = array(
	'section_title' => 'Tilføj begivenhed'
	,'edit_event' => 'Ret i begivenhed [id%d] \'%s\''
	,'update_event_button' => 'Opdater begivenhed'
	// event details
	,'event_details_label' => 'Begivenhedsoplysninger'
	,'event_title' => 'Begivenhedsoverskrift'
	,'event_desc' => 'Beskrivelse af begivenhed'
	,'event_cat' => 'Kategori'
	,'choose_cat' => 'Vælg en kategori'
	,'event_date' => 'Dato for begivenhed'
	,'day_label' => 'Dag'
	,'month_label' => 'Måned'
	,'year_label' => 'År'
	,'start_date_label' => 'Startdato'
	,'start_time_label' => 'kl.'
	,'end_date_label' => 'Varighed'
	,'all_day_label' => 'Hele dagen'
	// Contact details
	,'contact_details_label' => 'Kontaktoplysninger'
	,'contact_info' => 'Kontaktinformation'
	,'contact_email' => 'E-mail'
	,'contact_url' => 'Websted'
	// Repeat Begivenheder
	,'repeat_event_label' => 'Gentag begivenhed'
	,'repeat_method_label' => 'Gentag metode'
	,'repeat_none' => 'Gentag ikke denne begivenhed'
	,'repeat_every' => 'Gentag hver'
	,'repeat_days' => 'dag(e)'
	,'repeat_weeks' => 'uge(r)'
	,'repeat_months' => 'måned(er)'
	,'repeat_years' => 'år'
	,'repeat_end_date_label' => 'Gentag slutdato'
	,'repeat_end_date_none' => 'Ingen slutdato'
	,'repeat_end_date_count' => 'Slut efter %s gentagelser'
	,'repeat_end_date_until' => 'Gentag indtil'
	// new JCalpro 2
	,'repeat_event_detached' => 'This event was part of a repetition series, but has been modified and separated from it'
	,'repeat_event_detached_short' => 'Detached from recurrence'
	,'repeat_event_not_detached' => 'This event is part of a repetition series'
	,'repeat_edit_parent_event' => 'Edit parent event'
	,'deleted_child_events' => 'Deleted %d previous instances'
	,'created_child_events' => 'Created a total of %d repetitions of event %s. View this event by <a href="%s" >clicking here</a>.'  // Jcal Pro 2.1.x
	// Andre Oplysninger
	,'other_details_label' => 'Andre oplysninger'
	,'picture_file' => 'Billedfil'
	,'file_upload_info' => '(Maksimal størrelse: %d Kb  - Gyldige filtyper : %s )'
	,'del_picture' => 'Slet nuværende billede ?'
	// Administrative options
	,'admin_options_label' => 'Administrative muligheder'
	,'auto_appr_event' => 'Begivenhed godkendt'
	// Error messages
	,'no_title' => 'Du skal skrive en overskrift!'
	,'no_desc' => 'Du skal skrive en beskrivelse!'
	,'no_cat' => 'Du skal vælge en kategori fra menuen!'
	,'date_invalid' => 'Du skal angive en gyldig dato!'
	,'end_days_invalid' => 'Værdien indtastet i \'Dage\' feltet er ikke gyldig!'
	,'end_hours_invalid' => 'Værdien indtastet i \'Timer\' feltet er ikke gyldig!'
	,'end_minutes_invalid' => 'Værdien indtastet i \'Minutter\' feltet er ikke gyldig!'
	,'non_valid_extension' => 'Filformatet af det tilføjede billede er ikke gyldigt! (Gyldige formater: %s)'
	,'file_too_large' => 'Det tilføjede billede er større end %d Kb!'
	,'move_image_failed' => 'Systemet kunne ikke uploade billedet ordentligt. Tjek venligst at det er den rette størrelse og i et gyldigt format, eller kontakt administratoren.'
	,'non_valid_dimensions' => 'Billedets bredde eller højde er større end %s pixels!'
	,'recur_val_1_invalid' => 'Værdien indtastet i \'gentag interval\' er ikke gyldig. Værdien skal være et tal større end \'0\'!'
	,'recur_end_count_invalid' => 'Værdien indtastet i \'antal gentagelser\' er ikke gyldig. Værdien skal være et tal større end \'0\'!'
	,'recur_end_until_invalid' => 'Datoen i \'gentag indtil\' skal være efter startdatoen!'
	,'no_recur_end_date' => 'A recurring event should have an end-date or a number of occurences'
	// new JCalpro 2
	,'failed_existing_event_update' => 'Database error during update of event %s (%d)'
	,'failed_child_event_deletion' => 'Database error deleting children of event %s (%d)'
	,'failed_child_event_creation' => 'Database error creating children of event %s (%d)'
	,'no_calendar' => 'You must select a calendar from the drop down menu !'
	,'event_cal' => 'Calendar'
	,'private_event' => 'Private event'
	,'private_event_read_only' => 'Private event, others can read'
	,'public_event' => 'Public event'
	,'privacy' => 'Privacy'
	,'failed_event_creation' => 'Database error while trying to create this event'
	// Misc. messages JCal 2.1
	,'submit_event_pending' => 'Din begivenhed er afsendt. Den vil dog ikke kunne ses i kalenderen før den er godkendt af en administrator. Tak for dit bidrag!'
	,'submit_event_approved' => 'Din begivenhed er automatisk godkendt. View this event by <a href="%s" >clicking here</a>. Tak for dit bidrag!'
	,'event_repeat_msg' => 'Denne begivenhed gentages'
	,'event_no_repeat_msg' => 'Denne begivenhed gentages ikke'
	,'recur_start_date_invalid' => 'Start date is not valid. For a recurring event, start date must be on the first recurrence of the series (ie: if recurring every tuesday, start date has to be a tuesday)'
	
	// new JCalPro 2.1
	,'repeat_daily' => 'Repeat daily'
	,'repeat_weekly' => 'Repeat weekly'
	,'repeat_monthly' => 'Repeat monthly'
	,'repeat_yearly' => 'Repeat yearly'
	,'rec_weekly_on' => 'on :'
	,'rec_monthly_on' => 'on the:'
	,'rec_yearly_on' => 'on the:'
	,'rec_day_first' => 'first'
	,'rec_day_second' => 'second'
	,'rec_day_third' => 'third'
	,'rec_day_fourth' => 'fourth'
	,'rec_day_last' => 'last'
	,'rec_day_day' => 'day'
	,'rec_day_week_day' => 'week day'
	,'rec_day_weekend_day' => 'week-end day'
	,'rec_yearly_on_month_label' => 'in'
	);
	// ======================================================
	// daily view
	// ======================================================
	$lang_daily_event_view = array(
	'section_title' => 'Daglig'
	,'next_day' => 'Næste dag'
	,'previous_day' => 'Forrige dag'
	,'no_events' => 'Der er ingen begivenheder denne dag.'
	);
	// ======================================================
	// weekly view
	// ======================================================
	$lang_weekly_event_view = array(
	'section_title' => 'Ugentlig'
	,'week_period' => '%s - %s'
	,'next_week' => 'Næste uge'
	,'previous_week' => 'Forrige uge'
	,'selected_week' => 'Uge %d'
	,'no_events' => 'Der er ingen begivenheder denne uge'
	);
	// ======================================================
	// monthly view
	// ======================================================
	$lang_monthly_event_view = array(
	'section_title' => 'Månedlig'
	,'next_month' => 'Næste måned'
	,'previous_month' => 'Forrige måned'
	);
	// ======================================================
	// flat view
	// ======================================================
	$lang_flat_event_view = array(
	'section_title' => 'Flad visning'
	,'week_period' => '%s - %s'
	,'next_month' => 'Næste måned'
	,'previous_month' => 'Forrige måned'
	,'contact_info' => 'Kontaktinformation'
	,'contact_email' => 'E-mail'
	,'contact_url' => 'Websted'
	,'no_events' => 'Der er ingen begivenheder denne måned'
	);
	// ======================================================
	// Begivenhed view
	// ======================================================
	$lang_event_view = array(
	'section_title' => 'Vis begivenhed'
	,'display_event' => 'Begivenhed: \'%s\''
	,'cat_name' => 'Kategori'
	,'event_start_date' => 'Dato'
	,'event_end_date' => 'Indtil'
	,'event_duration' => 'Varighed'
	,'contact_info' => 'Kontaktinformation'
	,'contact_email' => 'E-mail'
	,'contact_url' => 'Website'
	,'no_event' => 'Der er ingen begivenheder'
	,'stats_string' => '<strong>%d</strong> begivenheder i alt'
	,'edit_event' => 'Rediger begivenhed'
	,'delete_event' => 'Slet begivenhed'
	,'delete_confirm' => 'Er du sikker på at du vil slette denne begivenhed?'
	
	);
	// ======================================================
	// Categories view
	// ======================================================
	$lang_cats_view = array(
	'section_title' => 'Vis kategorier'
	,'cat_name' => 'Kategorinavn'
	,'total_events' => 'Begivenheder i alt'
	,'upcoming_events' => 'Kommende begivenheder'
	,'no_cats' => 'Der er ingen kategorier.'
	,'stats_string' => 'Der er <strong>%d</strong> begivenheder i <strong>%d</strong> kategorier'
	);
	// ======================================================
	// Kategori Begivenheder view
	// ======================================================
	$lang_cat_events_view = array(
	'section_title' => 'Begivenhed under \'%s\''
	,'event_name' => 'Begivenhedsnavn'
	,'event_date' => 'Dato'
	,'no_events' => 'Der er ingen begivenheder under denne kategori.'
	,'stats_string' => '<strong>%d</strong> begivenheder ialt.'
	,'stats_string1' => '<strong>%d</strong> begivenhed(er) på <strong>%d</strong> side(r)'
	);
	// ======================================================
	// cal_search.php
	// ======================================================
	$lang_event_search_data = array(
	'section_title' => 'Søg i kalender',
	'search_results' => 'Søgeresultater',
	'category_label' => 'Kategori',
	'date_label' => 'Dato',
	'no_event' => 'Der er ingen begivenheder under denne kategori.',
	'search_caption' => 'Indtast søgeord...',
	'search_again' => 'Søg igen',
	'search_button' => 'Søg',
	// Misc.
	'no_results' => 'Søgningen fandt intet.',	
	// Stats
	'stats_string1' => 'Søgningen fandt <strong>%d</strong> begivenhed(er)',
	'stats_string2' => 'Søgningen fandt <strong>%d</strong> begivenhed(er) på <strong>%d</strong> side(r)'
	);
	// ======================================================
	// profile.php
	// ======================================================

	if (defined('PROFILE_PHP'))
	$lang_user_profile_data = array(
	'section_title' => 'Min profil',
	'edit_profile' => 'Ret min profil',
	'update_profile' => 'Opdater min profil',
	'actions_label' => 'Aktioner',  
	// Account Info
	'account_info_label' => 'Profil-information',
	'user_name' => 'Brugernavn',
	'user_pass' => 'Adgangskode',
	'user_pass_confirm' => 'Bekræft adgangskode',
	'user_email' => 'E-mail-adresse',
	'group_label' => 'Gruppemedlemskab',
	// Andre Oplysninger
	'other_details_label' => 'Andre detaljer',
	'first_name' => 'Fornavn',
	'last_name' => 'Efternavn',
	'full_name' => 'Fuldt navn',
	'user_website' => 'Hjemmeside',
	'user_location' => 'Hjemby',
	'user_occupation' => 'Beskæftigelse',
	// Misc.
	'select_language' => 'Vælg sprog',
	'edit_profile_success' => 'Din profil er opdateret',
	'update_pass_info' => 'Lad adgangskodefelterne være tomme, hvis du ikke vil ændre din nuværende adgangskode',
	// Error messages
	'invalid_password' => 'Indtast en adgangskode, der udelukkende består af bogstaver og tal, og som er mellem 4 og 16 tegn langt!',
	'password_is_username' => 'Adgangskode skal være forskellig fra brugernavnet!',
	'password_not_match' =>'De indtastede adgangskoder var forskellige',
	'invalid_email' => 'Du skal indtaste en gyldig e-mail-adresse!',
	'email_exists' => 'En anden bruger er allerede registreret med den e-mail-adresse du har indtastet. Indtast en anden e-mail-adresse!',
	'no_email' => 'Du skal indtaste en e-mail-adresse!',
	'no_password' => 'Du skal indtaste en adgangskode!'
	);
	// ======================================================
	// register.php
	// ======================================================
	if (defined('USER_REGISTRATION_PHP'))
	$lang_user_registration_data = array(
	'section_title' => 'Brugerregistrering',
	// Step 1: Terms & Conditions
	'terms_caption' => 'Brugerbetingelser',
	'terms_intro' => 'For at fortsætte, skal du godkende flg.:',
	'terms_message' => 'Læs venligst reglerne herunder. Hvis du kan acceptere dem og ønsker at fortsætte med registreringen, så klik på "Godkend"-knappen herunder. For at afbryde registreringen, tryk på din \'Tilbage\'-knap i din browser.<br /><br />Bemærk venligst at vi ikke er ansvarlige for begivenheder indtastet af brugerne. Vi er ikke ansvarlige for nøjagtigheden, fuldstændigheden eller brugbarheden af de offentliggjorte begivenheder, ej heller for indholdet af begivenhederne.<br /><br />Teksterne udtrykker forfatteren af begivenhedernes synspunkt, ikke nødvendigvis denne kalenderapplikations synspunkt. Enhver bruger, som finder at en offentliggjort begivenhed er anstødelig, opfordres til straks at kontakte os via e-mail. Vi har mulighed for at slette anstødeligt indhold, og vi bestræber os på at gøre dette indenfor en rimelig tidsramme, såfremt vi afgør at sletning er nødvendig.<br /><br />Du samtykker i forbindelse med brugen af denne service i, at du ikke vil bruge denne kalenderapplikation til at offentliggøre materiale, som du ved er usand og/eller ærekrænkende, unøjagtig, stødende, vulgært, hadefuldt, chikanerende, uanstændigt, blasfemisk, seksuelt orienteret, truende, krænker privatlivets fred eller på anden måder krænker danske love.<br/><br/>Du samtykker i, at du ikke vil offentliggøre copyright-beskyttet materiale medmindre rettighederne ejes af dig eller af %s.',
	'terms_button' => 'Godkend',
	/////////////////////////////////////////////////////////////////TERMS_MESSAGE er ikke 100% oversat.

	// Account Info
	'account_info_label' => 'Profil-information',
	'user_name' => 'Brugernavn',
	'user_pass' => 'Adgangskode',
	'user_pass_confirm' => 'Godkend adgangskode',
	'user_email' => 'E-mail',
	// Andre Oplysninger
	'other_details_label' => 'Andre oplysninger',
	'first_name' => 'Fornavn',
	'last_name' => 'Efternavn',
	'user_website' => 'Hjemmeside',
	'user_location' => 'Hjemby',
	'user_occupation' => 'Beskæftigelse',
	'register_button' => 'Indsend min registrering',

	// Stats
	'stats_string1' => '<strong>%d</strong> brugere',
	'stats_string2' => '<strong>%d</strong> brugere på <strong>%d</strong> side(r)',
	// Misc.
	'reg_nomail_success' => 'Tak for din registrering.',
	'reg_mail_success' => 'En e-mail med informaion om hvordan du aktiverer din konto er blevet sendt til den e-mail-adresse du indtastede.',
	'reg_activation_success' => 'Tillykke! Din profil er nu aktiv og du kan logge ind med dit brugernavn og adgangskode. Tak for din registrering.',
	// Mail messages
	'reg_confirm_subject' => 'Registrering hos %s',

	// Error messages
	'no_username' => 'Du skal indtaste et brugernavn!',
	'invalid_username' => 'Indtast et brugernavn, der kun består af bogstaver og tal, og er mellem 4 og 30 tegn langt!',
	'username_exists' => 'Brugernavnet du indtastede er optaget. Indtast et nyt brugernavn!',
	'no_password' => 'Du skal indtaste en adgangskode!',
	'invalid_password' => 'Indtast en adgangskode, der kun består af bogstaver og tal, og er mellem 4 og 16 tegn langt!',
	'password_is_username' => 'Adgangskoden skal være forskellig fra brugernavnet!',
	'password_not_match' =>'De indtastede adgangskoder var forskellige',
	'no_email' => 'Du skal indtaste en e-mail!',
	'invalid_email' => 'Du skal skrive en gyldig e-mail-adresse!',
	'email_exists' => 'En anden bruger er registreret med den e-mail-adresse du indtastede. Indtast en anden e-mail-adresse.!',
	'delete_user_failed' => 'Denne profil kan ikke slettes',
	'no_users' => 'Der er ingen brugerprofiler!',
	'already_logged' => 'Du er allerede logget ind som medlem!',
	'registration_not_allowed' => 'Brugerregistrering er ikke aktiv!',
	'reg_email_failed' => 'Der skete en fejl under afsendelse af aktiveringsmail!',
	'reg_activation_failed' => 'Der skete en fejl under godkendelsen af aktiveringen'

	);
	// Message body for email activation
	$lang_user_registration_data['reg_confirm_body'] = <<<EOT
Tak fordi du registrede dig i {CALENDAR_NAME}
Dit brugernavn er: "{USERNAME}"
Din adgangskode er: "{PASSWORD}"
For at aktivere din profil skal du klikke på linket herunder
eller kopiere det til din webbrowser
{REG_LINK}
Venlig hilsen
Administratoren i {CALENDAR_NAME}
EOT;
	// ======================================================
	// theme.php
	// ======================================================
	// To Be Done
	// ======================================================
	// functions.inc.php
	// ======================================================
	// To Be Done
	// ======================================================
	// dblib.php
	// ======================================================
	// To Be Done
	// ======================================================
	// admin_Begivenheder.php
	// ======================================================
	if (defined('ADMIN_EVENTS_PHP'))
	$lang_event_admin_data = array(
	'section_title' => 'Begivenhedsadministration',
	'events_to_approve' => 'Begivenhedsadministration: Begivenheder, der afventer godkendelse',
	'upcoming_event' => 'Begivenhedsadministration: Kommende begivenheder',
	'past_event' => 'Begivenhedsadministration: Tidligere begivenheder',
	'add_event' => 'Tilføj ny begivenhed',
	'edit_event' => 'Rediger begivenhed',
	'view_event' => 'Vis begivenhed',
	'approve_event' => 'Godkend begivenhed',
	'update_event' => 'Opdater begivenhedsinformation',
	'delete_event' => 'Slet begivenhed',
	'events_label' => 'Begivenheder',
	'auto_approve' => 'Auto-godkend',
	'date_label' => 'Dato',
	'actions_label' => 'Aktioner',
	'events_filter_label' => 'Sorter begivenheder',
	'events_filter_options' => array('Vis alle begivenheder','Vis ikke-godkendte begivenheder','Vis kommende begivenheder','Vis tidligere begivenheder'),
	'picture_attached' => 'Billede vedhæftet',
	// Vis Begivenhed
	'view_event_name' => 'Begivenhed: \'%s\'',
	'event_start_date' => 'Dato',
	'event_end_date' => 'Indtil',
	'event_duration' => 'Varighed',
	'contact_info' => 'Kontaktinformation',
	'contact_email' => 'E-mail',
	'contact_url' => 'Websted',
	// General Info
	// Begivenhed form
	'edit_event_title' => 'Begivenhed: \'%s\'',
	'cat_name' => 'Kategori',
	'event_start_date' => 'Dato',
	'event_end_date' => 'Indtil',
	'contact_info' => 'Kontaktinformation',
	'contact_email' => 'E-mail',
	'contact_url' => 'Websted',
	'no_event' => 'Der er ingen begivenheder',
	'stats_string' => '<strong>%d</strong> Begivenheder ialt',
	// Stats
	'stats_string1' => '<strong>%d</strong> Begivenhed(er)',
	'stats_string2' => 'Total: <strong>%d</strong> Begivenheder på <strong>%d</strong> side(r)',
	// Misc.
	'add_event_success' => 'Ny begivenhed tilføjet',
	'edit_event_success' => 'Begivenhed opdateret',
	'approve_event_success' => 'Begivenhed godkendt',
	'delete_confirm' => 'Er du sikker på at du vil slette denne begivenhed ?',
	'delete_event_success' => 'Begivenhed slettet',
	'active_label' => 'Aktiv',
	'not_active_label' => 'Inaktiv',
	// Error messages
	'no_event_name' => 'Du skal indtaste et navn til denne begivenhed!',
	'no_event_desc' => 'Du skal indtaste en beskrivelse af denne begivenhed!',
	'no_cat' => 'Du skal vælge en kategori til denne begivenhed!',
	'no_day' => 'Du skal vælge en dag!',
	'no_month' => 'Du skal vælge en måned!',
	'no_year' => 'Du skal vælge et år!',
	'non_valid_date' => 'Indtast en gyldig dato!',
	'end_days_invalid' => '\'Dage\'-feltet under \'Varighed\' må kun bestå af tal!',
	'end_hours_invalid' => '\'Timer\'-feltet under \'Varighed\' må kun indeholde tal!',
	'end_minutes_invalid' => '\'Minutter\'-feltet under \'Varighed\' må kun indeholde tal!',
	'file_too_large' => 'Det billede du vedhæftede er større end %d Kb!',
	'non_valid_extension' => 'Det vedhæftede billedes filformat er ikke tilladt!',
	'delete_event_failed' => 'Denne begivenhed kunne ikke slettes',
	'approve_event_failed' => 'Denne begivenhed kunne ikke godkendes',
	'no_events' => 'Der er ingen begivenheder!',
	'move_image_failed' => 'Systemet kunne ikke flytte det uploadede billede!',
	'non_valid_dimensions' => 'Billedets bredde eller højde er større end %s pixels!',
	'recur_val_1_invalid' => 'Værdien indtastet i \'Gentag interval\' er ikke gyldigt. Det skal være et tal større end \'0\'!',
	'recur_end_count_invalid' => 'Værdien indtastet i \'Antal gentagelser\' er ikke gyldigt. Det skal være et tal større end \'0\'!',
	'recur_end_until_invalid' => 'Værdien indtastet i \'Gentag indtil\', er ikke gyldigt. Det skal være en dato efter startdatoen!'
	);
	// ======================================================
	// admin_categories.php
	// ======================================================
	if (defined('ADMIN_CATS_PHP'))
	$lang_cat_admin_data = array(
	'section_title' => 'Kategori-administration',
	'add_cat' => 'Tilføj ny kategori',
	'edit_cat' => 'Ret kategori',
	'update_cat' => 'Opdater kategori-info',
	'delete_cat' => 'Slet kategori',
	'events_label' => 'Begivenheder',
	'visibility' => 'Offentliggjort',
	'actions_label' => 'Aktioner',
	'users_label' => 'Brugere',
	'admins_label' => 'Administratorer',
	// General Info
	'general_info_label' => 'Generel information',
	'cat_name' => 'Kategorinavn',
	'cat_desc' => 'Kategoribeskrivelse',
	'cat_color' => 'Farve',
	'pick_color' => 'Vælg en farve!',
	'status_label' => 'Status',
	'category_label' => 'Category permissions',
	// Administrative Options
	'admin_label' => 'Administrative egenskaber',
	'auto_admin_appr' => 'Auto-godkend admin-indtastninger',
	'auto_user_appr' => 'Auto-godkend bruger-indtastninger',
	// Stats
	'stats_string1' => '<strong>%d</strong> kategorier',
	'stats_string2' => 'Aktiv: <strong>%d</strong>&nbsp;&nbsp;&nbsp;Total: <strong>%d</strong>&nbsp;&nbsp;&nbsp;på <strong>%d</strong> side(r)',
	// Misc.
	'add_cat_success' => 'Ny kategori tilføjet',
	'edit_cat_success' => 'Kategori opdateret',
	'delete_confirm' => 'Er du sikker på at du vil slette denne kategori ?',
	'delete_cat_success' => 'Kategori slettet',
	'active_label' => 'Aktiv',
	'not_active_label' => 'Inaktiv',
	// Error messages
	'no_cat_name' => 'Du skal indtaste et navn til denne kategori!',
	'no_cat_desc' => 'Du skal indtaste en beskrivelse af denne kategori!',
	'no_color' => 'Du skal vælge en farve til denne kategori!',
	'delete_cat_failed' => 'Denne kategori kunne ikke slettes',
	'no_cats' => 'Der er ingen kategorier!',
	'cat_has_events' => 'Kategori %d indeholder %d begivenhed(er) og kan derfor ikke slettes!<br>Slet resterende begivenheder og prøv igen!'
	,'default' => 'Use default from settings'
	,'no_cats_to_delete' => 'There is no category left to delete'
	);

	// JCAL pro 2
	// ======================================================
	// admin_calendars
	// ======================================================

	if (defined('ADMIN_CALS_PHP'))

	$lang_cal_admin_data = array(
	'section_title' => 'Calendars Administration',
	'add_cal' => 'Add New Calendar',
	'edit_cal' => 'Edit Calendar',
	'update_cal' => 'Update Calendar Info',
	'delete_cal' => 'Delete Calendar',
	'events_label' => 'Events',
	'visibility' => 'Visibility',
	'actions_label' => 'Actions',
	'users_label' => 'Users',
	'admins_label' => 'Admins',
	// General Info
	'general_info_label' => 'General Information',
	'cal_name' => 'Calendar Name',
	'cal_desc' => 'Calendar Description',
	'status_label' => 'Status',
	'calendar_label' => 'Calendar permissions',
	// Stats
	'stats_string1' => '<strong>%d</strong> calendars',
	'stats_string2' => 'Active: <strong>%d</strong>&nbsp;&nbsp;&nbsp;Total: <strong>%d</strong>&nbsp;&nbsp;&nbsp;on <strong>%d</strong> page(s)',
	// Misc.
	'add_cal_success' => 'New calendar added succesfully',
	'edit_cal_success' => 'Calendar updated succesfully',
	'delete_confirm' => 'Are you sure you want to delete this calendar ?',
	'delete_cal_success' => 'Calendar deleted succesfully',
	'active_label' => 'Active',
	'not_active_label' => 'Not Active',
	// Error messages
	'no_cal_name' => 'You must provide a name for this calendar !',
	'no_cal_desc' => 'You must provide a description for this calendar !',
	'delete_cal_failed' => 'This calendar cannot be deleted',
	'no_cals' => 'There are no calendars to display !',
	'cal_has_events' => 'Calendar #%d contains %d event(s) and therefore cannot be deleted! Please delete remaining events under this calendar and try again!',
	'default' => 'Use default from settings'
	,'no_cals_to_delete' => 'There is no calendar left to delete'
	);

	// ======================================================
	// admin_users.php
	// ======================================================
	if (defined('ADMIN_USERS_PHP'))
	$lang_user_admin_data = array(
	'section_title' => 'Brugeradministration',
	'add_user' => 'Tilføj ny bruger',
	'edit_user' => 'Rediger bruger',
	'update_user' => 'Opdater bruger',
	'delete_user' => 'Slet bruger',
	'last_access' => 'Sidste login',
	'actions_label' => 'Aktioner',
	'active_label' => 'Aktiv',
	'not_active_label' => 'Inaktiv',
	// Account Info
	'account_info_label' => 'Brugerinformation',
	'user_name' => 'Brugernavn',
	'user_pass' => 'Adgangskode',
	'user_pass_confirm' => 'Bekræft adgangskode',
	'user_email' => 'E-mail',
	'group_label' => 'Gruppemedlemskab',
	'status_label' => 'Brugerstatus',
	// Andre Oplysninger
	'other_details_label' => 'Andre oplysninger',
	'first_name' => 'Fornavn',
	'last_name' => 'Efternavn',
	'user_website' => 'Hjemmeside',
	'user_location' => 'Hjemby',
	'user_occupation' => 'Beskæftigelse',
	// Stats
	'stats_string1' => '<strong>%d</strong> brugere',
	'stats_string2' => '<strong>%d</strong> brugere på <strong>%d</strong> side(r)',
	// Misc.
	'select_group' => 'Vælg...',
	'add_user_success' => 'Bruger tilføjet',
	'edit_user_success' => 'Bruger opdateret',
	'delete_confirm' => 'Er du sikker på du vil slette denne bruger?',
	'delete_user_success' => 'Bruger slettet',
	'update_pass_info' => 'Lad adgangskode-feltet være tomt, hvis du ikke vil ændre det',
	'access_never' => 'Aldrig',
	// Error messages
	'no_username' => 'Du skal indtaste et brugernavn!',
	'invalid_username' => 'Indtast et brugernavn, der udelukkende består af tal og bogstaver, og er mellem 4 og 30 tegn langt!',
	'invalid_password' => 'Indtast en adgangskode, der udelukkende består af tal og bogstaver, og er mellem 4 og 16 tegn langt!',
	'password_is_username' => 'Adgangskode skal være forskellig fra brugernavnet!',
	'password_not_match' =>'De 2 adgangskoder var forskellige',
	'invalid_email' => 'Du skal skrive en gyldig e-mail-adresse!',
	'email_exists' => 'En anden bruger er registreret med den e-mail-adresse du indtastede. Indtast en anden e-mail-adresse.!',
	'username_exists' => 'Brugernavnet er optaget, vælg venligst et andet!',
	'no_email' => 'Du skal indtaste en e-mail-adresse!',
	'invalid_email' => 'Du skal indtaste en gyldig e-mail-adresse!',
	'no_password' => 'Du skal indtaste en adgangskode!',
	'no_group' => 'Vælg en gruppe til denne bruger!',
	'delete_user_failed' => 'Denne profil kan ikke slettes',
	'no_users' => 'Der er ingen brugerprofiler!'
	);
	// ======================================================
	// admin_groups.php
	// ======================================================
	if (defined('ADMIN_GROUPS_PHP'))
	$lang_group_admin_data = array(
	'section_title' => 'Gruppeadministration',
	'add_group' => 'Tilføj ny gruppe',
	'edit_group' => 'Rediger gruppe',
	'update_group' => 'Opdater gruppe',
	'delete_group' => 'Slet gruppe',
	'view_group' => 'Vis gruppe',
	'users_label' => 'Brugere',
	'actions_label' => 'Aktioner',
	// General Info
	'general_info_label' => 'Generel information',
	'group_name' => 'Gruppenavn',
	'group_desc' => 'Gruppebeskrivelse',
	// Group Access Level
	'access_level_label' => 'Gruppe-adgangsniveau',
	'Administrator' => 'Brugere i denne gruppe har administratoradgang',
	'can_manage_accounts' => 'Brugere i denne gruppe kan redigere brugere',
	'can_change_settings' => 'Brugere i denne gruppe kan ændre i kalenderegenskaber',
	'can_manage_cats' => 'Brugere i denne gruppe kan redigere kategorier',
	'upl_need_approval' => 'Indtastede begivenheder kræver administrativ godkendelse',
	// Stats
	'stats_string1' => '<strong>%d</strong> grupper',
	'stats_string2' => 'Total: <strong>%d</strong> grupper på <strong>%d</strong> side(r)',
	'stats_string3' => 'Total: <strong>%d</strong> brugere på <strong>%d</strong> side(r)',
	// View Group Members
	'group_members_string' => 'Medlemmer af \'%s\' gruppen',
	'username_label' => 'Brugernavn',
	'firstname_label' => 'Fornavn',
	'lastname_label' => 'Efternavn',
	'email_label' => 'E-mail',
	'last_access_label' => 'Sidste login',
	'edit_user' => 'Rediger bruger',
	'delete_user' => 'Slet bruger',
	// Misc.
	'add_group_success' => 'Ny gruppe tilføjet',
	'edit_group_success' => 'Gruppe opdateret',
	'delete_confirm' => 'Er du sikker på du vil slette denne gruppe?',
	'delete_user_confirm' => 'Er du sikker på du vil slette denne bruger?',
	'delete_group_success' => 'Gruppe slettet',
	'no_users_string' => 'Der er ingen brugere i denne gruppe',
	// Error messages
	'no_group_name' => 'Du skal indtaste et navn på denne gruppe!',
	'no_group_desc' => 'Du skal indtaste en beskrivelse for denne gruppe!',
	'delete_group_failed' => 'Denne gruppe kunne ikke slettes',
	'no_groups' => 'Der er ingen grupper!',
	'group_has_users' => 'Denne gruppe indeholder %d bruger(e) og kan derfor ikke slettes!<br>Fjern resterende brugere fra denne gruppe og prøv igen!'
	);
	// ======================================================
	// admin_settings.php / admin_settings_template.php /
	// admin_settings_updates.php
	// ======================================================
	$lang_settings_data = array(
	'section_title' => 'Kalenderindstillinger'
	// Links
	,'admin_links_text' => 'Vælg sektion'
	,'admin_links' => array('Hovedindstillinger','Templateindstillinger','Opdateringer')
	// General Settings
	,'general_settings_label' => 'Hovedindstillinger'
	,'calendar_name' => 'Kalendernavn'
	,'calendar_description' => 'Kalenderbeskrivelse'
	,'calendar_admin_email' => 'Kalenderadministrators e-mail'
	,'cookie_name' => 'Navn på cookie brugt af komponenten'
	,'cookie_path' => 'Sti på cookie brugt af komponenten'
	,'debug_mode' => 'Aktiver debug mode'
	,'calendar_status' => 'Kalenderens offentlige status'
	// Environment Settings
	,'env_settings_label' => 'Miljøindstillinger'
	,'lang' => 'Sprog'
	,'lang_name' => 'Sprog'
	,'lang_native_name' => 'Navn'
	,'lang_trans_date' => 'Oversat d.'
	,'lang_author_name' => 'Forfatter'
	,'lang_author_email' => 'E-mail'
	,'lang_author_url' => 'Websted'
	,'charset' => 'Landekode'
	,'theme' => 'Tema'
	,'theme_name' => 'Temanavn'
	,'theme_date_made' => 'Lavet den'
	,'theme_author_name' => 'Forfatter'
	,'theme_author_email' => 'E-mail'
	,'theme_author_url' => 'Websted'
	,'timezone' => 'Tidszone-forskydning (for DST calculation)'
	,'time_format' => 'Format for klokkeslæt'
	,'24hours' => '24 timer'
	,'12hours' => '12 timer'
	,'auto_daylight_saving' => 'Automatisk indstilling af sommertid'
	,'main_table_width' => 'Bredde på hovedtabel (pixels eller %)'
	,'day_start' => 'Ugedage starter med'
	,'default_view' => 'Standardvisning'
	,'search_view' => 'Tillad søgning'
	,'archive' => 'Vis tidligere begivenheder'
	,'events_per_page' => 'Antal begivenheder pr. side'
	,'sort_order' => 'Standardsortering'
	,'sort_order_title_a' => 'Titel stigende'
	,'sort_order_title_d' => 'Titel faldende'
	,'sort_order_date_a' => 'Dato stigende'
	,'sort_order_date_d' => 'Dato faldende'
	,'show_recurrent_events' => 'Vis gentagne begivenheder'
	,'multi_day_events' => 'Flerdagsbegivenheder'
	,'multi_day_events_all' => 'Vis alle datoer'
	,'multi_day_events_bounds' => 'Vis kun start og slutdatoer'
	,'multi_day_events_start' => 'Vis kun startdato'
	// User Settings
	,'user_settings_label' => 'Brugerindstillinger'
	,'allow_user_registration' => 'Tillad brugerregistreringer'
	,'reg_duplicate_emails' => 'Tillad samme e-mail-adresse til flere brugere'
	,'reg_email_verify' => 'Aktiver brugeraktivering gennem e-mail'
	// event View
	,'event_view_label' => 'Vis begivenheder'
	,'popup_event_mode' => 'Popup-begivenhed'
	,'popup_event_width' => 'Bredde på popup-vindue'
	,'popup_event_height' => 'Højde på popup-vindue'
	// Add event View
	,'add_event_view_label' => 'Tilføj begivenhedsvisning'
	,'add_event_view' => 'Aktiveret'
	,'addevent_allow_html' => 'Tillad <b>BB Code</b> i beskrivelse'
	,'addevent_allow_contact' => 'Tillad kontakt'
	,'addevent_allow_email' => 'Tillad e-mail'
	,'addevent_allow_url' => 'Tillad URL'
	,'addevent_allow_picture' => 'Tillad billeder'
	,'new_post_notification' => 'Send mig en e-mail når en begivenhed skal godkendes'
	// Calendar View
	,'calendar_view_label' => 'Vis kalender (månedlig)'
	,'monthly_view' => 'Aktiveret'
	,'cal_view_show_week' => 'Vis ugenumre'
	,'cal_view_max_chars' => 'Maks. tegn i beskrivelse'
	// Flyer View
	,'flyer_view_label' => 'Vis brochure'
	,'flyer_view' => 'Aktiveret'
	,'flyer_show_picture' => 'Vis billeder i brochurevisning'
	,'flyer_view_max_chars' => 'Maks. tegn i beskrivelse'
	// Weekly View
	,'weekly_view_label' => 'Vis ugentlig'
	,'weekly_view' => 'Aktiveret'
	,'weekly_view_max_chars' => 'Maks. tegn i beskrivelse'
	// Daily View
	,'daily_view_label' => 'Vis daglig'
	,'daily_view' => 'Aktiveret'
	,'daily_view_max_chars' => 'Maks. tegn i beskrivelse'
	// Vis Kategorier
	,'categories_view_label' => 'Vis kategorier'
	,'cats_view' => 'Aktiveret'
	,'cats_view_max_chars' => 'Maks. tegn i beskrivelse'
	// Mini Calendar
	,'mini_cal_label' => 'Minikalender'
	,'mini_cal_def_picture' => 'Standardbillede'
	,'mini_cal_display_picture' => 'Vis billede'
	,'mini_cal_diplay_options' => array('Intet','Standardbillede', 'Dagligt billede','Ugentligt billede','Tilfældigt billede')
	// Mail Settings
	,'mail_settings_label' => 'Mail-indstillinger'
	,'mail_method' => 'Metode til at sende mail'
	,'mail_smtp_host' => 'SMTP hosts (adskilt af semikolon;)'
	,'mail_smtp_auth' => ' SMTP authentication'
	,'mail_smtp_username' => 'SMTP brugernavn'
	,'mail_smtp_adgangskode' => 'SMTP adgangskode'
	// Picture Settings
	,'picture_settings_label' => 'Billed-indstillinger'
	,'max_upl_dim' => 'Maks. bredde og højde for uploadede billeder'
	,'max_upl_size' => 'Maks. størrelse for uploadede billeder (i bytes)'
	,'picture_chmod' => 'Standardrettigheder for billeder (CHMOD)(oktalt)'
	,'allowed_file_extensions' => 'Godkendte filtyper for uploadede billeder'
	// Form Buttons
	,'update_config' => 'Gem ny konfiguration'
	,'restore_config' => 'Gendan standardindstillinger'
	// Misc.
	,'update_settings_success' => 'Indstillinger opdateret'
	,'restore_default_confirm' => 'Er du sikker på du vil gendanne standardindstillinger?'
	// Template Configuration
	,'template_type' => 'Skabelonstype'
	,'template_header' => 'Hovedtekst'
	,'template_footer' => 'Fodtekst'
	,'template_status_default' => 'Brug standard-tema-skabelon'
	,'template_status_custom' => 'Brug flg. skabelon:'
	,'template_custom' => 'Brugerdefineret skabelon'

	,'info_meta' => 'Meta-information'
	,'info_status' => 'Statuskontrol'
	,'info_status_default' => 'Deaktiver dette indhold'
	,'info_status_custom' => 'Vis flg. indhold:'
	,'info_custom' => 'Brugerdefineret indhold'
	,'dynamic_tags' => 'Dynamiske tags'
	// Product updates
	,'updates_check_text' => 'Vent venligst mens vi henter information fra serveren...'
	,'updates_no_response' => 'Intet svar fra serveren, prøv igen senere.'
	,'avail_updates' => 'Tilgængelige opdateringer:'
	,'updates_download_zip' => 'Download ZIP-fil (.zip)'
	,'updates_download_tgz' => 'Download TGZ-fil (.tar.gz)'
	,'updates_released_label' => 'Udgivelsesdag: %s'
	,'updates_no_update' => 'Du bruger den seneste version. Ingen opdatering nødvendig.'
	);
	// ======================================================
	// cal_mini.inc.php
	// ======================================================

	$lang_mini_cal = array(
	'def_pic' => 'Standardbillede'
	,'daily_pic' => 'Dagens billede (%s)'
	,'weekly_pic' => 'Ugens billede (%s)'
	,'rand_pic' => 'Tilfældigt billede (%s)'
	,'post_event' => 'Tilføj ny begivenhed'
	,'num_events' => '%d begivenhed(er)'
	,'selected_week' => 'Uge %d'
	);
	// ======================================================
	// extcalendar.php
	// ======================================================
	// To Be Done
	// ======================================================
	// config.inc.php
	// ======================================================
	// To Be Done
	// ======================================================
	// installe.php
	// ======================================================
	// To Be Done
	// ======================================================
	// login.php
	// ======================================================
	if (defined('LOGIN_PHP'))
	$lang_login_data = array(
	'section_title' => 'Log ind'
	// General Settings
	,'login_intro' => 'Indtast brugernavn og adgangskode for at logge ind'
	,'username' => 'Brugernavn'
	,'password' => 'Adgangskode'
	,'remember_me' => 'Husk mig'
	,'login_button' => 'Log ind'
	// Errors
	,'invalid_login' => 'Tjek dine indtastede oplysninger og prøv igen!'
	,'no_username' => 'Du skal indtaste dit brugernavn!'
	,'already_logged' => 'Du er allerede logget ind!'
	);
	// ======================================================
	// logout.php
	// ======================================================
	// To Be Done
	// ======================================================
	// plugins.php
	// ======================================================
	// To Be Done
	
	// ======================================================
	// latest_events module
	// ======================================================

	$lang_latest_events = array(
	'view_full_cal' => 'View full calendar'
	,'add_new_event' => 'Add new event'
	,'recent_events' => 'Recent events'
	,'no_events_scheduled' => 'There are no upcoming events currently scheduled.'
	,'more_days' => ' More Days'
	,'days_ago' => ' Days Ago'
	);
	
	// New defined constants, used to make a start with new language system
	if (!defined('_EXTCAL_THEMES_INSTALL_HEADING'))
	{
		DEFINE('_EXTCAL_THEMES_INSTALL_HEADING', 'JCal Pro Themes Manager');

		//Common
		DEFINE('_EXTCAL_VERSION', 'Version');
		DEFINE('_EXTCAL_DATE', 'Dato');
		DEFINE('_EXTCAL_AUTHOR', 'Forfatter');
		DEFINE('_EXTCAL_AUTHOR_EMAIL', 'Forfatter E-Mail');
		DEFINE('_EXTCAL_AUTHOR_URL', 'Forfatter URL');
		DEFINE('_EXTCAL_PUBLISHED', 'Udgivet');

		//Plugins
		DEFINE('_EXTCAL_THEME_PLUGIN', 'Tema');
		DEFINE('_EXTCAL_THEME_PLUGCOM', 'Tema/Kommando');
		DEFINE('_EXTCAL_THEME_NAME', 'Navn');
		DEFINE('_EXTCAL_THEME_HEADING', 'JCal Pro Themes Manager');
		DEFINE('_EXTCAL_THEME_FILTER', 'Filter');
		DEFINE('_EXTCAL_THEME_ACCESS_LIST', 'Access List');
		DEFINE('_EXTCAL_THEME_ACCESS_LVL', 'Access Level');
		DEFINE('_EXTCAL_THEME_CORE', 'Core');
		DEFINE('_EXTCAL_THEME_DEFAULT', 'Default');
		DEFINE('_EXTCAL_THEME_ORDER', 'Order');
		DEFINE('_EXTCAL_THEME_ROW', 'Row');
		DEFINE('_EXTCAL_THEME_TYPE', 'Type');
		DEFINE('_EXTCAL_THEME_ICON', 'Icon');
		DEFINE('_EXTCAL_THEME_LAYOUT_ICON', 'Layout Icon');
		DEFINE('_EXTCAL_THEME_DESC', 'Description');
		DEFINE('_EXTCAL_THEME_EDIT', 'Edit');
		DEFINE('_EXTCAL_THEME_NEW', 'New');
		DEFINE('_EXTCAL_THEME_DETAILS', 'Plugin Details');
		DEFINE('_EXTCAL_THEME_PARAMS', 'Parameters');
		DEFINE('_EXTCAL_THEME_ELMS', 'Elements');
		//Plugin Installer
		DEFINE('_EXTCAL_THEMES_INSTALL_MSG', 'Only those Themes that can be uninstalled are displayed - the Core Theme cannot be removed.');
		DEFINE('_EXTCAL_THEME_NONE', 'There are no non-core themes installed');

		//Language Manager
		DEFINE('_EXTCAL_LANG_HEADING', 'EXTCAL Language Manager');
		DEFINE('_EXTCAL_LANG_LANG', 'Language');

		//Language Installer
		DEFINE('_EXTCAL_LANG_HEADING_INSTALL', 'Install new EXTCAL Language');
		DEFINE('_EXTCAL_LANG_BACK', 'Back to Language Manager');
		//

		//Global Installer
		DEFINE('_EXTCAL_INS_PACKAGE_UPLOAD', 'Upload Package File');
		DEFINE('_EXTCAL_INS_PACKAGE_FILE', 'Package File');
		DEFINE('_EXTCAL_INS_INSTALL', 'Install From Directory');
		DEFINE('_EXTCAL_INS_INSTALL_DIR', 'Install Directory');
		DEFINE('_EXTCAL_INS_UPLOAD_BUTTON', 'Upload File &amp; Install');
		DEFINE('_EXTCAL_INS_INSTALL_BUTTON', 'Install');
	}