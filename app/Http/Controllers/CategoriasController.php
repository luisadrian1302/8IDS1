<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriasController extends Controller
{
    //
     // Mostrar la lista de categorías
     public function index()
     {
         $categories = Categorias::all();
         return view('categories.index', compact('categories'));
     }
 
     public function indexAPI()
     {
         Log::info('Iniciando el proceso en el controlador Index categoria.');
         $categories = Categorias::all();
         Log::info('Proceso finalizado.');
         return $categories;
     }

     public function getAPI($id)
     {
        try {
             Log::info('Iniciando el proceso de obtener una categoria');

            $categoria = Categorias::findOrFail($id);
            Log::info('Proceso finalizado.');

            return $categoria;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            Log::channel('slack')->error('Ocurrió un error en el servidor: ' . $th->getMessage());
       
            return response()->json(['message' => $th->getMessage()])->setStatusCode(400); 

        }

     }
       
     // Mostrar el formulario para crear una nueva categoría
     public function create()
     {
         return view('categories.create');
     }


     // Guardar una nueva categoría
    public function storeAPI(Request $request)
    {
        Log::info('Iniciando el proceso de crear categoria');

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Categorias::create([
            'nombre' => $request->name
        ]);
        Log::info('Proceso finalizado.');

        return "Ok";
    }

    public function updateAPI(Request $request, $id)
    {

        try {
            Log::info('Iniciando el proceso de actualizar categoria');
            
            $request->validate([
                'name' => 'required|string|max:255'
            ]);
    
            
            $categoria = Categorias::findOrFail($id);
            $categoria->update([
                'nombre' => $request->name
            ]);
            Log::info('Proceso finalizado.');


            // return "Ok";
            return response()->json(['message' => 'Ok']); 
        } catch (\Throwable $th) {
            //throw $th;
            Log::channel('slack')->error('Ocurrió un error en el servidor: ' . $th->getMessage());

            return response()->json(['message' => $th->getMessage()])->setStatusCode(400); 

        }
       


    }
    
    public function deleteAPI($id){

        Log::info('Iniciando el proceso de eliminar categoria');

        $categoria = Categorias::find($id);
        $categoria->delete();

        Log::info('Proceso finalizado.');
        return "Ok";

    }
}
