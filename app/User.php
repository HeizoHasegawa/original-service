<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\UserReservation;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // このユーザーがお気に入りしているワークスペース
    public function favorite_workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'user_favorite', 'user_id', 'workspace_id')->withTimestamps();
    }
    
    // お気に入りに追加する
    public function favorite($workspaceId)
    {
        $exist = $this->is_favorite($workspaceId);
        
        if ($exist) {
            return false;
        }else{
            $this->favorite_workspaces()->attach($workspaceId);
            return true;
        }
    }
    
    // お気に入りを解除する
    public function unfavorite($workspaceId)
    {
        $exist =$this->is_favorite($workspaceId);
        
        if ($exist){
            $this->favorite_workspaces()->detach($workspaceId);
            return true;
        }else{
            return false;
        }
    }
    
    // お気に入りの中に、$workspaceIdのものが存在するか
    public function is_favorite($workspaceId)
    {
        return $this->favorite_workspaces()->where('workspace_id', $workspaceId)->exists();
    }
    
    // このユーザーが予約しているワークスペース
    public function reserved_workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'user_reservation', 'user_id', 'workspace_id')
                        ->withPivot(['date','headcount'])
                        ->withTimestamps();
    }

    // 予約する
    public function reserve($workspaceId, $date, $headcount)
    {
        $exist = $this->is_reserved($workspaceId, $date);

        if ($exist) {
            return false;
        }else{
            $this->reserved_workspaces()->attach($workspaceId,['date' => $date, 'headcount' => $headcount]);
            return true;
        }
    }
    
    // 予約を変更する
    public function change_reserve($workspaceId, $date, $headcount)
    {
        $exist = $this->is_reserved($workspaceId, $date);

        if ($exist) {
            $user_reservation = UserReservation::where('workspace_id',$workspaceId)
                    ->where('date',$date)
                    ->where('user_id',$this->id)
                    ->first();
            $user_reservation->headcount = $headcount;
            $user_reservation->save();
            return true;
        }else{
            return false;
        }
    }
    
    // 予約を取り消す
    public function unreserve($workspaceId, $date)
    {
        $exist =$this->is_reserved($workspaceId, $date);
        
        if ($exist){
            //削除したい対象のデータを抽出する（ワークスペースIDと日付、ユーザIDで検索）
            $user_reservation = UserReservation::where('workspace_id',$workspaceId)
                                ->where('date' , $date)
                                ->where('user_id',$this->id)
                                ->first();
            //削除処理を実施。
            $user_reservation->delete();

            return true;
        }else{
            return false;
        }
    }
    
    // 予約の中に、同$workspaceIdで、同一日のものが存在するか
    public function is_reserved($workspaceId, $date)
    {
        return $this->reserved_workspaces()->where('workspace_id', $workspaceId)->where('date', $date)->exists();
    }
    
}