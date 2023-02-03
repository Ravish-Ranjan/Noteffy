<?php
// Romanian language file for VirtualHosts form
// Translated by Ciprian Murariu <ciprianmp[at]yahoo[dot]com>
//3.1.1 - NotwwwDir
//3.1.3 - VirtualHostPortNone'
//3.1.4 - txtTLDdev
//3.1.9 - VirtualHostName modified - Accept diacritical characters (IDN)
//3.2.6 - HoweverWamp
//3.2.8 - phpNotExists - VirtualHostPhpFCGI - modifyForm - modifyVhost - modAliasForm
//      - modifyAlias - StartAlias - ModifiedAlias - NoModifyAlias - HoweverAlias
//  modified: VirtualHostPort (%s replaced by below ) - Start - VirtualCreated - However - HoweverWamp
//  array $langues_help added.
//3.3.0 - modification of lines FcgidInitialEnv

$langues = array(
	'langue' => 'Română',
	'locale' => 'romanian',
	'addVirtual' => 'Adaugă un VirtualHost',
	'backHome' => 'Înapoi la homepage',
	'VirtualSubMenuOn' => '<code>Sub-meniul VirtualHost</code> trebuie setat la (Activat) în Meniul Click-Dreapta <code>Setări Wamp</code>. Apoi reîncarcă această pagină',
	'UncommentInclude' => 'Anulează comentariul <small>(Elimină simbolul #)</small> liniei <code>#Include conf/extra/httpd-vhosts.conf</code><br />în fişierul %s',
	'FileNotExists' => 'Fişierul <code>%s</code> nu există',
	'txtTLDdev' => 'Numele Serverului %s foloseşte TLD %s care este exclusiv folosit de browserele web. Foloseşte un alt TLD (.test spre examplu)',
	'FileNotWritable' => 'Fişierul <code>%s</code> este nemodificabil',
	'DirNotExists' => '<code>%s</code> nu există sau nu este un director valid',
	'NotwwwDir' => 'Directorul <code>%s</code> este rezervat pentru "localhost". Vă rugăm să folosiţi un alt director.',
	'NotCleaned' => 'Fişierul <code>%s</code> nu a fost golit.<br />Rămân exemple de VirtualHost precum: dummy-host.example.com',
	'NoVirtualHost' => 'Niciun VirtualHost definit în <code>%s</code><br />Ar trebui să conţină măcar VirtualHost pentru localhost.',
	'NoFirst' => '<code>localhost</code> trebuie să fie primul VirtualHost definit în fişierul <code>%s</code>',
	'ServerNameInvalid' => 'Numele Serverului <code>%s</code> nu este valid.',
	'LocalIpInvalid' => 'IP-ul local <code>%s</code> nu este valid.',
	'VirtualHostName' => 'Numele <code>VirtualHost</code> Fără spaţii - Fără underscore(_) ',
	'VirtualHostFolder' => 'Completează <code>calea</code> absolută către <code>directorul</code> VirtualHost <i>Exemplu: C:/wamp/www/project/ sau E:/www/site1/</i> ',
	'VirtualHostIP' => '<code class="option">Dacă</code> vrei să foloseşti VirtualHost după IP: <code class="option">IP local</code> 127.x.y.z ',
	'VirtualHostPhpFCGI' => '<code class="option">Dacă</code> vrei să foloseşti PHP în modul FCGI: <code class="option">Versiuni acceptate</code> mai jos ',
	'VirtualHostPort' => '<code class="option">Dacă</code> vrei să foloseşti un alt "Port de Intrare" decât cel implicit <code class="option">Porturi acceptate</code> %s',
	'VirtualHostPortNone' => 'Dacă vrei să foloseşti alt "Port de Intrare" decât cel implicit, trebuie să adaugi un Port de Intrare pentru Apache folosind Meniul Click-Dreapta din bară ',
	'VirtualAlreadyExist' => 'Numele Serverului <code>%s</code> există deja',
	'VirtualIpAlreadyUsed' => 'IP-ul local <code>%s</code> există deja',
	'VirtualPortNotExist' => 'Portul <code>%s</code> nu este un "Port de Intrare" Apache',
	'VirtualPortExist' => 'Portul <code>%s</code> este "Portul de Intrare" implicit al Apache şi nu mai trebuie menţionat',
	'VirtualHostExists' => 'VirtualHost definit deja:',
	'Start' => 'Începe crearea/modificarea VirtualHost (S-ar putea să dureze puţin...)',
	'StartAlias' => 'Începe modificarea Alias',
	'GreenErrors' => 'Erorile încercuite cu culoarea verde pot fi corectate în mod automat',
	'Correct' => 'Începe corectarea automată a erorilor încercuite cu culoarea verde',
	'NoModify' => 'Imposibil de modificat <code>httpd-vhosts.conf</code> sau fişierele <code>hosts</code>',
	'NoModifyAlias' => 'Alias-ul nu a fost modificat',
	'VirtualCreated' => 'Fişierele au fost modificate. VirtualHost <code>%s</code> a fost creat',
	'ModifiedAlias' => 'Alias-ul <code>%s</code> a fost modificat',
	'CommandMessage' => 'Mesajele de la consolă pentru actualizarea DNS:',
	'However' => 'Poţi adăuga un nou VirtualHost folosind "Adaugă un VirtualHost".<br />Oricum, pentru ca noul VirtualHost să fie luat în considerare de Serverul Apache, trebuie să apeşi pe<br /><code>Reporneşte DNS</code><br />din Meniul Click-Dreapta pe icon-ul Wampmanager din bară.',
	'HoweverAlias' => 'Poţi modifica un alt Alias validând "Adaugă un VirtualHost".<br>HOricum, pentru ca modificarea Alias să fie luat în considerare de Serverul Apache, trebuie să apeşi pe<br /><code>Reporneşte DNS</code><br />din Meniul Click-Dreapta pe icon-ul Wampmanager din bară.</i>',
	'HoweverWamp' => 'VirtualHost creat a fost încărcat de Apache.<br />Poți adăuga un nou VirtualHost prin apăsarea pe "Adaugă un VirtualHost".<br />Poți începe să lucrezi la noul VirtualHost,<br />dar pentru ca aceste noi VirtualHosts să fie afișate în meniurile Wampmanager, trebuie să apeși <br><code>Reîncarcă</code><br />din meniul Click-Dreapta pe icon-ul Wampmanager din bară.</i>',
	'suppForm' => 'Goleşte formularul VirtualHost',
	'suppVhost' => 'Elimină VirtualHost',
	'modifyForm' => 'Modifică formularul VirtualHost',
	'modifyVhost' => 'Modifică VirtualHost',
	'modAliasForm' => 'Modifică formularul Alias',
	'modifyAlias' => 'Modifică Alias',
	'Required' => 'Obligatoriu',
	'Optional' => 'Opţional',
	'phpNotExists' => 'Versiunea PHP nu este instalată',
	);

$langues_help['fcgi_mode_link'] = 'Ajutor pentru modul FCGI';
$langues_help['fcgi_mode_help'] = <<< 'FCGIEOT'
- *** Cum se utilizează PHP în modul Fast CGI cu Wampserver ***
CGI (Common Gateway Interface) defineşte o cale pentru un server web de a interacţiona cu programe care generează conţinut extern, cunoscute sub numele de programe sau scripturi CGI. Este o modalitate la îndemână de a introduce conţinut dinamic pe site-ul tău, folosind limbajul de programare care îţi este mai familiar.

- ** O singură versiune PHP ca modul Apache **
Încă de la începuturi, Wampserver încarcă o singură versiune PHP ca modul Apache:
  <code>LoadModule php_module "${INSTALL_DIR}/bin/php/php8.1.1/php8apache2_4.dll"</code>
ceea ce face ca VirtualHost, Alias-urile şi Proiectele să utilizeze aceeaşi versiune PHP.
Când comuţi la o nouă versiune PHP din meniul PHP al Wampmanager, această nouă versiune va fi utilizată peste tot.

- ** Mai multe versiuni PHP cu modul FCGI **
Începând cu versiunea Wampserver 3.2.8, este posibilă utilizarea PHP în modul CGI, ex. poţi defini o versiune diferită a PHP, pentru care addon-urile au fost instalate anterior, pentru fiecare VirtualHost. Astfel, VirtualHost nu mai sunt limitate la a utiliza aceeaşi versiune de PHP.

Modulul Apache fcgid_module (mod_fcgid.so) simplifică implementarea CGI
Documentaţia se regăseşte aici: <a href='https://httpd.apache.org/mod_fcgid/mod/mod_fcgid.html'>mod_fcgid</a>

--- 1 *** PreCondiţii ***
- 1.1 Existenţa fişierului mod_fcgid.so în directorul Apache "modules".
- 1.2 Existenţa liniei de încărcare a modulului în fişierul httpd.conf
LoadModule fcgid_module modules/mod_fcgid.so
- 1.3 Existenţa directivelor de configurare a modulului fcgid_module în fişierul httpd.conf
<IfModule fcgid_module>
  FcgidMaxProcessesPerClass 300
  FcgidConnectTimeout 10
  FcgidProcessLifeTime 1800
  FcgidMaxRequestsPerProcess 0
  FcgidMinProcessesPerClass 0
  FcgidFixPathinfo 0
  FcgidZombieScanInterval 20
  FcgidMaxRequestLen 536870912
  FcgidBusyTimeout 120
  FcgidIOTimeout 120
  FcgidTimeScore 3
  FcgidPassHeader Authorization
  Define PHPROOT ${INSTALL_DIR}/bin/php/php
</IfModule>

Aceste 3 condiţii de mai sus (1.1, 1.2 şi 1.3) sunt realizate în mod automat odată cu actualizarea la versiunea Wampserver 3.2.8

--- 2 *** Crearea unui VirtualHost FCGI ***
- După actualizarea la versiunea Wampserver 3.2.8, pagina 'http://localhost/add_vhost.php' va permite adăugarea cu uşurinţă a unui VirtualHost FCGI.
Versiunile PHP utilizate ce pot fi setate sunt numai cele instalate deja în Wampserver, pentru a evita o eroare legată de versiunea PHP.
Declararea într-un VirtualHost a unei versiuni PHP inexistente în Wampserver va genera o eroare Apache şi blocarea acestuia ("crash").

- Dacă vrei să modifici un VirtualHost definit deja pentru a adăuga modul FCGI cu o versiune PHP existentă în addon-urile Wampserver, deschideţi pagina http://localhost/add_vhost.php şi lansaţi formularul de modificare a VirtualHost pentru ca, în dar trei click-uri, sî adaugi modul FCGI, să modifici versiunea de PHP sau să ştergi modul FCGI.
După efectuarea modificărilor, Wampserver va trebui reîncărcat (refresh).
Aceeaşi pagină http://localhost/add_vhost.php va permite, de asemenea, prin formularul de modificare a Alias, să adaugi modul FCGI la un Alias, să schimbi versiunea PHP sau să ştergi modul FCGI, tot în numai trei click-uri.

+-------------------+
| Mai multe detalii |
+-------------------+
Pentru a adăuga modul FCGI la un VirtualHost existent, trebuiesc doar adăugate directivele următoare chiar înainte de &lt;/VirtualHost> la sfârşitul respectivului VirtualHost:
  <IfModule fcgid_module>
    Define FCGIPHPVERSION "7.4.27"
    FcgidInitialEnv PHPRC "${PHPROOT}${FCGIPHPVERSION}/php.ini"
    <Files ~ "\.php$">
      Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
      AddHandler fcgid-script .php
      FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
    </Files>
  </IfModule>

Versiunea PHP trebuie să existe ca addon PHP în Wampserver şi poate fi modificată.
Pe de altă parte, ştergând aceste linii va determina ca VirtualHost să ruleze numai în versiunea PHP încărcată ca modul Apache.

Pentru Alias e puţin mai complicat, liniile de mai sus trebuie adăugate în două părţi, prima parte:
<IfModule fcgid_module>
  Define FCGIPHPVERSION "7.4.27"
  FcgidCmdOptions ${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe \
  InitialEnv PHPRC=${PHPROOT}${FCGIPHPVERSION}/php.ini
</IfModule>
chiar înaintea directivei <Directory...
Cea de-a doua parte:
<IfModule fcgid_module>
  <Files ~ "\.php$">
    Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
    AddHandler fcgid-script .php
    FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
  </Files>
</IfModule>
în cuprinsul contextului <Directory...>..</Directory>, pentru a obţine, ca exemplu al unui Alias oarecare, următoarea structură:

Alias /myalias "g:/www/mydir/"
<IfModule fcgid_module>
  Define FCGIPHPVERSION "7.4.27"
  FcgidCmdOptions ${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe \
  InitialEnv PHPRC=${PHPROOT}${FCGIPHPVERSION}/php.ini
</IfModule>
<Directory "g:/www/mydir/">
  Options Indexes FollowSymLinks
  AllowOverride all
  Require local
  <IfModule fcgid_module>
    <Files ~ "\.php$">
      Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
      AddHandler fcgid-script .php
      FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
    </Files>
  </IfModule>
</Directory>

FCGIEOT;

?>