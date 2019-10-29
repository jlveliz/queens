<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepositoryInterface\MissRepositoryInterface;
use App\RepositoryInterface\EventRepositoryInterface;
use App\RepositoryInterface\ScoreRepositoryInterface;

class HomeController extends Controller
{
    
    protected $event;
    protected $miss;
    protected $score;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepositoryInterface $event, MissRepositoryInterface $miss, ScoreRepositoryInterface $score)
    {
        $this->middleware('auth');
        $this->event = $event;
        $this->miss = $miss;
        $this->score = $score;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.home');
    }


    public function vote($eventType = '', Request $request)
    {
        if (!$eventType) {
            return redirect('home');
        }

       

        if($eventType !=  $this->event->getCurrent()->generateSlug())
            return redirect('home');

        if ($this->event->getCurrent()->generateSlug() == 'ronda-de-preguntas') {
            $citiesSemifinalists = $this->score->getSemifinalist();
            $misses = $this->miss->semifinalist($citiesSemifinalists);
            
        } else {
            $misses = $this->miss->paginate();
        }
        return view('app.show',compact('misses'));
    }


    public function thanks()
    {
        return view('app.thanks');
    }
}
