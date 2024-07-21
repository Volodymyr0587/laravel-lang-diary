<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $words = auth()->user()->words;
        return view('words.index', compact('words'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = auth()->user()->languages;
        return view('words.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'word' => 'required|string|max:255',
            'translation' => 'required|string|max:255',
            'translation_language_id' => 'required|exists:languages,id',
        ]);

        $word = Word::create([
            'user_id' => auth()->id(),
            'word' => $data['word'],
        ]);

        $translation = Translation::create([
            'word_id' => $word->id,
            'language_id' => $request->translation_language_id,
            'translation' => $data['translation'],
        ]);

        $word->languages()->attach($request->translation_language_id);

        return redirect()->route('words.index')->with('success', 'Word and translation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Word $word)
    {
        Gate::authorize('editWord', $word);

        $translations = $word->translations()->with('language')->get();

        return view('words.show', compact('word', 'translations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Word $word)
    {
        Gate::authorize('editWord', $word);

        $languages = auth()->user()->languages()->get(); // Отримання всіх мов

        return view('words.edit', compact('word', 'languages'));
    }

     /**
     * Update a resource in storage.
     */
    public function update(Request $request, Word $word)
    {
        $data = $request->validate([
            'word' => 'required|string|max:255',
            'translations' => 'array',
            'translations.*.id' => 'nullable|exists:translations,id',
            'translations.*.language_id' => 'required_with:translations|exists:languages,id',
            'translations.*.translation' => 'required_with:translations|string|max:255',
            'new_translation' => 'nullable|string|max:255',
            'new_translation_language_id' => 'nullable|exists:languages,id',
        ]);

        // Оновлення слова
        $word->update([
            'word' => $data['word'],
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
                'word_id' => $word->id,
                'language_id' => $data['new_translation_language_id'],
                'translation' => $data['new_translation'],
            ]);
        }

        return redirect()->route('words.index')->with('success', 'Word and translations updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word)
    {
        Gate::authorize('editWord', $word);

        $word->delete();

        return redirect()->route('words.index')->with('success', 'Word deleted successfully');
    }
}
