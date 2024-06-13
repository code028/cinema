<?php

namespace App\Http\Controllers;

use App\Http\Filters\MovieFilter;
use App\Http\Filters\ShowingFilter;
use App\Models\Airing;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Showing;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;



class PageController extends Controller
{
    public function index(ShowingFilter $filter, Request $request)
    {
        date_default_timezone_set('Europe/Belgrade');
        Carbon::setLocale('sr');

        $today = Carbon::today();

        $all_cinemas = Cinema::all();

        $showings = Showing::filter($filter)
            ->with('movie');

        if(!$request->exists('selected_date')) {
            $showings->whereHas('airings', function ($query) use ($today) {
                $query->where('day', $today);
            });
        }

        $showings = $showings->simplePaginate(5);


        $dates = [];
        $startDate = Carbon::today();

        for ($i = 0; $i < 7; $i++) {
            if ($i == 0) {
                $dates[] = ['label' => Str::ucfirst('danas'), 'value' => $startDate->format('Y-m-d')];
            } elseif ($i == 1) {
                $dates[] = ['label' => Str::ucfirst($startDate->copy()->addDays($i)->format('d.m') . ' - sutra'), 'value' => $startDate->copy()->addDays($i)->format('Y-m-d')];
            } else {
                $label = $startDate->copy()->addDays($i)->format('d.m') . ' - ' . $startDate->copy()->addDays($i)->translatedFormat('l');
                $dates[] = [
                    'label' => Str::ucfirst($label),
                    'value' => $startDate->copy()->addDays($i)->format('Y-m-d')
                ];
            }
        }

        return view('pages.home.index', compact('showings','all_cinemas', 'dates', 'today'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages.profile.index', compact("user"));
    }

    public function showMovie(string $id)
    {
        date_default_timezone_set('Europe/Belgrade');
        Carbon::setLocale('sr');

        $all_cinemas = Cinema::all();

        $movie = Movie::findOrFail($id);

        $today = Carbon::today();

        $airings = Airing::whereHas('showing', function ($query) use ($movie) {
            $query->where('movie_id', $movie->id);
        })
            ->where('day', $today)
            ->with('cinema', 'room')
            ->get()
            ->sortByDesc('startTime');

        // Grupišemo emitovanja po bioskopima
        $groupedAirings = $airings->groupBy('cinema_id');

        $dates = [];
        $startDate = Carbon::today();

        for ($i = 0; $i < 7; $i++) {
            if ($i == 0) {
                $dates[] = ['label' => Str::ucfirst('danas'), 'value' => $startDate->format('Y-m-d')];
            } elseif ($i == 1) {
                $dates[] = ['label' => Str::ucfirst($startDate->copy()->addDays($i)->format('d.m') . ' - sutra'), 'value' => $startDate->copy()->addDays($i)->format('Y-m-d')];
            } else {
                $label = $startDate->copy()->addDays($i)->format('d.m') . ' - ' . $startDate->copy()->addDays($i)->translatedFormat('l');
                $dates[] = [
                    'label' => Str::ucfirst($label),
                    'value' => $startDate->copy()->addDays($i)->format('Y-m-d')
                ];
            }
        }

        return view('pages.movie.index', compact('movie', 'groupedAirings', 'dates', 'all_cinemas', 'today'));
    }

    public function showTicketOverview(string $id1, $id2)
    {
        $airing = Airing::findOrFail($id2);

        return view("pages.airing.overview", compact("airing"));
    }

    public function submitTicket(Request $request, string $id1, $id2)
    {
        // Validacija zahteva
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Pronalaženje emitovanja
        $airing = Airing::findOrFail($id2);
        // Učitavanje sobe
        $airing->load('room');

        // Pronalaženje trenutnog korisnika
        $user = Auth::user();

        // Provera kapaciteta
        $availableSeats = $airing->room->capacity - $airing->occupied;
        if ($request->quantity > $availableSeats) {
            return redirect()->back()->with('error', 'The number of seats is limited.');
        }

        // Provera balansa korisnika
        $totalPrice = $airing->price * $request->quantity;
        if ($totalPrice > $user->balance) {
            return redirect()->back()->with('error', 'Not enough funds.');
        }

        // Ažuriranje zauzetosti mesta
        $airing->occupied += $request->quantity;
        $airing->save();

        // Kreiranje karte
        Ticket::create([
            'user_id' => $user->id,
            'airing_id' => $airing->id,
            'price' => $airing->price,
            'quantity' => $request->quantity,
        ]);

        // Ažuriranje balansa korisnika
        $userModel = User::find($user->id); // Pretpostavljamo da je ovo vaš model korisnika
        $userModel->balance -= $totalPrice;
        $userModel->save();

        return redirect()->route('home');
    }

    public function allMovies(MovieFilter $filter){
        $movies = Movie::filter($filter)->simplePaginate(4);

        return view('pages.movies.index', compact('movies'));
    }

    public function about(){
        return view('pages.about.index');
    }
    public function contact(){
        return view('pages.contact.index');
    }

    public function addToFavorite(string $id){

        $movie = Movie::findOrFail($id);

        $user = Auth::user();
        if ($user->movies()->where('movie_id', $movie->id)->exists()) {
            $user->movies()->detach($movie->id);
            return redirect()->back()->with('success', 'Film je uklonjen iz omiljenih.');
        }

        $user->movies()->attach($movie->id);
        return redirect()->back()->with('success', 'Film je dodat u omiljene.');
    }
}
