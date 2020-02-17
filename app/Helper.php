<?php

function thaiDate($strDate,$time="") {
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    if ($time=='') return $strDay.'-'.$strMonth.'-'.$strYear;
    else return "$strDay $strMonthThai $strYear $strHour:$strMinute";
}


function IsAdmin($level='1') {
    if (Auth::user()->level >= $level) return true;
    return false;
}

function Slug($title, $separator = '-', $language = 'Th') {
    $flip = $separator === '-' ? '_' : '-';
    $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);
    $title = str_replace(['@','&',"'"],[ $separator.'at'.$separator, $separator.'and'.$separator,''], $title);
    $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);
    $title = mb_strtolower($title, 'UTF-8');
    return trim($title);
}

function creator($uid) {
    $db=DB::table('users')->where('id',$uid)->first();
    if ($db==null) return 'ไม่มีการระบุ';
    else return  $db->name;
    
}

function LineNotify($message, $token="")
{
    return $token;
// $message = 'ข้อความ';
   if ($token="") $token = 'wsWseXjZUFIaxNSWt1yfgQft72GvF6oDOn2bk6o3q0D';
   $ch = curl_init();
   curl_setopt( $ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
   curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
   curl_setopt( $ch, CURLOPT_POST, 1);
   curl_setopt( $ch, CURLOPT_POSTFIELDS, "message=$message");
   curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
   $headers = array( "Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token", );
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
   $result = curl_exec( $ch );
   curl_close( $ch );
   return $result;
}

function uploadImage($image, $path) {
    if ($image) {
        $filanemaWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filanemaWithExt, PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        $cover_path = str_replace('/','\\',public_path($path).'/');
        $image->move(public_path().'/'.$path,$fileNameToStore);
    }
    else { $fileNameToStore = 'noimg.jpg'; }
    return $fileNameToStore;
}

function getYoutube($url) {
   $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
   $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
   if (preg_match($longUrlRegex, $url, $matches)) $youtube_id = $matches[count($matches) - 1];
   if (preg_match($shortUrlRegex, $url, $matches)) $youtube_id = $matches[count($matches) - 1];
   return 'https://www.youtube.com/embed/' . $youtube_id;
}

function ballstep($obj){
    echo '<h3 style="font-size:20px; margin: 10px 0 5px 0;">ราคาบอลสเต็ป ทรรศนะบอลสเต็ป, ฟันธงบอลสเต็ป</h3>
    <div id="review-socre">
       <div class="head-tded">
          <h3><span style="font-size:18px; color: #909090;">ประจำวันที่</span> '.thaiDate(date('d-m-Y'),'off').'</h3>
       </div>
    </div>';
 
    $league='';
    foreach($obj->data as $ob) {
       if ($ob->league_name != $league) {
          $league=$ob->league_name;
          echo '<div class="div-table league-name">
             <div class="div-tablerow">
             <div class="div-tablecell">
                <img  src="'.url("/images/007-soccer-ball-1.png").'" class="linkimg" width="25px" height="25px" >&nbsp;';
                echo $ob->league_name;
             echo '</div>
             </div>
          </div>
          <div class="div-table" id="vision-hdp">
             <div class="div-tablerow">
             <div class="div-tablecell div-cell-head cell7">เวลา</div>
             <div class="div-tablecell div-cell-head cell21">คู่แข่ง</div>
             <div class="div-tablecell div-cell-head cell16">เต็มเวลา</div>
             <div class="div-tablecell div-cell-head cell16">สูง/ต่ำ</div>
             <div class="div-tablecell div-cell-head cell7">สกอร์ที่คาด</div>
             <div class="div-tablecell div-cell-head cell20">ทรรศนะบอล</div>
             <div class="div-tablecell div-cell-head cell13">ฟันธงสูง-ต่ำ</div> 
             </div>
          </div>';                   
       }
       $time = explode(':', $ob->clock);
       $styleTorH = $styleTorA = "";
       if($ob->team_tor != null) {
          if($ob->team_tor == 'h') $styleTorH = "style='color:red;'";
          else $styleTorA = "style='color:red;'";
       }
       $priceHomeFull = $priceAwayFull = $priceOver = $priceUnder = "";
       if(strpos($ob->full_hdp_home, '-') !== false) $priceHomeFull = "style='color:red;'";
       if(strpos($ob->full_hdp_away, '-') !== false) $priceAwayFull = "style='color:red;'";
       if(strpos($ob->full_goal_over, '-') !== false) $priceOver = "style='color:red;'";
       if(strpos($ob->full_goal_under, '-') !== false) $priceUnder = "style='color:red;'";
       $clock = $ob->clock;
       $arrClock = explode(' ', $clock);
       if($arrClock[0] != 'LIVE') {
          $date = $arrClock[0].'/'.date('Y');
          $date = str_replace('/', '-', $date);
       }
       else $date='';
       $time = str_replace('AM', ' AM', $arrClock[1]);
       $time = str_replace('PM', ' PM', $time);
       $dateTime = ($date != '') ? $date.' '.$time : $time;
       $dateTime = date('H:i', strtotime($dateTime) - 3600);  
       echo '<div class="div-table" id="vision-hdp">
          <div class="div-tablerow">
             <div class="div-tablecell cell7 bg-w">'.$dateTime.'</div>
             <div class="div-tablecell cell21 bg-w team-ab">
             <span class="team-a" '.$styleTorH.'>'.$ob->team_home_name.'</span>
             <br/>
             <span class="team-b" '.$styleTorA.'>'.$ob->team_away_name.'</span>
             </div>
             <div class="div-tablecell cell8 bg-g">
             <span class="team-a">'.$ob->full_hdp_ball.'</span>
             <br/>
             <span class="team-b"></span>
             </div>
             <div class="div-tablecell cell8 bg-w">
             <span class="team-a" '.$priceHomeFull.'>'.$ob->full_hdp_home.'</span><br/>
             <span class="team-b" '.$priceAwayFull.'>'.$ob->full_hdp_away.'</span>
             </div>
             <div class="div-tablecell cell8 bg-g"><span class="team-a">'.$ob->full_goal_ball.'</span><br/><span class="team-b">u</span></div>
             <div class="div-tablecell cell8 bg-w"><span class="team-a"'.$priceOver.'>'.$ob->full_goal_over.'</span><br/><span class="team-b" '.$priceUnder.'> '.$ob->full_goal_under.' </span></div>
             <div class="div-tablecell cell7 bg-w">'.$ob->vision_score.'</div>
             <div class="div-tablecell cell20 bg-y">'.$ob->vision.'</div>
             <div  class="div-tablecell cell13 bg-y2">'.$ob->vision_over_under.'</div>    
          </div>
       </div>';
    }

    function hdp($obj){
        echo '<h1 style="margin: 0 0 5px 0;">ราคาบอลเด็ด ทรรศนะบอลคู่ ทีเด็ดฟันธงบอลคู่</h1>
        <div id="review-socre">
           <div class="head-tded">
              <h3><span style="color: #909090;">ประจำวันที่</span> '.thaiDate(date('d-m-Y'),'off').'</h3>
           </div>
        </div>
     
        <hr class="gr">
        <a href="'.url('/').'"><i class="fas fa-home text-danger"></i> <span class="text-light">หน้าแรก</span></a> <i class="fas fa-angle-right text-danger"></i> <span class="text-info">ราคาบอลเด็ด ทรรศนะบอลคู่ ทีเด็ดฟันธงบอลคู่</span>
        <hr class="gr">';
     
        $league='';
        foreach($obj->data as $ob) {
           if ($ob->league_name != $league) {
              $league=$ob->league_name;
              echo '<div class="div-table league-name">
                 <div class="div-tablerow">
                 <div class="div-tablecell">
                    <img  src="'.url("/images/007-soccer-ball-1.png").'" class="linkimg" width="25px" height="25px" >&nbsp;';
                    echo $ob->league_name;
                 echo '</div>
                 </div>
              </div>
              <div class="div-table" id="vision-hdp">
                 <div class="div-tablerow">
                 <div class="div-tablecell div-cell-head cell7">เวลา</div>
                 <div class="div-tablecell div-cell-head cell21">คู่แข่ง</div>
                 <div class="div-tablecell div-cell-head cell16">เต็มเวลา</div>
                 <div class="div-tablecell div-cell-head cell16">สูง/ต่ำ</div>
                 <div class="div-tablecell div-cell-head cell7">สกอร์ที่คาด</div>
                 <div class="div-tablecell div-cell-head cell20">ทรรศนะบอล</div>
                 <div class="div-tablecell div-cell-head cell13">ฟันธงสูง-ต่ำ</div> 
                 </div>
              </div>';                   
           }
           $time = explode(':', $ob->clock);
           $styleTorH = $styleTorA = "";
           if($ob->team_tor != null) {
              if($ob->team_tor == 'h') $styleTorH = "style='color:red;'";
              else $styleTorA = "style='color:red;'";
           }
           $priceHomeFull = $priceAwayFull = $priceOver = $priceUnder = "";
           if(strpos($ob->full_hdp_home, '-') !== false) $priceHomeFull = "style='color:red;'";
           if(strpos($ob->full_hdp_away, '-') !== false) $priceAwayFull = "style='color:red;'";
           if(strpos($ob->full_goal_over, '-') !== false) $priceOver = "style='color:red;'";
           if(strpos($ob->full_goal_under, '-') !== false) $priceUnder = "style='color:red;'";
           $clock = $ob->clock;
           $arrClock = explode(' ', $clock);
           if($arrClock[0] != 'LIVE') {
              $date = $arrClock[0].'/'.date('Y');
              $date = str_replace('/', '-', $date);
           }
           else $date='';
           $time = str_replace('AM', ' AM', $arrClock[1]);
           $time = str_replace('PM', ' PM', $time);
           $dateTime = ($date != '') ? $date.' '.$time : $time;
           $dateTime = date('H:i', strtotime($dateTime) - 3600);  
           echo '<div class="div-table" id="vision-hdp">
              <div class="div-tablerow">
                 <div class="div-tablecell cell7 bg-w">'.$dateTime.'</div>
                 <div class="div-tablecell cell21 bg-w team-ab">
                 <span class="team-a" '.$styleTorH.'>'.$ob->team_home_name.'</span>
                 <br/>
                 <span class="team-b" '.$styleTorA.'>'.$ob->team_away_name.'</span>
                 </div>
                 <div class="div-tablecell cell8 bg-g">
                 <span class="team-a">'.$ob->full_hdp_ball.'</span>
                 <br/>
                 <span class="team-b"></span>
                 </div>
                 <div class="div-tablecell cell8 bg-w">
                 <span class="team-a" '.$priceHomeFull.'>'.$ob->full_hdp_home.'</span><br/>
                 <span class="team-b" '.$priceAwayFull.'>'.$ob->full_hdp_away.'</span>
                 </div>
                 <div class="div-tablecell cell8 bg-g"><span class="team-a">'.$ob->full_goal_ball.'</span><br/><span class="team-b">u</span></div>
                 <div class="div-tablecell cell8 bg-w"><span class="team-a"'.$priceOver.'>'.$ob->full_goal_over.'</span><br/><span class="team-b" '.$priceUnder.'> '.$ob->full_goal_under.' </span></div>
                 <div class="div-tablecell cell7 bg-w">'.$ob->vision_score.'</div>
                 <div class="div-tablecell cell20 bg-y">'.$ob->vision.'</div>
                 <div  class="div-tablecell cell13 bg-y2">'.$ob->vision_over_under.'</div>    
              </div>
           </div>';
        }
     }

    function visit($id, $act='show') { 
        $v = DB::table('analyzes')->where('id', $id)->first();
        if ($act == 'show') return $v->visit;
        else {
           DB::table('analyzes')->where('id',$id)->increment('visit');
           $vc=$v->visit+1;
           return $vc;
        }
     }

}