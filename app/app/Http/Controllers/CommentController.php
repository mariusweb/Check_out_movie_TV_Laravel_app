<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    public function store(StoreCommentRequest $request, $id)
    {
        Comment::create([
            'user_id' => auth()->user()->getAuthIdentifier(),
            'post_id' => $id,
            'comment' => $request->comment,
        ]);
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $liked = auth()->user()->hasLiked($post);
        $postLikes = $post->likers()->count();
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/' . $post['movie_id'] . '?language=en-US')
            ->json();
        $post['movie_data'] = $movie;
        $post['likes'] = $postLikes;
        $post['liked'] = $liked;

        $user = User::find($post->user_id);
        $user->getMedia();
        $user = $user->toArray();

        foreach($user['media'] as $userMedia){
            $user['file_name'] = $userMedia['file_name'];
            $user['folder_id'] = $userMedia['id'];
        }

        $authUser = auth()->user();
        $authUser->getMedia();
        $authUser = $authUser->toArray();
        foreach ($authUser['media'] as $authMedia){
            $authUser = [];
            $authUser['file_name'] = $authMedia['file_name'];
            $authUser['folder_id'] = $authMedia['id'];
        }

        $postComments = Comment::where('post_id', $post->id)->get();
        $commentCount = collect($postComments)->count();
        $post['comments'] = $commentCount;

        if( !$postComments->count() ){
            $postComments = ['false' => false];
        }else{
            $users = $postComments;

            foreach ($users as $key => $commentedUser){

                $commentLikes = $commentedUser->likers()->count();
                $commentLiked = auth()->user()->hasLiked($commentedUser);
                $users[$key]['liked'] = $commentLiked;
                $users[$key]['likes'] = $commentLikes;

                $commentedUser = User::find($commentedUser->user_id);
                $commentedUser->getMedia();
                $commentedUser = $commentedUser->toArray();
                $users[$key]['name'] = $commentedUser['name'];
                foreach ($commentedUser['media'] as $usersMedia){
                    $users[$key]['file_name'] = $usersMedia['file_name'];
                    $users[$key]['folder_id'] = $usersMedia['id'];
                }
            }

            $postComments = collect($users)->sortByDesc('updated_at')->all();

        }
        return view('post-comments', [
            'post' => $post,
            'user' => $user,
            'comments' => $postComments,
            'authUser' => $authUser
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        auth()->user()->toggleLike($comment);
        return redirect()->route('comments.show', $comment->post_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
