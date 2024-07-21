<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Word') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('words.update', $word) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="word" class="block text-gray-700">Word</label>
                            <input type="text" id="word" name="word" value="{{ old('word', $word->word) }}" class="form-input mt-1 block w-full" required>
                        </div>

                        <h3 class="text-xl font-semibold mb-2">Translations:</h3>

                        @foreach ($word->translations as $index => $translation)
                            <div class="mb-4">
                                <label for="translations[{{ $index }}][translation]" class="block text-gray-700">Translation</label>
                                <input type="text" id="translations[{{ $index }}][translation]" name="translations[{{ $index }}][translation]" value="{{ old('translations.' . $index . '.translation', $translation->translation) }}" class="form-input mt-1 block w-full" required>

                                <label for="translations[{{ $index }}][language_id]" class="block text-gray-700 mt-2">Language</label>
                                <select id="translations[{{ $index }}][language_id]" name="translations[{{ $index }}][language_id]" class="form-select mt-1 block w-full" required>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}" {{ $language->id == $translation->language_id ? 'selected' : '' }}>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Update Word</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
