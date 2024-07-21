<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $languages = $user->languages()->get();
        return view('languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('languages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $language = new Language($data);

        $language->user()->associate($user);

        $language->save();

        return redirect()->route('languages.index')->with('success', 'Language created successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        Gate::authorize('editLanguage', $language);
        return view('languages.show', compact('language'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        return view('languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        Gate::authorize('editLanguage', $language);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $language->update($data);

        return redirect()->route('languages.index')->with('success', 'Language updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        Gate::authorize('editLanguage', $language);

        $language->delete();

        return redirect()->route('languages.index')->with('success', 'Language deleted successfully');
    }
}
