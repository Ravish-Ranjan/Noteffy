<?php
//3.2.8 Nouveau fichier
//3.3.0 modification des lignes FcgidInitialEnv

$langues['fcgi_mode_link'] = 'Aide mode FCGI';
$langues['fcgi_not_loaded'] = 'PHP ne peut pas être utilisé en mode FCGI parce que le module Apache fcgid_module n\'est pas chargé';
$langues['fcgi_mode_help'] = <<< 'FCGIEOT'
<h4> - Comment utiliser PHP en mode Fast CGI avec Wampserver</h4>
CGI (Common Gateway Interface) définit une méthode d'interaction entre un serveur web et des programmes générateurs de contenu externes, plus souvent appelés programmes CGI ou scripts CGI. Il s'agit d'une méthode simple pour ajouter du contenu dynamique à votre site web en utilisant votre langage de programmation préféré.

<h5>- Une seule version PHP en Module Apache</h5>
Depuis l'origine, Wampserver charge PHP en tant que module Apache :
  <code>LoadModule php_module "${INSTALL_DIR}/bin/php/php8.1.1/php8apache2_4.dll"</code>
ce qui fait que tous les VirtualHost, les Alias et les Projets utilisent la même version PHP.
Si on change de version PHP via le menu PHP de Wampmanager, cette nouvelle version sera utilisée partout.

<h5>- Plusieurs versions PHP en mode FCGI</h5>
Depuis Wampserver 3.2.8, il est possible d'utiliser PHP en mode CGI, c'est-à-dire que l'on peut définir une version PHP différente, dont les addons ont été préalablement installés, pour chaque VirtualHost. Ce qui fait que les VirtualHost ne sont plus obligés d'utiliser la même version PHP.

Le module externe Apache fcgid_module (mod_fcgid.so) simplifie la mise en œuvre de CGI
La documentation est là : <a href='https://httpd.apache.org/mod_fcgid/mod/mod_fcgid.html'>mod_fcgid</a>

<h5>- Prérequis</h5>
- 1 - Présence du fichier mod_fcgid.so dans le dossier modules d'Apache.
- 2 - Présence de la ligne de chargement du module dans le fichier httpd.conf
  <code>LoadModule fcgid_module modules/mod_fcgid.so</code> (Non commentée - pas de # au début)
- 3 - Présence des directives communes de configuration du module fcgid_module dans le fichier httpd.conf
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
Ces trois points 1, 2 et 3 sont effectués automatiquement avec la mise à jour Wampserver 3.2.8

<h5>- Création d'un VirtualHost FCGI</h5>
- Après la mise à jour Wampserver 3.2.8, la page 'http://localhost/add_vhost.php' permet l'ajout d'un VirtualHost FCGI en toute simplicité.
Le choix de la version de PHP à utiliser est limité aux versions des addons PHP installés dans votre Wampserver ce qui évite une erreur de version PHP.
En effet, déclarer, dans un VirtualHost, une version PHP inexistante dans Wampserver va générer une erreur Apache et un "plantage" de celui-ci.

- Si vous voulez modifier un VirtualHost existant pour y adjoindre le mode FCGI avec une version PHP existante déjà dans les addons PHP Wampserver, il suffit... là aussi, d'aller sur la page http://localhost/add_vhost.php et de lancer le Formulaire de modification de VirtualHost pour pouvoir, en trois clics, ajouter le mode FCGI au VirtualHost, changer de version PHP ou supprimer le mode FCGI.
Il faudra rafraîchir Wampserver pour que cela soit pris en compte.
Cette même page 'http://localhost/add_vhost.php' permet également, via le Formulaire de modification Alias, d'ajouter le mode FCGI à un Alias, de changer la version PHP ou supprimer le mode FCGI, toujours en trois clics.

<h5>-- Quelques détails --</h5>

Pour ajouter le mode FCGI à un VirtualHost déjà existant, il suffit d'ajouter les directives suivantes, juste avant la fin &lt;/VirtualHost> de ce VirtualHost:
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
La version PHP doit exister comme addon PHP dans votre Wampserver et peut être modifiée.
À l'inverse la suppression de ces lignes fait que le VirtualHost revient à la version PHP utilisée en tant que module Apache.

Pour les Alias, c'est un petit peu moins simple, il faut ajouter les lignes précédentes en deux parties, la première partie :
<code>
&lt;IfModule fcgid_module>
  Define FCGIPHPVERSION "7.4.27"
  FcgidCmdOptions ${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe \
  InitialEnv PHPRC=${PHPROOT}${FCGIPHPVERSION}/php.ini
&lt;/IfModule>
</code>
juste avant la directive <code>&lt;Directory...</code>
La seconde partie :
<code>
&lt;IfModule fcgid_module>
  &lt;Files ~ "\.php$">
    Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
    AddHandler fcgid-script .php
    FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
  &lt;/Files>
&lt;/IfModule>
</code>
à l'intérieur du contexte <code>&lt;Directory...>...&lt;/Directory></code> de manière à obtenir, par exemple pour un Alias quelconque, la structure suivante :
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