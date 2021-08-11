<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @switch($user['id'])
                    @case(auth()->user()->getAuthIdentifier())
                    {{ __('My Profile') }}

                    @break
                    @default
                    {{ __($user['name'] . ' Profile') }}
                @endswitch
            </h2>
            <form method="GET" action="{{ route('profile.search') }}">
                @method('GET')
                @csrf
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" name="search" placeholder="Search for people" aria-label="Search"
                           aria-describedby="search-addon"/>
                    <button type="submit" class="input-group-text border-0 bg-white" id="search-addon">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>
    </x-slot>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="content" class="content content-full-width">
                    <!-- begin profile -->
                    <div class="profile">
                        <div class="profile-header">
                            <!-- BEGIN profile-header-cover -->
                            <div class="profile-header-cover"></div>
                            <!-- END profile-header-cover -->
                            <!-- BEGIN profile-header-content -->
                            <div class="profile-header-content">
                                <!-- BEGIN profile-header-img -->
                                <div class="profile-header-img">
                                    <img src="{{ asset('storage/' . $user['folder_id'] . '/' . $user['file_name']) }}" alt="{{ $user['name'] }}">
                                </div>
                                <!-- END profile-header-img -->
                                <!-- BEGIN profile-header-info -->
                                <div class="profile-header-info">
                                    <h4 class="m-t-10 m-b-5">{{ $user['name'] }}</h4>
                                    <p class="m-b-10">{{ $user['email'] }}</p>
                                    @switch($user['id'])
                                        @case(auth()->user()->getAuthIdentifier())
                                        <a href="{{ route('profile.edit', auth()->user()->getAuthIdentifier()) }}" class="btn btn-sm btn-info mb-2">Edit Profile</a>

                                        @break
                                        @default
                                        @switch($user['following'])
                                            @case(true)
                                            <a href="{{ route('profile.unfollow', $user['id']) }}" class="btn btn-sm btn-info mb-2">Unfollow</a>

                                            @break
                                            @default
                                            <a href="{{ route('profile.follow', $user['id']) }}" class="btn btn-sm btn-info mb-2">Follow</a>
                                        @endswitch
                                    @endswitch
                                </div>
                                <!-- END profile-header-info -->
                            </div>
                            <!-- END profile-header-content -->
                            <!-- BEGIN profile-header-tab -->
                            <ul class="profile-header-tab nav nav-tabs">
                                <li class="nav-item"><a href="#profile-post" class="nav-link active show" data-toggle="tab">POSTS</a></li>
                                <li class="nav-item"><a href="#profile-friends" class="nav-link" data-toggle="tab">FRIENDS</a></li>
                            </ul>
                            <!-- END profile-header-tab -->
                        </div>
                    </div>
                    <!-- end profile -->
                    <!-- begin profile-content -->
                    <div class="profile-content">
                        <!-- begin tab-content -->
                        <div class="tab-content p-0">
                            <!-- begin #profile-post tab -->
                            <div class="tab-pane fade active show" id="profile-post">
                                <!-- begin timeline -->
                                <ul class="timeline">
                                    @foreach($posts as $post)
                                        <li>
                                            <!-- begin timeline-time -->
                                            <div class="timeline-time">
                                                <span class="date">
                                                   {{date('Y-m-d', strtotime($post['updated_at']))}}
                                                </span>
                                                <span class="time">{{date('H:i', strtotime($post['updated_at']))}}</span>
                                            </div>
                                            <!-- end timeline-time -->
                                            <!-- begin timeline-icon -->
                                            <div class="timeline-icon">
                                                <a href="javascript:;">&nbsp;</a>
                                            </div>
                                            <!-- end timeline-icon -->
                                            <!-- begin timeline-body -->
                                            <div class="timeline-body">
                                                <div class="timeline-header">
                                                    <span class="userimage"><img src="{{ asset('/storage/' . $user['folder_id'] . '/' . $user['file_name']) }}" alt=""></span>
                                                    <span class="username"><a href="{{ route( 'profile.show', $post['user_id'] ) }}">{{ $user['name'] }}</a> <small></small></span>
                                                    @if($post['user_id'] === auth()->user()->getAuthIdentifier())
                                                        <form method="POST" action="{{ route('posts.destroy', $post['id']) }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class=" btn btn-danger">{{ __('Delete')}}</button>
                                                        </form>


                                                        <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary launch-modal-{{$post['id']}}"
                                                                    data-bs-toggle="modal" data-bs-target="#exampleModal-{{$post['id']}}">
                                                                Rate and Post agian
                                                            </button>
                                                            <div class="modal fade" id="exampleModal-{{$post['id']}}" tabindex="-1"
                                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                        </div>

                                                                        <form class="rating-group" id="rating-group-{{$post['id']}}"
                                                                              method="POST"
                                                                              action="{{ route('posts.update', $post['id']) }}">
                                                                            @method('PUT')
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <div id="full-stars-example">

                                                                                    <label aria-label="1 star" class="rating__label"
                                                                                           for="{{$post['id']}}-rating-1"><i
                                                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                                                    <input
                                                                                        class="rating__input rating__input-{{$post['id']}}"
                                                                                        name="rating" id="{{$post['id']}}-rating-1"
                                                                                        value="1" type="radio"
                                                                                        @if($post['rating'] === "1")
                                                                                        checked
                                                                                        @endif
                                                                                    >

                                                                                    <label aria-label="2 stars" class="rating__label"
                                                                                           for="{{$post['id']}}-rating-2"><i
                                                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                                                    <input
                                                                                        class="rating__input rating__input-{{$post['id']}}"
                                                                                        name="rating" id="{{$post['id']}}-rating-2"
                                                                                        value="2" type="radio"
                                                                                        @if($post['rating'] === "2")
                                                                                        checked
                                                                                        @endif
                                                                                    >

                                                                                    <label aria-label="3 stars" class="rating__label"
                                                                                           for="{{$post['id']}}-rating-3"><i
                                                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                                                    <input
                                                                                        class="rating__input rating__input-{{$post['id']}}"
                                                                                        name="rating" id="{{$post['id']}}-rating-3"
                                                                                        value="3" type="radio"
                                                                                        @if($post['rating'] === "3")
                                                                                        checked
                                                                                        @endif
                                                                                    >

                                                                                    <label aria-label="4 stars" class="rating__label"
                                                                                           for="{{$post['id']}}-rating-4"><i
                                                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                                                    <input
                                                                                        class="rating__input rating__input-{{$post['id']}}"
                                                                                        name="rating" id="{{$post['id']}}-rating-4"
                                                                                        value="4" type="radio"
                                                                                        @if($post['rating'] === "4")
                                                                                        checked
                                                                                        @endif
                                                                                    >

                                                                                    <label aria-label="5 stars" class="rating__label"
                                                                                           for="{{$post['id']}}-rating-5"><i
                                                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                                                    <input
                                                                                        class="rating__input rating__input-{{$post['id']}}"
                                                                                        name="rating" id="{{$post['id']}}-rating-5"
                                                                                        value="5" type="radio"
                                                                                        @if($post['rating'] === "5")
                                                                                        checked
                                                                                        @endif
                                                                                    >
                                                                                </div>
                                                                                <div class="form-group shadow-textarea">
                                                                <textarea class="form-control z-depth-1"
                                                                          name="post_text"
                                                                          id="post_text-{{$post['id']}}" rows="3"
                                                                          placeholder="Write something here...">{{ $post['post_text'] }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="reset" class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">Close
                                                                                </button>
                                                                                <button class="btn btn-primary submit-{{$post['id']}}">Save
                                                                                    changes
                                                                                </button>
                                                                            </div>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-center small text-warning mb-2 ">


                                                            </div>


                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="timeline-content col col-xl-6 col-lg-8 col-md-12 col-sm-12 ">
                                                        <p class="lead">
                                                            {{$post['post_text']}}
                                                        </p>
                                                        <div class="d-flex flex-column align-items-center">
                                                            <div class="post-stars mb-2">
                                                                @for($i = 0; $i < $post['rating']; $i++)
                                                                    <i class="post__star fa fa-star fa-3x"></i>
                                                                @endfor
                                                            </div>
                                                            <div class="card mb-2" >
                                                                <img src="https://image.tmdb.org/t/p/w500{{ $post['movie_data']['poster_path'] }}" class="card-img-top" alt="{{ $post['movie_data']['original_title'] }}">
                                                                <div class="card-body">
                                                                    <h5 class="card-title h5"><strong>{{ $post['movie_data']['original_title'] }}</strong></h5>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="timeline-likes">
                                                    <div class="stats-right">
                                                        <i class="fa fa-comments fa-fw fa-lg m-r-3"></i>
                                                        <span class="stats-text">{{ $post['comments'] }} Comments</span>
                                                    </div>
                                                    <div class="stats">
                                                        <span class="fa-stack fa-fw stats-icon">
                                                          <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                                          <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                                                        </span>
                                                        <span class="stats-total">{{ $post['likes'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="{{ route('posts.edit', $post['id']) }}" class="m-r-15 text-inverse-lighter">
                                                        @if($post['liked'] === false)
                                                            <i class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i> Like
                                                        @elseif($post['liked'] === true)
                                                            <i class="fa fa-thumbs-down fa-fw fa-lg m-r-3" ></i> Dislike
                                                        @endif
                                                    </a>
                                                    <a href="{{ route('comments.show', $post['id']) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Comments</a>

                                                </div>
                                                <div class="timeline-comment-box">
                                                    <div class="user"><a href="{{ route( 'profile.index' ) }}"></a><img src="{{ asset('/storage/' . $authUser['folder_id'] . '/' . $authUser['file_name']) }}"></div>
                                                    <div class="input">
                                                        <form action="{{ route('comments.store', $post['id']) }}" method="POST">
                                                            @method('POST')
                                                            @csrf
                                                            <div class="input-group">
                                                                {{--                                    <input type="text" class="form-control rounded-corner" placeholder="Write a comment...">--}}
                                                                <textarea name="comment" class="form-control rounded-corner" rows="1" placeholder="Write a comment..."></textarea>
                                                                <span class="input-group-btn p-l-10">
                                                                    <button class="btn btn-primary f-s-12 rounded-corner" type="submit">Comment</button>
                                                                </span>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end timeline-body -->
                                        </li>
                                    @endforeach

                                    <li>
                                        <!-- begin timeline-icon -->
                                        <div class="timeline-icon">
                                            <a href="javascript:;">&nbsp;</a>
                                        </div>
                                        <!-- end timeline-icon -->
                                        <!-- begin timeline-body -->
                                        <div class="timeline-body">
                                            Loading...
                                        </div>
                                        <!-- begin timeline-body -->
                                    </li>
                                </ul>
                                <!-- end timeline -->
                            </div>
                            <!-- end #profile-post tab -->
                        </div>
                        <!-- end tab-content -->
                    </div>
                    <!-- end profile-content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
