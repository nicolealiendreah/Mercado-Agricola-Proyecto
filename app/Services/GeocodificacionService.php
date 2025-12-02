<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodificacionService
{
    /**
     * Obtiene información geográfica (departamento, municipio, provincia, ciudad) desde coordenadas
     * usando la API de Nominatim (OpenStreetMap)
     * 
     * @param float $latitud
     * @param float $longitud
     * @return array|null
     */
    public function obtenerInformacionGeografica(float $latitud, float $longitud): ?array
    {
        try {
            // API de Nominatim (OpenStreetMap) - gratuita y sin API key
            $url = 'https://nominatim.openstreetmap.org/reverse';
            
            $response = Http::withHeaders([
                'User-Agent' => 'MercadoAgricola/1.0', // Requerido por Nominatim
                'Accept-Language' => 'es'
            ])->get($url, [
                'format' => 'json',
                'lat' => $latitud,
                'lon' => $longitud,
                'addressdetails' => 1,
                'zoom' => 10
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['address'])) {
                    $address = $data['address'];
                    
                    // Extraer información para Bolivia
                    $departamento = $this->extraerDepartamento($address);
                    $municipio = $this->extraerMunicipio($address);
                    $provincia = $this->extraerProvincia($address);
                    $ciudad = $this->extraerCiudad($address);
                    
                    return [
                        'departamento' => $departamento,
                        'municipio' => $municipio,
                        'provincia' => $provincia,
                        'ciudad' => $ciudad,
                        'direccion_completa' => $data['display_name'] ?? null
                    ];
                }
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error en geocodificación inversa: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Extrae el departamento de la dirección
     */
    private function extraerDepartamento(array $address): ?string
    {
        // En Bolivia, el departamento puede venir como 'state' o 'region'
        return $address['state'] ?? $address['region'] ?? null;
    }

    /**
     * Extrae el municipio de la dirección
     */
    private function extraerMunicipio(array $address): ?string
    {
        // En Bolivia, el municipio puede venir como 'municipality', 'city', 'town' o 'village'
        return $address['municipality'] ?? $address['city'] ?? $address['town'] ?? $address['village'] ?? null;
    }

    /**
     * Extrae la provincia de la dirección
     */
    private function extraerProvincia(array $address): ?string
    {
        // En Bolivia, la provincia puede venir como 'province' o 'county'
        return $address['province'] ?? $address['county'] ?? null;
    }

    /**
     * Extrae la ciudad de la dirección
     */
    private function extraerCiudad(array $address): ?string
    {
        // La ciudad puede venir como 'city', 'town', 'village' o 'municipality'
        return $address['city'] ?? $address['town'] ?? $address['village'] ?? $address['municipality'] ?? null;
    }
}
