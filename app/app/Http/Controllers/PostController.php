<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userFollowings = auth()->user()->followings;
        $usersPosts = [];
        $usersWithAvatar = [];

        foreach ($userFollowings as $follower) {

            $posts = Post::where('user_id', $follower->followable_id)
                ->get();

            foreach ($posts as $key => $post){
                $liked = auth()->user()->hasLiked($post);
                $postLikes = $post->likers()->count();
                $posts[$key]['likes'] = $postLikes;
                $posts[$key]['liked'] = $liked;
            }

            $posts = $posts->toArray();
            $usersPosts = array_merge($usersPosts, $posts);

            $user = User::find($follower->followable_id);
            $user->getMedia();
            $user = $user->toArray();

            foreach($user['media'] as $userMedia){
                $user['file_name'] = $userMedia['file_name'];
                $user['folder_id'] = $userMedia['id'];
            }
            $usersWithAvatar[$follower->followable_id] =  $user;

        }
        $usersPosts = collect($usersPosts)->sortByDesc('updated_at')->all();

        foreach ($usersPosts as $key => $userPost){
            $movie = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/movie/' . $userPost['movie_id'] . '?language=en-US')
                ->json();
            $usersPosts[$key]['movie_data'] = $movie;
        }

        dump($usersWithAvatar, $usersPosts);

        return view('posts', [
            'users' => $usersWithAvatar,
            'posts' => $usersPosts
        ]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request, $id)
    {
        Post::create([
            'user_id' => auth()->user()->id,
            'movie_id' => $id,
            'rating' => $request->rating,
            'post_text' => $request->post_text
        ]);

        return redirect()->route('movies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        auth()->user()->toggleLike($post);
        return redirect()->route('posts.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostCreateRequest $request, Post $post)
    {

        $post->rating = $request->rating;
        $post->post_text = $request->post_text;
        $post->save();

        return redirect()->route('movies.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
