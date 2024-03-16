<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ShowController extends Controller
{
    /**
     * The maximum size of files allowed to be uploaded.
     */
    private int $upload_max_filesize;

    /**
     * Default pagination size.
     */
    private int $paginate = 10;

    /**
     * The default validation rules for Show objects.
     */
    private array $rules = [
        'name' => ['required', 'min:3', 'max:64'],
        'duration' => ['required', 'integer'],
        'description' => ['required', 'min:3', 'max:512'],
        'type_id' => ['required', 'integer'],
        'cover' => ['nullable', 'file', 'max:2048'], // TODO: dynamic upload max file size
        'trailer_url' => ['nullable', 'url'],
        'expiration' => ['nullable', 'date'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $shows = (new Show())->where('id', "!=", 1)->with(['type'])->get();

        return response(['data' => $shows], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response([
                "errors" => $validator->errors()
            ], 422);
        }

        $type = (new \App\Models\ShowType())->find($request->input('type_id'));

        $cover = $request->has('cover') && $request->file('cover')->getSize() > 0
            ? $request->file('cover')->store('shows', 'public')
            : '/storage/default.png';

        $show = (new Show)->create([
            'name' => $request->input('name'),
            'type' => $type->get('name'),
            'type_id' => $request->input('type_id'),
            'duration' => $request->input('duration'),
            'description' => $request->input('description'),
            'is_active' => $request->has('is_active'),
            'trailer_url' => $request->input('trailer_url'),
            'cover' => $cover,
            'creator_id' => $request->user()->id
        ]);

        return response(['data' => $show->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Show $show): Response
    {
        return response($show->load(['type']), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Show $show): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response([
                "message" => "Please fix the following errors and try again",
                "errors" => $validator->errors()
            ], 422);
        }

        if ($request->has('cover') && $request->file('cover')?->getSize() != null) {
            $show['cover'] = $request->file('cover')->store('shows', 'public');
        }

        $show->update([
            'name' => $request->input('name'),
            'type_id' => $request->input('type_id'),
            'duration' => $request->input('duration'),
            'description' => $request->input('description'),
            'is_active' => $request->has('is_active'),
            'trailer_url' => $request->input('trailer_url'),
        ]);

        return response()->noContent(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Show $show)
    {
        //
    }
}
