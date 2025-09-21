<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\MercadoLibreService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create(MercadoLibreService $ml)
    {
        $categories = $ml->categories();
        return view('products.form', compact('categories'));
    }

    public function store(Request $r, MercadoLibreService $ml)
    {
        $r->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'images.*' => 'image|max:2048'
        ]);

        $product = Product::create($r->only('name', 'description', 'price', 'stock', 'category_id'));
        $pictures = [];
        if ($r->hasFile('images')) {
            foreach ($r->file('images') as $file) {
                try {
                    $path = $file->store('products');
                    // $pic = $ml->uploadPicture($path);
                    // $pictures[] = ['source' => $pic['secure_url']];
                } catch (\Exception $e) {
                    return back()->withErrors(['images' => 'Erro ao enviar imagem: ' . $e->getMessage()]);
                }
            }
        }

        $payload = [
            'title' => $product->name,
            'category_id' => $product->category_id,
            'price' => (float)$product->price,
            'currency_id' => 'BRL',
            'available_quantity' => (int)$product->stock,
            'buying_mode' => 'buy_it_now',
            'listing_type_id' => 'gold_special',
            'condition' => 'new',
            'description' => ['plain_text' => $product->description],
            'pictures' => $pictures,
        ];

        try {
            $resp = $ml->createOrUpdateItem($payload);
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with(['error' =>  'Produto cadastrado, porém, houve um erro ao enviar produto ao Mercado Livre: ' . $e->getMessage()]);
        }

        $product->ml_item_id = $resp['id'] ?? null;
        $product->ml_status = $resp['status'] ?? null;
        $product->ml_response = $resp;
        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Produto enviado ao Mercado Livre');
    }

    public function edit(Product $product, MercadoLibreService $ml)
    {
        $categories = $ml->categories();
        return view('products.form', compact('product', 'categories'));
    }

    public function update(Request $r, Product $product, MercadoLibreService $ml)
    {
        $product->update($r->only('name', 'description', 'price', 'stock', 'category_id'));

        $payload = [
            'title' => $product->name,
            'price' => (float)$product->price,
            'available_quantity' => (int)$product->stock,
            'description' => ['plain_text' => $product->description],
        ];

        try {
            $resp = $ml->createOrUpdateItem($payload, $product->ml_item_id);
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with(['error' => 'Produto alterado, porém, houve um erro ao enviar alteração ao Mercado Livre: ' . $e->getMessage()]);
        }

        $product->ml_status = $resp['status'] ?? null;
        $product->ml_response = $resp;
        $product->save();

        return back()->with('success', 'Produto atualizado');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produto removido com sucesso');
    }
}
