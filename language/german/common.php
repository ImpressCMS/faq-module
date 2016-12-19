<?php
/**
* English language constants commonly used in the module
*
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		faq
* @version		$Id: 2011-04-08 14:01:04Z blauer-fisch $
*/

if (!defined("ICMS_ROOT_PATH")) die("ImpressCMS Basispfad ist nicht definiert");

define("_CO_FAQ_READMORE", "Weiter...");

// faq
define("_CO_FAQ_FAQ_FAQ_ID", "ID");
define("_CO_FAQ_FAQ_FAQ_ID_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_QUESTION", "Frage stellen (Bitte aussagekräftig beschreiben)");
define("_CO_FAQ_FAQ_FAQ_QUESTION_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_MENUTITLE", "Titel im Menü");
define("_CO_FAQ_FAQ_FAQ_MENUTITLE_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_ANSWER", "Antwort");
define("_CO_FAQ_FAQ_FAQ_ANSWER_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_UID", "Autor");
define("_CO_FAQ_FAQ_FAQ_UID_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_CID", "Kategorie");
define("_CO_FAQ_FAQ_FAQ_CID_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_DIDUNO", "Wußten Sie schon?");
define("_CO_FAQ_FAQ_FAQ_DIDUNO_DSC", "Dieses Feld wird benutzt in 'Wußten Sie schon?' Beginnen Sie den Satz am besten mit einem Frgewort.");
define("_CO_FAQ_FAQ_FAQ_STATUS", "Status");
define("_CO_FAQ_FAQ_FAQ_STATUS_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_PUBLISHED_DATE", "nach Datum");
define("_CO_FAQ_FAQ_FAQ_PUBLISHED_DATE_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_CANCOMMENT", "Kommentare aktivieren?");
define("_CO_FAQ_FAQ_FAQ_CANCOMMENT_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_WEIGHT", "Gewichtung");
define("_CO_FAQ_FAQ_FAQ_WEIGHT_DSC", " ");
define("_CO_FAQ_FAQ_FAQ_ATTACHMENTS", "Attachments");
define("_CO_FAQ_FAQ_FAQ_ATTACHMENTS_DSC", "Click the button \"add attachments\" to select and attach items to this faq");
define("_CO_FAQ_FAQ_LEARNMORE", "To learn more, see the following NAIMA Publications:");
define("_CO_FAQ_FAQ_FAQ_NOTIFYPUB", "Benachrichtigen Sie mich, bei wenn die Frage genehmigt wurde.");

define("_CO_FAQ_FAQ_STATUS_PUBLISHED", "Veröffentlicht");
define("_CO_FAQ_FAQ_STATUS_PENDING", "Wartend");
define("_CO_FAQ_FAQ_STATUS_REJECTED", "Abgelehnt");
define("_CO_FAQ_FAQ_STATUS_OFFLINE", "Offline");

define("_CO_FAQ_FAQ_READ", "Zeige Berechtigungen");
define("_CO_FAQ_FAQ_READ_DSC", "Select wich groups will have view permission for this faq. This means that a user belonging to one of these groups will be able to view the faq when it is activated in the site.");

define("_CO_FAQ_FAQ_INFO", "Veröffentlicht von %s am %s. (%u gelesen)");
define("_CO_FAQ_FAQ_FROM_USER", "Alle Kommentare von %s");
define("_CO_FAQ_FAQ_COMMENTS_INFO", "%d Kommentare");
define("_CO_FAQ_FAQ_NO_COMMENT", "Kein Kommentar");

define("_CO_FAQ_SUBMITTED_FAQS", "<h1>Eingereichte FAQs von Benutzer</h1>");
define("_CO_FAQ_REQUESTED_FAQS", "<h1>Angefragte FAQs von Benutzer</h1>");

// category
define("_CO_FAQ_CATEGORY_CAT_ID", "ID");
define("_CO_FAQ_CATEGORY_CAT_ID_DSC", " ");
define("_CO_FAQ_CATEGORY_CAT_TITLE", "Titel");
define("_CO_FAQ_CATEGORY_CAT_TITLE_DSC", " ");
define("_CO_FAQ_CATEGORY_CAT_MENUTITLE", "Titel im Menü");
define("_CO_FAQ_CATEGORY_CAT_MENUTITLE_DSC", " ");
define("_CO_FAQ_CATEGORY_CAT_PID", "Hauptkategorie");
define("_CO_FAQ_CATEGORY_CAT_PID_DSC", "Wenn Sie diese neue Kategorie als Unterkategorie anlegen möchten, dann wählen Sie hier Ihre Hauptkategorie aus. Wenn Sie eine Hauptkategorie erstellen wollen, lassen Sie das Feld leer.");
define("_CO_FAQ_CATEGORY_CAT_SUMMARY", "Zusammenfassung");
define("_CO_FAQ_CATEGORY_CAT_SUMMARY_DSC", " ");
define("_CO_FAQ_CATEGORY_CAT_DESCRIPTION", "Beschreibung");
define("_CO_FAQ_CATEGORY_CAT_DESCRIPTION_DSC", " ");
define("_CO_FAQ_CATEGORY_CAT_WEIGHT", "Gewichtung");
define("_CO_FAQ_CATEGORY_CAT_WEIGHT_DSC", " ");
define("_CO_FAQ_CATEGORY_CAT_PUBLISHED_DATE", "Veröffentlichungsdatum");
define("_CO_FAQ_CATEGORY_CAT_PUBLISHED_DATE_DSC", " ");
define("_CO_FAQ_CATEGORY_CAT_STATUS", "Status");
define("_CO_FAQ_CATEGORY_CAT_STATUS_DSC", " ");
define("_CO_FAQ_CATEGORY_CAT_SUBS", "Unterkategorie");
define("_CO_FAQ_CATEGORY_CAT_SUBS_DSC", " ");

define("_CO_FAQ_CATEGORY_STATUS_ACTIVE", "Aktiv");
define("_CO_FAQ_CATEGORY_STATUS_INACTIVE", "Inaktiv");

define("_CO_FAQ_CATEGORY_READ", "Zeige Berechtigungen");
define("_CO_FAQ_CATEGORY_READ_DSC", "Select wich groups will have view permission for this category. This means that a user belonging to one of these groups will be able to view the category when it is activated in the site.");
define("_CO_FAQ_CATEGORY_WRITE", "Schreibe Berechtigungen");
define("_CO_FAQ_CATEGORY_WRITE_DSC", "Select the groups which are allowed to create new faqs on this category. This means that a user belonging to one of these groups will be able to add new faqs in this category directly on the site.");

// Attachments
define("_CO_FAQ_ATTACHMENT_ATTACH_ID", "ID");
define("_CO_FAQ_ATTACHMENT_ATTACH_ID_DSC", " ");
define("_CO_FAQ_ATTACHMENT_ATTACH_FID", "FAQ");
define("_CO_FAQ_ATTACHMENT_ATTACH_FID_DSC", " ");
define("_CO_FAQ_ATTACHMENT_ATTACH_MODULE", "Module");
define("_CO_FAQ_ATTACHMENT_ATTACH_MODULE_DSC", " ");
define("_CO_FAQ_ATTACHMENT_ATTACH_ITEMID", "Item");
define("_CO_FAQ_ATTACHMENT_ATTACH_ITEMID_DSC", " ");
define("_CO_FAQ_ATTACHMENT_ATTACH_WEIGHT", "Gewichtung");
define("_CO_FAQ_ATTACHMENT_ATTACH_WEIGHT_DSC", " ");
define("_CO_FAQ_ATTACHMENT_ATTACH_STATUS", "Status");
define("_CO_FAQ_ATTACHMENT_ATTACH_STATUS_DSC", " ");

define("_CO_FAQ_ATTACHMENT_STATUS_ACTIVE", "Zeigen");
define("_CO_FAQ_ATTACHMENT_STATUS_INACTIVE", "Verstecken");

define("_CO_FAQ_ATTACHMENT_READ", "Zeige Berechtigungen");
define("_CO_FAQ_ATTACHMENT_READ_DSC", "Select wich groups will have view permission for this attachment. This means that a user belonging to one of these groups will be able to view the attachment when it is activated in the site.");

define("_CO_FAQ_ATTACHMENT_SEL_MODULE", "Select a module plugin: ");
define("_CO_FAQ_ATTACHMENT_AVALIABLE_ITEMS", "Avaliable Items from %s");
define("_CO_FAQ_ATTACHMENT_AVALIABLE_ITEMS_DSC", "Bellow is a list of all avaliable items for the selected module. Select the desired items and click on the add button to attach it in the FAQ.");
?>