<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Workspace;
use App\User;

class WorkspacesController extends Controller
{
    public function index()
    {
        
        $workspaces = Workspace::paginate($perPage=5, $columns=['*'], $pageName='all');
        $disp_date = date('Y-m');         
        // ロゴ画像のURL取得
        $image_name = 'logo.png';
        $image_url = Storage::disk('s3')->url($image_name);


        if (\Auth::check()){
            //$user = \Auth::user();
            //$favorites = $user->favorite_workspaces;
            $favorites = Workspace::join('user_favorite', 'user_favorite.workspace_id', '=', 'workspaces.id')
                                ->where('user_id', \Auth::user()->id)
                                ->orderBy('workspace_id', 'asc')
                                ->paginate($perPage=5, $columns=['*'], $pageName='fav');
            
            // joinはあとでまとめる。
            $workspace_res = Workspace::join('user_reservation', 'user_reservation.workspace_id','=', 'workspaces.id')
                                ->where('user_id', \Auth::user()->id)
                                ->where('date', '>=', date('Y-m-d'))
                                ->orderBy('date', 'asc')
                                ->paginate($perPage=5, $columns=['*'], $pageName='res');
            return view('welcome', [
                'workspaces' => $workspaces,
                'favorites' => $favorites,
                'workspace_res' => $workspace_res,
                'disp_date' => $disp_date,
                ]);
        }

        return view('welcome', [
            'workspaces' => $workspaces,
            'disp_date' => $disp_date,
            'image_url' => $image_url,
            ]);
    }


    /*
     *  $id : workspace_id
     */
    public function show($id, $disp_date='nodata', $mov="0")
    {
        // 該当ワークスペースに予約テーブルの情報を結合
        $workspace = Workspace::findOrFail($id);
        $workspace_res = $workspace
                            ->join('user_reservation', 'workspaces.id', '=', 'user_reservation.workspace_id')
                            ->get();
        // 予約テーブルを該当月の範囲で検索
        $start_day = '2022-04-01';
        $end_day = '2022-04-30';
        $reserves = $workspace->reserved_users()
                        ->wherePivot('date','>',$start_day)
                        ->wherePivot('date','<',$end_day)
                        ->get();
        
        // ワークスペースイメージのURL取得
        $image_name = $workspace->image;
        $image_url = Storage::disk('s3')->url($image_name);
        
        if ($disp_date == 'nodata'){
            $disp_date = date("Y-m");
        }
        if ($mov == 1){
            $disp_date = date('Y-m', strtotime($disp_date . ' 1 month'));
        }elseif ($mov == -1){
            $disp_date = date('Y-m', strtotime($disp_date . ' -1 month'));
        }
        
        return view('workspaces.workspace', [
            'workspace' => $workspace,
            'workspace_res' => $workspace_res,
            'image_url' => $image_url,
            'disp_date' => $disp_date
        ]);
    }


    /*
     *  $id : workspace_id
     */
    public function reserve($id, $date)
    {
        
        $workspace = Workspace::findOrFail($id);
        $disp_date = date('Y-m', strtotime($date));

        return view('workspaces.reserve', [
            'workspace' => $workspace,
            'date' => $date,
            'disp_date' => $disp_date,
        ]);
    }
    
    public function reserve_store(Request $request, $id, $date)
    {
        $workspace = Workspace::findOrFail($id);
        //予約する。
        $result = \Auth::user()->reserve($id, $date, $request->headcount);

        // joinはあとでまとめる。
        $workspace_res = $workspace
                            ->join('user_reservation', 'user_reservation.workspace_id','=', 'workspaces.id')
                            ->get();
        
        // ワークスペースイメージのURL取得
        $image_name = $workspace->image;
        $image_url = Storage::disk('s3')->url($image_name);
        
        $disp_date = date('Y-m', strtotime($date));
       
        return view('workspaces.workspace', [
            'workspace' => $workspace,
            'workspace_res' => $workspace_res,
            'image_url' => $image_url,
            'disp_date' => $disp_date
        ]);
    }
    
    public function edit($id, $date)
    {
        $workspace = Workspace::findOrFail($id);
        
        // joinはモデルにまとめる・・・。
        $workspace_res = $workspace
                    ->join('user_reservation', 'user_reservation.workspace_id','=', 'workspaces.id')
                    ->where('workspace_id', $id)
                    ->where('date',$date)
                    ->get();
        //dd($workspace_res);
        $headcount = $workspace_res->first()->headcount;
        $disp_date = date('Y-m', strtotime($date));
        
        return view('workspaces.edit', [
            'workspace' => $workspace,
            'date' => $date,
            'headcount' => $headcount,
            'disp_date' => $disp_date,
            ]);
    }
    
    public function update(Request $request, $id, $date)
    {
        $workspace = Workspace::findOrFail($id);
        //予約を変更する。
        // dd($request);
        $result = \Auth::user()->change_reserve($id, $date, $request->headcount);

        // joinはあとでまとめる。
        $workspace_res = $workspace
                            ->join('user_reservation', 'user_reservation.workspace_id','=', 'workspaces.id')
                            ->get();
        
        // ワークスペースイメージのURL取得
        $image_name = $workspace->image;
        $image_url = Storage::disk('s3')->url($image_name);
       
        $disp_date = date('Y-m', strtotime($date));
       
        return view('workspaces.workspace', [
            'workspace' => $workspace,
            'workspace_res' => $workspace_res,
            'image_url' => $image_url,
            'disp_date' => $disp_date
        ]);

    }
    
    public function destroy(Request $request, $id, $date)
    {
        $workspace = Workspace::findOrFail($id);
        //予約を取り消す。
        $result = \Auth::user()->unreserve($id, $date);

        // joinはあとでまとめる。
        $workspace_res = $workspace
                            ->join('user_reservation', 'user_reservation.workspace_id','=', 'workspaces.id')
                            ->get();
        
        // ワークスペースイメージのURL取得
        $image_name = $workspace->image;
        $image_url = Storage::disk('s3')->url($image_name);
       
        $disp_date = date('Y-m', strtotime($date));
       
        return view('workspaces.workspace', [
            'workspace' => $workspace,
            'workspace_res' => $workspace_res,
            'image_url' => $image_url,
            'disp_date' => $disp_date
        ]);

    }

    // ====================================================================

    public function upload_images()
    {
        return view('workspaces.store');
    }

    public function store_images(Request $request)
    {

        $this->validate($request, ['myfile' => 'required|image']);
        $image = $request->file('myfile');
        $path = Storage::disk('s3')->putFile('images', $image, 'public');
        dd($path);
        $url = Storage::disk('s3')->url($path);
        dd($url);

        return redirect()->back->with('s3url', $url);
    }

    
}
