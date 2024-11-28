<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class userControllerTest extends TestCase
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

    public function it_can_list_all_users()
    {
        $tk = $this->getToken();
        $response = $this->getJson('/api/getUsers', [
            'headers'=> [
                'Authorization'=> "Bearer $tk",
                "Content-Type"=> "application/json"
            ] 
              
        ]);

        $response->assertStatus(200);

    }

      /** @test */
    public function it_can_show_users_by_id()
    {
        $tk = $this->getToken();
        
        $usuario = User::factory()->create([
            'name' => 'luis',
            'email' => 'example11@example.com',
            'email_verified_at' => '2024-10-10',
            'password' => '12345678',
        ]);
        


        $response = $this->getJson("api/getUser/{$usuario->id}" , [
            'headers'=> [
                'Authorization'=> "Bearer $tk",
                "Content-Type"=> "application/json"
            ] 
              
        ] );

        $response->assertStatus(200);
        
    }

       /** @test */

       public function it_can_create_user()
       {
            
   
           $response = $this->postJson('/api/register', [
               'name' => 'Luis',
               'email' => 'exaple7@example2.com', 
               'password' => '12345678',  
               'rol' => 'user',  
               
           ]);
   
   
           $response->assertStatus(201);
           
       }
      /** @test */
       public function it_can_update_user()
       {
            $tk = $this->getToken();
            
   
            $usuario = User::factory()->create([
                'name' => 'luis',
                'email' => 'example80@example.com',
                'email_verified_at' => '2024-10-10',
                'password' => '12345678',
            ]);
            
   
           $response = $this->putJson("/api/getUser/{$usuario->id}", [
            'name' => 'Luis modify',
            'email' => 'exaple80@updated.com', 
            'password' => '12345678',  
            'rol' => 'admin',  
        ], ['headers'=> [
            'Authorization'=> "Bearer $tk",
            "Content-Type"=> "application/json"
        ]]);

        $response->assertStatus(200);
       
       }

   /** @test */
       public function it_can_delete_a_gastos()
       {
           $tk = $this->getToken();
   
           $categoria = User::factory()->create([
            'name' => 'luis',
            'email' => 'example9@example.com',
            'email_verified_at' => '2024-10-10',
            'password' => '12345678',
           ]);
   
           $response = $this->deleteJson("/api/getUser/{$categoria->id}", [
   
           ], [
               'headers'=> [
                   'Authorization'=> "Bearer $tk",
                   "Content-Type"=> "application/json"
               ]
   
           ]);
   
           $response->assertStatus(200);
           
       }
   
}
