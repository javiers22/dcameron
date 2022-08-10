<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Habitacion;
use App\Models\Tipo;

class AppController extends Controller
{
    public function listado(Request $request)
    {
        $hotel=Hotel::select()->get()->toArray();
        return response()->json($hotel);
    }

    public function habitaciones_por_hotel(Request $request)
    {
        $habitaciones=Habitacion::selectRaw("habitacions.id,habitacions.cantidad,habitacions.hotels_id,habitacions.tipos_id,tipos.tipo,tipos.acomodacion")
        ->where("hotels_id","=",$request->input('hotels_id'))
        ->join("tipos","tipos.id","=","habitacions.tipos_id")
        ->get()
        ->toArray();
        return response()->json($habitaciones);
    }

    public function insertar_hotel(Request $request)
    {
        
        $hoteles=Hotel::select()->get()->toArray();
        $encontrado=false;
        foreach($hoteles as $clave => $valor)
        {
            if($hoteles[$clave]["nombre"]==$request->input('nombre'))
            {
                $encontrado=true;
            }
        }
        if(!$encontrado)
        {
            $hotel=new Hotel();
            $hotel->nombre=$request->input('nombre');
            $hotel->direccion=$request->input('direccion');
            $hotel->nit=$request->input('nit');
            $hotel->ciudad=$request->input('ciudad');
            $hotel->num_hab=$request->input('num_hab');
            $hotel->save();
            return response()->json($hotel); 
        } 
        else
        {
            $error=array("error"=>1);
            return response()->json($error);  
        }      
    }

    public function insertar_habitacion(Request $request)
    {        
        $hab_hotel=Hotel::Where("id","=",$request->input('hotels_id'))->get()->toArray();
        $sum_hab=Habitacion::selectRaw("sum(cantidad) as suma")->where("hotels_id","=",$request->input('hotels_id'))->get()->toArray();
        $sumatoria=$request->input('cantidad')+$sum_hab[0]["suma"];
        $habitaciones=Habitacion::where("hotels_id","=",$request->input('hotels_id'))->get()->toArray();        

        $encontrado=false;
        foreach($habitaciones as $clave => $valor)
        {
            if($habitaciones[$clave]["tipos_id"]==$request->input('tipos_id'))
            {
                $encontrado=true;
            }
        }

        if($sumatoria <= $hab_hotel[0]["num_hab"] && !$encontrado)
        {
            $habitacion=new Habitacion();      
            $habitacion->cantidad=$request->input('cantidad');  
            $habitacion->hotels_id=$request->input('hotels_id');  
            $habitacion->tipos_id=$request->input('tipos_id');  
            $habitacion->save();
            return response()->json($habitacion);  
        }    
        else
        {
            $error=array("error"=>1);
            return response()->json($error);  
        }  
    }

    public function get_tipos(Request $request)
    {
        $tipos=Tipo::select()->get()->toArray();
        return response()->json($tipos);        
    }
}
