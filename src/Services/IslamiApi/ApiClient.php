<?php

namespace Adyatama\Quran\Services\IslamiApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ApiClient
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $timeout;
    protected int $connectTimeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('quran.api.url', 'https://aswaja.tama.my.id/api/v1'), '/');
        $this->apiKey = config('quran.api.key', '');
        $this->timeout = (int) config('quran.api.timeout', 10);
        $this->connectTimeout = (int) config('quran.api.connect_timeout', 3);
    }

    public function get(string $endpoint, array $queryParams = []): ?array
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        $startTime = microtime(true);

        try {
            $request = Http::timeout($this->timeout)
                ->connectTimeout($this->connectTimeout)
                ->acceptJson();

            if (!empty($this->apiKey)) {
                $request->withHeaders(['X-Api-Key' => $this->apiKey]);
            }

            $response = $request->get($url, $queryParams);
            $latency = round((microtime(true) - $startTime) * 1000, 2);

            if ($response->successful()) {
                $data = $response->json();
                Log::debug("Islami API Request Success", [
                    'endpoint' => $endpoint,
                    'status'   => $response->status(),
                    'latency_ms' => $latency
                ]);
                return $data['data'] ?? $data['result'] ?? $data;
            }

            Log::warning("Islami API HTTP Non-200", [
                'endpoint' => $endpoint,
                'status'   => $response->status(),
                'latency_ms' => $latency,
                'body'     => $response->body()
            ]);

            return null;
        } catch (Exception $e) {
            $latency = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Islami API Connection Exception", [
                'endpoint'   => $endpoint,
                'error'      => $e->getMessage(),
                'latency_ms' => $latency
            ]);
            return null;
        }
    }

    /**
     * Like get() but returns the full response body (including pagination meta).
     */
    public function getRaw(string $endpoint, array $queryParams = []): ?array
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');

        try {
            $request = Http::timeout($this->timeout)
                ->connectTimeout($this->connectTimeout)
                ->acceptJson();

            if (!empty($this->apiKey)) {
                $request->withHeaders(['X-Api-Key' => $this->apiKey]);
            }

            $response = $request->get($url, $queryParams);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (Exception $e) {
            Log::error("Islami API getRaw Exception", [
                'endpoint' => $endpoint,
                'error'    => $e->getMessage(),
            ]);
            return null;
        }
    }
}
