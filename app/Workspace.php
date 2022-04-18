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

    // このワークスペースを予約しているユーザー
    public function reserved_users()
    {
        return $this->belongsToMany(User::class, 'user_reservation', 'workspace_id', 'user_id')
                        ->withPivot(['date','headcount'])
                        ->withTimestamps();
    }
    
    // カレンダー
    public function calendar($workspaceId, $reserved_dates, $disp_date)
    {
        if ($disp_date == ""){
            $year = date("Y");
            $month = date("m");
        }else{
            //dd($disp_date);
            $date = explode("-",$disp_date);
            $year = $date[0];
            $month = $date[1];
        }
        //$month = 4;
        //$year = 2023;

        $w_som = date("w",mktime(0,0,0,$month,1,$year));  //その月の1日が何曜日かを確認（日:0、月:1・・・土:6）
        $d_eom = date("d",mktime(0,0,0,$month+1,0,$year));  //その月の月末日を取得
        $num_weeks = ceil(($d_eom-(7-$w_som)) / 7)+1;
        //dd($w_som, $d_eom, $num_weeks);
        $html = "<div class='lead font-weight-bold text-center'>";
        $html .= "<a href='" . route('workspaces.show', [$workspaceId, $disp_date, -1]) . "'><<</a>　";
        $html .= $year . " / " . $month;
        $html .= "　<a href='" . route('workspaces.show', [$workspaceId, $disp_date, 1]) . "'>>></a>";
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
        while($i < $d_eom){
            $html .= "<tr>";
            $w_now = 0;
            while ($w_now < 7){
                $day = (int)date("d",mktime(0,0,0,$month,1+$i,$year));
                $week = date("l",mktime(0,0,0,$month,1+$i,$year));
                $set_date = date("Y-m-d",mktime(0,0,0,$month,1+$i,$year));
                // 予約の有無を確認して予約可否を表示
                if( \Auth::check()){
                    $chkId = \Auth::user()->id;
                }else{
                    $chkId = 0;
                }
                
                foreach ($reserved_dates as $reserved_date){
                    if ($reserved_date->workspace_id == $workspaceId && $reserved_date->date == $set_date && $reserved_date->user_id == $chkId){
                        $res = "<a href='" . route('workspace.edit', [$this->id, $set_date]) . "'><i class='fa-regular fa-circle-check fa-2x' style='color:red;'></i></a>";
                        break;
                    }elseif($reserved_date->workspace_id == $workspaceId && $reserved_date->date == $set_date){
                        $res = '<i class="fa-solid fa-xmark fa-2x"></i>';
                        break;
                    }else{
                        $res = "<a href='" . route('workspace.reserve', [$this->id, $set_date]) . "'><i class='fa-regular fa-circle fa-2x'></i></a>";
                    //}else{
                    //    $res = "<a href='" . route('login.get', [$this->id, $set_date]) . "'><i class='fa-regular fa-circle fa-2x'></i></a>";
                    }
                }
                $class = "";
                //土日の場合は色指定
                if ($week == "Saturday"){
                    $class .= " table-primary";
                }elseif($week == "Sunday"){
                    $class .= " table-danger";
                }
                // 今月以外日付の文字色を灰色に。
                if ($i<0 || $i>$d_eom-1){
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