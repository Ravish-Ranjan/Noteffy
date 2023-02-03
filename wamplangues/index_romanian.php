<?php
// Romanian language file for Index page
// Translated by Ciprian Murariu <ciprianmp[at]yahoo[dot]com>
// 3.1.4 - txtTLDdev
// 3.2.0 - txtProjects
// 3.2.1 - defaultDBMS - HelpMySQLMariaDB
// 3.2.5 - documentation-of added for languages requiring it
// for English is identical to documentation
// 3.2.6 - txtNoHosts
// 3.2.8 - phpNotExists - txtProjectsLink -	phpExtensions - phpVersionsUse

$langues = array(
	'langue' => 'Română',
	'locale' => 'romanian',
	'titreHtml' => 'Index-ul WAMPSERVER',
	'titreConf' => 'Configurare Server',
	'versa' => 'Versiune Apache:',
	'doca2.2' => 'httpd.apache.org/docs/2.2/en/',
	'doca2.4' => 'httpd.apache.org/docs/2.4/en/',
	'versp' => 'Versiune PHP:',
	'server' => 'Aplicaţie Server:',
	'documentation' => 'Documentaţie',
	'documentation-of' => 'Documentaţie',
	'docp' => 'www.php.net/manual/en/',
	'versm' => 'Versiune MySQL:',
	'docm' => 'dev.mysql.com/doc/index.html',
	'versmaria' => 'Versiune MariaDB: ',
	'docmaria' => 'mariadb.com/kb/en/mariadb/documentation',
	'phpExt' => 'Extensii încarcate: ',
	'titrePage' => 'Instrumente',
	'txtProjet' => 'Proiectele Tale',
	'txtNoProjet' => 'Nu există încă niciun Proiect.<br />Pentru a crea unul, nu trebuie decât să creaţi un director (folder) în \'www\'.',
	'txtProjects' => 'Acestea vă sunt directoarele din %s<br />Pentru a le putea folosi ca un link http, acestea trebuiesc declarate ca VirtualHost',
	'txtProjectsLink' =>'Oricum, poţi folosi Click-Dreapta, Setări Wamp, Atenţie: Riscant! Numai pentru experţi, Permite link-uri în pagina de pornire a proiectelor',
	'txtAlias' => 'Aliasuri',
	'txtNoAlias' => 'Nu există niciun Alias.<br />Pentru a crea unul, foloseşte meniul WAMPSERVER.',
	'txtVhost' => 'VirtualHost',
	'txtServerName' => 'Numele Serverului %s are o eroare de sintaxă în fişierul %s',
	'txtDocRoot' => 'Numele Serverului %s foloseşte DocumentRoot %s rezervat pentru localhost',
	'txtTLDdev' => 'Numele Serverului %s foloseşte TLD %s care este exclusiv folosit de browserele web. Foloseşte un alt TLD (.test spre examplu)',
	'txtNoHosts' => 'Numele Serverului %s nu a fost definit în fișierul hosts.',
	'txtServerNameIp' => 'IP %s pentru Numele Serverului %s este invalid în fişierul %s',
	'txtVhostNotClean' => 'Fişierul %s nu a fost golit. Rămân exemple de VirtualHost precum: dummy-host.example.com',
	'txtNoVhost' => 'Niciun VirtualHost definit. Adaugă câte unul pentru fiecare proiect în fişierul: wamp/bin/apache/apache%s/conf/extra/httpd-vhosts.conf',
	'txtNoIncVhost' => 'Şterge comentariul sau adaugă linia <i>Include conf/extra/httpd-vhosts.conf</i> în fişierul wamp/bin/apache/apache%s/conf/httpd.conf',
	'txtNoVhostFile' => 'Fişierul: %s nu există',
	'txtNoPath' => 'Calea %s pentru %s nu există (Fişierul %s)',
	'txtNotWritable' => 'Fişierul: %s nu este modificabil',
	'txtNbNotEqual' => 'Numărul de %s nu se potriveşte cu numărul de %s în fişierul %s',
	'txtAddVhost' => 'Adaugă un Virtual Host',
	'txtPortNumber' => 'Numărul Portului pentru %s este incorect sau diferă de cel din fişierul %s',
	'txtCorrected' => 'Unele erori VirtualHosts pot fi corectate.',
	'forum' => 'Forumul Wampserver',
	'forumLink' => 'http://forum.wampserver.com/list.php?2',
	'portUsed' => 'Portul definit pentru Apache: ',
	'mysqlportUsed' => 'Portul definit pentru MySQL: ',
	'mariaportUsed' => 'Portul definit pentru MariaDB: ',
	'defaultDBMS' => 'DBMS implicit',
	'phpNotExists' => 'Versiune PHP indisponibilă',
	'HelpMySQLMariaDB' => 'Cum să folosiţi MySQL şi/sau MariaDB?<br />Ce înseamnă DBMS implicit?<br />Cum să schimbaţi DBMS implicit?<br />Citiţi pagina de Ajutor: Click-dreapta pe icon-ul Wampmanager -> Ajutor -> MariaDB - MySQL',
	'nolocalhost' => 'Nu este o idee bună sa adăugaţi localhost în adresa (url-ul) proiectelor. Este recomandată definirea unui VirtualHost corespunzător în fişierul<br />wamp/bin/apache/apache%s/conf/extra/httpd-vhosts.conf<br />şi evitarea folosirii localhost în adrese (url).',
	'phpExtensions' => 'Extensii PHP încărcate',
	'phpVersionsUse' => 'Utilizarea versiunilor PHP',
	);
?>