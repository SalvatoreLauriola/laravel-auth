<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{


    //Admin users
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //post che puo vedere utente loggato, in base all'user/ valori corrispondenti al nostro id
        $posts = Post::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        $data = $request->all(); //prendi tutti i dati

        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'], '-');
        

        $newPost = new Post ();
        $newPost->fill($data); //stampa solo quelli dichiarati in fillable
        $saved = $newPost->save(); //metodo x salvare

        if($saved) {
            return redirect()->route('admin.posts.show', $newPost->id); //ritorna alla show
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validationRules());
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $updated = $post->update($data);  //metodo update per aggiornare

        if($updated) {
            return redirect()->route('admin.posts.show', $post->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(empty($post)){
            abort('404');
        }

        $title = $post->title;  //referenza per sapere cosa ho cancellato (banner)
        $deleted = $post->delete(); // metodi di eloquent

        if($deleted) {
            return  redirect()->route('admin.posts.index')->with('post-deleted', $title); //come richiamiamo
        }
    }

    // Validation rules

    private function validationRules()
    {
        return [
            'title' => 'required',
            'body' => 'required'
        ];
    }
}
