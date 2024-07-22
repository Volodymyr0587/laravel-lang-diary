<?php

namespace App\Http\Controllers;

use App\Models\Phrase;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PhraseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phrases = auth()->user()->phrases;
        return view('phrases.index', compact('phrases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = auth()->user()->languages;
        return view('phrases.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'phrase' => 'required|string|max:255',
            'translation' => 'required|string|max:255',
            'translation_language_id' => 'required|exists:languages,id',
        ]);

        $phrase = Phrase::create([
            'user_id' => auth()->id(),
            'phrase' => $data['phrase'],
        ]);

        $translation = Translation::create([
            'phrase_id' => $phrase->id,
            'language_id' => $request->translation_language_id,
            'translation' => $data['translation'],
        ]);

        $phrase->languages()->attach($request->translation_language_id);

        return redirect()->route('phrases.index')->with('success', 'Phrase and translation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Phrase $phrase)
    {
        Gate::authorize('editPhrase', $phrase);

        $translations = $phrase->translations()->with('language')->get();

        return view('phrases.show', compact('phrase', 'translations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phrase $phrase)
    {
        Gate::authorize('editPhrase', $phrase);

        $languages = auth()->user()->languages()->get();

        return view('phrases.edit', compact('phrase', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Phrase $phrase)
    {
        $data = $request->validate([
            'phrase' => 'required|string|max:255',
            'translations' => 'array',
            'translations.*.id' => 'nullable|exists:translations,id',
            'translations.*.language_id' => 'required_with:translations|exists:languages,id',
            'translations.*.translation' => 'required_with:translations|string|max:255',
            'new_translation' => 'nullable|string|max:255',
            'new_translation_language_id' => 'nullable|exists:languages,id',
        ]);

        $phrase->update([
            'phrase' => $data['phrase'],
        ]);

        // Оновлення перекладів
        if (isset($data['translations'])) {
            foreach ($data['translations'] as $translationData) {
                if (!empty($translationData['id'])) {
                    // Оновлюємо існуючі переклади
                    $translation = Translation::find($translationData['id']);
                    if ($translation) {
                        $translation->update([
                            'language_id' => $translationData['language_id'],
                            'translation' => $translationData['translation'],
                        ]);
                    }
                }
            }
        }

        // Додаємо новий переклад
        if (!empty($data['new_translation']) && !empty($data['new_translation_language_id'])) {
            Translation::create([
                'phrase_id' => $phrase->id,
                'language_id' => $data['new_translation_language_id'],
                'translation' => $data['new_translation'],
            ]);
        }

        return redirect()->route('phrases.index')->with('success', 'Phrase and translation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phrase $phrase)
    {
        Gate::authorize('editPhrase', $phrase);

        $phrase->delete();

        return redirect()->route('phrases.index')->with('success', 'Phrase deleted successfully');
    }
}
