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
    protected bool $verifySsl;
    protected array $defaultQuery;
    protected array $headers;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('quran.api.url', 'https://aswaja.tama.my.id/api/v1'), '/');
        $this->apiKey = config('quran.api.key', '');
        $this->timeout = (int) config('quran.api.timeout', 10);
        $this->connectTimeout = (int) config('quran.api.connect_timeout', 3);
        $this->verifySsl = (bool) config('quran.api.verify_ssl', false);
        $this->defaultQuery = $this->withoutNullValues((array) config('quran.api.default_query', []));
        $this->headers = $this->withoutNullValues((array) config('quran.api.headers', []));

        if ($this->apiKey !== '' && !isset($this->headers['X-Api-Key'])) {
            $this->headers['X-Api-Key'] = $this->apiKey;
        }
    }

    public function endpoint(string $key, array $replacements = []): string
    {
        $template = (string) config("quran.api.endpoints.{$key}", $key);

        foreach ($replacements as $placeholder => $value) {
            $template = str_replace(
                '{' . $placeholder . '}',
                rawurlencode((string) $value),
                $template
            );
        }

        return ltrim($template, '/');
    }

    public function get(string $endpoint, array $queryParams = []): ?array
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        $startTime = microtime(true);

        try {
            $response = $this->request()->get($url, $this->mergeQuery($queryParams));
            $latency = round((microtime(true) - $startTime) * 1000, 2);

            if ($response->successful()) {
                $data = $response->json();
                if (!is_array($data)) {
                    return null;
                }
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
            $response = $this->request()->get($url, $this->mergeQuery($queryParams));

            if ($response->successful()) {
                $data = $response->json();
                return is_array($data) ? $data : null;
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

    protected function request()
    {
        $request = Http::timeout($this->timeout)
            ->connectTimeout($this->connectTimeout)
            ->acceptJson();

        if (!$this->verifySsl) {
            $request = $request->withoutVerifying();
        }

        if ($this->headers !== []) {
            $request = $request->withHeaders($this->headers);
        }

        return $request;
    }

    protected function mergeQuery(array $queryParams): array
    {
        return array_merge($this->defaultQuery, $this->withoutNullValues($queryParams));
    }

    protected function withoutNullValues(array $values): array
    {
        return array_filter($values, static fn ($value) => $value !== null && $value !== '');
    }
}
