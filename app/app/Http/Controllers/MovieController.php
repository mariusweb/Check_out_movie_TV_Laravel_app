<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/popular?language=en-US')
            ->json()['results'];
        $collection = collect($response);
        $filtered = $collection->filter(function ($value, $key) {
            return $key < 8;
        })->toArray();

        $usersRated = Post::select('movie_id', 'rating', 'post_text', 'id')
            ->where('user_id', auth()->user()->id)
            ->get();

        foreach ($filtered as $key => $movie) {
            foreach ($usersRated as $rated) {

                if ($movie['id'] === $rated['movie_id']) {
                    $filtered[$key]['rating'] = $rated['rating'];
                    $filtered[$key]['post_text'] = $rated['post_text'];
                    $filtered[$key]['post_id'] = $rated['id'];

                }
            }
        }

        dump($filtered);
        return view('dashboard', [
            'movies' => $filtered,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/' . $id . '?language=en-US')
            ->json();




        $similar = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/' . $id . '/similar')
            ->json()['results'];

        $similarCollection = collect($similar);
        $similarFiltered = $similarCollection->filter(function ($value, $key) {
            return $key < 4;
        })->toArray();

        $userRateds = Post::select('movie_id', 'rating', 'post_text', 'id')
            ->where('user_id', auth()->user()->id)
            ->get();

        foreach ($similarFiltered as $key => $similarMovie) {
            foreach ($userRateds as $rated) {

                if ($movie['id'] === $rated['movie_id']) {
                    $movie['rating'] = $rated['rating'];
                    $movie['post_text'] = $rated['post_text'];
                    $movie['post_id'] = $rated['id'];
                }

                if ($similarMovie['id'] === $rated['movie_id']) {
                    $similarFiltered[$key]['rating'] = $rated['rating'];
                    $similarFiltered[$key]['post_text'] = $rated['post_text'];
                    $similarFiltered[$key]['post_id'] = $rated['id'];

                }
            }
        }


        dump($movie, $similarFiltered);

        return view('movie-tv', ['movie' => $movie, 'similar' => $similarFiltered]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
