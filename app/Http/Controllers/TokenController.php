<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index()
    {
        $token = Token::where('user_id', auth()->id())->first();
        return view('token.index', compact('token'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'access_token' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
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
