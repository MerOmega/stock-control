<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Models\Configuration;

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
    public function update(ConfigRequest $request)
    {
        // Get the singleton configuration
        $configuration = Configuration::getSingleton();

        // Update the configuration
        $configuration->update($request->only('low_stock_alert', 'default_per_page'));

        return redirect()->back()->with('success', trans('messages.configuration.configuration_updated'));
    }
}
