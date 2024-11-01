=== Plugin Name ===
Contributors: klange
Donate link: http://www.yaawp-plugin.com/
Tags: affiliate, amazon, amazon wordpress plugin, wordpress amazon plugin
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: 0.87
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Produkte direkt aus dem Amazon PartnerNet suchen und importieren oder anhand der ASIN in Seiten bzw. Beitr&auml;gen einf&uuml;gen.

== Description ==

Das WordPress-Plugin YAAWP (Yet Another Amazon Wordpress Plugin) verhilft Ihnen kinderleicht zu Ihrem eigenen Amazon-Shop und das in unter 5 Minuten. Was Sie daf&uuml;r tun m&uuml;ssen? Nicht besonders viel, denn mit der praktischen Importfunktion (inkl. Live-Vorschau) dieses neuen WordPress Amazon Plugins k&ouml;nnen Sie Artikel direkt aus dem Amazon PartnerNet importieren - und das hundertfach. Alles, was Sie machen m&uuml;ssen, ist, die passende Produktkategorie und anschlie&szlig;end das gew&uuml;nschte Produkt auszuw&auml;hlen - voil&agrave;.

<h4>Zahlreiche Funktionen</h4>
* Unterst&uuml;tzt aktuell Amazon DE
* Import von Bild, Beschreibung und Rezessionen
* Bulk Import - hunderte Produkte direkt importieren
* Produkte mit ASIN in Seiten / Beitr&auml;gen einf&uuml;gen
* Importfunktion hat eine Live-Vorschau
* Automatische Aktualisierung der Produkte
* Nutzt das Amazon Associate Programm (Amazon PartnerNet)
* Sehr flexibel dank eigenem Administrationsmen&uuml;
* &Auml;nderbares Produktlayout: Liste/Grid
* 3 Produkt Layouts (Produktseite)
* Social Bookmark Verwaltung

<h4>Sehen Sie sich die Demo an</h4>
Sofern Sie erst sehen m&ouml;chten was Yet Another Amazon WordPress Plugin Lite kann schauen Sie sich unsere <a href="http://lite.yaawp-plugin.com/">Demo</a> an.

<h4>Weitere Informationen</h4>
Weitere Informationen zum YAAWP-Plugin finden Sie unter <a href="http://www.yaawp-plugin.com/">www.yaawp-plugin.com</a>.

== Installation ==

1. Inhalt von `yaawp.zip` hochladen in `/wp-content/plugins/`
1. CHMOD the `/cache/assets/img` directory to 777
1. Aktiviere das Plugin
1. YAAWP -> Einstellungen (geheimer Zugriffsschl&uuml;ssel, Zugriffsschl&uuml;ssel und Tracking ID)

== Frequently Asked Questions ==

= Ist dies die finale Lite Version ? =

Nein, wir brauchen nur etwas mehr Feedback um YAAWP weiter zu verbesser.

= Wo finde ich diese Amazon Zugriffsschl&uuml;ssel ? =

Unter `https://portal.aws.amazon.com/gp/aws/securityCredentials` kann ein Zugriffsschl&uuml;ssel erstellt werden, es entstehen keine Kosten.

= Funktioniert YAAWP mit allen Themes ? =

Nein, aktuell funktioniert das ganze nur zu 100% mit Twenty Twelve.

= Gibt es Tutorials zur Einrichtung ? =

Ja, aktuell 2. (http://youtu.be/PZz4skb0juM YAAWP: ASIN in Beitr&auml;gen) (http://youtu.be/3Rt4lusadBY YAAWP: Shop in unter 5 Minuten)

= Import funktioniert nicht? Kein Artikel gefunden? =

Vermutlich ist etwas bei den Amazon Einstellungen falsch. Bitte `https://portal.aws.amazon.com/gp/aws/securityCredentials` besuchen und vervollst&auml;ndigen. Verwenden Sie die Zugriffsschl&uuml;ssel-ID, die Sie nach der Registrierung unter `https://partnernet.amazon.de/gp/flex/advertising/api/sign-in.html` erhalten haben.

= Gibt es ein Support-Forum? =

Derzeit geschlosse.

== Screenshots ==

1. **Einstellungen / Setup**
2. **Importfunktion**
3. **Beispiel Shortcode (ASIN)**
4. **Beispielansicht nach Import**
5. **Listenansicht der Produkte nach Import (NEU)**
6. **Produkt Layout 1 - Beispiel der Ansicht**
7. **WordPress Admin - Einstellung Social Bookmark**

== Changelog ==

= 0.1 =
* Int

= 0.5 =
* Vielzahl verschiedener Funktionen weiter ausgebaut
* diverse kleine Bugfixes

= 0.6 =
* Bugfix: Import schlug fehl wenn die Beschreibung genau 200 Zeichen hatte
* Bugfix: Cron zum aktualisieren l&auml;uft nun auch beim Aufruf des Frontend
* Bugfix: Produkt Layouts werden jetzt mit Namen angezeigt, nicht mit mit Dateinamen
* Bugfix: Archive wird jetzt Seitenweise ausgegeben (Post Per Page)
* Bugfix: Import, Ergebnisse zeigen jetzt kein Fehler nach Neuauswahl an
* Bugfix: Ausgabe Titel in der Anzeige
* Bugfix: Diverse kleinere Sprachfehler ausgebessert
* Zugef&uuml;gt: Produktmerkmale
* Zugef&uuml;gt: Unter Einstellungen ist ein neuer Reiter f&uuml;r Shop Einstellungen
* Zugef&uuml;gt: Shop, diverse Einstellungsm&ouml;glichkeiten (Produktauswahl, Layoutdesign etc.)
* Zugef&uuml;gt: Seitenauswahl integriert
* Zugef&uuml;gt: Archive u.a. neue Grafiken
* Zugef&uuml;gt: Einstellungsm&ouml;glichkeiten "Social" Bookmarks

= 0.7 =
* Bugfix: Einige Pfadeinstellungen wurden korrigiert

= 0.8 =
* Bugfix: Einige Pfadeinstellungen wurden korrigiert
* Zugef&uuml;gt: Externe Links (Amazon) &ouml;ffnen jetzt im neuen Fenster
* Zugef&uuml;gt: Externe Links (Amazon) Attribut - external nofollow
* Zugef&uuml;gt: Neuer Reiter unter Einstellungen: Kategorien
* Zugef&uuml;gt: Kategorien (Navigation/Sidebar) k&ouml;nnen jetzt sotiert werden
* Zugef&uuml;gt: Reiter Shop wurde erweitert
* Zugef&uuml;gt: l&auml;nge vom Produkttitel und Produktbeschreibung kann gesetzt werden

= 0.81 =
* Bugfix: ASIN in Seiten/Beitr&auml;gen erzeugten Fehler bei weniger als 30 Zeichen im Titel
* Bugfix: Aktiviertes Plugin machte es unm&ouml;glich Bilder in Seiten/Beitr&auml;gen zu nutzen

= 0.82 =
* Zugef&uuml;gt: Titell&auml;nge kann jetzt selbst bestimmt werden
* Zugef&uuml;gt: Titel kann jetzt selbst bestimmt werden
* Zugef&uuml;gt: Produktlink als Link - in das Dropdown eingepflegt
* Bugfix: Kategorie wird jetzt korrekt &uuml;bernommen
* Zugef&uuml;gt: &Uuml;berarbeitete Beschreibung vom Plugin

= 0.83 =
* Bugfix: Produkte wurden bei gel&ouml;schter Kategorie nicht mehr komplett angezeigt

= 0.84 =
* Bugfix: Links die durch Shortcode in Beitr&auml;gen angezeigt werden hatten kein nofollow

= 0.85 =
* Bugfix: Produkte werden nicht mehr entfernt nach 1-2 Stunden

= 0.86 =
* Bugfix: Einstellungen f&uuml;r Social-Media konnten nicht gespeichert werden

= 0.87 =
* Bugfix: Bei der Nutzung von Shortcodes (in Beitr&auml;gen) wurden Fehler erzeugt
* Bugfix: Fehlende Kategorien werden bei Shortcodes nun nicht mehr leer angezeigt 

== Upgrade Notice ==
Sofern 0.6 Stabil l&auml;uft kann dieses Update ignoriert werden