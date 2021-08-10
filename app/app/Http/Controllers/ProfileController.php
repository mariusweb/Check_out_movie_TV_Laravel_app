<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Managers\ProfilesManager;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct(private ProfilesManager $profilesManager)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAvatar = $this->profilesManager->getUserData(auth()->user()->getAuthIdentifier());
        $userPosts = $this->profilesManager->getUsersPosts(auth()->user()->getAuthIdentifier());

        return view('profile', [
            'user' => $userAvatar,
            'posts' => $userPosts,
            'authUser' => $userAvatar
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
        $user = $this->profilesManager->getUserData($id);
        $userPosts = $this->profilesManager->getUsersPosts($id);
        $authUser = $this->profilesManager->getAuthUserData();

        return view('profile', [
            'user' => $user,
            'posts' => $userPosts,
            'authUser' => $authUser
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userAvatar = $this->profilesManager->getUserData($id);
        return view('edit-profile', ['avatar' => $userAvatar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->profilesManager->updateUser($request);
        $userAvatar = $this->profilesManager->getUsersAvatar();
        return view('profile', ['avatar' => $userAvatar]);
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
    }
    public function follow($id)
    {
        $user = User::find($id);
        $authUser = User::find(auth()->user()->getAuthIdentifier());
        $authUser->follow($user);
        return redirect()->route('profile.show', $id);
    }
    public function unfollow($id)
    {
        $user = User::find($id);
        $authUser = User::find(auth()->user()->getAuthIdentifier());
        $authUser->unfollow($user);

        return redirect()->route('profile.show', $id);
    }
    public function search(SearchRequest $request)
    {

        $users = $this->profilesManager->searchForUsers($request);
        return view('users-result', [
            'users' => $users,
            'search' => $request->search
        ]);
    }
}
