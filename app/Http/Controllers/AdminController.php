<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BookLeaseController;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = BookLeaseController::getDataForChart();
        if(gettype($data) === 'array'){
            $weeks = BookLeaseController::getWeeks($data);
            $profitsPerWeek = BookLeaseController::getProfitsPerWeek($data);
            $data['weeks'] = $weeks; 
            $data['profits'] = $profitsPerWeek;  
    
            $jdata = json_encode($data);
        }
        else{
            $jdata = $data;
        }
        return view('dashboard.pages.index',["jsonData"=>$jdata]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listUsers()
    {
        //$this->authorize('view', User::class);
        $users = new User;

        $users=DB::table('users')
                ->select('id','username', 'email','isActive')
                ->where('isAdmin',0)->where('deleted_at',null)
                ->get();
        return view('dashboard.pages.users', ['users'=>$users]);
    }
    public function listAdmins()
    {
        //$this->authorize('view', User::class);
        $users = new User;

        $users=DB::table('users')
                ->select('id','username', 'email','isActive')
                ->where('isAdmin',1)->where('deleted_at',null)
                ->get();
        return view('dashboard.pages.admins', ['users'=>$users]);
    }

    public function ChangeActiveState($id)
    {
        $this->authorize('view', User::class);
        $user = User::find($id);
        $user->isActive = !$user->isActive ;
        $user->save();  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
    }
}
