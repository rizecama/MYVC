<?php
/*
 **********************************************
 Copyright (c) 2006-2009 Anything-Digital.com
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
	'name' => 'Romanian'
	,'nativename' => 'Română' // Language name in native language. E.g: 'Fran�ais' for 'French'
	,'locale' => array('ro_RO','Română')
	,'charset' => 'UTF-8' // For reference, go to : http://www.w3.org/International/O-charset-lang.html
	,'direction' => 'ltr' // 'ltr' for Left to Right. 'rtl' for Right to Left languages such as Arabic.
	,'author' => 'Barbu Valentin-Nicusor (jimie)'
	,'author_email' => 'jimiero@gmail.com'
	,'author_url' => 'http://www.craiova-net.ro'
	,'transdate' => '03/16/2009'
	);

	$lang_general = array (
	'yes' => 'Da'
	,'no' => 'Nu'
	,'back' => 'Înapoi'
	,'continue' => 'Contunuă'
	,'close' => 'Închide'
	,'errors' => 'Erori'
	,'info' => 'Informaţie'
	,'day' => 'Zi'
	,'days' => 'Zile'
	,'month' => 'Lună'
	,'months' => 'Luni'
	,'year' => 'An'
	,'years' => 'Ani'
	,'hour' => 'Oră'
	,'hours' => 'Ore'
	,'minute' => 'Minut'
	,'minutes' => 'Minute'
	,'everyday' => 'Zilnic'
	,'everymonth' => 'Lunar'
	,'everyyear' => 'Anual'
	,'active' => 'Activ'
	,'not_active' => 'Inactiv'
	,'today' => 'Astăzi'
	,'signature' => ''
	,'expand' => 'Extinde'
	,'collapse' => 'Restrânge'
	,'any_calendar' => 'Arată toate calendare'
	,'noon' => 'amiază'
	,'midnight' => 'miezul nopţii'
	,'am' => 'am'
	,'pm' => 'pm'
	
	);

	// Date formats, For reference, go to : http://www.php.net/manual/en/function.strftime.php
	$lang_date_format = array (
	'full_date' => '%A, %B %d, %Y' // e.g. Wednesday, June 05, 2002
	,'full_date_time_24hour' => '%A, %B %d, %Y At %H:%M' // e.g. Wednesday, June 05, 2002 At 21:05
	,'full_date_time_12hour' => '%A, %B %d, %Y At %I:%M %p ' // e.g. Wednesday, June 05, 2002 At 9:05 pm
	,'day_month_year' => '%d-%b-%Y' // e.g 10-Sep-2004
	,'local_date' => '%c' // Preferred date and time representation for current language
	,'mini_date' => '%a. %d %b, %Y'
	,'month_year' => '%B %Y'
	,'day_of_week' => array('Duminică','Luni','Marţi','Miercuri','Joi','Vineri','Sâmbătă')
	,'months' => array('Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie','Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie')
	// Jcal Pro 2.1.x
	,'date_entry' => '%Y-%m-%d'
	);

	$lang_system = array (
	'system_caption' => 'Mesaj de sistem'
	,'page_access_denied' => 'Nu aveţi suficiente privilegii pentru a accesa această opţiune.' 
	,'page_requires_login' => 'Trebuie să fi-ţi autentificat pentru a accesa această pagină.'
	,'operation_denied' => 'Nu aveţi suficiente privilegii pentru a efectua această operaţiune.'
	,'section_disabled' => 'Această secţiune este momentan dezactivată !'
	,'non_exist_cat' => 'Categoria selectată nu există !'
	,'non_exist_event' => 'Evenimentul selectat nu există !'
	,'param_missing' => 'Parametrii furnizaţi sunt incorecţi.'
	,'no_events' => 'Nu există evenimente pentru a fi afişate'
	,'config_string' => 'În momentul de faţă folosiţi \'%s\' rulând pe %s, %s şi %s.'
	,'no_table' => 'Tabela \'%s\' nu există !'
	,'no_anonymous_group' => 'Tabela %s nu conţine grupul \'Anonim\' !'
	,'calendar_locked' => 'Acest serviciu este temporar dezactivat pentru întreţinere si upgrade-uri. Ne cerem scuze pentru neplăcerile create !'
	,'new_upgrade' => 'Sistemul a detectat o nouă versiune. Este recomandat să efectuaţi upgrade-ul acum. Daţi Click "Continuă" pentru a lansa instrumentul de upgrade.'
	,'no_profile' => 'A apărut o eroare în timpul căutarii informaţiilor profilului dumneavoastră'
	,'unknown_component' => 'Componentă necunoscută'
	// Mail messages
	,'new_event_subject' => 'Eveniment care necesită aprobarea pe %s'
	,'event_notification_failed' => 'A apărut o eroare in timpul încercării de a trimite e-mail-lui de notificare!'

	,'show_required_privileges' => 'Nivelul dumneavostră de utilizator este %s, în timp ce acesta trebuie să fie %s'  // JCal 2.1
	,'template_block_not_found' => '<b>Eroare template<b><br />Nu s-a putut găsi blocul \'%s\' în :<br /><pre>%s</pre>'
	,'template_file_not_found' => '<b>JCAL Pro eroare critică</b>:<br />Nu se poate încărca fişierul template-ului %s!</b>'
	);

	// Message body for new event email notification
	$lang_system['event_notification_body'] = <<<EOT
Următorul eveniment tocmai a fost postat in {CALENDAR_NAME}
şi necesită aprobarea dumneavoastră:

Titlu: "{TITLE}"
Data: "{DATE}"
Durată: "{DURATION}"

Puteţi accesa acest eveniment făcând click pe link-ul de mai jos 
sau copiaţi-l şi apoi lipiţi-l in browser-ul dumneavoastră.

{LINK}

(REŢINEŢI că trebuie să fiţi autentificat ca un Administrator pentru
ca link-ul să funcţioneze.)

Cu respect,

Echipa de management a {CALENDAR_NAME}

EOT;

	// Admin menu entries
	$lang_admin_menu = array (
	'login' => 'Login'
	,'register' => 'Înregistrare'
	,'logout' => 'Logout <span style="color:#FF9922">[<span style="color:#606F79">%s</span>]</span>'
	,'user_profile' => 'Profilul meu'
	,'admin_events' => 'Evenimente'
	,'admin_categories' => 'Categorii'
	,'admin_groups' => 'Grupuri'
	,'admin_users' => 'Utilizatori'
	,'admin_settings' => 'Setări'
	);

	// Main menu entries
	$lang_main_menu = array (
	'add_event' => 'Adaugă eveniment'
	,'cal_view' => 'Vizualizare lunară'
	,'flat_view' => 'Vizualizare extinsă'
	,'weekly_view' => 'Vizualizare săptămânală'
	,'daily_view' => 'Vizualizare zilnică'
	,'yearly_view' => 'Vizualizare anuală'
	,'categories_view' => 'Categorii'
	,'search_view' => 'Caută'
	,'ical_view' => 'preia in format iCal'
	,'print_view' => 'Printează'
	);

	// ======================================================
	// Add Event view
	// ======================================================

	$lang_add_event_view = array(
	'section_title' => 'Adaugă eveniment'
	,'edit_event' => 'Editează eveniment [id%d] \'%s\''
	,'update_event_button' => 'Actualizează Eveniment'

	// Event details
	,'event_details_label' => 'Detalii Eveniment'
	,'event_title' => 'Titlu Eveniment'
	,'event_desc' => 'Descriere Eveniment'
	,'event_cat' => 'Categorie'
	,'choose_cat' => 'Selectaţi o categorie'
	,'event_date' => 'Data evenimentului'
	,'day_label' => 'Zi'
	,'month_label' => 'Lună'
	,'year_label' => 'An'
	,'start_date_label' => 'Ora Începerii'
	,'start_time_label' => 'La'
	,'end_date_label' => 'Durata'
	,'all_day_label' => 'Toată ziua'
	// Contact details
	,'contact_details_label' => 'Detalii Contact'
	,'contact_info' => 'Informaţii contact'
	,'contact_email' => 'Email'
	,'contact_url' => 'URL'
	// Repeat events
	,'repeat_event_label' => 'Repetare Eveniment'
	,'repeat_method_label' => 'Metodă de repetare'
	,'repeat_none' => 'Nu repeta acest eveniment'
	,'repeat_every' => 'Repetă in fiecare'
	,'repeat_days' => 'Zi(le)'
	,'repeat_weeks' => 'Saptămân(ă)'
	,'repeat_months' => 'Lună(i)'
	,'repeat_years' => 'An(i)'
	,'repeat_end_date_label' => 'Repetare dată final'
	,'repeat_end_date_none' => 'Fară data de final'
	,'repeat_end_date_count' => 'Terminare dupa %s apariţie(ii)'
	,'repeat_end_date_until' => 'Repetă pâna la'
	// new JCalpro 2
	,'repeat_event_detached' => 'Acest eveniment a fost parte a unei repetiţii, dar a fost modificat si separat de aceasta'
	,'repeat_event_detached_short' => 'Desprins din repetiţie'
	,'repeat_event_not_detached' => 'Acest eveniment este parte a unei serii de repetiţii'
	,'repeat_edit_parent_event' => 'Editaţi eveniment principal'
	,'deleted_child_events' => 'Au fost şterse %d repetări precedente'
	,'created_child_events' => 'S-au creat un total de %d repetiţii pentru evenimentul %s. Vizualizaţi acest eveniment făcând <a href="%s" >click aici</a>.'  // Jcal Pro 2.1.x

	// Other details
	,'other_details_label' => 'Alte Detalii'
	,'picture_file' => 'Fişier imagine'
	,'file_upload_info' => '(%d KBytes limită - Extensii valide : %s )'
	,'del_picture' => 'Stergeţi poza actuală ?'
	// Administrative options
	,'admin_options_label' => 'Opţiuni de administrare'
	,'auto_appr_event' => 'Evenimentul a fost aprobat'

	// Error messages
	,'no_title' => 'Trebuie să furnizaţi un titlu pentru acest eveniment !'
	,'no_desc' => 'Trebuie să furnizaţi o descriere pentru acest eveniment !'
	,'no_cat' => 'Trebuie să selectaţi o categorie din meniul derulant !'
	,'date_invalid' => 'Trebuie sa furnizaţi o dată validă pentru acest eveniment !'
	,'end_days_invalid' => 'Valoarea pe care aţi introdus-o în câmpul \'Zile\' nu este validă !'
	,'end_hours_invalid' => 'Valoarea pe care aţi introdus-o în câmpul \'Ore\' nu este validă !'
	,'end_minutes_invalid' => 'Valoarea pe care aţi intodus-o în câmpul \'Minute\' nu este validă !'
	,'move_image_failed' => 'Sistemul nu a reuşit să incarce imaginea în mod corespunzător. Vă rugam sa verificaţi dacă este tipul corespunzător şi dacă nu este prea mare, sau anunţaţi administratorul site-ului.'
	,'non_valid_dimensions' => 'Lăţimea sau înălţimea imaginii este mai mare de %s pixeli !'

	,'recur_val_1_invalid' => 'Valoarea pe care aţi introdus-o ca \'interval repetare\' nu este validă. Această valoare trebuie să fie un număr mai mare decât \'0\' !'
	,'recur_end_count_invalid' => 'Valoarea pe care aţi introdus-o ca \'numar de apariţii\' nu este validă. Această valoare trebuie să fie un număr mai mare decât \'0\' !'
	,'recur_end_until_invalid' => 'Valoarea datei pentru \'repetă pâna la\' nu este validă !'
	,'no_recur_end_date' => 'Un eveniment care se repetă trebuie să aibă o dată de final sau un număr de repetări'
	
	// new JCalpro 2
	,'failed_existing_event_update' => 'Eroare bază de date în timpul actualizării evenimentului %s (%d)'
	,'failed_child_event_deletion' => 'Eroare bază de date în timpul ştergerii evenimentului secundar %s (%d)'
	,'failed_child_event_creation' => 'Eroare bază de date în timpul creării evenimentului secundar %s (%d)'
	,'no_calendar' => 'Trebuie să selectaţi un calendar din meniul derulant !'
	,'event_cal' => 'Calendar'
	,'private_event' => 'Eveniment Privat'
	,'private_event_read_only' => 'Eveniment privat, ceilalţi pot citi'
	,'public_event' => 'Eveniment public'
	,'privacy' => 'Confidenţialitate'
	,'failed_event_creation' => 'Eroare bază de date în timpul creării acestui eveniment'
	// Misc. messages JCal 2.1
	,'submit_event_pending' => 'Evenimentul dumneavoastră a fost trimis! Cu toate acestea, NU va apărea in calendar până când nu primeşte aprobarea de la administrator. Vă mulţumim pentru înregistrare!'
	,'submit_event_approved' => 'Evenimentul dumneavoastră este aprobat automat. Vizualizaţi acest eveniment făcând <a href="%s" >click aici</a>. Vă mulţumim pentru înregistrare!'
	,'event_repeat_msg' => 'Acest eveniment este setat să se repete'
	,'event_no_repeat_msg' => 'Acest eveniment nu se repetă'
	,'recur_start_date_invalid' => 'Data începerii nu este validă. Pentru un eveniment ce se repetă, data inceperii trebuie să fie prima repetiţie a seriei (ex: dacă se repetă în fiecare marţi, data începerii trebuie să fie o marţi)'
	
	// new JCalPro 2.1
	,'repeat_daily' => 'Repetă zilnic'
	,'repeat_weekly' => 'Repetă săptămânal'
	,'repeat_monthly' => 'Repetă lunar'
	,'repeat_yearly' => 'Repetă anual'
	,'rec_weekly_on' => 'pe :'
	,'rec_monthly_on' => 'în:'
	,'rec_yearly_on' => 'în:'
	,'rec_day_first' => 'prima'
	,'rec_day_second' => 'a doua'
	,'rec_day_third' => 'a treia'
	,'rec_day_fourth' => 'a patra'
	,'rec_day_last' => 'ultima'
	,'rec_day_day' => 'zi'
	,'rec_day_week_day' => 'ziua săptămânii'
	,'rec_day_weekend_day' => 'ziua de week-end'
	,'rec_yearly_on_month_label' => 'în'
	
	);

	// ======================================================
	// daily view
	// ======================================================

	$lang_daily_event_view = array(
	'section_title' => 'Vizualizare zilnică'
	,'next_day' => 'Ziua următoare'
	,'previous_day' => 'Ziua anterioară'
	,'no_events' => 'Nu sunt evenimente în această zi.'
	);

	// ======================================================
	// weekly view
	// ======================================================

	$lang_weekly_event_view = array(
	'section_title' => 'Vizualizare săptămânală'
	,'week_period' => '%s - %s'
	,'next_week' => 'Săptamâna următoare'
	,'previous_week' => 'Săptămâna anterioară'
	,'selected_week' => 'Săptamâna %d'
	,'no_events' => 'Nu sunt evenimente în această săptămână.'
	);

	// ======================================================
	// monthly view
	// ======================================================

	$lang_monthly_event_view = array(
	'section_title' => 'Vizualizare lunară'
	,'next_month' => 'Luna următoare'
	,'previous_month' => 'Luna anterioară'
	);

	// ======================================================
	// flat view
	// ======================================================

	$lang_flat_event_view = array(
	'section_title' => 'Vizualizare extinsă'
	,'week_period' => '%s - %s'
	,'next_month' => 'Luna următoare'
	,'previous_month' => 'Luna anterioară'
	,'contact_info' => 'Informaţii contact'
	,'contact_email' => 'Email'
	,'contact_url' => 'URL'
	,'no_events' => 'Nu sunt evenimente în această lună'
	);

	// ======================================================
	// Event view
	// ======================================================

	$lang_event_view = array(
	'section_title' => 'Vizualizare eveniment'
	,'display_event' => 'Evenimentul: \'%s\''
	,'cat_name' => 'Categoria'
	,'event_start_date' => 'Data'
	,'event_end_date' => 'Până la'
	,'event_duration' => 'Durată'
	,'contact_info' => 'Informaţii contact'
	,'contact_email' => 'Email'
	,'contact_url' => 'URL'
	,'no_event' => 'Nu există evenimente pentru afişare.'
	,'stats_string' => '<strong>%d</strong> de evenimente în total'
	,'edit_event' => 'Editează eveniment'
	,'delete_event' => 'Şterge eveniment'
	,'delete_confirm' => 'Sunteţi sigur că doriţi să ştergeţi acest eveniment ?'
	
	);

	// ======================================================
	// Categories view
	// ======================================================

	$lang_cats_view = array(
	'section_title' => 'Vizualizare categorii'
	,'cat_name' => 'Nume categorie'
	,'total_events' => 'Total Evenimente'
	,'upcoming_events' => 'Evenimente viitoare'
	,'no_cats' => 'Nu există categorii pentru afişare.'
	,'stats_string' => 'Sunt <strong>%d</strong> Evenimente în <strong>%d</strong> Categorii'
	);

	// ======================================================
	// Category Events view
	// ======================================================

	$lang_cat_events_view = array(
	'section_title' => 'Evenimente în \'%s\''
	,'event_name' => 'Nume eveniment'
	,'event_date' => 'Data'
	,'no_events' => 'Nu există evenimente în această categorie.'
	,'stats_string' => '<strong>%d</strong> Evenimente în total'
	,'stats_string1' => '<strong>%d</strong> Eveniment(e) în <strong>%d</strong> pagină(i)'
	);

	// ======================================================
	// cal_search.php
	// ======================================================

	$lang_event_search_data = array(
	'section_title' => 'Caută Calendar',
	'search_results' => 'Rezultate căutare',
	'category_label' => 'Categoria',
	'date_label' => 'Data',
	'no_events' => 'Nu există evenimente în această categorie.',
	'search_caption' => 'Introduceţi cateva cuvinte...',
	'search_again' => 'Caută din nou',
	'search_button' => 'Caută',
	// Misc.
	'no_results' => 'Nici un rezultat găsit',	
	// Stats
	'stats_string1' => '<strong>%d</strong> eveniment(e) găsit(e)',
	'stats_string2' => '<strong>%d</strong> Eveniment(e) în <strong>%d</strong> pagină(i)'
	);

	// ======================================================
	// profile.php
	// ======================================================

	if (defined('PROFILE_PHP'))

	$lang_user_profile_data = array(
	'section_title' => 'Profilul meu',
	'edit_profile' => 'Editare profilul meu',
	'update_profile' => 'Actualizare profilul meu',
	'actions_label' => 'Acţiuni',
	// Account Info
	'account_info_label' => 'Informaţii cont',
	'user_name' => 'Username',
	'user_pass' => 'Parolă',
	'user_pass_confirm' => 'Confirmă parola',
	'user_email' => 'Adresă de E-mail',
	'group_label' => 'Apartenenţă grup',
	// Other Details
	'other_details_label' => 'Alte detalii',
	'first_name' => 'Nume',
	'last_name' => 'Prenume',
	'full_name' => 'Nume complet',
	'user_website' => 'Home page',
	'user_location' => 'Locaţie',
	'user_occupation' => 'Ocupaţie',
	// Misc.
	'select_language' => 'Selectaţi limba',
	'edit_profile_success' => 'Profilul a fost actualizat cu succes',
	'update_pass_info' => 'Lăsaţi câmpul parolei necompletat dacă nu doriţi să vă schimbaţi parola',
	// Error messages
	'invalid_password' => 'Vă rugam scrieţi o parolă care să conţină doar litere si cifre, între 4 şi 16 caractere lungime !',
	'password_is_username' => 'Parola trebuie să fie diferită de username !',
	'password_not_match' =>'Parola pe care aţi introdus-o nu se potriveşte cu \'Confirmă parola\'',
	'invalid_email' => 'Trebuie să furnizaţi o adresă de email validă !',
	'email_exists' => 'Un alt utilizator s-a înregistrat deja cu această adresă de email. Vă rugăm scrieţi o altă adresă de email !',
	'no_email' => 'Trebuie să furnizaţi o adresă de email !',
	'invalid_email' => 'Trebuie să furnizaţi o adresă de email validă !',
	'no_password' => 'Trebuie să furnizaţi o parolă pentru noul cont !'
	);

	// ======================================================
	// register.php
	// ======================================================

	if (defined('USER_REGISTRATION_PHP'))

	$lang_user_registration_data = array(
	'section_title' => 'Înregistrare Utilizator',
	// Step 1: Terms & Conditions
	'terms_caption' => 'Termeni şi condiţii',
	'terms_intro' => 'Pentru a putea continua, trebuie să fiţi de acord cu următoarele:',
	'terms_message' => 'Vă rugăm să aveţi un moment pentru revizuirea acestor reguli detaliate mai jos. Dacă sunteţi de acord cu ele şi doriţi continuarea inregistrării, faceţi click pe butonul \'Sunt de acord\' de mai jos. Pentru a opri înregistrarea, faceţi click pe butonul \'înapoi\' al browser-ului dvs.<br /><br />Vă rugăm să reţineţi că nu suntem responsabili pentru orice evenimente postate de utilizatori în acest calendar.  Noi nu garantăm exactitatea, completitudinea sau utilitatea oricărui eveniment postat.<br /><br />Mesajele exprimă punctele de vedere ale autorului, nu neapărat punctele de vedere ale acestei aplicaţii. Orice utilizator care simte că un eveniment post este criticabil este încurajat să ne contactateze imediat prin e-mail. Avem capacitatea de a elimina conţinutul inacceptabil si vom face toate eforturile pentru a face acest lucru, într-un timp rezonabil, dacă vom stabili că este necesară eliminarea.<br /><br />Sunteţi de acord, prin utilizarea de către dvs. a acestui serviciu, că nu veţi folosi această aplicaţie pentru a posta orice material care este cu bună ştiinţă fals şi / sau defăimatoar, inexact, abuziv, vulgar, plin de ură, hărţuitor, obscen, profan, cu orientare sexuală, ameninţătoare, invazivă pentru intimitatea unei persoane, sau alte încălcări ale legii.<br /><br />Sunteţi de acord să nu postaţi orice material protejat de copyright cu excepţia cazului în care dreptul de autor este deţinut de către dumneavoastră sau de către %s.',
	'terms_button' => 'Sunt de acord',

	// Account Info
	'account_info_label' => 'Informaţii cont',
	'user_name' => 'Username',
	'user_pass' => 'Parolă',
	'user_pass_confirm' => 'Confirmă Parola',
	'user_email' => 'Adresă de email',
	// Other Details
	'other_details_label' => 'Alte detalii',
	'first_name' => 'Nume',
	'last_name' => 'Prenume',
	'user_website' => 'Home page',
	'user_location' => 'Locaţie',
	'user_occupation' => 'Ocupaţie',
	'register_button' => 'Trimite înregistrarea mea',

	// Stats
	'stats_string1' => '<strong>%d</strong> utilizatori',
	'stats_string2' => '<strong>%d</strong> utilizatori în <strong>%d</strong> pagină(i)',
	// Misc.
	'reg_nomail_success' => 'Vă mulţumim pentru înregistrare.',
	'reg_mail_success' => 'Un e-mail cu informaţii despre cum să vă activaţi contul a fost trimis la adresa dvs. de e-mail.',
	'reg_activation_success' => 'Felicitări! Contul dvs. este acum activ şi vă puteţi autentifica cu numele de utilizator şi parola. Vă mulţumim pentru înregistrare.',
	// Mail messages
	'reg_confirm_subject' => 'Înregistrare la %s',

	// Error messages
	'no_username' => 'Trebuie să furnizaţi un username !',
	'invalid_username' => 'Vă rugăm să introduceţi un username care să conţină numai litere şi cifre, între 4 şi 30 de caractere lungime !',
	'username_exists' => 'Username-ul furnizat este deja folosit. Vă rugăm alegeţi un alt username !',
	'no_password' => 'Trebuie sa furnizaţi o parolă !',
	'invalid_password' => 'Vă rugăm să introduceţi o parolă care să conţină numai litere şi cifre, între 4 şi 16 de caractere lungime !',
	'password_is_username' => 'Parola trebuie să fie diferită de username !',
	'password_not_match' =>'Parola pe care aţi scris-o nu se potriveşte cu \'confirmă parola\'',
	'no_email' => 'Trebuie să furnizaţi o adresa de email !',
	'invalid_email' => 'Trebuie să furnizaţi o adresa de email validă !',
	'email_exists' => 'Un alt utilizator s-a înregistrat deja cu această adresă de email. Vă rugăm să scrieţi o altă adresă de email !',
	'delete_user_failed' => 'Acest cont de utilizator nu poate fi şters',
	'no_users' => 'Nu există conturi de utilizatori pentru afişare !',
	'already_logged' => 'Sunteţi deja autentificat ca membru !',
	'registration_not_allowed' => 'Înregistrările de utilizatori sunt momentan dezactivate !',
	'reg_email_failed' => 'A apărut o eroare în timpul trimiterii mail-ului de activare !',
	'reg_activation_failed' => 'A apărut o eroare în timpul procesului de activare !'

	);
	// Message body for email activation
	$lang_user_registration_data['reg_confirm_body'] = <<<EOT
Vă mulţumim că v-aţi înregistrat la {CALENDAR_NAME}

Username-ul dvs. este : "{USERNAME}"
Parola dvs. este : "{PASSWORD}"

Pentru a activa contul dvs., trebuie să faceţi click pe link-ul de mai jos
sau copiaţi-l şi lipiţi-l în browser-ul dumneavoastră.

{REG_LINK}

Cu respect,

Echipa de management a {CALENDAR_NAME}

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
	// admin_events.php
	// ======================================================

	if (defined('ADMIN_EVENTS_PHP'))

	$lang_event_admin_data = array(
	'section_title' => 'Administrare eveniment',
	'events_to_approve' => 'Administrare Eveniment: Evenimente pentru aprobare',
	'upcoming_events' => 'Administrare Eveniment: Evenimente viitoare',
	'past_events' => 'Administrare Eveniment: Evenimente anterioare',
	'add_event' => 'Adaugă eveniment nou',
	'edit_event' => 'Editează Eveniment',
	'view_event' => 'Vizualizare Eveniment',
	'approve_event' => 'Aprobă eveniment',
	'update_event' => 'Actualizează Informaţii Eveniment',
	'delete_event' => 'Şterge eveniment',
	'events_label' => 'Evenimente',
	'auto_approve' => 'Aprobare automată',
	'date_label' => 'Data',
	'actions_label' => 'Acţiuni',
	'events_filter_label' => 'Filtrează evenimente',
	'events_filter_options' => array('Arată toate evenimentele','Arată doar evenimentele neaprobate','Arată doar evenimentele viitoare','Arată doar evenimentele anterioare'),
	'picture_attached' => 'Imagine ataşată',
	// View Event
	'view_event_name' => 'Eveniment: \'%s\'',
	'event_start_date' => 'Data',
	'event_end_date' => 'Până la',
	'event_duration' => 'Durată',
	'contact_info' => 'Informaţii contact',
	'contact_email' => 'Email',
	'contact_url' => 'URL',
	// General Info
	// Event form
	'edit_event_title' => 'Eveniment: \'%s\'',
	'cat_name' => 'Categoria',
	'event_start_date' => 'Data',
	'event_end_date' => 'Până la',
	'contact_info' => 'Informaţii contact',
	'contact_email' => 'Email',
	'contact_url' => 'URL',
	'no_event' => 'Nu există evenimente pentru afişare.',
	'stats_string' => '<strong>%d</strong> de evenimente în total',
	// Stats
	'stats_string1' => '<strong>%d</strong> eveniment(e)',
	'stats_string2' => 'În total: <strong>%d</strong> de evenimente în <strong>%d</strong> pagină(i)',
	// Misc.
	'add_event_success' => 'Eveniment nou adăugat cu succes.',
	'edit_event_success' => 'Eveniment actualizat cu succes. Vizualizaţi acest eveniment făcând <a href="%s" >click aici</a>',  // Jcal Pro 2.1.x
	'approve_event_success' => 'Eveniment aprobat cu succes',
	'delete_confirm' => 'Sunteţi sigur că vreţi să ştergeţi acest eveniment ?',
	'delete_event_success' => 'Eveniment şters cu succes',
	'active_label' => 'Activ',
	'not_active_label' => 'Inactiv',
	// Error messages
	'no_event_name' => 'Trebuie să furnizaţi un nume pentru acest eveniment !',
	'no_event_desc' => 'Trebuie să furnizaţi o descriere pentru acest eveniment !',
	'no_cat' => 'Trebuie să selectaţi o categorie pentru acest eveniment !',
	'no_day' => 'Trebuie să selectaţi o zi !',
	'no_month' => 'Trebuie să selectaţi o lună !',
	'no_year' => 'Trebuie să selectaţi un an !',
	'non_valid_date' => 'Vă rugăm scrieţi o dată validă !',
	'end_days_invalid' => 'Vă rugăm asiguraţi-vă dacă câmpul \'Zile\' de sub \'Durată\' conţine doar cifre !',
	'end_hours_invalid' => 'Vă rugăm asiguraţi-vă dacă câmpul \'Ore\' de sub \'Durată\' conţine doar cifre !',
	'end_minutes_invalid' => 'Vă rugăm asiguraţi-vă dacă câmpul \'Minute\' de sub \'Durată\' conţine doar cifre !',
	'delete_event_failed' => 'Acest eveniment nu poate fi şters',
	'approve_event_failed' => 'Acest eveniment nu poate fi aprobat',
	'no_events' => 'Nu există evenimente pentru afişare !',
	'recur_val_1_invalid' => 'Valoarea introdusă pentru \'interval repetare\' nu este validă. Această valoare trebuie sa fie un număr mai mare decât \'0\' !',
	'recur_end_count_invalid' => 'Valoarea introdusă ca \'numărul de repetări\' nu este validă. Această valoare trebuie sa fie un număr mai mare decât \'0\' !',
	'recur_end_until_invalid' => 'Valoarea datei \'repetă până la\' trebuie să fie mai mare decât data începerii evenimentului !'

	);

	// ======================================================
	// admin_categories.php
	// ======================================================

	if (defined('ADMIN_CATS_PHP'))

	$lang_cat_admin_data = array(
	'section_title' => 'Administrare categorii',
	'add_cat' => 'Adaugă categorie nouă',
	'edit_cat' => 'Editează categorie',
	'update_cat' => 'Actualizează Info Categorie',
	'delete_cat' => 'Şterge categorie',
	'events_label' => 'Evenimente',
	'visibility' => 'Vizibilitate',
	'actions_label' => 'Acţiuni',
	'users_label' => 'Utilizatori',
	'admins_label' => 'Administratori',
	// General Info
	'general_info_label' => 'Informaţii Generale',
	'cat_name' => 'Nume categorie',
	'cat_desc' => 'Descriere categorie',
	'cat_color' => 'Culoare',
	'pick_color' => 'Selectaţi o culoare!',
	'status_label' => 'Status',
	'category_label' => 'Permisiuni categorie',
	// Stats
	'stats_string1' => '<strong>%d</strong> categorii',
	'stats_string2' => 'Active: <strong>%d</strong>&nbsp;&nbsp;&nbsp;Total: <strong>%d</strong>&nbsp;&nbsp;&nbsp;în <strong>%d</strong> pagină(i)',
	// Misc.
	'add_cat_success' => 'Categorie nouă adaugată cu succes',
	'edit_cat_success' => 'Categorie actualizată cu succes',
	'delete_confirm' => 'Sunteţi sigur că doriţi să ştergeţi această categorie ?',
	'delete_cat_success' => 'Categoria a fost ştearsă cu succes',
	'active_label' => 'Activ',
	'not_active_label' => 'Inactiv',
	// Error messages
	'no_cat_name' => 'Trebuie să furnizaţi un nume pentru această categorie !',
	'no_cat_desc' => 'Trebuie să furnizaţi o descriere pentru această categorie !',
	'no_color' => 'Trebuie să furnizaţi o culoare pentru această categorie !',
	'delete_cat_failed' => 'Această categorie nu poate fi ştearsă',
	'no_cats' => 'Nu există categorii pentru afişare !',
	'cat_has_events' => 'Categoria #%d conţine %d eveniment(e) şi de aceea  nu poate fi ştearsă! Vă rugăm ştergeţi evenimentele din această categorie şi încercaţi din nou!'
	,'default' => 'Utilizaţi setările implicite'
	,'no_cats_to_delete' => 'Nu mai există nici o categorie pentru a fi ştearsă'

	);

	// JCAL pro 2
	// ======================================================
	// admin_calendars
	// ======================================================

	if (defined('ADMIN_CALS_PHP'))

	$lang_cal_admin_data = array(
	'section_title' => 'Administrare calendare',
	'add_cal' => 'Adaugă calendar nou',
	'edit_cal' => 'Editează Calendar',
	'update_cal' => 'Actualizează Info Calendar',
	'delete_cal' => 'Şterge calendar',
	'events_label' => 'Evenimente',
	'visibility' => 'Vizibilitate',
	'actions_label' => 'Acţiuni',
	'users_label' => 'Utilizatori',
	'admins_label' => 'Administratori',
	// General Info
	'general_info_label' => 'Informaţii Generale',
	'cal_name' => 'Nume Calendar',
	'cal_desc' => 'Descriere Calendar',
	'status_label' => 'Status',
	'calendar_label' => 'Permisiuni Calendar',
	// Stats
	'stats_string1' => '<strong>%d</strong> calendare',
	'stats_string2' => 'Active: <strong>%d</strong>&nbsp;&nbsp;&nbsp;Total: <strong>%d</strong>&nbsp;&nbsp;&nbsp;în <strong>%d</strong> pagină(i)',
	// Misc.
	'add_cal_success' => 'Calendar nou adăugat cu succes',
	'edit_cal_success' => 'Calendar actualizat cu succes',
	'delete_confirm' => 'Sunteţi sigur că doriţi să ştergeţi aceast calendar ?',
	'delete_cal_success' => 'Calendarul a fost şters cu succes',
	'active_label' => 'Activ',
	'not_active_label' => 'Inactiv',
	// Error messages
	'no_cal_name' => 'Trebuie să furnizaţi un nume pentru acest calendar !',
	'no_cal_desc' => 'Trebuie să furnizaţi o descriere pentru acest calendar !',
	'delete_cal_failed' => 'Acest calendar nu poate fi şters',
	'no_cals' => 'Nu există calendare pentru afişare !',
	'cal_has_events' => 'Calendarul #%d conţine %d eveniment(e) şi de aceea nu poate fi şters! Vă rugăm ştergeti evenimentele din acest calendar şi încercaţi din nou!',
	'default' => 'Utilizaţi setările implicite'
	,'no_cals_to_delete' => 'Nu mai există nici un calendar pentru a fi şters'
	);

	// ======================================================
	// admin_users.php
	// ======================================================

	if (defined('ADMIN_USERS_PHP'))

	$lang_user_admin_data = array(
	'section_title' => 'Administrare utilizator',
	'add_user' => 'Adaugă utilizator nou',
	'edit_user' => 'Editează Info utilizator',
	'update_user' => 'Actualizează Info utilizator',
	'delete_user' => 'Şterge cont utilizator',
	'last_access' => 'Ultima Accesare',
	'actions_label' => 'Acţuni',
	'active_label' => 'Activ',
	'not_active_label' => 'Inactiv',
	// Account Info
	'account_info_label' => 'Informaţii Cont',
	'user_name' => 'Username',
	'user_pass' => 'Parolă',
	'user_pass_confirm' => 'Confirmă Parola',
	'user_email' => 'Adresă E-mail',
	'group_label' => 'Apartenenţă grup',
	'status_label' => 'Status cont',
	// Other Details
	'other_details_label' => 'Alte detalii',
	'first_name' => 'Nume',
	'last_name' => 'Prenume',
	'user_website' => 'Home page',
	'user_location' => 'Locaţie',
	'user_occupation' => 'Ocupaţie',
	// Stats
	'stats_string1' => '<strong>%d</strong> utilizatori',
	'stats_string2' => '<strong>%d</strong> utilizatori în <strong>%d</strong> pagină(i)',
	// Misc.
	'select_group' => 'Selectaţi unul...',
	'add_user_success' => 'Cont utilizator adăugat cu succes',
	'edit_user_success' => 'Cont utilizator actualizat cu succes',
	'delete_confirm' => 'Sunteţi sigur că doriţi să ştergeţi acest cont?',
	'delete_user_success' => 'Cont utilizator şters cu succes',
	'update_pass_info' => 'Lăsaţi câmpul parolei necompletat dacă nu doriţi să schimbaţi parola',
	'access_never' => 'Niciodată',
	// Error messages
	'no_username' => 'Trebuie să furnizaţi un username !',
	'invalid_username' => 'Vă rugăm să introduceţi un username care să conţină numai litere şi cifre, să aibă între 4 şi 30 caractere lungime !',
	'invalid_password' => 'Vă rugăm să introduceţi o parolă care să conţină numai de litere şi cifre, să aibă între 4 şi 16 caractere lungime !',
	'password_is_username' => 'Parola trebuie să fie diferită de username !',
	'password_not_match' =>'Parola pe care aţi introdus-o nu se potriveşte cu \'Confirmă parola\'',
	'invalid_email' => 'Trebuie să furnizaţi o adresă de email!',
	'email_exists' => 'Un alt utilizator s-a înregistrat deja cu această adresă de email. Vă rugăm scrieţi o altă adresă de email !',
	'username_exists' => 'Username-ul furnizat este deja folosit. Vă rugăm alegeţi un alt username !',
	'no_email' => 'Trebuie să furnizaţi o adresă de email !',
	'invalid_email' => 'Trebuie să furnizaţi o adresă de email validă !',
	'no_password' => 'Trebuie să furnizaţi o parolă pentru acest utilizator nou !',
	'no_group' => 'Vă rugă să selectaţi o apartenenţă grup pentru acest utilizator !',
	'delete_user_failed' => 'Acest cont de utilizator nu poate fi şters',
	'no_users' => 'Nu există nici un cont utilizator pentru afişare !'

	);

	// ======================================================
	// admin_groups.php
	// ======================================================

	if (defined('ADMIN_GROUPS_PHP'))

	$lang_group_admin_data = array(
	'section_title' => 'Administrare grup',
	'add_group' => 'Adaugă grup nou',
	'edit_group' => 'Editează grup',
	'update_group' => 'Actualizează Info Grup',
	'delete_group' => 'Şterge Grup',
	'view_group' => 'Vizualizare Grup',
	'users_label' => 'Membrii',
	'actions_label' => 'Acţiuni',
	// General Info
	'general_info_label' => 'Informatii Generale',
	'group_name' => 'Nume Grup',
	'group_desc' => 'Descriere Grup',
	// Group Access Level
	'access_level_label' => 'Nivel acces grup',
	'Administrator' => 'Utilizatorii din acest grup au acces de administrator',
	'can_manage_accounts' => 'Utilizatorii din acest grup pot administra conturile de utilizatori',
	'can_change_settings' => 'Utilizatorii din acest grup pot schimba setările calendarului',
	'can_manage_cats' => 'Utilizatorii din acest grup pot administra categoriile',
	'upl_need_approval' => 'Evenimentele trimise necesită aprobarea administratorului',
	// Stats
	'stats_string1' => '<strong>%d</strong> grupuri',
	'stats_string2' => 'Total: <strong>%d</strong> grupuri în <strong>%d</strong> pagină(i)',
	'stats_string3' => 'Total: <strong>%d</strong> utilizatori în <strong>%d</strong> pagină(i)',
	// View Group Members
	'group_members_string' => 'Membrii grupului \'%s\'',
	'username_label' => 'Username',
	'firstname_label' => 'Nume',
	'lastname_label' => 'Prenume',
	'email_label' => 'Email',
	'last_access_label' => 'Ultima accesare',
	'edit_user' => 'Editează utilizator',
	'delete_user' => 'Şterge utilizator',
	// Misc.
	'add_group_success' => 'Grup nou adăugat cu succes',
	'edit_group_success' => 'Grup actualizat cu succes',
	'delete_confirm' => 'Sunteţi sigur că doriţi să ştergeţi acest grup ?',
	'delete_user_confirm' => 'Sunteţi sigur că doriţi să ştergeţi acest grup?',
	'delete_group_success' => 'Grupul a fost şters cu succes',
	'no_users_string' => 'Nu există nici un utilizator în acest grup',
	// Error messages
	'no_group_name' => 'Trebuie să furnizaţi un nume pentru acest grup !',
	'no_group_desc' => 'Trebuie să furnizaţi o descriere pentru acest grup !',
	'delete_group_failed' => 'Acest grup nu poate fi şters',
	'no_groups' => 'Nu există grupui pentru vizualizare !',
	'group_has_users' => 'Acest grup conţine %d utilizator(i) şi de aceea nu poate fi şters!<br>Vă rugăm scoateţi utilizatorii din grup şi încercaţi din nou!'

	);

	// ======================================================
	// admin_settings.php / admin_settings_template.php /
	// admin_settings_updates.php
	// ======================================================

	$lang_settings_data = array(
	'section_title' => 'Setări Calendar'
	// Links
	,'admin_links_text' => 'Alege Secţiunea'
	,'admin_links' => array('Setări Principale','Configurare Template','Actualizari Produs')
	// General Settings
	,'general_settings_label' => 'General'
	,'calendar_name' => 'Nume Calendar'
	,'calendar_description' => 'Descriere Calendar'
	,'calendar_admin_email' => 'Email Administrator Calendar'
	,'cookie_name' => 'Numele cookie-ului folosit de script'
	,'cookie_path' => 'Calea cookie-ului folosită de script'
	,'debug_mode' => 'Activează modul de depanare'
	// Environment Settings
	,'env_settings_label' => 'Ambianţă'
	,'lang' => 'Limbă'
	,'lang_name' => 'Limbă'
	,'lang_native_name' => 'Numele nativ'
	,'lang_trans_date' => 'Tradus în'
	,'lang_author_name' => 'Autor'
	,'lang_author_email' => 'E-mail'
	,'lang_author_url' => 'Website'
	,'charset' => 'Codare caractere'
	,'theme' => 'Temă'
	,'theme_name' => 'Nume temă'
	,'theme_date_made' => 'Fabricat în'
	,'theme_author_name' => 'Autor'
	,'theme_author_email' => 'E-mail'
	,'theme_author_url' => 'Website'
	,'timezone' => 'Utilizaţi acest fus orar pentru calcularea DST'
	,'time_format' => 'Format afişare oră'
	,'24hours' => '24 Ore'
	,'12hours' => '12 Ore'
	,'auto_daylight_saving' => 'Se adaptează automat pentru ora de vară (DST)'
	,'main_table_width' => 'Lătimea tabelei principale (Pixeli sau %)'
	,'day_start' => 'Săptamânile încep'
	,'default_view' => 'Ecran predefinit'
	,'search_view' => 'Activează cautare'
	,'archive' => 'Arată evenimentele anterioare'
	,'events_per_page' => 'Numărul evenimentelor pe pagină'
	,'sort_order' => 'Ordinea de sortare implicită'
	,'sort_order_title_a' => 'Titlu ascendent'
	,'sort_order_title_d' => 'Titlu descendent'
	,'sort_order_date_a' => 'Dată ascendentă'
	,'sort_order_date_d' => 'Dată descendentă'
	,'show_recurrent_events' => 'Afişează evenimentele care se repetă'
	,'multi_day_events' => 'Evenimente în mai multe zile'
	,'multi_day_events_all' => 'Arată întreaga perioadă'
	,'multi_day_events_bounds' => 'Arată doar data începerii si data terminării'
	,'multi_day_events_start' => 'Arată data începerii'
	// User Settings
	,'user_settings_label' => 'Setări Utilizator'
	,'allow_user_registration' => 'Permite înregistrarea de utilizatori'
	,'reg_duplicate_emails' => 'Permite email duplicat'
	,'reg_email_verify' => 'Porneşte activarea contului prin email'
	// Event View
	,'event_view_label' => 'Vizualizare eveniment'
	,'popup_event_mode' => 'Eveniment în Pop-up'
	,'popup_event_width' => 'Lătimea ferestrei Pop-up'
	,'popup_event_height' => 'Înălţimea ferestrei Pop-up '
	// Add Event View
	,'add_event_view_label' => 'Adaugă Eveniment'
	,'add_event_view' => 'Activat'
	,'addevent_allow_html' => 'Permite <b>HTML</b> în descriere'
	,'addevent_allow_contact' => 'Permite contactare'
	,'addevent_allow_email' => 'Permite Email'
	,'addevent_allow_url' => 'Permite URL'
	,'addevent_allow_picture' => 'Permite imagini'
	,'new_post_notification' => 'Trimite-mi un email atunci când un eveniment necesită aprobare'
	// Calendar View
	,'calendar_view_label' => 'Vizualizare Lunară'
	,'monthly_view' => 'Activat'
	,'cal_view_show_week' => 'Arată Numerele săptamânii'
	,'cal_view_max_chars' => 'Maximum caractere în titlu'
	// Flyer View
	,'flyer_view_label' => 'Vizualizare extinsă'
	,'flyer_view' => 'Activat'
	,'flyer_show_picture' => 'Arată imaginile în vizualizare exstinsă'
	,'flyer_view_max_chars' => 'Maximum de caractere în descriere'
	// Weekly View
	,'weekly_view_label' => 'Vizualizare săptamânală'
	,'weekly_view' => 'Activat'
	,'weekly_view_max_chars' => 'Maximum de caractere în titlu'
	// Daily View
	,'daily_view_label' => 'Vizualizare Zilnică'
	,'daily_view' => 'Activat'
	,'daily_view_max_chars' => 'Maximum de caractere în titlu'
	// Categories View
	,'categories_view_label' => 'Vizualizare categorii'
	,'cats_view' => 'Activat'
	,'cats_view_max_chars' => 'Maximum de caractere în titlu'
	// Mini Calendar
	,'mini_cal_label' => 'Mini Calendar'
	,'mini_cal_def_picture' => 'Imagine implicită'
	,'mini_cal_display_picture' => 'Imagine display'
	,'mini_cal_diplay_options' => array('Nici una','Imagine implicită', 'Imagine zilnică','Imagine săptămânală','Imagine la intâmplare')
	// Mail Settings
	,'mail_settings_label' => 'Setări Mail'
	,'mail_method' => 'Metodă de trimitere mail'
	,'mail_smtp_host' => 'Hosturi SMTP (separate de punct si virgulă ;)'
	,'mail_smtp_auth' => ' Autentificare SMTP'
	,'mail_smtp_username' => 'Uername SMTP'
	,'mail_smtp_password' => 'Parolă SMTP'

	// Form Buttons
	,'update_config' => 'Salvează configuraţie nouă'
	,'restore_config' => 'Restabilire setări implicite'
	// Misc.
	,'update_settings_success' => 'Setări actualizate cu succes'
	,'restore_default_confirm' => 'Sunteţi sigur ca doriţi restabilirea setărilor implicite ?'
	// Template Configuration
	,'template_type' => 'Tip template'
	,'template_header' => 'Personalizare Header'
	,'template_footer' => 'Personalizare Footer'
	,'template_status_default' => 'Foloseşte template-ul implicit'
	,'template_status_custom' => 'Foloseşte urmatorul template:'
	,'template_custom' => 'Template personalizat'

	,'info_meta' => 'Informaţii Meta'
	,'info_status' => 'Control Status'
	,'info_status_default' => 'Dezactivează acest conţinut'
	,'info_status_custom' => 'Afişează următorul conţinut:'
	,'info_custom' => 'Conţinut personalizat'

	,'dynamic_tags' => 'Dynamic Tags'

	// Product Updates
	,'updates_check_text' => 'Vă rugăm aşteptaţi, în timp ce noi regăsim informaţiile pe server...'
	,'updates_no_response' => 'Nici un răspuns de la server. Vă rugăm incercaţi din nou mai târziu.'
	,'avail_updates' => 'Actualizări disponibile'
	,'updates_download_zip' => 'Descarcă pachet ZIP (.zip)'
	,'updates_download_tgz' => 'Descarcă pachet TGZ (.tar.gz)'
	,'updates_released_label' => 'Data lansării: %s'
	,'updates_no_update' => 'Rulaţi ultima versiune disponibilă. Nu aveţi nevoie de nicio actualizare.'
	);

	// ======================================================
	// cal_mini.inc.php
	// ======================================================

	$lang_mini_cal = array(
	'def_pic' => 'Imagine implicită'
	,'daily_pic' => 'Imaginea zilei (%s)'
	,'weekly_pic' => 'Imaginea săptămânii (%s)'
	,'rand_pic' => 'Imagine la întâmplare (%s)'
	,'post_event' => 'Postează eveniment nou'
	,'num_events' => '%d eveniment(e)'
	,'selected_week' => 'Săptămana %d'
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
	// install.php
	// ======================================================

	// To Be Done

	// ======================================================
	// login.php
	// ======================================================

	if (defined('LOGIN_PHP'))

	$lang_login_data = array(
	'section_title' => 'Ecran Autentificare'
	// General Settings
	,'login_intro' => 'Scrieţi username-ul şi parola pentru a vă autentifica'
	,'username' => 'Username'
	,'password' => 'Parolă'
	,'remember_me' => 'Tine-mă minte'
	,'login_button' => 'Login'
	// Errors
	,'invalid_login' => 'Vă rugăm să vă verificaţi informaţiile de autentificare şi încercaţi din nou!'
	,'no_username' => 'Trebuie să furnizaţi un nume de utilizator !'
	,'already_logged' => 'Sunteţi deja autentificat !'
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
	'view_full_cal' => 'Vezi calendarul complet'
	,'add_new_event' => 'Adaugă eveniment nou'
	,'recent_events' => 'Evenimente recente'
	,'no_events_scheduled' => 'Nu există evenimente viitoare programate.'
	,'more_days' => ' Mai multe zile'
	,'days_ago' => ' Zile in urmă'
	);



	// New defined constants, used to make a start with new language system

	if (!defined('_EXTCAL_THEMES_INSTALL_HEADING'))
	{
		DEFINE('_EXTCAL_THEMES_INSTALL_HEADING', 'Manager Teme JCal Pro');

		//Common
		DEFINE('_EXTCAL_VERSION', 'Versiune');
		DEFINE('_EXTCAL_DATE', 'Data');
		DEFINE('_EXTCAL_AUTHOR', 'Autor');
		DEFINE('_EXTCAL_AUTHOR_EMAIL', 'E-Mail Autor');
		DEFINE('_EXTCAL_AUTHOR_URL', 'Autor URL');
		DEFINE('_EXTCAL_PUBLISHED', 'Publicata');

		//Plugins
		DEFINE('_EXTCAL_THEME_PLUGIN', 'Temă');
		DEFINE('_EXTCAL_THEME_PLUGCOM', 'Temă/Comandă');
		DEFINE('_EXTCAL_THEME_NAME', 'Nume');
		DEFINE('_EXTCAL_THEME_HEADING', 'Manager Teme JCal Pro');
		DEFINE('_EXTCAL_THEME_FILTER', 'Filtrează');
		DEFINE('_EXTCAL_THEME_ACCESS_LIST', 'Listă acces');
		DEFINE('_EXTCAL_THEME_ACCESS_LVL', 'Nivel acces');
		DEFINE('_EXTCAL_THEME_CORE', 'Inima');
		DEFINE('_EXTCAL_THEME_DEFAULT', 'Implicit');
		DEFINE('_EXTCAL_THEME_ORDER', 'Ordine');
		DEFINE('_EXTCAL_THEME_ROW', 'Rând');
		DEFINE('_EXTCAL_THEME_TYPE', 'Tip');
		DEFINE('_EXTCAL_THEME_ICON', 'Icoană');
		DEFINE('_EXTCAL_THEME_LAYOUT_ICON', 'Layout Icoană');
		DEFINE('_EXTCAL_THEME_DESC', 'Descriere');
		DEFINE('_EXTCAL_THEME_EDIT', 'Editează');
		DEFINE('_EXTCAL_THEME_NEW', 'Nou');
		DEFINE('_EXTCAL_THEME_DETAILS', 'Detalii Plugin');
		DEFINE('_EXTCAL_THEME_PARAMS', 'Parametrii');
		DEFINE('_EXTCAL_THEME_ELMS', 'Elemente');
		//Plugin Installer
		DEFINE('_EXTCAL_THEMES_INSTALL_MSG', 'Numai acele teme care pot fi dezinstalate sunt afişate- Tema Inima nu poate fi ştearsă.');
		DEFINE('_EXTCAL_THEME_NONE', 'Nu există teme non-core instalate');

		//Language Manager
		DEFINE('_EXTCAL_LANG_HEADING', 'Manager Limba EXTCAL');
		DEFINE('_EXTCAL_LANG_LANG', 'Limba');

		//Language Installer
		DEFINE('_EXTCAL_LANG_HEADING_INSTALL', 'Instalează limbă EXTCAL nouă');
		DEFINE('_EXTCAL_LANG_BACK', 'Înapoi la Manager Limbă');
		//

		//Global Installer
		DEFINE('_EXTCAL_INS_PACKAGE_UPLOAD', 'Incarcă fişier pachet');
		DEFINE('_EXTCAL_INS_PACKAGE_FILE', 'Fişier pachet');
		DEFINE('_EXTCAL_INS_INSTALL', 'Instalează din director');
		DEFINE('_EXTCAL_INS_INSTALL_DIR', 'Director instalare');
		DEFINE('_EXTCAL_INS_UPLOAD_BUTTON', 'Incarcă fişier şi Instalează');
		DEFINE('_EXTCAL_INS_INSTALL_BUTTON', 'Instalează');
	}