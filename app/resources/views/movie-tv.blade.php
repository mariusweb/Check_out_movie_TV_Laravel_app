<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __($movie['original_title']) }}
            </h2>
            <form method="GET" action="">
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                           aria-describedby="search-addon"/>
                    <button type="submit" class="input-group-text border-0 bg-white" id="search-addon">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>

    </x-slot>



    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0" src="https://image.tmdb.org/t/p/w780{{$movie['poster_path']}}" alt="{{$movie['original_title']}}" />
                </div>
                <div class="col-md-6">
                    <h1 class="display-1 fw-bolder">{{ $movie['original_title'] }}</h1>
                    <div class="fs-5 mb-5">
                        <span class="text-decoration-line-through"> IMDB rating: {{$movie['vote_average']}}</span>

                    </div>
                    <p class="lead">{{ $movie['overview'] }}</p>
                    <div class="d-flex">



                    @if(isset($movie['rating']))
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary launch-modal-{{$movie['id']}}"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal-{{$movie['id']}}">
                                Rate and Post agian
                            </button>
                            <div class="modal fade" id="exampleModal-{{$movie['id']}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>

                                        <form class="rating-group" id="rating-group-{{$movie['id']}}"
                                              method="POST"
                                              action="{{ route('posts.update', $movie['post_id']) }}">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal-body">
                                                <div id="full-stars-example">
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}} rating__input--none"
                                                        name="rating" id="{{$movie['id']}}-rating-none"
                                                        value="0" type="radio"
                                                        @if($movie['rating'] === "0")
                                                        checked
                                                        @endif
                                                    >
                                                    <label aria-label="No rating" class="rating__label"
                                                           for="{{$movie['id']}}-rating-none"><i
                                                            class="rating__icon rating__icon--none fa fa-ban"></i></label>

                                                    <label aria-label="1 star" class="rating__label"
                                                           for="{{$movie['id']}}-rating-1"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-1"
                                                        value="1" type="radio"
                                                        @if($movie['rating'] === "1")
                                                        checked
                                                        @endif
                                                    >

                                                    <label aria-label="2 stars" class="rating__label"
                                                           for="{{$movie['id']}}-rating-2"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-2"
                                                        value="2" type="radio"
                                                        @if($movie['rating'] === "2")
                                                        checked
                                                        @endif
                                                    >

                                                    <label aria-label="3 stars" class="rating__label"
                                                           for="{{$movie['id']}}-rating-3"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-3"
                                                        value="3" type="radio"
                                                        @if($movie['rating'] === "3")
                                                        checked
                                                        @endif
                                                    >

                                                    <label aria-label="4 stars" class="rating__label"
                                                           for="{{$movie['id']}}-rating-4"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-4"
                                                        value="4" type="radio"
                                                        @if($movie['rating'] === "4")
                                                        checked
                                                        @endif
                                                    >

                                                    <label aria-label="5 stars" class="rating__label"
                                                           for="{{$movie['id']}}-rating-5"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-5"
                                                        value="5" type="radio"
                                                        @if($movie['rating'] === "5")
                                                        checked
                                                        @endif
                                                    >
                                                </div>
                                                <div class="form-group shadow-textarea">
                                                                <textarea class="form-control z-depth-1"
                                                                          name="post_text"
                                                                          id="post_text-{{$movie['id']}}" rows="3"
                                                                          placeholder="Write something here...">{{ $movie['post_text'] }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close
                                                </button>
                                                <button class="btn btn-primary submit-{{$movie['id']}}">Save
                                                    changes
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center small text-warning mb-2 ">


                            </div>

                    @elseif(!isset($movie['rating']))
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary launch-modal-{{$movie['id']}}"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal-{{$movie['id']}}">
                                Rate and Post
                            </button>
                            <div class="modal fade" id="exampleModal-{{$movie['id']}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>

                                        <form class="rating-group" id="rating-group-{{$movie['id']}}"
                                              method="POST"
                                              action="{{ route('posts.store', $movie['id']) }}">
                                            @method('POST')
                                            @csrf
                                            <div class="modal-body">
                                                <div id="full-stars-example">
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}} rating__input--none"
                                                        name="rating" id="{{$movie['id']}}-rating-none"
                                                        value="0" type="radio" checked>
                                                    <label aria-label="No rating" class="rating__label"
                                                           for="{{$movie['id']}}-rating-none"><i
                                                            class="rating__icon rating__icon--none fa fa-ban"></i></label>
                                                    <label aria-label="1 star" class="rating__label"
                                                           for="{{$movie['id']}}-rating-1"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-1"
                                                        value="1" type="radio">
                                                    <label aria-label="2 stars" class="rating__label"
                                                           for="{{$movie['id']}}-rating-2"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-2"
                                                        value="2" type="radio">
                                                    <label aria-label="3 stars" class="rating__label"
                                                           for="{{$movie['id']}}-rating-3"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-3"
                                                        value="3" type="radio">
                                                    <label aria-label="4 stars" class="rating__label"
                                                           for="{{$movie['id']}}-rating-4"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-4"
                                                        value="4" type="radio">
                                                    <label aria-label="5 stars" class="rating__label"
                                                           for="{{$movie['id']}}-rating-5"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input
                                                        class="rating__input rating__input-{{$movie['id']}}"
                                                        name="rating" id="{{$movie['id']}}-rating-5"
                                                        value="5" type="radio">
                                                </div>
                                                <div class="form-group shadow-textarea">
                                                                <textarea class="form-control z-depth-1"
                                                                          name="post_text"
                                                                          id="post_text-{{$movie['id']}}" rows="3"
                                                                          placeholder="Write something here..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close
                                                </button>
                                                <button class="btn btn-primary submit-{{$movie['id']}}">Save
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



{{--                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">--}}
{{--                            Rate--}}
{{--                        </button>--}}
{{--                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                            <div class="modal-dialog">--}}
{{--                                <div class="modal-content">--}}
{{--                                    <div class="modal-header">--}}
{{--                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>--}}
{{--                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                                    </div>--}}
{{--                                    <div class="modal-body">--}}
{{--                                        <div id="full-stars-example" class="d-flex flex-column align-items-center" >--}}
{{--                                            <form class="rating-group" method="POST" action="{{ route('movies.update', $movie['id']) }}">--}}
{{--                                                @method('POST')--}}
{{--                                                @csrf--}}
{{--                                                <input class="rating__input rating__input--none" name="rating" id="{{$movie['id']}}-rating-none" value="0" type="radio">--}}
{{--                                                <label aria-label="No rating" class="rating__label" for="{{$movie['id']}}-rating-none"><i class="rating__icon rating__icon--none fa fa-ban"></i></label>--}}
{{--                                                <label aria-label="1 star" class="rating__label" for="{{$movie['id']}}-rating-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>--}}
{{--                                                <input class="rating__input" name="rating" id="{{$movie['id']}}-rating-1" value="1" type="radio">--}}
{{--                                                <label aria-label="2 stars" class="rating__label" for="{{$movie['id']}}-rating-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>--}}
{{--                                                <input class="rating__input" name="rating" id="{{$movie['id']}}-rating-2" value="2" type="radio">--}}
{{--                                                <label aria-label="3 stars" class="rating__label" for="{{$movie['id']}}-rating-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>--}}
{{--                                                <input class="rating__input" name="rating" id="{{$movie['id']}}-rating-3" value="3" type="radio">--}}
{{--                                                <label aria-label="4 stars" class="rating__label" for="{{$movie['id']}}-rating-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>--}}
{{--                                                <input class="rating__input" name="rating" id="{{$movie['id']}}-rating-4" value="4" type="radio">--}}
{{--                                                <label aria-label="5 stars" class="rating__label" for="{{$movie['id']}}-rating-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>--}}
{{--                                                <input class="rating__input" name="rating" id="{{$movie['id']}}-rating-5" value="5" type="radio">--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="modal-footer">--}}
{{--                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                                        <button type="button" class="btn btn-primary">Save changes</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related items section-->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Related products</h2>
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($similar as $movieSimilar)
                    <div class="col mb-5">
                        <div class="card h-100 border-0 shadow">
                            <!-- Product image-->
                            <div class="card-img-top">
                                <img class="img-fluid w-100" src="https://image.tmdb.org/t/p/w500{{$movieSimilar['poster_path']}}" alt="{{$movieSimilar['original_title']}}" />
                            </div>
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{$movieSimilar['original_title']}}</h5>
                                    <!-- Button trigger modal -->
                                @if(isset($movieSimilar['rating']))
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary launch-modal-{{$movieSimilar['id']}}"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal-{{$movieSimilar['id']}}">
                                        Rate and Post agian
                                    </button>
                                    <div class="modal fade" id="exampleModal-{{$movieSimilar['id']}}" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>

                                                <form class="rating-group" id="rating-group-{{$movieSimilar['id']}}"
                                                      method="POST"
                                                      action="{{ route('posts.update', $movieSimilar['post_id']) }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div id="full-stars-example">
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}} rating__input--none"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-none"
                                                                value="0" type="radio"
                                                                @if($movieSimilar['rating'] === "0")
                                                                checked
                                                                @endif
                                                            >
                                                            <label aria-label="No rating" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-none"><i
                                                                    class="rating__icon rating__icon--none fa fa-ban"></i></label>

                                                            <label aria-label="1 star" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-1"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-1"
                                                                value="1" type="radio"
                                                                @if($movieSimilar['rating'] === "1")
                                                                checked
                                                                @endif
                                                            >

                                                            <label aria-label="2 stars" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-2"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-2"
                                                                value="2" type="radio"
                                                                @if($movieSimilar['rating'] === "2")
                                                                checked
                                                                @endif
                                                            >

                                                            <label aria-label="3 stars" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-3"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-3"
                                                                value="3" type="radio"
                                                                @if($movieSimilar['rating'] === "3")
                                                                checked
                                                                @endif
                                                            >

                                                            <label aria-label="4 stars" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-4"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-4"
                                                                value="4" type="radio"
                                                                @if($movieSimilar['rating'] === "4")
                                                                checked
                                                                @endif
                                                            >

                                                            <label aria-label="5 stars" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-5"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-5"
                                                                value="5" type="radio"
                                                                @if($movieSimilar['rating'] === "5")
                                                                checked
                                                                @endif
                                                            >
                                                        </div>
                                                        <div class="form-group shadow-textarea">
                                                            <textarea class="form-control z-depth-1"
                                                                      name="post_text"
                                                                      id="post_text-{{$movieSimilar['id']}}" rows="3"
                                                                      placeholder="Write something here...">{{ $movieSimilar['post_text'] }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button class="btn btn-primary submit-{{$movieSimilar['id']}}">Save
                                                            changes
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center small text-warning mb-2 ">


                                    </div>

                                @elseif(!isset($movieSimilar['rating']))
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary launch-modal-{{$movieSimilar['id']}}"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal-{{$movieSimilar['id']}}">
                                        Rate and Post
                                    </button>
                                    <div class="modal fade" id="exampleModal-{{$movieSimilar['id']}}" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>

                                                <form class="rating-group" id="rating-group-{{$movieSimilar['id']}}"
                                                      method="POST"
                                                      action="{{ route('posts.store', $movieSimilar['id']) }}">
                                                    @method('POST')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div id="full-stars-example">
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}} rating__input--none"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-none"
                                                                value="0" type="radio" checked>
                                                            <label aria-label="No rating" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-none"><i
                                                                    class="rating__icon rating__icon--none fa fa-ban"></i></label>
                                                            <label aria-label="1 star" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-1"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-1"
                                                                value="1" type="radio">
                                                            <label aria-label="2 stars" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-2"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-2"
                                                                value="2" type="radio">
                                                            <label aria-label="3 stars" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-3"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-3"
                                                                value="3" type="radio">
                                                            <label aria-label="4 stars" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-4"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-4"
                                                                value="4" type="radio">
                                                            <label aria-label="5 stars" class="rating__label"
                                                                   for="{{$movieSimilar['id']}}-rating-5"><i
                                                                    class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                            <input
                                                                class="rating__input rating__input-{{$movieSimilar['id']}}"
                                                                name="rating" id="{{$movieSimilar['id']}}-rating-5"
                                                                value="5" type="radio">
                                                        </div>
                                                        <div class="form-group shadow-textarea">
                                                            <textarea class="form-control z-depth-1"
                                                                      name="post_text"
                                                                      id="post_text-{{$movieSimilar['id']}}" rows="3"
                                                                      placeholder="Write something here..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button class="btn btn-primary submit-{{$movieSimilar['id']}}">Save
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

                                    IMDB rating: {{round($movieSimilar['vote_average'],1)}}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto" href="{{ route('movies.show', $movieSimilar['id']) }}">View details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

</x-app-layout>
