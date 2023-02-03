<?php

//3.1.1 - NotwwwDir
//3.1.3 - VirtualHostPortNone
//3.1.4 - txtTLDdev
//3.1.9 - VirtualHostName modificēts - pieņem diakritiskās rakstzīmes (IDN)
$langues = array(
'langue' => 'latviešu valoda',
'locale' => 'latviešu valoda',
'addVirtual' => 'Pievienot VirtualHost',
'backHome' => 'Atpakaļ uz sākumlapu',
'VirtualSubMenuOn' => ' <code>VirtualHost apakšizvēlne</code>vienumam jābūt iestatītam uz (Ieslēgts) <code>Wamp iestatījumi</code>Ar peles labo pogu noklikšķiniet uz izvēlnes. Pēc tam atkārtoti ielādējiet šo lapu ',
'UncommentInclude' => 'Atcelt komentāru <small> (noņemiet #)</small>līnijai <code>#Iekļaujiet conf/extra/httpd-vhosts.conf</code><br>failā %s',
'FileNotExists' => 'Faila <code>%s</code>nev',
'txtTLDdev' => 'Servera nosaukums %s izmanto TLD %s ko monopolizē tīmekļa pārlūkprogrammas. Izmantojiet citu TLD (piemēram, .test)',
'FileNotWritable' => 'Fails <code>%s</code>nav rakstāms',
'DirNotExists' => '<code>%s</code>nav vai arī nav direktorijs',
'NotwwwDir' => ' <code>%s</code>mape ir rezervēta vietnei "localhost". Lūdzu, izmantojiet citu mapi.',
'NotCleaned' => '<code>%s</code>fails nav iztīrīts.<br>Ir palikuši VirtualHost piemēri, piemēram: dummy-host.example.com',
'NoVirtualHost' => 'Vietnē nav definēts neviens VirtualHost <code>%s</code><br>Tam vajadzētu būt vismaz localhost priekš VirtualHost.',
'NoFirst' => 'Failā pirmajam VirtualHost jābūt <code> localhost</code><code>%s</code>',
'ServerNameInvalid' => 'Servera nosaukums <code>%s</code>nav derīgs.',
'LocalIpInvalid' => 'Vietējā IP adrese <code>%s</code>nav derīga.',
'VirtualHostName' => ' <code>Virtuālais resursdators</code> bez atstarpēm un bez pasvītrojuma zīmēm (_) ',
'VirtualHostFolder' => 'VirtualHost <code>mapes</code> absolūtais <code>ceļš</code> <i>Piemēri: C:/wamp/www/projekts/ vai E:/www/vietne1/</i> ',
'VirtualHostIP' => '<code class="option"> Ja</code> vēlaties izmantot VirtualHost ar IP: <code class="option"> vietējais IP</code>127.x.y.z ',
'VirtualHostPort' => '<code class="option">Ja</code> vēlaties izmantot "Klausīšanās portu", nevis noklusējumu <code class="option"> Pieņemtie porti</code> %s',
'VirtualHostPortNone' => 'Ja vēlaties izmantot "Klausīšanās portu", kas nav noklusējuma ports, jums tas ir jāpievieno Apache, klikšķinot ar peles labo pogu uz Rīki ',
'VirtualAlreadyExist' => 'Servera nosaukums <code>%s</code>jau eksistē',
'VirtualIpAlreadyUsed' => 'Vietējais IP <code>%s</code>jau eksistē',
'VirtualPortNotExist' => 'Ports <code>%s</code>nav "Klausīšanās ports" Apache',
'VirtualPortExist' => 'Ports <code>%s</code>ir noklusējuma Apache klausīšanās ports un to nevajadzētu pieminēt',
'VirtualHostExists' => 'Ir definēti šādi VirtualHost:',
'Start' => 'Sākt VirtualHost izveidi (var paiet zināms laiks...)',
'GreenErrors' => 'Zaļi ierāmētās kļūdas var labot automātiski.',
'Correct' => 'Sāciet kļūdu automātisku labošanu zaļi ierāmētajā panelī',
'NoModify' => 'Nav iespējams modificēt <code> httpd-vhosts.conf</code>vai <code> resursdatora</code>failus',
'VirtualCreated' => 'Faili ir modificēti. Virtuālais resursdators <code>%s</code> tika izveidots ',
'CommandMessage' => 'Ziņojumi no konsoles, lai atjauninātu DNS:',
'Tomēr' => 'Jūs varat pievienot citu VirtualHost, apstiprinot "Pievienot VirtualHost".<br>Tomēr, lai Apache ņemtu vērā šos jaunos VirtualHost, jums jāpalaiž vienums<br><code>Restartējiet DNS</code><br>no ikonas Wampmanager ar peles labo pogu noklikšķiniet uz Rīki. <i>(Diemžēl to nevar izdarīt automātiski)</i>',
'suppForm' => 'Atvērt VirtualHost pārtraukšanu',
'suppVhost' => 'Pārtraukt atzīmētos VirtualHost',
'Obligāts' => 'Nepieciešams',
'Pēc izvēles' => 'Pēc izvēles',
	);
?>