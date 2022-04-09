<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Workspace;
use App\User;

class WorkspacesController extends Controller
{
    public function index()
    {
        
        $workspaces = Workspace::paginate(5);
        
        if (\Auth::check()){
            $user = \Auth::user();
            $favorites = $user->favorite_workspaces;
            return view('welcome', [
                'workspaces' => $workspaces,
                'favorites' => $favorites,
                ]);
        }

        return view('welcome', [
            'workspaces' => $workspaces,
            ]);
    }


    /*
     *  $id : workspace_id
     */
    public function show($id)
    {
        
        $workspace = Workspace::findOrFail($id);
        
        return view('workspaces.workspace', [
            'workspace' => $workspace,
        ]);
    }

    
}
