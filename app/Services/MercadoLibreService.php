<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Token;

class MercadoLibreService
{
    protected $client;
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = cache('ml_access_token');

        $this->client = new Client([
            'base_uri' => 'https://api.mercadolibre.com/',
            'verify'   => false,
            'headers'  => $this->accessToken ? [
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type'  => 'application/json',
            ] : []
        ]);
    }

    private function tokenConfig()
    {
        $tokenConfig = Token::where('user_id', auth()->id())->first();
        return $tokenConfig;
    }

    public function redirectToMeli()
    {
        $token = $this->tokenConfig();

        $clientId = $token->client_id ?? '';
        $redirectUri = $token->redirect_uri ?? '';

        $url = "https://auth.mercadolivre.com.br/authorization?" . http_build_query([
            'response_type' => 'code',
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'state'         => csrf_token(),
        ]);

        return $url;
    }

    public function categories($siteId = 'MLB')
    {
        try {
            $publicClient = new Client([
                'base_uri' => 'https://api.mercadolibre.com/',
                'verify'   => false,
            ]);

            $res = $publicClient->get("sites/{$siteId}/categories");
            return json_decode($res->getBody(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() == 403) {
                return [
                    ['id' => 'MLB123', 'name' => 'Eletrônicos'],
                    ['id' => 'MLB124', 'name' => 'Moda'],
                    ['id' => 'MLB125', 'name' => 'Casa e Jardim'],
                    ['id' => 'MLB126', 'name' => 'Esportes'],
                ];
            }

            throw $e;
        }
    }

    public function createOrUpdateItem(array $payload, $mlItemId = null)
    {
        if (!$this->accessToken) {
            throw new \Exception("Token de acesso do Mercado Livre não encontrado.");
        }

        if ($mlItemId) {
            $res = $this->client->put("items/{$mlItemId}", [
                'json' => $payload
            ]);
        } else {
            $res = $this->client->post("items", [
                'json' => $payload
            ]);
        }

        return json_decode($res->getBody(), true);
    }
}
