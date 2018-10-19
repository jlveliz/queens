<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\RepositoryInterface\CityRepositoryInterface;

class CityController extends Controller
{
    
    private $city;
    
    public function __construct(CityRepositoryInterface $city)
    {
        $this->city = $city;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = $this->city->enum();
        return view('admin.cities.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.create-edit');
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
        $city = $this->city->save($data);
        $sessionData['tipo_mensaje'] = 'success';
        $sessionData['mensaje'] = "Se ha guardado Satisfactoriamente el cantón";

        if ($city) {
            return redirect('/admin/cities/'.$city->id.'/edit')->with($sessionData);
        }

        $sessionData['tipo_mensaje'] = 'error';
        $sessionData['mensaje'] = "No se ha podido guardar el cantón";

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
        $city = $this->city->find($id);
        return view('admin.cities.create-edit',compact('city'));
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
        $city = $this->city->edit($id, $request->all());

        $sessionData['tipo_mensaje'] = 'success';
        $sessionData['mensaje'] = "Se ha guardado Satisfactoriamente el cantón";

        if ($city) {
            return redirect('/admin/cities/'.$city->id.'/edit')->with($sessionData);
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
        //
    }
}
