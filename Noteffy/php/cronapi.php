
   <?php
    echo __DIR__;
    require_once('hash.php');
    $mailcmd = "python3 ".explode("/php",__DIR__)[0]."python/mail.py";
    date_default_timezone_set("Asia/Kolkata");
    $crontable = new SplFileObject("../../../../home/shivang/cronbuffer.afh",'w+') or die("Could not open file");

    echo 1111;

 function cronCreate(&$user){
     global $mailcmd,$crontable;

     $crontable->fwrite('#'.$user['User_Name']."\n");
     foreach($user['To-do'] as $tasklist){
        if($tasklist['Priority']==0){
         continue;
        }
        //Default is inactive task
        $m1 = "0";$d = "0";$h = "0";$m2 = "0";$dow = "0";
        $t_time = $tasklist['T_Time'];
        $t_date = $tasklist['T_Date'];
        $t_dt = $t_date." ".$t_time;
        $crontable->fwrite("#".$t_dt."\n");
        $findate = date_create(date($t_dt));
        $curdate = date_create(date('d-m-Y H:i'));
        $interval = date_diff($curdate,$findate);
        $remtime = $interval->i;

       if($interval->invert==1){
            //Ask gaurang for note deletion code and insert it here
            $tasklist['Priority'] = '0';
            $crontable->fwrite("# Sike that was deleted fool\n");
        }
        elseif($interval->invert==0){
            if($interval->h==0 && $remtime<=10){
               $tasklist['Priority'] = '1';
            }
            elseif($interval->h==0 && $remtime<=20){
               $tasklist['Priority'] = '2';
            }
            elseif($interval->h==0 && $remtime>20){
               $tasklist['Priority'] = '3';
            }
            switch($tasklist['Priority']){
                  case '1':
                     $m1 = "*/2";$h = "*";$d = "*";$m2 = "*";$dow = "*";break;
                  case '2':
                     $m1 = "*/5";$h = "*";$d = "*";$m2 = "*";$dow = "*";break;
                  case '3':
                     $m1 = "*/10";$h = "*";$d = "*";$m2 = "*";$dow = "*";break;
         }
         $crontable->fwrite("#Priority: ".$tasklist['Priority']."\n");
         $entry = "\n$m1 $h $d $m2 $dow $mailcmd ".$user['Email']." 2 '".implode("<br>",explode("\n",$tasklist['Tasks']))."'\n";
         $crontable->fwrite($entry);
      }

   }
   $crontable->fwrite("* * * * * cat /home/shivang/cronbuffer.afh | crontab\n");
    $crontable->rewind();
 }

  function cronUpdate(){
      global $crontable;
      $storage = file_get_contents(__DIR__."/storage.aes") or die("Could Not open file");
      $storage = decrypt_data($storage);
      $storage = json_decode($storage,true);

      $crontable->fwrite("* * * * * php /opt/lampp/htdocs/testing/cronapi.php\n");
      foreach($storage["Users"] as $user){
         cronCreate($user);
      }

      $storage1 = json_encode($storage,true);
      $storage1 = encrypt_data($storage1);
      file_put_contents(__DIR__."/storage.aes",$storage1);

    }
   cronUpdate();
    ?>

