<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use App\Services\MercadoLibreService;

class TokenController extends Controller
{
    public function index(MercadoLibreService $ml)
    {
        $url_meli = $ml->redirectToMeli();
        $token = Token::where('user_id', auth()->id())->first();
        return view('token.index', compact('token', 'url_meli'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'redirect_uri' => 'required|url',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        $token = Token::where('user_id', auth()->id())->first();

        if ($token) {
            $token->update($data);
            $message = 'Token atualizado com sucesso!';
        } else {
            Token::create($data);
            $message = 'Token cadastrado com sucesso!';
        }

        return redirect()->route('token.index')->with('success', $message);
    }
}
