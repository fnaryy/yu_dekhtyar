<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Sends formatted lead notifications to a Telegram chat via the Bot API.
 *
 * Token + chat ID are read from config('services.telegram.*'), which is
 * populated from .env. Never expose these to client-side code.
 */
class TelegramService
{
    private const API_BASE = 'https://api.telegram.org/bot';

    /**
     * @return array{ok: bool, error?: string}
     */
    public function sendLeadNotification(Lead $lead): array
    {
        $token  = (string) config('services.telegram.token');
        $chatId = (string) config('services.telegram.chat_id');

        if ($token === '' || $chatId === '') {
            return ['ok' => false, 'error' => 'Telegram credentials are not configured'];
        }

        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post(self::API_BASE . $token . '/sendMessage', [
                    'chat_id'    => $chatId,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                    'text'       => $this->formatMessage($lead),
                ]);

            if ($response->successful() && $response->json('ok') === true) {
                return ['ok' => true];
            }

            $error = $response->json('description') ?? 'HTTP ' . $response->status();
            Log::warning('Telegram sendMessage failed', ['lead_id' => $lead->id, 'error' => $error]);
            return ['ok' => false, 'error' => $error];

        } catch (\Throwable $e) {
            Log::error('Telegram exception', ['lead_id' => $lead->id, 'message' => $e->getMessage()]);
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    private function formatMessage(Lead $lead): string
    {
        $esc = fn (?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $lines = [
            '<b>🆕 НОВАЯ ЗАЯВКА #' . $lead->id . '</b>',
            '',
            '<b>Имя:</b> ' . $esc($lead->name),
            '<b>Компания:</b> ' . $esc($lead->company),
            '<b>Контакт:</b> <code>' . $esc($lead->contact) . '</code>',
        ];

        if ($lead->phone) {
            $lines[] = '<b>Телефон:</b> <code>' . $esc($lead->phone) . '</code>';
        }

        if ($lead->message) {
            $lines[] = '';
            $lines[] = '<b>Сообщение:</b>';
            $lines[] = $esc($lead->message);
        }

        $lines[] = '';
        $lines[] = '<i>Получено: ' . $lead->created_at->format('d.m.Y H:i') . '</i>';

        return implode("\n", $lines);
    }
}
