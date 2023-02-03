<?php
//3.1.1 - NotwwwDir
//3.1.3 - VirtualHostPortNone
//3.1.4 - txtTLDdev
//3.1.9 - VirtualHostName modified - Accept diacritical characters (IDN)
//3.2.6 - HoweverWamp
//3.2.8 - phpNotExists - VirtualHostPhpFCGI - modifyForm - modifyVhost - modAliasForm
//      - modifyAlias - StartAlias - ModifiedAlias - NoModifyAlias - HoweverAlias
//  modified: VirtualHostPort (%s replaced by below ) - Start - VirtualCreated - However - HoweverWamp
//  array $langues_help added.
//3.3.0 - Modification of lines FcgidInitialEnv

$langues = array(
	'langue' => 'English',
	'locale' => 'english',
	'addVirtual' => 'Add a VirtualHost',
	'backHome' => 'Back to homepage',
	'VirtualSubMenuOn' => 'The <code>VirtualHost sub-menu</code> item must be set to (On) in the <code>Wamp Settings</code> Right-Click menu. Then reload this page',
	'UncommentInclude' => 'Uncomment <small>(Suppress #)</small> the line <code>#Include conf/extra/httpd-vhosts.conf</code><br>in file %s',
	'FileNotExists' => 'The file <code>%s</code> does not exists',
	'txtTLDdev' => 'The ServerName %s use TLD %s which is monopolized by web browsers. Use another TLD (.test for example)',
	'FileNotWritable' => 'The file <code>%s</code> is not writable',
	'DirNotExists' => '<code>%s</code> does not exists or is not a directory',
	'NotwwwDir' => 'The <code>%s</code> folder is reserved for "localhost". Please use another folder.',
	'NotCleaned' => 'The <code>%s</code> file has not been cleaned.<br>There remain VirtualHost examples like: dummy-host.example.com',
	'NoVirtualHost' => 'There is no VirtualHost defined in <code>%s</code><br>It should at least have the VirtualHost for localhost.',
	'NoFirst' => 'The first VirtualHost must be <code>localhost</code> in <code>%s</code> file',
	'ServerNameInvalid' => 'The ServerName <code>%s</code> is invalid.',
	'LocalIpInvalid' => 'The local IP <code>%s</code> is invalid.',
	'VirtualHostName' => 'Name of the <code>Virtual Host</code> No space - No underscore(_) ',
	'VirtualHostFolder' => 'Complete absolute <code>path</code> of the VirtualHost <code>folder</code> <i>Examples: C:/wamp/www/projet/ or E:/www/site1/</i> ',
	'VirtualHostIP' => '<code class="option">If</code> you want to use VirtualHost by IP: <code class="option">local IP</code> 127.x.y.z ',
	'VirtualHostPhpFCGI' => '<code class="option">If</code> you want to use PHP in FCGI mode <code class="option">Accepted versions</code> below ',
	'VirtualHostPort' => '<code class="option">If</code> you want to use "Listen port" other than the default <code class="option">Accepted ports</code> below ',
	'VirtualHostPortNone' => 'If you want to use a "Listen port" other than the default one, you must add a Listen Port to Apache by Right-Click Tools ',
	'VirtualAlreadyExist' => 'The ServerName <code>%s</code> already exists',
	'VirtualIpAlreadyUsed' => 'The local IP <code>%s</code> already exists',
	'VirtualPortNotExist' => 'The port <code>%s</code> is not a "Listen port" Apache',
	'VirtualPortExist' => 'The port <code>%s</code> is default "Listen port" Apache and should not be mentioned',
	'VirtualHostExists' => 'VirtualHost already defined:',
	'Start' => 'Start the creation/modification of the VirtualHost (May take a while...)',
	'StartAlias' => 'Start the modification of the Alias',
	'GreenErrors' => 'The green framed errors can be corrected automatically.',
	'Correct' => 'Start the automatic correction of errors inside the green borders panel',
	'NoModify' => 'Impossible to modify <code>httpd-vhosts.conf</code> or <code>hosts</code> files',
	'NoModifyAlias' => 'Alias has not been modified',
	'VirtualCreated' => 'The files have been modified. Virtual host <code>%s</code> was created/modified',
	'ModifiedAlias' => 'The alias <code>%s</code> have been modified',
	'CommandMessage' => 'Messages from the console to update DNS:',
	'However' => 'You may add/modify another VirtualHost by validate "Add a VirtualHost".<br>However, for these new VirtualHost are taken into account by Wampmanager (Apache), you must run item<br><code>Restart DNS</code><br>from Right-Click Tools menu of Wampmanager icon.</i>',
	'HoweverAlias' => 'You may modify another Alias by validate "Add a VirtualHost".<br>However, for these modified Alias is taken into account by Wampmanager (Apache), you must run item<br><code>Restart DNS</code><br>from Right-Click Tools menu of Wampmanager icon.</i>',
	'HoweverWamp' => 'The created/modified VirtualHost has been taken into account by Apache.<br>You may add/modify another VirtualHost by validate "Add a VirtualHost".<br>You can start working on this new VirtualHost<br>But in order for these new VirtualHosts to be taken into account by the Wampmanager menus, you must launch the item<br><code>Refresh</code><br>from Right-Click menu of Wampmanager icon.</i>',
	'suppForm' => 'Delete VirtualHost form',
	'suppVhost' => 'Delete VirtualHost',
	'modifyForm' => 'Modify VirtualHost form',
	'modifyVhost' => 'Modify VirtualHost',
	'modAliasForm' => 'Modify Alias form',
	'modifyAlias' => 'Modify Alias',
	'Required' => 'Required',
	'Optional' => 'Optional',
	'phpNotExists' => 'PHP version doesn\'t exist',
	);

$langues_help['fcgi_mode_link'] = 'FCGI mode help';
$langues_help['fcgi_mode_help'] = <<< 'FCGIEOT'
- *** How to use PHP in Fast CGI mode with Wampserver ***
The CGI (Common Gateway Interface) defines a way for a web server to interact with external content-generating programs, which are often referred to as CGI programs or CGI scripts. It is a simple way to put dynamic content on your web site, using whatever programming language you're most familiar with.

- ** Only one PHP version as Apache module **
Since the beginning, Wampserver loads PHP as an Apache module:
LoadModule php_module "${INSTALL_DIR}/bin/php/php8.1.1/php8apache2_4.dll"
which makes all VirtualHost, Alias and Projects use the same PHP version.
If you change the PHP version via the PHP menu of Wampmanager, this new version will be used everywhere.

- ** Several PHP versions with FCGI mode **
Since Wampserver 3.2.8, it is possible to use PHP in CGI mode, i.e. you can define a different PHP version, whose addons have been previously installed, for each VirtualHost. This means that the VirtualHost are not obliged to use the same PHP version anymore.

The Apache fcgid_module (mod_fcgid.so) simplifies the implementation of CGI
The documentation is here: https://httpd.apache.org/mod_fcgid/mod/mod_fcgid.html

--- 1 *** Prerequisites ***
- 1.1 Presence of the mod_fcgid.so file in the Apache modules folder.
- 1.2 Presence of the module loading line in the httpd.conf file
LoadModule fcgid_module modules/mod_fcgid.so
- 1.3 Presence of the common configuration directives of the module fcgid_module in the file httpd.conf
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

These three points 1.1, 1.2 and 1.3 are done automatically with the Wampserver 3.2.8 update

--- 2 *** Creating a FCGI VirtualHost ***
- After the Wampserver 3.2.8 update, the http://localhost/add_vhost.php page allows the addition of a FCGI VirtualHost in all simplicity.
The choice of the version of PHP to use is limited to the versions of the PHP addons installed in your Wampserver what avoids an error of version PHP.
Indeed, to declare, in a VirtualHost, a non-existent PHP version in Wampserver will generate an Apache error and a "crash" of this one.

- If you want to modify an existing VirtualHost to add the FCGI mode with an existing PHP version already in the Wampserver PHP addons, you just have to go on the page http://localhost/add_vhost.php and launch the VirtualHost modification form to be able, in three clicks, to add the FCGI mode to the VirtualHost, to change the PHP version or to remove the FCGI mode.
It will be necessary to refresh Wampserver for that to be taken into account.
This same page http://localhost/add_vhost.php also allows, via the Alias modification form, to add the FCGI mode to an Alias, to change the PHP version or to remove the FCGI mode, always in three clicks.

+--------------+
| Some details |
+--------------+
To add FCGI mode to an existing VirtualHost, simply add the following directives just before the </VirtualHost> end of that VirtualHost:
  <IfModule fcgid_module>
    Define FCGIPHPVERSION "7.4.27"
    FcgidInitialEnv PHPRC "${PHPROOT}${FCGIPHPVERSION}/php.ini"
    <Files ~ "\.php$">
      Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
      AddHandler fcgid-script .php
      FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
    </Files>
  </IfModule>

The PHP version must exist as a PHP addon in your Wampserver and can be modified.
Conversely removing these lines causes the VirtualHost to revert to the PHP version used as an Apache module.

For Alias, it's a little less simple, you need to add the previous lines in two parts, the first part:
<IfModule fcgid_module>
  Define FCGIPHPVERSION "7.4.27"
  FcgidCmdOptions ${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe \
  InitialEnv PHPRC=${PHPROOT}${FCGIPHPVERSION}/php.ini
</IfModule>
just before the <Directory... directive.
The second part:
<IfModule fcgid_module>
  <Files ~ "\.php$">
    Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
    AddHandler fcgid-script .php
    FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
  </Files>
</IfModule>
inside the <Directory...></Directory> context so as to obtain, for example for any Alias, the following structure:

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