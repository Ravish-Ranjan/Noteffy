<?php
//3.1.1 - NotwwwDir
//3.1.3 - VirtualHostPortNone
//3.1.4 - txtTLDdev
//3.1.9 - VirtualHostName modifié. Accepte les diacritiques (IDN)
//3.2.6 - HoweverWamp
//3.2.8 - phpNotExists - VirtualHostPhpFCGI - modifyForm - modifyVhost - modAliasForm
//      - modifyAlias - StartAlias - ModifiedAlias - NoModifyAlias - HoweverAlias
//    modifiés: VirtualHostPort - Start - VirtualCreated - However - HoweverWamp
//    array $langues_help ajouté.
//3.3.0 - Modification des lignes FcgidInitialEnv

$langues = array(
	'langue' => 'Français',
	'locale' => 'french',
	'addVirtual' => 'Ajouter un VirtualHost',
	'backHome' => 'Retour à l\'accueil',
	'VirtualSubMenuOn' => 'L\'item <code>Sous-menu VirtualHost</code> doit être validé dans le menu Clic-Droit <code>Paramètres Wamp</code><br>Validez cet item puis rechargez cette page',
	'UncommentInclude' => 'Décommenter <small>(Supprimer #)</small> la ligne <code>#Include conf/extra/httpd-vhosts.conf</code><br>dans le fichier %s',
	'FileNotExists' => 'Le fichier <code>%s</code> n\'existe pas',
	'txtTLDdev' => 'Le ServerName %s utilise le TLD %s qui est accaparé par les navigateurs internet. Utilisez un autre TLD (.test par exemple)',
	'FileNotWritable' => 'Le fichier <code>%s</code> est protégé en écriture.',
	'DirNotExists' => '<code>%s</code> n\'existe pas ou n\'est pas un dossier',
	'NotwwwDir' => 'Le dossier <code>%s</code> est réservé à "localhost". Veuillez utiliser un autre dossier',
	'NotCleaned' => 'Le fichier <code>%s</code> n\'a pas été nettoyé.<br>Il reste des exemples de VirtualHost comme : dummy-host.example.com',
	'NoVirtualHost' => 'Aucun VirtualHost n\'est défini dans <code>%s</code><br>Il doit y avoir au moins un VirtualHost pour localhost.',
	'NoFirst' => 'Le premier VirtualHost doit être <code>localhost</code> dans le fichier <code>%s</code>',
	'ServerNameInvalid' => 'Le nom du ServerName <code>%s</code> n\'est pas valide.',
	'LocalIpInvalid' => 'L\'IP locale <code>%s</code> n\'est pas valide.',
	'VirtualHostName' => 'Nom du <code>Virtual Host</code> Pas d\'espace - Pas de tiret bas (_) ',
	'VirtualHostFolder' => '<code>Chemin</code> complet absolu du <code>dossier</code> VirtualHost - <i>Exemples : C:/wamp/www/projet/ ou E:/www/site1/</i> ',
	'VirtualHostIP' => '<code class="option">Si</code> vous voulez utiliser les VirtualHost par IP : <code class="option">IP locale</code> 127.x.y.z ',
	'VirtualHostPort' => '<code class="option">Si</code> vous voulez utiliser un "Listen port" autre que celui par défaut <code class="option">Ports acceptés</code> ci-dessous ',
	'VirtualHostPhpFCGI' => '<code class="option">Si</code> vous voulez utiliser PHP en mode FCGI <code class="option">Versions acceptées</code> ci-dessous ',
	'VirtualHostPortNone' => 'Si vous voulez utiliser un "Listen port" autre que celui par défaut, vous devez ajouter un Listen Port à Apache par Clic-Droit Outils ',
	'VirtualAlreadyExist' => 'Le ServerName <code>%s</code> existe déjà',
	'VirtualIpAlreadyUsed' => 'L\'IP locale <code>%s</code> existe déjà',
	'VirtualPortNotExist' => 'Le port <code>%s</code> ne fait pas partie des "Listen port" Apache',
	'VirtualPortExist' => 'Le port <code>%s</code> fait partie des "Listen port" Apache par défaut et ne doit pas être mentionné',
	'VirtualHostExists' => 'VirtualHost déjà définis :',
	'Start' => 'Démarrer la création ou la modification du VirtualHost (Peut prendre un certain temps)',
	'StartAlias' => 'Démarrer la modification de l\'Alias',
	'GreenErrors' => 'Les erreurs encadrées en vert peuvent être corrigées automatiquement"',
	'Correct' => 'Démarrer la correction automatique des erreurs notées dans le cadre à bordures vertes',
	'NoModify' => 'Impossible de modifier les fichiers <code>httpd-vhosts.conf</code> ou <code>hosts</code>',
	'NoModifyAlias' => 'L\'Alias n\'a pas été modifié',
	'VirtualCreated' => 'Les fichiers ont été modifiés, le virtual host <code>%s</code> a été créé/modifié',
	'ModifiedAlias' => 'L\'alias <code>%s</code> a été modifié',
	'CommandMessage' => 'Messages de la console pour actualisation des DNS :',
	'However' => 'Vous pouvez ajouter/modifier un autre VirtualHost en validant "Ajouter un VirtualHost"<br>Cependant, pour que ces nouveaux VirtualHost soient pris en compte par Wampmanager (Apache), vous devez lancer l\'item<br><code>Redémarrage DNS</code><br>du menu Outils par Clic-Droit sur l\'icône Wampmanager.</i>',
	'HoweverAlias' => 'Vous pouvez modifier un autre Alias en validant "Ajouter un VirtualHost"<br>Cependant, pour que cet Alias modifié soit pris en compte par Wampmanager (Apache), vous devez lancer l\'item<br><code>Redémarrage DNS</code><br>du menu Outils par Clic-Droit sur l\'icône Wampmanager.</i>',
	'HoweverWamp' => 'Le VirtualHost créé a été pris en compte par Apache.<br>Vous pouvez ajouter/modifier un autre VirtualHost en validant "Ajouter un VirtualHost"<br>Vous pouvez commencer à travailler sur ce nouveau VirtualHost<br>Mais pour que ces nouveaux VirtualHost soient pris en compte par les menus Wampmanager, vous devez lancer l\'item<br><code>Rafraîchir</code><br>du menu Outils par Clic-Droit sur l\'icône Wampmanager.</i>',
	'suppForm' => 'Formulaire de suppression de VirtualHost',
	'suppVhost' => 'Supprimer VirtualHost',
	'modifyForm' => 'Formulaire de modification de VirtualHost',
	'modifyVhost' => 'Modifier VirtualHost',
	'modAliasForm' => 'Formulaire de modification d\'Alias',
	'modifyAlias' => 'Modifier Alias',
	'Required' => 'Requis',
	'Optional' => 'Optionnel',
	'phpNotExists' => 'La version de PHP n\'existe pas',
);

$langues_help['fcgi_mode_link'] = 'Aide mode FCGI';
$langues_help['fcgi_mode_help'] = <<< 'FCGIEOT'
- *** Comment utiliser PHP en mode Fast CGI avec Wampserver ***
CGI (Common Gateway Interface) définit une méthode d'interaction entre un serveur web et des programmes générateurs de contenu externes, plus souvent appelés programmes CGI ou scripts CGI. Il s'agit d'une méthode simple pour ajouter du contenu dynamique à votre site web en utilisant votre langage de programmation préféré.

- ** Une seule version PHP en Module Apache **
Depuis l'origine, Wampserver charge PHP en tant que module Apache :
  LoadModule php_module "${INSTALL_DIR}/bin/php/php8.1.1/php8apache2_4.dll"
ce qui fait que tous les VirtualHost, les Alias et les Projets utilisent la même version PHP.
Si on change de version PHP via le menu PHP de Wampmanager, cette nouvelle version sera utilisée partout.

- ** Plusieurs versions PHP en mode FCGI **
Depuis Wampserver 3.2.8, il est possible d'utiliser PHP en mode CGI, c'est-à-dire que l'on peut définir une version PHP différente, dont les addons ont été préalablement installés, pour chaque VirtualHost. Ce qui fait que les VirtualHost ne sont plus obligés d'utiliser la même version PHP.

Le module externe Apache fcgid_module (mod_fcgid.so) simplifie la mise en œuvre de CGI
La documentation est là : https://httpd.apache.org/mod_fcgid/mod/mod_fcgid.html

--- 1 *** Prérequis ***
- 1.1 Présence du fichier mod_fcgid.so dans le dossier modules d'Apache.
- 1.2 Présence de la ligne de chargement du module dans le fichier httpd.conf
  LoadModule fcgid_module modules/mod_fcgid.so
- 1.3 Présence des directives communes de configuration du module fcgid_module dans le fichier httpd.conf
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

Ces trois points 1.1, 1.2 et 1.3 sont effectués automatiquement avec la mise à jour Wampserver 3.2.8

--- 2 *** Création d'un VirtualHost FCGI ***
- Après la mise à jour Wampserver 3.2.8, la page 'http://localhost/add_vhost.php' permet l'ajout d'un VirtualHost FCGI en toute simplicité.
Le choix de la version de PHP à utiliser est limité aux versions des addons PHP installés dans votre Wampserver ce qui évite une erreur de version PHP.
En effet, déclarer, dans un VirtualHost, une version PHP inexistante dans Wampserver va générer une erreur Apache et un "plantage" de celui-ci.

- Si vous voulez modifier un VirtualHost existant pour y adjoindre le mode FCGI avec une version PHP existante déjà dans les addons PHP Wampserver, il suffit... là aussi, d'aller sur la page http://localhost/add_vhost.php et de lancer le Formulaire de modification de VirtualHost pour pouvoir, en trois clics, ajouter le mode FCGI au VirtualHost, changer de version PHP ou supprimer le mode FCGI.
Il faudra rafraîchir Wampserver pour que cela soit pris en compte.
Cette même page 'http://localhost/add_vhost.php' permet également, via le Formulaire de modification Alias, d'ajouter le mode FCGI à un Alias, de changer la version PHP ou supprimer le mode FCGI, toujours en trois clics.

+------------------+
| Quelques détails |
+------------------+
Pour ajouter le mode FCGI à un VirtualHost déjà existant, il suffit d'ajouter les directives suivantes, juste avant la fin </VirtualHost> de ce VirtualHost:
  <IfModule fcgid_module>
    Define FCGIPHPVERSION "7.4.27"
    FcgidInitialEnv PHPRC "${PHPROOT}${FCGIPHPVERSION}/php.ini"
    <Files ~ "\.php$">
      Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
      AddHandler fcgid-script .php
      FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
    </Files>
  </IfModule>

La version PHP doit exister comme addon PHP dans votre Wampserver et peut être modifiée.
À l'inverse la suppression de ces lignes fait que le VirtualHost revient à la version PHP utilisée en tant que module Apache.

Pour les Alias, c'est un petit peu moins simple, il faut ajouter les lignes précédentes en deux parties, la première partie :
<IfModule fcgid_module>
  Define FCGIPHPVERSION "7.4.27"
  FcgidCmdOptions ${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe \
  InitialEnv PHPRC=${PHPROOT}${FCGIPHPVERSION}/php.ini
</IfModule>
juste avant la directive <Directory...
La seconde partie :
<IfModule fcgid_module>
  <Files ~ "\.php$">
    Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
    AddHandler fcgid-script .php
    FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
  </Files>
</IfModule>
à l'intérieur du contexte <Directory...></Directory> de manière à obtenir, par exemple pour un Alias quelconque, la structure suivante :
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