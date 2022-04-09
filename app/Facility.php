<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    //
    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_facility', 'facility_id', 'workspace_id')->withTimestamps();
    }
}
