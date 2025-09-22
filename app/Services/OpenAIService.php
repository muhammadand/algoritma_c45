<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY'); // Ambil API Key dari .env
        $this->apiUrl = env('OPENAI_API_URL'); // Ambil API URL dari .env
    }

    public function sendMessage($message)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('https://api.openai.com/v1/completions', [
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => [
                        ['role' => 'user', 'content' => $message],
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ]
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Tangani error dari API
            return [
                'error' => 'Error connecting to OpenAI API: ' . $e->getMessage(),
            ];
        }
    }
    
}
