<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(isset($search))
                    {{ __('Movies from '. $search) }}
                @else
                    {{ __('Movies') }}
                @endif
            </h2>
            <form method="GET" action="{{ route('movies.search') }}">
                <div class="input-group rounded">
                    <input type="text" class="form-control rounded" name="search" placeholder="Search for movies" aria-label="Search"
                           aria-describedby="search-addon"/>
                    <button type="submit" class="input-group-text border-0 bg-white" id="search-addon">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>

    </x-slot>

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Shop in style</h1>
                <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($movies as $movie)
                    <div class="col mb-5">
                        <div class="card h-100 border-0 shadow">
                            <!-- Product image-->
                            <div class="card-img-top">
                                <img class="img-fluid w-100"
                                     src="https://image.tmdb.org/t/p/w500{{$movie['poster_path']}}"
                                     alt="{{$movie['original_title']}}"/>
                            </div>
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{$movie['original_title']}}</h5>

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


                                <!-- Product price-->
                                    IMDB rating: {{$movie['vote_average']}}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto"
                                       href="{{ route('movies.show', $movie['id']) }}">View details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach


            </div>
        </div>
    </section>
    <!-- Footer-->

</x-app-layout>
