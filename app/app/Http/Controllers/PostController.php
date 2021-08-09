<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Comment;
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

                $postComments = Comment::where('post_id', $post->id)->get();
                $commentCount = collect($postComments)->count();
                $posts[$key]['comments'] = $commentCount;
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
    public function search(SearchRequest $request)
    {
        $searchKey = $request->search;
        $posts = Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
            ->select(
                'posts.id as id',
                'posts.post_text as post_text',
                'posts.rating as rating',
                'posts.movie_id as movie_id',
                'posts.updated_at',
                'users.name as name',
                'posts.user_id as user_id',
                Comment::raw("count(comments.id) as comments"),
            )
            ->groupBy('posts.id')
            ->orderBy('posts.updated_at', 'desc')
            ->orWhere(
                function ($queryName) use ($searchKey) {
                    $queryName->where('name', 'LIKE', '%' . $searchKey . '%');
                }
            )->orWhere(
                function ($queryLink) use ($searchKey) {
                    $queryLink->where('post_text', 'LIKE', '%' . $searchKey . '%');
                }
            )->get();

        foreach ($posts as $key => $post){

            $liked = auth()->user()->hasLiked($post);
            $postLikes = $post->likers()->count();
            $posts[$key]['likes'] = $postLikes;
            $posts[$key]['liked'] = $liked;

            $movie = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/movie/' . $post->movie_id . '?language=en-US')
                ->json();
            $posts[$key]['movie_data'] = $movie;
        }


        $posts = collect($posts)->toArray();
        $usersIdsFromPosts = collect($posts)->unique('user_id');
        $users = [];
        foreach ($usersIdsFromPosts as  $user){
            $userFind = User::find($user['user_id']);
            $userFind->getMedia();
            $userFind = collect($userFind)->toArray();
            $users[$user['user_id']] = $userFind;
            $users[$user['user_id']]['folder_id'] = $userFind['media'][0]['id'];
            $users[$user['user_id']]['file_name'] = $userFind['media'][0]['file_name'];

        }

        return view('posts', [
            'users' => $users,
            'posts' => $posts,
            'search' => $request->search
        ]);
    }
}
