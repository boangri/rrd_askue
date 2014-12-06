<?php

$header = <<<EOT
#!/usr/bin/rrdcgi
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta http-equiv="Refresh" content="300">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<title>Энергопотребление в снт "Твой дом"</title>
<style>
body {
    background-color: #ffe7be;
}
</style>
</head>
<body>
<h2 align=center>Энергопотребление в снт "Твой дом"</h2>
<p>
<center>
EOT;
             
$tail = <<<EOT
 </center>
  </p>
 </body>
 </html>        
EOT;

$list = array("2", "3", "4", "5", "8");

$msg = $header;

foreach ($list as $n) {

$item = <<<EOT
 <RRD::GRAPH ../html/askue/img/power-b{$n}-<RRD::CV scale>.gif  
  --start -<RRD::CV start> -l 0
  --imginfo '<IMG SRC=/askue/img/%s WIDTH=%lu HEIGHT=%lu >'
  --width 600 --height 200 --title "КТП{$n} - Полная потребляемая мощность" 
  --vertical-label "Ватт" 
  --color CANVAS#000000
  --color GRID#FFFFFF
  --color MGRID#FFFFFF
  DEF:mps=/var/lib/rrd/askue/m230-b{$n}.rrd:mps:AVERAGE
  DEF:mp1=/var/lib/rrd/askue/m230-b{$n}.rrd:mp1:AVERAGE
  DEF:mp2=/var/lib/rrd/askue/m230-b{$n}.rrd:mp2:AVERAGE
  DEF:mp3=/var/lib/rrd/askue/m230-b{$n}.rrd:mp3:AVERAGE
  DEF:se1ai=/var/lib/rrd/askue/m230-b{$n}.rrd:se1ai:AVERAGE
  DEF:se2ai=/var/lib/rrd/askue/m230-b{$n}.rrd:se2ai:AVERAGE
  CDEF:se1=se1ai,3600000,*
  CDEF:se2=se2ai,3600000,*
  CDEF:mp1c=mp1,30,*
  CDEF:mp2c=mp2,30,*
  CDEF:mp3c=mp3,30,*
  CDEF:mpsc=mps,30,*
  AREA:mp1c#FFFF00:"фаза A"
  STACK:mp2c#00FF00:"фаза B"
  STACK:mp3c#FF0000:"фаза C"
>
 <RRD::GRAPH ../html/askue/img/power-o{$n}-<RRD::CV scale>.gif  
  --start -<RRD::CV start> -l 0
  --imginfo '<IMG SRC=/askue/img/%s WIDTH=%lu HEIGHT=%lu >'
  --width 600 --height 200 --title "КТП{$n} - Уличное освещение" 
  --vertical-label "Ватт" 
  --color CANVAS#000000
  --color GRID#FFFFFF
  --color MGRID#FFFFFF
  DEF:mps=/var/lib/rrd/askue/m230-o{$n}.rrd:mps:AVERAGE
  DEF:mp1=/var/lib/rrd/askue/m230-o{$n}.rrd:mp1:AVERAGE
  DEF:mp2=/var/lib/rrd/askue/m230-o{$n}.rrd:mp2:AVERAGE
  DEF:mp3=/var/lib/rrd/askue/m230-o{$n}.rrd:mp3:AVERAGE
  DEF:v1=/var/lib/rrd/askue/m230-o{$n}.rrd:mv1:AVERAGE
  DEF:v2=/var/lib/rrd/askue/m230-o{$n}.rrd:mv2:AVERAGE
  DEF:v3=/var/lib/rrd/askue/m230-o{$n}.rrd:mv3:AVERAGE
  DEF:se1ai=/var/lib/rrd/askue/m230-o{$n}.rrd:se1ai:AVERAGE
  DEF:se2ai=/var/lib/rrd/askue/m230-o{$n}.rrd:se2ai:AVERAGE
  CDEF:se1=se1ai,3600000,*
  CDEF:se2=se2ai,3600000,*
  CDEF:mp1c=mp1,1,2,v1,220,-,220,/,*,-,*
  CDEF:mp2c=mp2,1,2,v2,220,-,220,/,*,-,*
  CDEF:mp3c=mp3,1,2,v3,220,-,220,/,*,-,*
  CDEF:mpc=mp1,1,2,v1,220,-,220,/,*,-,*,mp2,1,2,v2,220,-,220,/,*,-,*,+,mp3,1,2,v3,220,-,220,/,*,-,*,+
  AREA:mp1#FFFF00:"фаза A"
  STACK:mp2#00FF00:"фаза B"
  STACK:mp3#FF0000:"фаза C"
>
 <RRD::GRAPH ../html/askue/img/volt-b{$n}-<RRD::CV scale>.gif  
  --start -<RRD::CV start> -l 0
  --imginfo '<IMG SRC=/askue/img/%s WIDTH=%lu HEIGHT=%lu >'
  --width 600 --height 200 --title "КТП{$n} - напряжения 220V" 
  --vertical-label "Вольт" 
  -l 150 -u 250 -r
  --color CANVAS#000000
  --color GRID#FFFFFF
  --color MGRID#FFFFFF
  DEF:v1=/var/lib/rrd/askue/m230-b{$n}.rrd:mv1:AVERAGE
  DEF:v2=/var/lib/rrd/askue/m230-b{$n}.rrd:mv2:AVERAGE
  DEF:v3=/var/lib/rrd/askue/m230-b{$n}.rrd:mv3:AVERAGE
  CDEF:mv1=v1,220,-
  CDEF:mv2=v2,220,-
  CDEF:mv3=v3,220,-
  LINE1:v1#FFFF00:"VA"
  LINE1:v2#00FF00:"VB"
  LINE1:v3#FF0000:"VC"
 > 
<hr>     
EOT;
  $msg .= $item;
}
$msg .= $tail;

//echo $msg;
if (file_put_contents('askue', $msg)) {
    echo "Файл askue записан!\n";
} else {
    echo "Облом!\n";
}

