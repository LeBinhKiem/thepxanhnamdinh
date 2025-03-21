<?php

namespace Modules\Base\Lib;

use Illuminate\Support\Facades\Http;

class ChatGptLib
{
    protected static $instance = null;
    private $message;
    private $data;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ChatGptLib();
        }

        return self::$instance;
    }
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }
    public function get() {
        return $this->data ?? "";
    }

    public function chat()
    {
        try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('CHAT_GPT_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => "gpt-3.5-turbo",
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $this->message ?? ""
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->body();

            $response = json_decode($response, true);
            $this->data = $response['choices'][0]['message']['content'];
        } catch (\Throwable $e) {
            $this->data = "Đẩy quá số lần quy định! Vui lòng thử lại trong 20s";
        }
        return $this;
    }
}