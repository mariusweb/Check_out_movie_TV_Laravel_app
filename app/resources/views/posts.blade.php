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
                        <a href="javascript:;">&nbsp;</a>
                    </div>
                    <!-- end timeline-icon -->
                    <!-- begin timeline-body -->
                    <div class="timeline-body">
                        <div class="timeline-header">
                            <span class="userimage"><img src="{{ asset('/storage/' . $users[$post['user_id']]['folder_id'] . '/' . $users[$post['user_id']]['file_name']) }}" alt=""></span>
                            <span class="username"><a href="{{ route( 'profile.show', $post['user_id'] ) }}">{{ $users[$post['user_id']]['name'] }}</a> <small></small></span>

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
