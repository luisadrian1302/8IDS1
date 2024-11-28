<?php

namespace Tests\Feature;

use App\Models\Categorias;
use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Tests\TestCase;

class CategoriasControllerTest extends TestCase
{
    


    public function getToken(){
        if (FacadesAuth::attempt(['email' => 'lm0336172@gmail.com', 'password' => '12345678'])) {
            $user = FacadesAuth::user();
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

    public function it_can_list_all_categories()
    {
       
        
        
        $tk = $this->getToken();
        $response = $this->getJson('/api/categories', [
            'headers'=> [
                'Authorization'=> "Bearer $tk",
                "Content-Type"=> "application/json"
            ] 
              
        ]);

        $response->assertStatus(200);

            //code...
        
       
    }

      /** @test */
    public function it_can_create_a_category()
    {
    $tk = $this->getToken();

    $response = $this->postJson('api/categories', [
        'name' => 'New Category'
    ], ['headers'=> [
        'Authorization'=> "Bearer $tk",
        "Content-Type"=> "application/json"
    ] ]);

    $response->assertStatus(200);  // Created
        
    }


    /** @test */
    public function it_can_show_category_by_id()
    {
        $categoria = Categorias::factory()->create([
            'nombre' => 'Categoría de prueba',  // Asegúrate de pasar un nombre
        ]);
        
        $tk = $this->getToken();


        $response = $this->getJson("/api/categories/{$categoria->id}" , [
            'headers'=> [
                'Authorization'=> "Bearer $tk",
                "Content-Type"=> "application/json"
            ] 
              
        ] );

        $response->assertStatus(200);
        
    }
    /** @test */
    public function it_can_update_a_category()
    {
        $tk = $this->getToken();

        $categoria = Categorias::factory()->create([
            'nombre' => 'Categoría de prueba',  // Asegúrate de pasar un nombre
        ]);
        $response = $this->putJson("/api/categories/{$categoria->id}", [
            'name' => 'Updated Category',
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
    public function it_can_delete_a_category()
    {
        $tk = $this->getToken();

        $categoria = Categorias::factory()->create([
            'nombre' => 'Categoría de prueba',  // Asegúrate de pasar un nombre
        ]);

        $response = $this->deleteJson("/api/categories/{$categoria->id}", [

        ], [
            'headers'=> [
                'Authorization'=> "Bearer $tk",
                "Content-Type"=> "application/json"
            ]

        ]);

        $response->assertStatus(200);
        
    }

 
}
