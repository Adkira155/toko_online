<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BinderbyteService
{
    protected $client;
    protected $apiKey;
    protected $cekOngkir;

    public function __construct()
    {
        $this->apiKey = env('BINDERBYTE_API_KEY');

        $this->client = new Client([
            'base_uri' => 'https://api.binderbyte.com/wilayah/',
            'timeout'  => 10.0,
        ]);

        $this->cekOngkir = new Client([
            'base_uri' => 'http://api.binderbyte.com/v1/cost',
            'timeout' => 10.0,
        ]);
    }

    public function getProvinces()
    {
        return Cache::remember('provinces', now()->addDay(), function () {
            try {
                $response = $this->client->get('provinsi', [
                    'query' => ['api_key' => $this->apiKey],
                ]);

                $responseData = json_decode($response->getBody(), true);

                if (!isset($responseData['value']) || !is_array($responseData['value'])) {
                    throw new \Exception('Format data provinsi tidak valid');
                }

                return $responseData['value'];
            } catch (RequestException $e) {
                Log::error('Error saat mengambil data provinsi: ' . $e->getMessage());
                return [];
            } catch (\Exception $e) {
                Log::error('Kesalahan saat mengambil data provinsi: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getCities($provinceId)
    {
        $cacheKey = "cities_{$provinceId}";
    
        return Cache::remember($cacheKey, now()->addDay(), function () use ($provinceId, $cacheKey) {
            try {
                $response = $this->client->get('kabupaten', [
                    'query' => ['api_key' => $this->apiKey, 'id_provinsi' => $provinceId],
                ]);
    
                $responseData = json_decode($response->getBody(), true);
    
                // Log response untuk debugging
                Log::info("Response dari API kota untuk provinsi {$provinceId}", $responseData);
    
                // Validasi format data
                if (!isset($responseData['value']) || !is_array($responseData['value'])) {
                    Log::warning("Format data kota tidak valid untuk provinsi {$provinceId}");
                    Cache::forget($cacheKey); // Hapus cache jika data tidak valid
                    return [];
                }
    
                return $responseData['value'];
            } catch (RequestException $e) {
                Log::error("Error HTTP saat mengambil data kota untuk provinsi {$provinceId}: " . $e->getMessage());
                Cache::forget($cacheKey); // Hapus cache jika terjadi kesalahan HTTP
                return [];
            } catch (\Exception $e) {
                Log::error("Kesalahan umum saat mengambil data kota untuk provinsi {$provinceId}: " . $e->getMessage());
                Cache::forget($cacheKey); // Hapus cache jika ada error lain
                return [];
            }
        });
    }

    public function cekOngkir($originCityId, $destinationCityId, $weight, $courier)
    {
        try {
            Log::info('Parameter cekOngkir:', [
                'originCityId' => $originCityId,
                'destinationCityId' => $destinationCityId,
                'weight' => $weight,
                'courier' => $courier,
            ]);

            $response = $this->cekOngkir->get('cost', [
                'query' => [
                    'api_key' => $this->apiKey,
                    'origin' => $originCityId,
                    'destination' => $destinationCityId,
                    'weight' => $weight,
                    'courier' => $courier,
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            Log::info('Respons API cekOngkir:', $responseData);

            if (!isset($responseData['status']) || $responseData['status'] !== 200) {
                Log::error('Gagal mengambil ongkir', ['response' => $responseData]);
                return null;
            }

            return $responseData['results'] ?? null;
        } catch (\Exception $e) {
            Log::error('Kesalahan saat cek ongkir: ' . $e->getMessage());
            return null;
        }
    }
    // public function cekOngkir($originCityId, $destinationCityId, $weight, $courier)
    // {
    //     try {
    //         $response = $this->cekOngkir->get('cost', [
    //             'query' => [
    //                 'api_key' => $this->apiKey,
    //                 'origin' => $originCityId,
    //                 'destination' => $destinationCityId,
    //                 'weight' => $weight,
    //                 'courier' => $courier,
    //             ],
    //         ]);

    //         $responseData = json_decode($response->getBody(), true);

    //         if (!isset($responseData['status']) || $responseData['status'] !== 200) {
    //             Log::error('Gagal mengambil ongkir', ['response' => $responseData]);
    //             return null;
    //         }

    //         return $responseData['results'] ?? null;
    //     } catch (\Exception $e) {
    //         Log::error('Kesalahan saat cek ongkir: ' . $e->getMessage());
    //         return null;
    //     }
    // }
}