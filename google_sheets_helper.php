<?php
// Google Sheets API Helper Functions
require_once 'google_sheets_config.php';

class GoogleSheetsHelper {
    private $access_token;
    private $sheet_id;
    
    public function __construct() {
        global $google_service_account_file, $google_sheet_id;
        $this->sheet_id = $google_sheet_id;
        $this->access_token = $this->getAccessToken($google_service_account_file);
    }
    
    private function getAccessToken($service_account_file) {
        // Read service account JSON
        if (!file_exists($service_account_file)) {
            throw new Exception("Service account file not found: " . $service_account_file);
        }
        
        $service_account = json_decode(file_get_contents($service_account_file), true);
        
        // Create JWT assertion
        $header = json_encode(['typ' => 'JWT', 'alg' => 'RS256']);
        $now = time();
        $payload = json_encode([
            'iss' => $service_account['client_email'],
            'scope' => 'https://www.googleapis.com/auth/spreadsheets',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ]);
        
        $base64_header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64_payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature_input = $base64_header . '.' . $base64_payload;
        
        // Sign with private key
        $private_key = openssl_pkey_get_private($service_account['private_key']);
        openssl_sign($signature_input, $signature, $private_key, 'sha256');
        openssl_free_key($private_key);
        
        $base64_signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $signature_input . '.' . $base64_signature;
        
        // Exchange JWT for access token
        $token_data = http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $token_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // For InfinityFree compatibility - uncomment if SSL issues occur
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $token_response = json_decode($response, true);
        
        if ($http_code !== 200 || !isset($token_response['access_token'])) {
            throw new Exception("Failed to get access token. HTTP Code: $http_code, Response: $response");
        }
        
        return $token_response['access_token'];
    }
    
    public function appendToSheet($sheet_name, $values) {
        global $google_sheets_api_base;
        
        $url = $google_sheets_api_base . '/' . $this->sheet_id . '/values/' . urlencode($sheet_name) . ':append';
        
        $data = json_encode([
            'values' => [$values],
            'majorDimension' => 'ROWS'
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?valueInputOption=RAW');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->access_token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // For InfinityFree compatibility - uncomment if SSL issues occur
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code !== 200) {
            throw new Exception("Failed to append to sheet: " . $response);
        }
        
        return json_decode($response, true);
    }
    
    public function addRSVPEntry($id, $nama, $jumlah_pax, $hubungan, $status, $created_at) {
        global $rsvp_sheet_name;
        
        $values = [
            $id,
            $nama,
            $jumlah_pax,
            $hubungan,
            $status,
            $created_at
        ];
        
        return $this->appendToSheet($rsvp_sheet_name, $values);
    }
    
    public function addUcapanEntry($id, $nama_tetamu, $ucapan_tetamu, $created_at = null) {
        global $ucapan_sheet_name;
        
        if ($created_at === null) {
            $created_at = date('Y-m-d H:i:s');
        }
        
        $values = [
            $id,
            $nama_tetamu,
            $ucapan_tetamu,
            $created_at
        ];
        
        return $this->appendToSheet($ucapan_sheet_name, $values);
    }
}
?>