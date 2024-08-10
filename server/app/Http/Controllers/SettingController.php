<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * @var array|string[] An array of validation rules.
     */
    private array $rules = [
        'organization' => 'required|min:2|max:255',
        'seats' => 'required|integer',
        'address' => 'required|min:3|max:255',
        'phone' => 'required',
        'email' => 'required|email'
    ];

    /**
     * Returns the organization's global application settings.
     */
    public function index(): Response
    {
        // TODO: Return different things for authenticated and non-authenticated users

        $settings = DB::table('settings')->first();

        return response([
            'organization' => [
                'name' => $settings->organization,
                'address' => $settings->address,
                'phone' => $settings->phone,
                'fax' => $settings->fax,
                'email' => $settings->email,
                'website' => $settings->website,
                'seats' => $settings->seats,
                'logo' => $settings->logo,
                'cover' => $settings->cover,
                'tax' => $settings->tax,
            ],
            'version' => '1.0.0-beta.0',
            "database" => config("database.default"),
            "timezone" => config("app.timezone"),
            "other" => PHP_VERSION.'/'.\Illuminate\Foundation\Application::VERSION,
            "extensions" => get_loaded_extensions(),
            "memory_limit" => ini_get("memory_limit"),
            "max_execution_time" => ini_get("max_execution_time"),
            'upload_max_filesize' => ini_get('upload_max_filesize')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): Response
    {
        $validator = Validator::make($request->only('organization', 'seats', 'address', 'phone', 'email'),
            $this->rules);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::table('settings')->where('id', 1)->update([
            'organization' => $request->input('organization'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'fax' => $request->input('fax'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
            'seats' => $request->input('seats'),
            //'logo' => $settings->logo,
            //'cover' => $settings->cover,
            'tax' => $request->input('tax'),
        ]);

        return response()->noContent(200);
    }
}
