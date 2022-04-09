<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    // このワークスペースが所有する設備
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'workspace_facility', 'workspace_id', 'facility_id')->withTimestamps();
    }

    // このワークスペースをお気に入りしているユーザー
    public function favorite_user()
    {
        return $this->belongsToMany(User::class, 'user_favorite', 'workspace_id', 'user_id')->withTimestamps();
    }
    
    // カレンダー
    public function calendar()
    {
        $year = date("Y");
        $month = date("m");
        $day = date("d");

        $month = 5;
        
        
        $w_som = date("w",mktime(0,0,0,$month,1,$year));  //その月の1日が何曜日かを確認（日:0、月:1・・・土:6）
        $d_eom = date("d",mktime(0,0,0,$month,0,$year));  //その月の月末日を取得
        $num_weeks = ceil(($d_eom-(7-$w_som)) / 7);

        
        $html = $year . "/" . $month;
        $html .= <<<EOM
        <table class="table table-sm">
            <tbody class="text-center table-bordered">
                <tr>
                    <th class="table-danger">日</th>
                    <th>月</th>
                    <th>火</th>
                    <th>水</th>
                    <th>木</th>
                    <th>金</th>
                    <th class="table-primary">土</th>
                </tr>
EOM;
        $week = 1;
        $i = -$w_som;
        while($i < $d_eom-1){
            $html .= "<tr>";
            $w_now = 0;
            while ($w_now < 7){
                
                $day = (int)date("d",mktime(0,0,0,$month,1+$i,$year));
                $week = date("l",mktime(0,0,0,$month,1+$i,$year));
                // 予約の有無を確認
                if (1){
                    $res = '<a href="#"><i class="fa-regular fa-circle"></i></a>';
                }elseif(0){
                    $res = '<a href="#"><i class="fa-regular fa-circle-check"></i></a>';
                }else{
                    $res = '<a href="#"><i class="fa-solid fa-xmark"></i></a>';
                }
                $class = "";
                //土日の場合は色指定
                if ($week == "Saturday"){
                    $class .= " table-primary";
                }elseif($week == "Sunday"){
                    $class .= " table-danger";
                }
                // 今月以外日付の文字色を灰色に。
                if ($i<0 || $i>$d_eom){
                    $class .= " text-secondary"; 
                }
                
                $html .= '<td class="' . $class . '">' . $day . "<br>". $res ."</td>";
                $i++;
                $w_now++;
            }
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";
    return $html;
    }
}
