<?php

namespace App\Http\Controllers\Admin\Inspira;

use App\Http\Controllers\Controller;
use App\Models\InspiraSetting;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $settings = [
            'default_frequency' => InspiraSetting::getValue('default_frequency', 'daily'),
            'renewal_reminder_days' => InspiraSetting::getValue('renewal_reminder_days', '3'),
            'anthropic_model' => InspiraSetting::getValue('anthropic_model', env('ANTHROPIC_MODEL', 'claude-sonnet-4-6')),
            'system_prompt' => InspiraSetting::getValue('system_prompt', ''),
        ];

        return view('admin.inspira.config', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'default_frequency' => 'required|in:daily,weekly',
            'renewal_reminder_days' => 'required|integer|min:1|max:30',
            'anthropic_model' => 'required|string|max:255',
            'system_prompt' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            InspiraSetting::setValue($key, $value);
        }

        return redirect()->route('admin.inspira.config')
            ->with('success', 'Configuration Inspira mise à jour.');
    }
}
