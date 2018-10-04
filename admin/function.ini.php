<?php
$nwords = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen", "twenty", 30 => "thirty", 40 => "forty", 50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty", 90 => "ninety" );

function int_to_words($x)
{
	   
           global $nwords;
           if(!is_numeric($x))
           {
               $w = '#';
           }else if(fmod($x, 1) != 0)
           {
               $w = '#';
           }else{
               if($x < 0)
               {
                   $w = 'minus ';
                   $x = -$x;
               }else{
                   $w = '';
               }
               if($x < 21)
               {
                   $w .= $nwords[$x];
               }else if($x < 100)
               {
                   $w .= $nwords[10 * floor($x/10)];
                   $r = fmod($x, 10);
                   if($r > 0)
                   {
                       $w .= '-'. $nwords[$r];
                   }
               } else if($x < 1000)
               {
                   $w .= $nwords[floor($x/100)] .' hundred';
                   $r = fmod($x, 100);
                   if($r > 0)
                   {
                       $w .= ' and '. int_to_words($r);
                   }
               } else if($x < 100000)
               {
                   $w .= int_to_words(floor($x/1000)) .' thousand';
                   $r = fmod($x, 1000);
                   if($r > 0)
                   {
                       $w .= ' ';
                       if($r < 100)
                       {
                           $w .= 'and ';
                       }
                       $w .= int_to_words($r);
                   }
               } else {
                   $w .= int_to_words(floor($x/100000)) .' lakh';
                   $r = fmod($x, 100000);
                   if($r > 0)
                   {
                       $w .= ' ';
                       if($r < 100)
                       {
                           $word .= 'and ';
                       }
                       $w .= int_to_words($r);
                   }
               }
           }
           return $w;
       }
	   
function IntToTimeAMPM($para=null)
{
$time=date('H:i',$para);
$time=explode(":",$time);
$hh=$time[0];
$mm=$time[1];	

if($hh==00){$AMPM="AM";$hh=12;}
elseif(($hh>00)&&($hh<12)){$AMPM="AM";}
elseif(($hh>=12)&&($hh<24)){$AMPM="PM";}
return date('h:i',$para)." ".$AMPM;
}

function dateTimeDiff($dtnw,$dtprev)
{
//total seconds
$seconds = abs($dtnw-$dtprev)/60*60;
$totSec=$seconds;

		//days
		$days=floor($seconds/86400);
		$seconds-=$days*86400;
		//hr
		$hours=floor($seconds / 3600) % 24;
		$seconds -= $hours * 3600;
		//min
		$min=floor($seconds / 60) % 60;
		$seconds -= $minutes * 60;
		// what's left is seconds
		$seconds = $seconds % 60;

$diff=$totSec.",".$days.",".$hours.",".$min.",".$seconds;
$diff=explode(",",$diff);
return $diff;
}
function calcDays($Outdt,$graceHR,$graceMin)
{
	$days=0;
	$nw=strtotime(date('d-m-Y H:i'));
	
	$diff=dateTimeDiff($nw,$Outdt);
	$day=$diff[1];
	$hr=$diff[2];
	$min=$diff[3];
	
	$days=$day;
			if($day==0)
			{
				$day++;
				$days=$day;
			
			}else
			{	if($hr!=0)
				{
					if($graceHR>=$hr)
					{
						if($min!=0)
						{
							if($graceMin<$min)
							{
							$days++;	
							}
						}
					}
					else
					{
						$days++;
					}
				}
			}

return $days;
}
function calcDaysOnCheckOut($inDt,$Outdt,$graceHR,$graceMin)
{
	$days=0;
	
	$diff=dateTimeDiff($Outdt,$inDt);
	$day=$diff[1];
	$hr=$diff[2];
	$min=$diff[3];
	
	$days=$day;
			if($day==0)
			{
				$days++;
			
			}else
			{
				if($hr!=0)
				{
					if($graceHR>=$hr)
					{
						if($min!=0)
						{
							if($graceMin<$min)
							{
							$days++;	
							}
						}
					}
					else
					{
						$days++;
					}
				}
			}

return $days;
}

/*
how to implement............
	$nw=strtotime(date('d-m-Y H:i'));
	$Outdt=strtotime(date('11-10-2015 09:00'));
		
		$diff=dateTimeDiff($nw,$Outdt);
	
	echo "<br>Total Seconds :".$days=$diff[0];
	echo "<br>Days :".$day=$diff[1];
	echo "<br>hour :".$hr=$diff[2];
	echo "<br>Minutes :".$min=$diff[3];
	echo "<br>Seconds :".$sec=$diff[4];
	
	$graceHour=7;
	$graceMinute=9;
	
	echo "<br>Total Days :".$days=calcDays($Outdt,$graceHour,$graceMinute);

*/


?>