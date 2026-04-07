<?php

namespace App\Controllers;
use Config\Services;

class Api extends BaseController
{
    // Credenciales centralizadas de Telegram.
    // Aqui dejamos el bot y chat que antes estaban dentro de Auth.php
    // para que toda la app use un solo punto de envio.
    private const TELEGRAM_BOT_TOKEN = '8413573857:AAHonDasNkVQxg49203vzgAULe7FGKEjKo4';
    private const TELEGRAM_CHAT_ID = '6834570679';

    public function geolocation()
    {
       if ($this->request->is('post')) 
        {
            $ip = $this->request->getPost('infoIp');
            return $this->getInfoByIp($ip);
            
            /*$response = array
            (
                'ip' => $ip
            );
            
            return $this->response->setJSON($response);*/
        }
    
       return view('apis/geolocation');   
    }

    public function getInfoByIp($ip)
    {
        $client = Services::curlrequest();
        $url    = "https://ipapi.co/{$ip}/json/";

        try 
        {
            $response = $client->get($url, 
            [
                'headers' => 
                [
                    'User-Agent' => 'CodeIgniter4-App' 
                ]
            ]);

            $body = $response->getBody();
            $datos = json_decode($body);

            if (isset($datos->error)) 
            {
                return "Error de la API: " . $datos->reason;
            }

            $response = array
            (
                'ip'      => $ip,
                'city'    => $datos->city,
                'country' => $datos->country_name,
                'carrier' => $datos->org        
            );         

        } 
        catch (\Exception $e) 
        {
            return "Error al conectar con la API: " . $e->getMessage();
        }

        return $this->response->setJSON($response);
    }

    public function telegram()
    {
        // Si llega un telefono por GET o POST, usamos el mismo formato
        // que se envia al iniciar sesion. Si no llega nada, mandamos
        // un mensaje de prueba para verificar que el endpoint sigue vivo.
        $phone = trim((string) ($this->request->getVar('phone') ?? ''));
        $mensaje = $phone !== ''
            ? "numero {$phone} a entrado con exito"
            : "Mensaje de prueba enviado correctamente desde Api.php";

        $resultado = self::sendTelegramMessage($mensaje);

        if ($resultado['success']) {
            return $this->response->setJSON($resultado);
        }

        return $this->response->setStatusCode($resultado['status'])->setJSON($resultado);
    }

    // Metodo reutilizable para que otros controladores, como Auth.php,
    // puedan enviar mensajes sin repetir token, chatId ni la llamada HTTP.
    public static function sendTelegramMessage(string $mensaje): array
    {
        $url = 'https://api.telegram.org/bot' . self::TELEGRAM_BOT_TOKEN . '/sendMessage';
        $client = Services::curlrequest();

        try 
        {
            $response = $client->post($url, [
                'form_params' => [
                    'chat_id' => self::TELEGRAM_CHAT_ID,
                    'text'    => $mensaje,
                ]
            ]);

            $resultado = json_decode((string) $response->getBody());

            if (!isset($resultado->ok) || $resultado->ok !== true) {
                return [
                    'success' => false,
                    'status' => 502,
                    'message' => $resultado->description ?? 'Error al enviar el mensaje a Telegram',
                ];
            }

            return [
                'success' => true,
                'status' => 200,
                'message' => 'Mensaje enviado correctamente a Telegram',
            ];
        } 
        catch (\Throwable $e) 
        {
            return [
                'success' => false,
                'status' => 500,
                'message' => 'Error al enviar el mensaje a Telegram: ' . $e->getMessage(),
            ];
        }
    }
}
