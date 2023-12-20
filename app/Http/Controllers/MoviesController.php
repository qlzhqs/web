<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\ViewModels\MoviesViewModel;
use App\ViewModels\MovieViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\isEmpty;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //mengambil API film, jangan lupa masukin juga token nya ke Env dan Services
        $popularMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/popular')
            ->json(['results']);

        $nowPlayingMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/now_playing')
            ->json(['results']);

        $topRatedMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/top_rated')
            ->json(['results']);

        $upcomingMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/upcoming')
            ->json(['results']);

        $genres = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/genre/movie/list')
            ->json(['genres']);

        $viewModel = new MoviesViewModel(
            $popularMovies,
            $nowPlayingMovies,
            $genres,
            $topRatedMovies,
            $upcomingMovies
        );

        return view('movies.index', $viewModel);
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
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/' . $id . '?append_to_response=credits,videos,images')
            ->json();
        $myRating = null;
        if(Auth::user()){
            $myRating = auth()->user()->rate($movie['id']);
        }
        $allComments = Comment::where('tmdb_id', $movie['id'])->with('user:id,name')->get();

        $viewModel = new MovieViewModel($movie);

        return view('movies.show', $viewModel, ['myRating' => $myRating, 'allComments' => $allComments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function random()
    {
        do {
            $random_id = mt_rand(1, 10000);
            $movie = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/movie/' . $random_id . '?append_to_response=credits,videos,images')
                ->json();
        } while (array_key_exists('success', $movie) && !$movie['success']);


        $viewModel = new MovieViewModel($movie);

        $myRating = null;
        if(Auth::user()){
            $myRating = auth()->user()->rate($movie['id']);
        }
        $allComments = Comment::where('tmdb_id', $movie['id'])->with('user:id,name')->get();

        $viewModel = new MovieViewModel($movie);

        return view('movies.show', $viewModel, ['myRating' => $myRating, 'allComments' => $allComments]);
    }
}
