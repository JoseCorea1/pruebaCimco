<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\export\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductosController extends Controller
{
    /**
     *Autor Jose Corea 
     *
     * La función index nos devuelve la vista principal del proyecto PruebaCimco 
     */
    public function index()
    {
        $Productos = Productos::all();
        return view('Productos.ProductosMtto');
    }
    /**
     * Store recibe como parametro $request, luego creamos un array llamado respuesta que 
     * nos servira para guardar los datos del producto en una tabla 
     */
    public function store(Request $request)
    {
        $respuesta = array(
            "STATUS" => "FAIL",
            "MENSAJE" => ""
        );
        try {
            $productos = new Productos();
            $productos->nombre = $request->txt_nombre_producto;
            $productos->cantidad = $request->num_cantidad_producto;
            $productos->existencias_bodega = $request->num_existencia_producto;
            $productos->disponible_bodega = $request->chk_disponible_bodega;
            $productos->costo = $request->num_costo_producto;
            $productos->precio_venta = $request->num_precio_venta;
            $productos->save();
            $respuesta["STATUS"] = "SUCCESS";
        } catch (\Throwable $th) {
            $respuesta["STATUS"] = "FAIL";
            $respuesta["MENSAJE"] = "OCURRIO UN ERROR AL GUARDAR SU PRODUCTO, FAVOR INTENTELO MAS TARDE";
            Log::error("==================================================== ERROR AL GUARDAR PRODUCTO ====================================================================");
            Log::error($th);
            Log::error("==================================================== FIN ERROR AL GUARDAR PRODUCTO ====================================================================");
        }
        return response()->json($request);
    }


    /**La funcion getProductos nos permite crear un query que realiza una consulta a la base de datos 
     * el query opcionalmente cuenta con el apartado AND nombre LIKE '%{$request->nombre}%' el cual nos sirve
     * en caso de que queramos realizar una consulta especificando el nombre del producto
     */
    public function getProductos(Request $request){
        $query = "SELECT id, nombre, cantidad, existencias_bodega, disponible_bodega, costo, precio_venta, created_at, updated_at ";
        $query .= "FROM pruebacimco.productos ";
        $query .= "WHERE 1 = 1 ";
        if (!empty($request->nombre)) {
            $query.= "AND nombre LIKE '%{$request->nombre}%'";
        }
        $Productos = DB::select($query);
        return view('Productos.tablaProductos',compact('Productos'));
    }

    /**
     * obtenerDataProducto nos devuelve la informacion de un producto especifico 
     * el cual luego usamos para llenar el formulario y editar
     */
    public function obtenerDataProducto(Request $request){
        $respuesta = array(
            "STATUS" => "SUCCESS",
            "MESSAGE" => null,
            "DATA" => null
        );
        $respuesta["DATA"] = Productos::find($request->id);
        return response()->json($respuesta);
    }
    /**
     * Update nos permite realizar una edicion a la tabla, utilizando el id del producto especifico
     */
    public function update(Request $request)
    {
        $respuesta = array(
            "STATUS" => "FAIL",
            "MENSAJE" => ""
        );
        try {
            $producto = Productos::find($request->num_id_producto);
            $producto->nombre = $request->txt_nombre_producto;
            $producto->cantidad = $request->num_cantidad_producto;
            $producto->existencias_bodega = $request->num_existencia_producto;
            $producto->disponible_bodega = $request->chk_disponible_bodega;
            $producto->costo = $request->num_costo_producto;
            $producto->precio_venta = $request->num_precio_venta;
            $producto->save();
            $respuesta["STATUS"] = "SUCCESS";
        } catch (\Throwable $th) {
            $respuesta["STATUS"] = "FAIL";
            $respuesta["MENSAJE"] = "OCURRIO UN ERROR AL EDITAR SU PRODUCTO, FAVOR INTENTELO MAS TARDE";
            Log::error("==================================================== ERROR AL EDITAR PRODUCTO ====================================================================");
            Log::error($th);
            Log::error("==================================================== FIN ERROR AL EDITAR PRODUCTO ====================================================================");
        }
        return response()->json($request);
    }

    /**
     * Destroy nos permite eliminar un producto en base a su id
     */
    public function destroy(Request $request)
    {
        $respuesta = array(
            "STATUS" => "SUCCESS",
            "MESSAGE" => null
        );
        try {
            $Productos = Productos::find($request->id);
            $Productos->delete(); 
        } catch (\Throwable $th) {
            $respuesta["STATUS"] = "FAIL";
            $respuesta["MESSAGE"] = "OCURRIO UN ERROR AL ELIMINAR EL PRODUCTO";
            Log::error("==================================================== ERROR AL ELIMINAR PRODUCTO ====================================================================");
            Log::error($th);
            Log::error("==================================================== FIN ERROR AL ELIMINAR PRODUCTO ====================================================================");
        }
        return response()->json($respuesta);
    }

    /**
     * la funcion obtenerCSV nos permite atravez de la biblioteca Laravel excel
     * exportar los datos hacia un documento con extencion.csv
     */
    public function obtenerCSV(){
        return Excel::download(new ProductosExport, 'Productos.csv');
    }
}
