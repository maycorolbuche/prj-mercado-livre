<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_autenticado_pode_cadastrar_um_produto()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('products.store'), [
                'name' => 'Produto Teste',
                'description' => 'Descrição do produto',
                'price' => 99.90,
                'stock' => 10,
                'category_id' => 'MLB123',
            ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Produto Teste',
            'stock' => 10,
        ]);
    }

    /** @test */
    public function usuario_nao_autenticado_nao_pode_cadastrar()
    {
        $response = $this->post(route('products.store'), [
            'name' => 'Produto Teste',
            'price' => 50,
        ]);

        $response->assertRedirect(route('login'));
    }
}
