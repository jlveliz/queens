<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\RepositoryInterface\ScoreRepositoryInterface;
use  App\RepositoryInterface\EventRepositoryInterface;
use  App\RepositoryInterface\MissRepositoryInterface;

class ScoreController extends Controller
{
    
    private $score;
    private $event;
    private $miss;
    
    public function __construct(ScoreRepositoryInterface $score, EventRepositoryInterface $event, MissRepositoryInterface $miss)
    {
        $this->score = $score;
        $this->event = $event;
        $this->miss = $miss;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       #
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $score = $this->score->save($data);
        $sessionData['tipo_mensaje'] = 'success';
        $sessionData['mensaje'] = "Gracias por votar";
       
        if ($score) {

            $totalMisses = $this->miss->count();
            $currentPage = (int)$data['current_page'];
            $currentEventName = $this->event->getCurrent()->generateSlug(); 
            $nextpage = 0;
            if ($currentPage <  $totalMisses) {
                $nextpage = $currentPage+=1;
                return redirect('/vote/'.$currentEventName.'?page='.$currentPage)->with($sessionData);
            } else {
                return redirect('/thanks');
            }
        }

        $sessionData['tipo_mensaje'] = 'error';
        $sessionData['mensaje'] = "No se ha podido realizar el voto";

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
        $score = $this->score->edit($id, $request->all());

        $sessionData['tipo_mensaje'] = 'success';
        $sessionData['mensaje'] = "Se ha actualizado Satisfactoriamente el cantón";

        
        if ($score) {
            $totalMisses = $this->miss->count();
            $currentPage = (int)$request->get('current_page');
            $currentEventName = $this->event->getCurrent()->generateSlug(); 
            $nextpage = 0;
            if ($currentPage <  $totalMisses) {
                $nextpage = $currentPage+=1;
                return redirect('/vote/'.$currentEventName.'?page='.$currentPage)->with($sessionData);
            } else {
                return redirect('/thanks');
            }
        }

        $sessionData['tipo_mensaje'] = 'error';
        $sessionData['mensaje'] = "No se ha podido actualizar el cantón";

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
        #
    }
}
