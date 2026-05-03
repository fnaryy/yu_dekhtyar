<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Services\TelegramService;

class LeadController extends Controller
{
    /**
     * Persist a lead and synchronously notify Telegram.
     *
     * Synchronous because volume is low and Telegram typically responds in <500ms;
     * the failure path still saves the lead and records the error so the owner
     * can retry from the admin panel.
     */
    public function store(StoreLeadRequest $request, TelegramService $telegram)
    {
        $lead = Lead::create([
            ...$request->validated(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        $result = $telegram->sendLeadNotification($lead);
        $lead->update([
            'telegram_sent'  => $result['ok'],
            'telegram_error' => $result['ok'] ? null : ($result['error'] ?? null),
        ]);

        return response()->json([
            'ok'      => true,
            'lead_id' => $lead->id,
        ]);
    }
}
