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

        $word = new Word([
            'word' => $data['word'],
            'user_id' => auth()->id(),
        ]);

        $word->save();

        $translation = new Translation([
            'word_id' => $word->id,
            'language_id' => $data['translation_language_id'],
            'translation' => $data['translation'],
        ]);

        $translation->save();

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
        $languages = auth()->user()->languages;
        $translation = $word->translations->first();

        return view('words.edit', compact('word', 'languages', 'translation'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Word $word)
    // {
    //     $data = $request->validate([
    //         'word' => 'required|string|max:255',
    //         'translations' => 'nullable|array',
    //         'translations.*.translation' => 'required|string|max:255',
    //         'translations.*.language_id' => 'required|exists:languages,id',
    //     ]);

    //     // Оновлення слова
    //     $word->update([
    //         'word' => $data['word'],
    //     ]);

    //     // Видалення старих перекладів
    //     $word->translations()->delete();

    //     // Додавання нових перекладів
    //     if (isset($data['translations'])) {
    //         foreach ($data['translations'] as $translationData) {
    //             Translation::create([
    //                 'word_id' => $word->id,
    //                 'language_id' => $translationData['language_id'],
    //                 'translation' => $translationData['translation'],
    //             ]);
    //         }
    //     }

    //     return redirect()->route('words.index')->with('success', 'Word and translations updated successfully');
    // }

    public function update(Request $request, Word $word)
    {
        $data = $request->validate([
            'word' => 'required|string|max:255',
            'translations' => 'nullable|array',
            'translations.*.translation' => 'required|string|max:255',
            'translations.*.language_id' => 'required|exists:languages,id',
        ]);

        // Оновлення слова
        $word->update([
            'word' => $data['word'],
        ]);

        // Збір ID мов, для яких потрібно додати нові переклади
        $existingLanguageIds = $word->translations->pluck('language_id')->toArray();
        $newLanguageIds = array_column($data['translations'], 'language_id');

        // Видалення старих перекладів, якщо мова більше не вибрана
        foreach ($word->translations as $translation) {
            if (!in_array($translation->language_id, $newLanguageIds)) {
                $translation->delete();
            }
        }

        // Додавання нових перекладів
        foreach ($data['translations'] as $translationData) {
            $translation = Translation::updateOrCreate(
                [
                    'word_id' => $word->id,
                    'language_id' => $translationData['language_id'],
                ],
                [
                    'translation' => $translationData['translation'],
                ]
            );
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
