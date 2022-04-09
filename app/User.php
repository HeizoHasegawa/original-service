<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
}
