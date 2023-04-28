
<?php
   //   echo __DIR__;
    require_once('/opt/lampp/htdocs/Noteffy/Noteffy-main/php/hash.php');
    $mailcmd = "python3 ".explode("/data",__DIR__)[0]."/php/mail.py";
    date_default_timezone_set("Asia/Kolkata");
    //Standardize link
    $parent =  explode("/php",__DIR__)[0]."\n";
    $crontable = new SplFileObject('/opt/lampp/htdocs/Noteffy/Noteffy-main/data/cronbuffer.afh','w+') or die("Could not open file");

    function fetchData(&$sto,$num){
       return $sto["User_Data"][$num];
    }
    function fetchClassData(&$sto,$num){
      echo "*******$num*********\n";
      $classnotes = array();
      foreach($sto["Organizations"] as $org){
         foreach($org["classes"] as $class){
            if(in_array($num,$class["group"])){
               foreach($class["To-do"] as $todo){
                  if(in_array($num,$todo["assignees"])){
                     $todo["class"]=$class["Cname"];
                     array_push($classnotes,$todo);
                  }
               }
            }
         }
      }
      print_r($classnotes);
      return $classnotes;
   }
   function cronCreate(&$user,&$dat,&$classdata){
      global $mailcmd,$crontable;
 
      $crontable->fwrite('#'.$user['User_Name']."\n");
      foreach($dat['To-do'] as $tasklist){
         if($tasklist['Priority']==0){
          continue;
         }
         //Default is inactive task
         $m1 = "0";$d = "0";$h = "0";$m2 = "0";$dow = "0";
         $t_time = $tasklist['Time'];
         $t_date = $tasklist['Date'];
         $t_dt = $t_date." ".$t_time;
         $crontable->fwrite("#".$t_dt."\n");
         $findate = date_create(date($t_dt));
         $curdate = date_create(date('d-m-Y H:i'));
         $interval = date_diff($curdate,$findate);
         $remtime = $interval->i;
  
        if($interval->invert==1){
             //Note deletion to occur here
             $tasklist['Priority'] = '0';
             $crontable->fwrite("# Sike that was deleted fool\n");
         }
         elseif($interval->invert==0){
             if($interval->h==0){
                $tasklist['Priority'] = '1';
             }
             elseif($interval->h>1 && $interval->h<24){
                $tasklist['Priority'] = '2';
             }
             elseif($interval->d>1 && $interval->d<7){
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
          $st1 =  explode("\r",implode("",$tasklist['Tasks']));
          $crontable->fwrite("#Priority: ".$tasklist['Priority']."\n");
          $entry = "\n$m1 $h $d $m2 $dow $mailcmd ".$user['Email']." 2 '".implode(" ",$st1)."'\n";
          $crontable->fwrite($entry);
       }
    }
    foreach($classdata as $ctasklist){
      if($ctasklist['Priority']==0){
       continue;
      }
      //Default is inactive task
      $m1 = "0";$d = "0";$h = "0";$m2 = "0";$dow = "0";
      $t_time = $ctasklist['Time'];
      $t_date = $ctasklist['Date'];
      $t_dt = $t_date." ".$t_time;
      $crontable->fwrite("#".$t_dt."\n");
      $findate = date_create(date($t_dt));
      $curdate = date_create(date('d-m-Y H:i'));
      $interval = date_diff($curdate,$findate);
      $remtime = $interval->i;

     if($interval->invert==1){
          //Note deletion to occur here
          $tasklist['Priority'] = '0';
          $crontable->fwrite("# Sike that was deleted fool\n");
      }
      elseif($interval->invert==0){
          if($interval->h==0){
             $ctasklist['Priority'] = '1';
          }
          elseif($interval->h>1 && $interval->h<24){
             $ctasklist['Priority'] = '2';
          }
          elseif($interval->d>1 && $interval->d<7){
             $ctasklist['Priority'] = '3';
          }
          switch($ctasklist['Priority']){
                case '1':
                   $m1 = "*/2";$h = "*";$d = "*";$m2 = "*";$dow = "*";break;
                case '2':
                   $m1 = "*/5";$h = "*";$d = "*";$m2 = "*";$dow = "*";break;
                case '3':
                   $m1 = "*/10";$h = "*";$d = "*";$m2 = "*";$dow = "*";break;
       }
       $st1 =  explode("\r",implode("",$ctasklist['Tasks']));
       foreach($ctasklist['status'] as $cind){
         print_r("========>".$cind['member']);
         if($cind['member']==$user['identifier']){
            foreach($cind['completed'] as $ci){
               $st1 = array_merge(array_splice($st1,0,$ci),array_splice($st1,$ci+1));
            }
      }
       }
       $crontable->fwrite("#Priority: ".$ctasklist['Priority']."\n");
       $entry = "\n$m1 $h $d $m2 $dow $mailcmd ".$user['Email']." 3 ".$ctasklist['class']." '".implode(" ",$st1)."'\n";
       $crontable->fwrite($entry);
    }
 }
    //   $crontable->rewind();
   }
   
   function cronUpdate(){
      global $crontable;global $parent;
      //       //Standardize link
       $storage = file_get_contents("/opt/lampp/htdocs/Noteffy/Noteffy-main/data/Details.json") or die("Could Not open file");
      //  $storage = decrypt_data($storage);
       $storage = json_decode($storage,true);
       $stodata = file_get_contents("/opt/lampp/htdocs/Noteffy/Noteffy-main/data/Data.json") or die("Could Not open file");
       //  $storage = decrypt_data($stodata);
       $stodata = json_decode($stodata,true);
       $stoclass = file_get_contents("/opt/lampp/htdocs/Noteffy/Noteffy-main/data/Organizations.json") or die("Could Not open file");
       //  $storage = decrypt_data($stoclass);
       $stoclass = json_decode($stoclass,true);
       
       //  echo $storage["Users"][0]["User_Name"];
       //       //Standardize link
       $crontable->fwrite("* * * * * php /opt/lampp/htdocs/Noteffy/Noteffy-main/data/cronapi.php\n");
       foreach($storage["Users"] as $user){
          $data = fetchData($stodata,$user["identifier"]);
          $cdata = fetchClassData($stoclass,$user["identifier"]);
          cronCreate($user,$data,$cdata);
         }
       $crontable->fwrite("* * * * * cat /opt/lampp/htdocs/Noteffy/Noteffy-main/data/cronbuffer.afh | crontab \n");
 
       $storage1 = json_encode($storage,true);
       $storage2 = json_encode($stodata,true);
       $storage3 = json_encode($stoclass,true);
      //  $storage1 = encrypt_data($storage1);
       file_put_contents("/opt/lampp/htdocs/Noteffy/Noteffy-main/data/Details.json",$storage1);
       file_put_contents("/opt/lampp/htdocs/Noteffy/Noteffy-main/data/Data.json",$storage2);
       file_put_contents("/opt/lampp/htdocs/Noteffy/Noteffy-main/data/Organizations.json",$storage3);
 
     }
    cronUpdate();
 
    ?>
