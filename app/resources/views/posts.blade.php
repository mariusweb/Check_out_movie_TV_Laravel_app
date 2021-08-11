<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                @if(isset($search))
                    {{ __('Posts from '. $search) }}
                @else
                    {{ __('Social Posts') }}
                @endif
            </h2>
            <form method="GET" action="{{ route('posts.search') }}">
                @method('GET')
                @csrf
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" name="search" placeholder="Search for posts" aria-label="Search"
                           aria-describedby="search-addon"/>
                    <button type="submit" class="input-group-text border-0 bg-white" id="search-addon">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>

    </x-slot>

    <div class="container">
        <ul class="timeline">
            @isset($posts)
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
                        <a href="{{ route('comments.show', $post['id']) }}">&nbsp;</a>
                    </div>
                    <!-- end timeline-icon -->
                    <!-- begin timeline-body -->
                    <div class="timeline-body">
                        <div class="timeline-header">
                            <span class="userimage"><img src="{{ asset('/storage/' . $users[$post['user_id']]['folder_id'] . '/' . $users[$post['user_id']]['file_name']) }}" alt=""></span>
                            <span class="username"><a href="{{ route( 'profile.show', $post['user_id'] ) }}">{{ $users[$post['user_id']]['name'] }}</a> <small></small></span>
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
                                                        <input
                                                            class="rating__input rating__input-{{$post['id']}} rating__input--none"
                                                            name="rating" id="{{$post['id']}}-rating-none"
                                                            value="0" type="radio" checked>
                                                        <label aria-label="No rating" class="rating__label"
                                                               for="{{$post['id']}}-rating-none"><i
                                                                class="rating__icon rating__icon--none fa fa-ban"></i></label>

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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="user"><img src="{{ asset('/storage/' . $users[auth()->user()->id]['folder_id'] . '/' . $users[auth()->user()->id]['file_name']) }}"></div>
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
            @endisset
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
    </div>
</x-app-layout>
