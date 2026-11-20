<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zona;

class ZonaController extends Controller
{
    //

    public function obtenerZonas(){
        $Zona = new Zona();

        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        $valores = $Zona::all();

        if(!empty($valores)){
            $satisfactorio = true;
            $estado = 200;
            $mensaje = "Valores encontrados";
            $errores = [
            "code" => 200,
            "msg"=> ""
            ];
        }else{
            $satisfactorio = false;
            $estado = 404;
            $mensaje = "No se han encontrado valores";
            $errores = [
                "code"=> 404,
                "msg"=> ""
            ];
        }

        $respuesta = [
            "success" => $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $valores,
            "errors" => $errores,
            "total" => sizeof($valores) // o tambien count($valores),
        ];

        return response()->json($respuesta);
    }



    public function obtenerZona(int $idzona = 0){
        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        if($idzona > 0){
            $Zona = new Zona();
            $valores = $Zona->where('id_zona',$idzona)->get();

            if(!empty($valores)){
                $satisfactorio = true;
                $estado = 200;
                $mensaje = "Valores encontrados";
                $errores = [
                    "code"=>200,
                    "msg"=>""
                ];
            }else{
                $satisfactorio = false;
                $estado = 404;
                $mensaje = "No se han encontrado valores";
                $errores = [
                    "code"=>404,
                    "msg"=>"Datos no encontrados"
                ];
            }
        }else{
            $satisfactorio = false;
            $estado = 400;
            $mensaje = "Valores encontrados";
            $errores = [
                "code"=>400,
                "msg"=>"El identificador de la zona está vacío"
            ];
        }

        $respuesta = [
            "success" => $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $valores,
            "errors" => $errores,
            "total" => sizeof($valores) // o tambien count($valores),
        ];

        return response()->json($respuesta,$estado);
    }

    public function obtenerZonaPais(int $idpais = 0){
        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];
        $valores = [];

        if($idpais > 0){
            $Zona = new Zona();
            $valores = $Zona->where('id_pais',$idpais)->get();

            if(!empty($valores)){
                $satisfactorio = true;
                $estado = 200;
                $mensaje = "Valores encontrados";
                $errores = [
                    "code"=>200,
                    "msg"=>""
                ];
            }else{
                $satisfactorio = false;
                $estado = 404;
                $mensaje = "No se han encontrado valores";
                $errores = [
                    "code"=>404,
                    "msg"=>"Datos no encontrados"
                ];
            }
        }else{
            $satisfactorio = false;
            $estado = 400;
            $mensaje = "No se ha enviado el parámetro obligatorio";
            $errores = [
                "code"=>400,
                "msg"=>"El identificador de país está vacío"
            ];
        }

        $respuesta = [
            "success" => $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $valores,
            "errors" => $errores,
            "total" => sizeof($valores) // o tambien count($valores),
        ];

        return response()->json($respuesta,$estado);
    }
    
    public function crearZona(Request $request){
        $satisfactorio = false;
        $estado = 0;
        $mensaje = "";
        $errores = [];

        $validacion = $request->validate([
            'idpais'=>'required|integer|gt:0',
            'nombrezona' => 'required|max:50'
        ]);

        $Zona = new Zona();
        $Zona->id_pais = $request->idpais;
        $Zona->nombre_zona = $request->nombrezona;

        $insertado = $Zona->save();

        if($insertado){
            $ultimoinsertado = $Zona->id;
            $datos_insertados = $this->obtenerZona($ultimoinsertado);

            $satisfactorio = true;
            $estado = 200;
            $mensaje = "Valores guardados correctamente";
            $errores = [
                "code"=>200,
                "msg"=>""
            ];
        }else{
            $satisfactorio = false;
            $estado = 500;
            $mensaje = "Hubo un problema al guardar los datos";
            $errores = [
                "code"=>500,
                "msg"=>"No se pudo hacer insert a la tabla"
            ];
        }


        $respuesta = [
            "success" => $satisfactorio,
            "status" => $estado,
            "msg" => $mensaje,
            "data" => $datos_insertados->original["data"][0],
            "errors" => $errores,
            "total" => $datos_insertados->original["total"],
        ];

        return response()->json($respuesta,$estado);
    }

}
