<?php
// Romanian language file for Help page
// Translated by Ciprian Murariu <ciprianmp[at]yahoo[dot]com>
//3.2.8 - New file
//3.3.0 - Modification of lines FcgidInitialEnv

$langues['fcgi_mode_link'] = 'ajutor pentru modul FCGI';
$langues['fcgi_not_loaded'] = 'PHP nu poate fi utilizat în modul FCGI întrucât modulul Apache fcgid_module nu este încărcat';
$langues['fcgi_mode_help'] = <<< 'FCGIEOT'
<h4>Cum se utilizează PHP în modul Fast CGI cu Wampserver</h4>
CGI (Common Gateway Interface) defineşte o cale pentru un server web de a interacţiona cu programe care generează conţinut extern, cunoscute sub numele de programe sau scripturi CGI. Este o modalitate la îndemână de a introduce conţinut dinamic pe site-ul tău, folosind limbajul de programare care îţi este mai familiar.

<h5>- O singură versiune PHP ca modul Apache</h5>
Încă de la începuturi, Wampserver încarcă o singură versiune PHP ca modul Apache:
  <code>LoadModule php_module "${INSTALL_DIR}/bin/php/php8.1.1/php8apache2_4.dll"</code>
ceea ce face ca VirtualHost, Alias-urile şi Proiectele să utilizeze aceeaşi versiune PHP.
Când comuţi la o nouă versiune PHP din meniul PHP al Wampmanager, această nouă versiune va fi utilizată peste tot.

<h5>- Mai multe versiuni PHP cu modul FCGI</h5>
Începând cu versiunea Wampserver 3.2.8, este posibilă utilizarea PHP în modul CGI, ex. poţi defini o versiune diferită a PHP, pentru care addon-urile au fost instalate anterior, pentru fiecare VirtualHost. Astfel, VirtualHost nu mai sunt limitate la a utiliza aceeaşi versiune de PHP.

Modulul Apache fcgid_module (mod_fcgid.so) simplifică implementarea CGI
Documentaţia se regăseşte aici: <a href='https://httpd.apache.org/mod_fcgid/mod/mod_fcgid.html'>mod_fcgid</a>

<h5>- PreCondiţii</h5>
- 1 Existenţa fişierului mod_fcgid.so în directorul Apache "modules".
- 2 Existenţa liniei de încărcare a modulului în fişierul httpd.conf
  <code>LoadModule fcgid_module modules/mod_fcgid.so</code> (Fără a fi comentată - Fără # la începutul liniei)
- 3 Existenţa directivelor de configurare a modulului fcgid_module în fişierul httpd.conf
<code>
&lt;IfModule fcgid_module>
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
&lt;/IfModule>
</code>
Aceste 3 condiţii de mai sus (1, 2 şi 3) sunt realizate în mod automat odată cu actualizarea la versiunea Wampserver 3.2.8

<h5>- Crearea unui VirtualHost FCGI</h5>
- După actualizarea la versiunea Wampserver 3.2.8, pagina 'http://localhost/add_vhost.php' va permite adăugarea cu uşurinţă a unui VirtualHost FCGI.
Versiunile PHP utilizate ce pot fi setate sunt numai cele instalate deja în Wampserver, pentru a evita o eroare legată de versiunea PHP.
Declararea într-un VirtualHost a unei versiuni PHP inexistente în Wampserver va genera o eroare Apache şi blocarea acestuia ("crash").

- Dacă vrei să modifici un VirtualHost definit deja pentru a adăuga modul FCGI cu o versiune PHP existentă în addon-urile Wampserver, deschideţi pagina http://localhost/add_vhost.php şi lansaţi formularul de modificare a VirtualHost pentru ca, în dar trei click-uri, sî adaugi modul FCGI, să modifici versiunea de PHP sau să ştergi modul FCGI.
După efectuarea modificărilor, Wampserver va trebui reîncărcat (refresh).
Aceeaşi pagină http://localhost/add_vhost.php va permite, de asemenea, prin formularul de modificare a Alias, să adaugi modul FCGI la un Alias, să schimbi versiunea PHP sau să ştergi modul FCGI, tot în numai trei click-uri.

<h5>- Mai multe detalii</h5>
Pentru a adăuga modul FCGI la un VirtualHost existent, trebuiesc doar adăugate directivele următoare chiar înainte de &lt;/VirtualHost> la sfârşitul respectivului VirtualHost:
<code>
  &lt;IfModule fcgid_module>
    Define FCGIPHPVERSION "7.4.27"
    FcgidInitialEnv PHPRC "${PHPROOT}${FCGIPHPVERSION}/php.ini"
    &lt;Files ~ "\.php$">
      Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
      AddHandler fcgid-script .php
      FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
    &lt;/Files>
  &lt;/IfModule>
</code>
Versiunea PHP trebuie să existe ca addon PHP în Wampserver şi poate fi modificată.
Pe de altă parte, ştergând aceste linii va determina ca VirtualHost să ruleze numai în versiunea PHP încărcată ca modul Apache.

Pentru Alias e puţin mai complicat, liniile de mai sus trebuie adăugate în două părţi, prima parte:
<code>
&lt;IfModule fcgid_module>
  Define FCGIPHPVERSION "7.4.27"
  FcgidCmdOptions ${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe \
  InitialEnv PHPRC=${PHPROOT}${FCGIPHPVERSION}/php.ini
&lt;/IfModule>
</code>
chiar înaintea directivei &lt;Directory...
Cea de-a doua parte:
<code>
&lt;IfModule fcgid_module>
  &lt;Files ~ "\.php$">
    Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
    AddHandler fcgid-script .php
    FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
  &lt;/Files>
&lt;/IfModule>
</code>
în cuprinsul contextului &lt;Directory...>..&lt;/Directory>, pentru a obţine, ca exemplu al unui Alias oarecare, următoarea structură:
<code>
Alias /myalias "g:/www/mydir/"
&lt;IfModule fcgid_module>
  Define FCGIPHPVERSION "7.4.27"
  FcgidCmdOptions ${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe \
  InitialEnv PHPRC=${PHPROOT}${FCGIPHPVERSION}/php.ini
&lt;/IfModule>
&lt;Directory "g:/www/mydir/">
  Options Indexes FollowSymLinks
  AllowOverride all
  Require local
  &lt;IfModule fcgid_module>
    &lt;Files ~ "\.php$">
      Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
      AddHandler fcgid-script .php
      FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
    &lt;/Files>
  &lt;/IfModule>
&lt;/Directory>
</code>

FCGIEOT;

?>