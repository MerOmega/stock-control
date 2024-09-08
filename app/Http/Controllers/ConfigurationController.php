<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Retrieve the singleton configuration
        $configuration = Configuration::getSingleton();

        return view('configuration.edit', compact('configuration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'low_stock_alert'  => 'required|integer|min:0',
            'default_per_page' => 'required|integer|min:1',
        ]);

        // Get the singleton configuration
        $configuration = Configuration::getSingleton();

        // Update the configuration
        $configuration->update($request->only('low_stock_alert', 'default_per_page'));

        return redirect()->back()->with('success', trans('messages.configuration.configuration_updated'));
    }
}
