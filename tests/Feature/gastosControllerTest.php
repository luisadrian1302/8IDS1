<?php

namespace Tests\Feature;

use App\Models\Gastos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class gastosControllerTest extends TestCase
{

    public function getToken(){
        if (Auth::attempt(['email' => 'lm0336172@gmail.com', 'password' => '12345678'])) {
            $user = Auth::user();
            $token = $user->createToken('app')->plainTextToken;
            $arr = array(
                'acceso' => 'Ok',
                'error' => '',
                'token' => $token,
                'idUsuario' => $user->id,
                'nombreUsuario' => $user->name
            );
        }

        return json_encode($arr);

    }
    
      /** @test */

      public function it_can_list_all_gastos()
      {
          $tk = $this->getToken();
          $response = $this->getJson('/api/gastos/getall', [
              'headers'=> [
                  'Authorization'=> "Bearer $tk",
                  "Content-Type"=> "application/json"
              ] 
                
          ]);
  
          $response->assertStatus(200);
  
      }

       /** @test */
    public function it_can_show_gastos_by_id()
    {
        $tk = $this->getToken();
        
        $gastos = Gastos::factory()->create([
            'name' => 'Gasto de prueba',  
            'descripcion' => 'Descripcion gasto de prueba', 
            'monto' => 12,  
            'fecha_gasto' => '2024-11-26',  
            'id_categoria' => 1,  
            'id_users' => 1,  
        ]);
        


        $response = $this->getJson("api/gastos/get/{$gastos->id}" , [
            'headers'=> [
                'Authorization'=> "Bearer $tk",
                "Content-Type"=> "application/json"
            ] 
              
        ] );

        $response->assertStatus(200);
        
    }

       /** @test */

    public function it_can_create_gastos()
    {
        $tk = $this->getToken();
         


        $response = $this->postJson('/api/gastos/create', [
            'name' => 'New Category',
            'descripcion' => 'Descripcion gasto de prueba', 
            'monto' => 12,  
            'fecha_gasto' => '2024-11-26',  
            'id_categoria' => 1,  
        ], ['headers'=> [
            'Authorization'=> "Bearer $tk",
            "Content-Type"=> "application/json"
        ] ]);


        $response->assertStatus(200);
        
    }

       /** @test */
       public function it_can_update_a_gastos()
       {
           $tk = $this->getToken();
   
           $categoria = Gastos::factory()->create([
            'name' => 'Gasto de prueba',  
            'descripcion' => 'Descripcion gasto de prueba', 
            'monto' => 12,  
            'fecha_gasto' => '2024-11-26',  
            'id_categoria' => 1,  
            'id_users' => 1,  
           ]);

           $response = $this->putJson("/api/gastos/{$categoria->id}", [
               'name' => 'Updated Category',
               'descripcion' => 'Descripcion actualizado de prueba', 
                'monto' => 120,  
                'fecha_gasto' => '2024-11-30',  
                'id_categoria' => 1,  
                'id_users' => 1,  
           ], ['headers'=> [
               'Authorization'=> "Bearer $tk",
               "Content-Type"=> "application/json"
           ]]);
   
           $response->assertStatus(200);
           $response->assertJsonFragment([
               'message' => 'Ok'
           ]);
       }

       /** @test */
    public function it_can_delete_a_gastos()
    {
        $tk = $this->getToken();

        $categoria = Gastos::factory()->create([
            'name' => 'Gasto de prueba',  
            'descripcion' => 'Descripcion gasto de prueba', 
            'monto' => 12,  
            'fecha_gasto' => '2024-11-26',  
            'id_categoria' => 1,  
            'id_users' => 1,  
        ]);

        $response = $this->deleteJson("/api/gastos/{$categoria->id}", [

        ], [
            'headers'=> [
                'Authorization'=> "Bearer $tk",
                "Content-Type"=> "application/json"
            ]

        ]);

        $response->assertStatus(200);
        
    }
}
