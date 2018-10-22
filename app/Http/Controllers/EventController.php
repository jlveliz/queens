<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\RepositoryInterface\EventRepositoryInterface;

class EventController extends Controller
{
    
    private $event;
    
    public function __construct(EventRepositoryInterface $event)
    {
        $this->event = $event;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = $this->event->enum();
        return view('admin.events.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = $this->event->save($request->all());
        $sessionData['tipo_mensaje'] = 'success';
        $sessionData['mensaje'] = "Se ha guardado Satisfactoriamente el evento";

        if ($event) {
            return redirect('/admin/events/'.$event->id.'/edit')->with($sessionData);
        }

        $sessionData['tipo_mensaje'] = 'error';
        $sessionData['mensaje'] = "No se ha podido guardar el evento";
        return back()->with($sessionData);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = $this->event->find($id);
        return view('admin.events.create-edit',compact('event'));
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
        $event = $this->event->edit($id, $request->all());

        $sessionData['tipo_mensaje'] = 'success';
        $sessionData['mensaje'] = "Se ha actualizado Satisfactoriamente el evento";

        if ($event) {
            return redirect('/admin/events/'.$event->id.'/edit')->with($sessionData);
        }

        $sessionData['tipo_mensaje'] = 'error';
        $sessionData['mensaje'] = "No se ha podido actualizar el evento";

        return back()->with($sessionData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $removed = $this->event->remove($id);
        if ($removed) {
            $sessionData['tipo_mensaje'] = 'success';
            $sessionData['mensaje'] = "Se ha eliminado satisfactoriamente el evento";
        } else {
            $sessionData['tipo_mensaje'] = 'error';
            $sessionData['mensaje'] = "No se ha podido eliminar el evento";
        }

        return back()->with($sessionData);
    }
}
