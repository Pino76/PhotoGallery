<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users' );
    }

    private function getUserButtons(User $user){

        $id = $user->id;


        $buttonEdit= '<i class="bi bi-pen"></i>&nbsp;';
        if($user->deleted_at){
            $deleteRoute = route('admin.userrestore', ['user' => $id]);
            $btnClass = 'btn-default';
            $iconDelete = '<i class="bi bi-arrow-counterclockwise"></i>';
            $btnId = 'restore-'.$id;
        } else {
            $buttonEdit= '<a href="'.route('users.edit', ['user'=> $id]).'" id="edit-'.$id
                .'" class="btn btn-sm btn-primary"><i  class="bi bi-pen"></i></a>&nbsp;';
            $deleteRoute = route('users.destroy', ['user' => $id]);
            $iconDelete = '<i class="bi bi-trash"></i>';
            $btnClass = 'btn-warning';
            $btnId = 'delete-'.$id;
        }

        $buttonDelete = "<a  href='$deleteRoute' title='soft delete' id='$btnId' class='ajax $btnClass btn btn-sm'>$iconDelete</a>&nbsp;";

        $buttonForceDelete = '<a href="'.route('users.destroy', ['user'=> $id])
            .'?hard=1" title="hard delete" id="forcedelete-'.$id
            .'" class="ajax btn btn-sm btn-danger"><i class="bi bi-trash"></i> </a>';

        return $buttonEdit.$buttonDelete.$buttonForceDelete;
    }

    public function getUsers(){
        $users =  User::select(['id','name','email','user_role','created_at','deleted_at'])->latest('id')->withTrashed()->get();
        $result = DataTables::of($users )->addColumn('action', function ($user) {
            return $this->getUserButtons($user);
        })->editColumn('created_at', function($user){

            return $user->created_at ? $user->created_at->format('d-m-Y') : "";

        })->editColumn('deleted_at' , function($user){

            return $user->deleted_at ? $user->deleted_at->format('d-m-Y') : "";

        })->make(true);
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin.edituser', ["user" => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request, User $user)
    {
        $user = new User();
        $user->fill($request->only(['name' , 'email' , 'user_role']));
        $user->password = Hash::make($request->email);

        $res = $user->save();

        $message = $res ? 'User created' : 'Problem creating user';
        session()->flash('message',$message);
        return redirect()->route('users.index');
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
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        return view('admin.edituser' , ["user" =>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->user_role = $request->input('user_role');
        $res = $user->save();

        $message = $res ? 'User modified' : 'Problem updating user';
        session()->flash('message',$message);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = User::withTrashed()->findOrFail($id);
        $res = $request->hard ? $user->forceDelete() : $user->delete();
        return (string) $res;
    }


    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $res = $user->restore();
        return (string) $res;
    }

}
