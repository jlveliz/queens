<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepositoryInterface\MissRepositoryInterface;
use App\RepositoryInterface\EventRepositoryInterface;

class HomeController extends Controller
{
    
    protected $event;
    protected $miss;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepositoryInterface $event, MissRepositoryInterface $miss)
    {
        $this->middleware('auth');
        $this->event = $event;
        $this->miss = $miss;
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


    public function vote($eventType = '')
    {
        if (!$eventType) {
            return redirect('home');
        }

       

        if($eventType !=  $this->event->getCurrent()->generateSlug())
            return redirect('home');

        $misses = $this->miss->paginate();

        return view('app.show',compact('misses'));
    }


    public function dovote(Request $request)
    {
        dd($request);
    }
}
