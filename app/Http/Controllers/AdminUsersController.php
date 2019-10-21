<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\Http\Requests;
use App\User;
use App\Role;
use App\Photo;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users= User::all();
        return view('admin.users.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // The roles variable is sent to the create and select button values
        $roles= Role::lists('name', 'id')->all();
        return view('admin.users.create', compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        if(trim($request->password)==''){
            $input= $request->except(['password']);

        }else{
            $input= $request->all();
            $input['password']= bcrypt($request->password);
        }
//      User::create($request->all());
        $input= $request->all();
        if($file= $request->file('photo_id')){
            //return "Photo Exists";
            $name= time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo= Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }

        User::create($input);
        Session::flash('created_user', 'The user has been Created');
        return redirect('/admin/users');
//       return $request->all();
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
        return view('admin.users.show');
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
        $user= User::findOrFail($id);
        $roles= Role::lists('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //
//        return view('admin.users.update');
        $user= User::findorFail($id);
        if(trim($request->password)==''){
            $input= $request->except(['password']);

        }else{
            $input= $request->all();
            $input['password']= bcrypt($request->password);
        }
//        $input= $request->all();
        if($file= $request->file('photo_id')){
            $name= time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo= Photo::create(['file'=>$name]);
            $input['photo_id']= $photo->id;
        }
        $user->update($input);
        Session::flash('updated_user', 'The user has been updated');
        return redirect('/admin/users');

//        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Working perfectly without deleting the user;
//
//        User::findorFail($id)->delete();
//
////        $request->session  But the session needs to be injected into the public function
//        Session::flash('deleted_user', 'The user has been deleted');
//        return redirect('/admin/users');

        $user= User::findorFail($id);
        // The $user->photo->file is working with the accessor
        unlink(public_path(). $user->photo->file);
        $user->delete();
        Session::flash('deleted_user', 'The user has been deleted');
        return redirect('/admin/users');
//        return view('admin.users.destroy');
    }
}
