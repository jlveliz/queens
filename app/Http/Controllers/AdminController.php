<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepositoryInterface\EventRepositoryInterface;
use App\RepositoryInterface\ScoreRepositoryInterface;

class AdminController extends Controller
{
    
    protected $event;
    protected $score;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepositoryInterface $event, ScoreRepositoryInterface $score)
    {
        $this->middleware('admin');
        $this->event = $event;
        $this->score = $score;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = $this->event->getActives();
        $currentEvent = $this->event->getCurrentName();
        return view('admin.home',compact('events','currentEvent'));
    }

    public function updateCurrentEvent(Request $request)
    {
        $data = [
            'event_id' => $request->get('event_id'),
            'is_current' => 1
        ];

        $event = $this->event->setCurrentEvent($data);

        $sessionData['tipo_mensaje'] = 'success';
        $sessionData['mensaje'] = "Se ha Actualizado el evento";

        if ($event) {
            $sessionData['tipo_mensaje'] = 'danger';
            $sessionData['mensaje'] = "Existió un error al actualizar el evento";
        }

        return back()->with($sessionData);
    }

    public function reset(Request $request)
    {
        $this->score->reset();

        $sessionData['tipo_mensaje'] = 'success';
        $sessionData['mensaje'] = "Se ha Reinicializado los puntos Satisfactoriamente";
        return back()->with($sessionData);
        
    }
}
