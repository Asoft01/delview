<?php

namespace App\Http\Controllers;
use App\Photo;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\PostsCreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts= Post::all();
        return view('admin.posts.index', compact('posts'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::lists('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        //
        $input= $request->all();
        $user= Auth::user();
        if($file= $request->file('photo_id')){
            $name= time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo= Photo::create(['file'=>$name]);
            $input['photo_id']= $photo->id;
        }
    // Pulling out the relationship between the user and post and saving it into the database
        $user->posts()->create($input);
        return redirect('/admin/posts');

       // $user= Auth::user();
       // $user->posts;
//        $input= $request->all();
//        Post::create($input);
//        return redirect('/admin/posts');
        //return $request->all();
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
        $post= Post::findorFail($id);
        $categories= Category::lists('name', 'id')->all();
        return view('admin.posts.edit', compact('post', 'categories'));

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
//        return $request->all();
        $input=  $request->all();
        if($file= $request->file('photo_id')){
            $name= time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo= Photo::create(['file'=>$name]);
            $input['photo_id']= $photo->id;
        }

        Auth::user()->posts()->whereId($id)->first()->update($input);
        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //$post= Post::findorFail($id)->delete(); This is not gonna work cos it does not make anysense to delete post and getting the file
        $post= Post::findOrFail($id);
        unlink(public_path(). $post->photo->file);
        $post->delete();
        Session::flash('deleted_post', 'The post has been deleted');
        return redirect('/admin/posts');

    }
}
