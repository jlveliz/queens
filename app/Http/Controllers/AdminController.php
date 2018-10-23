<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepositoryInterface\EventRepositoryInterface;

class AdminController extends Controller
{
    
    protected $event;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepositoryInterface $event)
    {
        $this->middleware('admin');
        $this->event = $event;
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
}
