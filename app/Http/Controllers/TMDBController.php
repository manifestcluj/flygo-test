<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TMDBData;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class TMDBController extends Controller
{
    //

    protected $today = "";

    public function __construct()
    {
        $this->today = Carbon::now()->format('Y-m-d');
    }

    public function extract() {

       $url =  "https://api.themoviedb.org/3/discover/movie?api_key=".env('TMDB_API_KEY')."&language=en-US&sort_by=popularity.desc&include_video=false&primary_release_date.gte=" . $this->today . "&primary_release_date.lte=" . $this->today;

       $client = new Client();
       $contents = $client->request('GET', $url);

       if ($contents->getStatusCode() == 200) {

            $results = json_decode($contents->getBody());
            $total_movies = $results->total_results;
            TMDBController::storeRetrievedData($results->results, Auth::user()->id);

            if ($results->total_pages > 1) {
                // result is paginated, we handle all pages
                for ($page = 2; $page <= $results->total_pages; $page++ )
                {
                    $contents = $client->request('GET', $url . "&page=".$page );
                    if ($contents->getStatusCode() == 200)
                    {
                        $results = json_decode($contents->getBody());
                        TMDBController::storeRetrievedData($results->results, Auth::user()->id);
                    }
                }
            }


        }
        else dd('error reading TMDB movie list.');

        return redirect('/today')->with(['message' => $total_movies . ' were read from TMDB API.']);
    }


    public function today() {

        $movies = TMDBData::where('user_id', '=', Auth::user()->id)
            ->where('primary_release_date', '=', $this->today)
            ->paginate(10);

        return view('userarea.today', compact('movies'));
    }

    public function details($tmdb_id) {
        $movie = TMDBData::where('tmdb_id', '=', $tmdb_id)->first();

        // loading details from TMDB API
        $url = "https://api.themoviedb.org/3/movie/" . $tmdb_id . "?api_key=" . env('TMDB_API_KEY') . "&language=en-US";

        $client = new Client();
        $contents = $client->request('GET', $url);

        if ($contents->getStatusCode() == 200) {

            return view('userarea.modal')->with(['contents' => json_decode($contents->getBody()) ])->render();
        }
        else
            return response()->json(['result' => 'failed', 'response' => 'There was a problem loading the data. try again later.']);

    }

    static public function storeRetrievedData($results, $user_id = 0)
    {
        if (is_array($results))
            foreach ($results as $result) {
                // genres
                $genre_names = [];

                foreach ($result->genre_ids as $genre_id)
                    $genre_names[] = \Config::get('constants.genres.'.$genre_id);

                TMDBData::updateOrCreate(
                    [
                        'user_id' => $user_id,
                        'tmdb_id' => $result->id,
                    ],
                    [
                        'original_title' => $result->original_title,
                        'genre' => implode(',',   $genre_names),
                        'primary_release_date' => $result->release_date,
                    ]
                );
            }
    }
}
