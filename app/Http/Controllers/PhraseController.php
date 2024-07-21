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

        $phrase = new Phrase([
            'phrase' => $data['phrase'],
            'user_id' => auth()->id(),
        ]);

        $phrase->save();

        $translation = new Translation([
            'phrase_id' => $phrase->id,
            'language_id' => $data['translation_language_id'],
            'translation' => $data['translation'],
        ]);

        $translation->save();

        return redirect()->route('phrases.index')->with('success', 'Phrase and translation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Phrase $phrase)
    {
        Gate::authorize('editPhrase', $phrase);
        return view('phrases.show', compact('phrase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phrase $phrase)
    {
        $languages = auth()->user()->languages;
        $translation = $phrase->translations->first(); // Assuming one translation for simplicity
        return view('phrases.edit', compact('phrase', 'languages', 'translation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Phrase $phrase)
    {
        $data = $request->validate([
            'phrase' => 'required|string|max:255',
            'translation' => 'required|string|max:255',
            'translation_language_id' => 'required|exists:languages,id',
        ]);

        $phrase->update([
            'phrase' => $data['phrase'],
        ]);

        $translation = $phrase->translations->first(); // Assuming one translation for simplicity
        if ($translation) {
            $translation->update([
                'translation' => $data['translation'],
                'language_id' => $data['translation_language_id'],
            ]);
        } else {
            $translation = new Translation([
                'phrase_id' => $phrase->id,
                'language_id' => $data['translation_language_id'],
                'translation' => $data['translation'],
            ]);
            $translation->save();
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
