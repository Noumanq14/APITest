<?php

namespace App\Http\Controllers;

use App\Models\starwar_films;
use App\Models\starwarfilm_detail;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\StarwarMovie;
use Illuminate\Support\Facades\Cache;
use App\Models\MovieDetail;

class MovieListController extends Controller
{
    //
    public function index()
    {
        if (Cache::has('movieList'))
        {
            return response()->json([
                'success' => true,
                'message'    => 'Movie Data Found Successfully From Cache',
                'data'       => Cache::get('movieList')
            ],200);
        }
        else
        {
            $response = Http::withHeaders(
                ['Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxYjg0MTNlM2MzMGE4YWZjMTk2ZTM0NWE4MTU2MWY5MSIsInN1YiI6IjY0YjJhMjFmMzc4MDYyMDBjNTg2Y2Q1YiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.o1shWUvbVQK_s82SZGhzgqIE6DwAVESlSm2H_RX4ZjY',
                    'accept' => 'application/json']
            )->get('https://api.themoviedb.org/3/collection/10');

            $aResponse = $response->json();

            $record = [
                "movie_id"      => $aResponse["id"],
                "name"          => $aResponse["name"],
                "overview"      => $aResponse["overview"],
                "poster_path"   => $aResponse["poster_path"],
                "backdrop_path" => $aResponse["backdrop_path"],
                "parts"         => json_encode($aResponse["parts"])
            ];

            $starwarMovie = new StarwarMovie();

            $iCount = $starwarMovie::where('movie_id',$aResponse["id"])->count();
            if ($iCount <= 0)
                $starwarMovie::create($record);

            Cache::put('movieList', $record, 20);

            return response()->json([
                'success' => true,
                'message'    => 'Movie Data Found Successfully',
                'data'       => Cache::get('movieList')
            ],200);
        }
    }

    public function movieDetails(Request $request)
    {
        $movieId = $request["movie_id"] ?? 0;

        if ($movieId <= 0)
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'movie_id is required'
            ],400));

        if (Cache::has('movieDetails'))
        {
            return response()->json([
                'success'   => true,
                'message'    => 'Movie Details Found Successfully From Cache',
                'data'       => Cache::get('movieDetails')
            ],200);
        }
        else
        {
            $response = Http::withHeaders(
                ['Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxYjg0MTNlM2MzMGE4YWZjMTk2ZTM0NWE4MTU2MWY5MSIsInN1YiI6IjY0YjJhMjFmMzc4MDYyMDBjNTg2Y2Q1YiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.o1shWUvbVQK_s82SZGhzgqIE6DwAVESlSm2H_RX4ZjY',
                    'accept' => 'application/json']
            )->get('https://api.themoviedb.org/3/movie/'.$movieId);

            $aResponse = $response->json();

            $record = [
                "adult"                 => !$aResponse["adult"] ? "false" : "true",
                "backdrop_path"         => $aResponse["backdrop_path"],
                "belongs_to_collection" => json_encode($aResponse["belongs_to_collection"]),
                "budget"                => $aResponse["budget"],
                "genres"                => json_encode($aResponse["genres"]),
                "homepage"              => $aResponse["homepage"],
                "movie_id"              => $aResponse["id"],
                "imdb_id"               => $aResponse["imdb_id"],
                "original_language"     => $aResponse["original_language"],
                "original_title"        => $aResponse["original_title"],
                "overview"              => json_encode($aResponse["overview"]),
                "popularity"            => $aResponse["popularity"],
                "poster_path"           => $aResponse["poster_path"],
                "production_companies"  => json_encode($aResponse["production_companies"]),
                "production_countries"  => json_encode($aResponse["production_countries"]),
                "release_date"          => $aResponse["release_date"],
                "revenue"               => $aResponse["revenue"],
                "runtime"               => $aResponse["runtime"],
                "spoken_languages"      => json_encode($aResponse["spoken_languages"]),
                "status"                => $aResponse["status"],
                "tagline"               => $aResponse["tagline"],
                "title"                 => $aResponse["title"],
                "video"                 => !$aResponse["video"] ? "false" : "true",
                "vote_average"          => $aResponse["vote_average"],
                "vote_count"            => $aResponse["vote_count"]
            ];

            $movieDetail = new MovieDetail();

            $iCount = $movieDetail::where('movie_id',$aResponse["id"])->count();
            if ($iCount <= 0)
                $movieDetail::create($record);

            Cache::put('movieDetails', $record, 20);

            return response()->json([
                'success'    => true,
                'message'    => 'Movie Details Found Successfully',
                'data'       => Cache::get('movieDetails')
            ],200);
        }
    }

    public function movieUpdate(Request $request)
    {
        $movieId = $request["movie_id"] ?? 0;
        $data    = $request["data"] ?? array();

        if ($movieId <= 0)
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'movie_id is required'
            ],400));
        if (count($data) <= 0)
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'data is required'
            ],400));

        $count = MovieDetail::where('movie_id',$movieId)->count();

        if ($count > 0)
        {
            $data["adult"] = !$data["adult"] ? "false" : "true";
            $data["video"] = !$data["video"] ? "false" : "true";

            MovieDetail::where('movie_id',$movieId)->update($data);

            return response()->json([
                'success'    => true,
                'message'    => 'Movie Details Updated Successfully',
                'data'       => ''
            ],200);
        }
        else
            return response()->json([
                'success'    => false,
                'message'    => 'Unable to update the record',
                'data'       => ''
            ],400);
    }

    public function movieDelete(Request $request)
    {
        $movieId = $request["movie_id"] ?? 0;

        if ($movieId <= 0)
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'data'      => 'movie_id is required'
            ]));

        $count = MovieDetail::where('movie_id',$movieId)->count();
        if ($count > 0)
        {
            $movieDetail = MovieDetail::where('movie_id',$movieId)->delete();

            if ($movieDetail)
                return response()->json([
                    'success'    => true,
                    'message'    => 'Movie Details Deleted Successfully',
                    'data'       => ''
                ],200);
            else
                return response()->json([
                    'success'    => false,
                    'message'    => 'Unable to delete the record',
                    'data'       => ''
                ],400);
        }
        else
            return response()->json([
                'success'    => false,
                'message'    => 'Unable to delete the record',
                'data'       => ''
            ],400);
    }

    public function starwarFilms()
    {
        if (Cache::has('starwarFilms'))
        {
            return response()->json([
                'success' => true,
                'message'    => 'Star War Films Data Found Successfully From Cache',
                'data'       => Cache::get('starwarFilms')
            ],200);
        }
        else
        {
            $response = Http::get('https://swapi.dev/api/films');


            $aResponse = $response->json();

            $record = [
                "count"    => $aResponse["count"],
                "next"     => $aResponse["next"],
                "previous" => $aResponse["previous"],
                "results"  => json_encode($aResponse["results"])
            ];

            $starwarFilms = new starwar_films();

            $iCount = $starwarFilms::all()->count();
            if ($iCount <= 0)
                $starwarFilms::create($record);

            Cache::put('starwarFilms', $record, 20);

            return response()->json([
                'success' => true,
                'message'    => 'Star War Films Data Found Successfully',
                'data'       => Cache::get('starwarFilms')
            ],200);
        }
    }

    public function starwarFilmDetails(Request $request)
    {
        $filmId = $request["film_id"] ?? 0;

        if ($filmId <= 0)
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'film_id is required'
            ],400));

        if (Cache::has('starwarFilmDetails'))
        {
            return response()->json([
                'success' => true,
                'message'    => 'Star War Film Details Data Found Successfully From Cache',
                'data'       => Cache::get('starwarFilmDetails')
            ],200);
        }
        else
        {
            $response = Http::get('https://swapi.dev/api/films/'.$filmId);

            $aResponse = $response->json();

            $record = [
                "film_id"       => $filmId,
                "title"         => $aResponse["title"],
                "episode_id"    => $aResponse["episode_id"],
                "opening_crawl" => $aResponse["opening_crawl"],
                "director"      => $aResponse["director"],
                "producer"      => $aResponse["producer"],
                "release_date"  => $aResponse["release_date"],
                "characters"    => json_encode($aResponse["characters"]),
                "planets"       => json_encode($aResponse["planets"]),
                "starships"     => json_encode($aResponse["starships"]),
                "vehicles"      => json_encode($aResponse["vehicles"]),
                "species"       => json_encode($aResponse["species"]),
                "created"       => $aResponse["created"],
                "edited"        => $aResponse["edited"],
                "url"           => $aResponse["url"]
            ];



            $count = starwarfilm_detail::where('film_id',$filmId)->count();
            if ($count <= 0)
                starwarfilm_detail::create($record);

            Cache::put('starwarFilmDetails', $record, 20);

            return response()->json([
                'success'    => true,
                'message'    => 'Star War Film Details Data Found Successfully',
                'data'       => Cache::get('starwarFilmDetails')
            ],200);
        }
    }

    public function starwarFilmUpdate(Request $request)
    {
        $filmId = $request["film_id"] ?? 0;

        if ($filmId <= 0)
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'film_id is required'
            ],400));

        $data    = $request["data"] ?? array();

        if (count($data) <= 0)
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'data is required'
            ],400));

        $count = starwarfilm_detail::where('film_id',$filmId)->count();

        if ($count > 0)
        {
            starwarfilm_detail::where('film_id',$filmId)->update($data);

            return response()->json([
                'success'    => true,
                'message'    => 'Movie Details Updated Successfully',
                'data'       => ''
            ],200);
        }
        else
            return response()->json([
                'success'    => false,
                'message'    => 'Unable to update the record',
                'data'       => ''
            ],400);
    }

    public function starwarFilmDelete(Request $request)
    {
        $filmid = $request["film_id"] ?? 0;

        if ($filmid <= 0)
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'data'      => 'film_id is required'
            ]));

        $count = starwarfilm_detail::where('film_id',$filmid)->count();
        if ($count > 0)
        {
            $filmDetail = starwarfilm_detail::where('film_id',$filmid)->delete();

            if ($filmDetail)
                return response()->json([
                    'success'    => true,
                    'message'    => 'Movie Details Deleted Successfully',
                    'data'       => ''
                ],200);
            else
                return response()->json([
                    'success'    => false,
                    'message'    => 'Unable to delete the record',
                    'data'       => ''
                ],400);
        }
        else
            return response()->json([
                'success'    => false,
                'message'    => 'Unable to delete the record',
                'data'       => ''
            ],400);
    }
}
