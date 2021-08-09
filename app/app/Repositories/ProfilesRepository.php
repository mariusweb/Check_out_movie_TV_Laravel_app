<?php


namespace App\Repositories;

use App\Http\Requests\SearchRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class ProfilesRepository
{

    public function getUserData($id)
    {
        $user = User::find($id);
        $following = $user->hasFollower(auth()->user());
        $user->getMedia();
        $user = $user->toArray();
        $user['following'] = $following;
        foreach ($user['media'] as $media)
        {
            $user['folder_id'] = $media['id'];
            $user['file_name'] = $media['file_name'];
        }
        return $user;
    }

    public function updateUser($request):void
    {
        auth()->user()->update($request->only('name', 'email'));

        $temporaryFile = TemporaryFile::where('folder', $request->avatar)->first();
        $user = User::find(auth()->user()->id);
        if($temporaryFile){
            $user->clearMediaCollection('avatars');
            $user->addMedia(storage_path('app\avatars\tmp\\' . $request->avatar. '\\' . $temporaryFile->filename))
                ->toMediaCollection('avatars');
            rmdir(storage_path('app\avatars\tmp\\' . $request->avatar));
            $temporaryFile->delete();
        }
    }

    public function getUsersPosts($id)
    {
        $posts = Post::where('user_id', $id)->get();

        foreach ($posts as $key => $post){
            $postComments = Comment::where('post_id', $post->id)->get();
            $commentCount = collect($postComments)->count();
            $posts[$key]['comments'] = $commentCount;

            $liked = auth()->user()->hasLiked($post);
            $postLikes = $post->likers()->count();
            $posts[$key]['likes'] = $postLikes;
            $posts[$key]['liked'] = $liked;
            $movie = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/movie/' . $post['movie_id'] . '?language=en-US')
                ->json();
            $posts[$key]['movie_data'] = $movie;
        }
        $posts = collect($posts)->toArray();
        $posts = collect($posts)->sortByDesc('updated_at')->all();

        return $posts;
    }

    public function getAuthUserData()
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $user->getMedia();
        $user = $user->toArray();
        foreach ($user['media'] as $media)
        {
            $user['folder_id'] = $media['id'];
            $user['file_name'] = $media['file_name'];
        }
        return $user;
    }

    public function searchForUsers(SearchRequest $request)
    {
        $users = User::where('users.name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('users.email','LIKE','%' . $request->search . '%')
            ->get();

        foreach ($users as $key => $user){
            $following = $user->hasFollower(auth()->user());
            $user->getMedia();
            $user = $user->toArray();
            $users[$key]['following'] = $following;
            foreach ($user['media'] as $media)
            {
                $users[$key]['folder_id'] = $media['id'];
                $users[$key]['file_name'] = $media['file_name'];
            }

        }

        return $users;
    }

}
