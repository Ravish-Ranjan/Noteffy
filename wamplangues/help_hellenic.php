<?php
//3.2.8 - New file
//3.3.0 - Modification of lines FcgidInitialEnv

$langues['fcgi_mode_link'] = 'Βοήθεια κατάστασης FCGI';
$langues['fcgi_not_loaded'] = 'Η PHP δεν μπορεί να χρησιμοποιηθεί σε κατάσταση FCGI διότι το module fcgid_module του Apache δεν έχει φορτωθεί';
$langues['fcgi_mode_help'] = <<< 'FCGIEOT'
<h4>Πως να χρησιμοποιήσετε την PHP στην κατάσταση Fast CGI με τον Wampserver</h4>
Το CGI (Common Gateway Interface) ορίζει έναν τρόπο για έναν διακομιστή ιστού να συνεργάζεται με εξωτερικά προγράμματα δημιουργίας περιεχομένου, που συχνά αναφέρονται ως προγράμματα CGI ή κώδικες CGI.
Είναι ένας απλός τρόπος για εισαγωγή δυναμικού περιεχομένου στις ιστοσελίδες σας, χρησιμοποιώντας οποιαδήποτε γλώσσα προγραμματισμού με την οποία είστε εξοικειωμένοι.

<h5>- Μόνο μια έκδοση PHP ως module του Apache</h5>
Από την αρχή, το Wampserver φορτώνει την PHP ως module του Apache:
  <code>LoadModule php_module "${INSTALL_DIR}/bin/php/php8.1.1/php8apache2_4.dll"</code>
γεγονός που αναγκάζει όλα τα VirtualHost, Ετικέτες και Έργα να χρησιμοποιούν την ίδια έκδοση PHP.
Αν αλλάξετε την έκδοση PHP μέσω του μενού του Wampmanager, αυτή η νέα έκδοση θα έχει καθολική χρήση.

<h5>- Διάφορες εκδόσεις PHP με την κατάσταση FCGI</h5>
Με τον Wampserver 3.2.8, είναι δυνατό να χρησιμοποιηθεί η PHP κατάσταση CGI, δηλαδή μπορείτε να χρησιμοποιήσετε διαφορετική έκδοση PHP, της οποίας τα πρόσθετα έχουν εκ των προτέρων εγκατασταθεί, για κάθε VirtualHost. Αυτό σημαίνει ότι τα VirtualHost δεν είναι υποχρεωμένα να χρησιμοποιούν την ίδια έκδοση PHP πλέον.

Το fcgid_module του Apache (mod_fcgid.so) απλοποιεί την εφαρμογή του CGI.
Η τεκμηρίωση είναι εδώ: <a href='https://httpd.apache.org/mod_fcgid/mod/mod_fcgid.html'>mod_fcgid</a>

<h5>- Προαπαιτούμενα</h5>
- 1 Παρουσία του αρχείου mod_fcgid.so στο φάκελο των modules του Apache.
- 2 Παρουσία της γραμμής φόρτωση του module στο αρχείο httpd.conf.
  <code>LoadModule fcgid_module modules/mod_fcgid.so</code> (Μη σχολιασμένο - Καμιά δίεση [#] στην αρχή)
- 3 Παρουσία των κοινών οδηγίών ρύθμισης του module fcgid_module στο αρχείο httpd.conf
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
Αυτά τα τρία σημεία 1, 2 και 3 έχουν γίνει αυτόματα με την αναβάθμιση στην έκδοση 3.2.8 του Wampserver

<h5>- Δημιουργία ενός FCGI VirtualHost</h5>
- Μετά την ενημέρωση 3.2.8 του Wampserver, η σελίδα http://localhost/add_vhost.php επιτρέπει την προσθήκη ενός FCGI VirtualHost καθολικά και απλά.
Η επιλογή της έκδοσης PHP για χρήση περιορίζεται στις εκδόσεις PHP που έχουν εγκατασταθεί στον Wampserver, γεγονός που αποτρέπει σφάλματα της έκδοσης.
Πράγματι, για να κηρυχθεί, σε ένα VirtualHost, μια μη εγκατεστημένη στον Wampserver έκδοση PHP θα δώσει ένα σφάλμα του Apache και τη μη εκκίνησή του.

- Αν θέλετε να αλλάξετε ένα υπάρχον VirtualHost για να προσθέσετε μια κατάσταση FCGI με μια υπάρχουσα έκδοση PHP που είναι ήδη εγκατεστημένη στον Wampserver, απλά πρέπει να πάτε στη σελίδα http://localhost/add_vhost.php και επιλέξτε τη φόρμα αλλαγής VirtualHost για να ενεργοποιηθεί με τρία κλικ, ώστε να προσθεσετε την κατάσταση FCGI στο VirtualHost και να αλλάξετε την έκδοση PHP ή να απομακρύνετε την κατάσταση FCGI.
θα είναι απαραίτητο να ανανεώσετε τον Wampserver για να ληφθεί αυτό υπόψιν.
Αυτή η ίδια σελίδα: http://localhost/add_vhost.php σας επιτρέπει, μέσω της φόρμας αλλαγής Ετικέτας, να προσθέσετε την κατάσταση FCGI σε μια Ετικέτα, για να αλλάξετε την έκδοση PHP ή να απομακρύνετε την κατάσταση FCGI, πάντα με τρία κλικ.

<h5>- Ορισμένες λεπτομέρειες</h5>
Για να προσθέσετε την κατάσταση FCGI σε ένα υπάρχον VirtualHost, απλώς προσθέστε τις ακόλουθες οδηγίες ακριβώς πριν το &lt;/VirtualHost> του συγκεκριμένου VirtualHost:
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
Η έκδοση PHP πρέπει να υπάρχει ήδη εγκατεστημένη στον Wampserver και να μπορεί να διαμορφωθεί.
Αντίστροφα, η απομάκρυνση αυτών των γραμμών προκαλεί τη χρήση της έκδοσης PHP που χρησιμοποιεί το module του Apache από το VirtualHost.

Για τις Ετικέτες, είναι λίγοτερο απλό γιατί χρειάζεται να προσθέσετε τις προηγούμενες γραμμές σε δύο τμήματα, εκ των οποίων το πρώτο:
<code>
&lt;IfModule fcgid_module>
  Define FCGIPHPVERSION "7.4.27"
  FcgidCmdOptions ${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe \
  InitialEnv PHPRC=${PHPROOT}${FCGIPHPVERSION}/php.ini
&lt;/IfModule>
</code>
ακριβώς πριν την οδηγία &lt;Directory...
Το δεύτερο τμήμα:
<code>
&lt;IfModule fcgid_module>
  &lt;Files ~ "\.php$">
    Options +Indexes +Includes +FollowSymLinks +MultiViews +ExecCGI
    AddHandler fcgid-script .php
    FcgidWrapper "${PHPROOT}${FCGIPHPVERSION}/php-cgi.exe" .php
  &lt;/Files>
&lt;/IfModule>
</code>
εντός του περιεχομένου &lt;Directory...>..&lt;/Directory> ώστε να επιτύχετε, παράδειγμα για κάθε Ετικέτα, την ακόλουθη δομή:
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