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

                    {{-- <form action="{{ route('words.update', $word->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Word</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Here You can edit Word and Translation for it</p>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="word" class="block text-sm font-medium leading-6 text-gray-900">Word</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

                                                <input type="text" name="word" id="word" value="{{ $word->word }}" autocomplete="word"
                                                    class="block flex-1 border-0 bg-transparent py-1.5 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                    placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="translation" class="block text-sm font-medium leading-6 text-gray-900">Translation</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

                                                <input type="text" name="translation" id="translation" value="{{ $word->translations }}" autocomplete="translation"
                                                    class="block flex-1 border-0 bg-transparent py-1.5 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                    placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="translation_language_id" class="block text-sm font-medium leading-6 text-gray-900">Translation Language</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

                                                <select type="text" name="translation_language_id" id="translation_language_id"
                                                    class="block flex-1 border-0 bg-transparent py-1.5 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                >
                                                @foreach($languages as $language)
                                                    <option value="{{ $language->id }}" {{ $language->id == $word->translation->language_id ? 'selected' : '' }}>{{ $language->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('words.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </form> --}}

                    <form action="{{ route('words.update', $word) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Edit Word</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Edit the word and its translations</p>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <!-- Word Field -->
                                    <div class="sm:col-span-4">
                                        <label for="word" class="block text-sm font-medium leading-6 text-gray-900">Word</label>
                                        <div class="mt-2">
                                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="word" id="word" autocomplete="word"
                                                    class="block flex-1 border-0 bg-transparent py-1.5 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                    value="{{ old('word', $word->word) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Existing Translations -->
                                    <div class="sm:col-span-4">
                                        <label class="block text-sm font-medium leading-6 text-gray-900">Translations</label>
                                        <div class="mt-2 space-y-4">
                                            @foreach ($word->translations as $index => $translation)
                                                <div class="flex items-center gap-x-4">
                                                    <select name="translations[{{ $index }}][language_id]"
                                                            class="block flex-1 border-0 bg-transparent py-1.5 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                                        @foreach($languages as $language)
                                                            <option value="{{ $language->id }}" {{ $language->id == $translation->language_id ? 'selected' : '' }}>
                                                                {{ $language->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="translations[{{ $index }}][translation]"
                                                           class="block flex-1 border-0 bg-transparent py-1.5 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                           value="{{ old('translations.' . $index . '.translation', $translation->translation) }}"
                                                           placeholder="Translation">
                                                    <input type="hidden" name="translations[{{ $index }}][id]" value="{{ $translation->id }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Add New Translation -->
                                    <div class="sm:col-span-4">
                                        <label for="new_translation" class="block text-sm font-medium leading-6 text-gray-900">Add New Translation</label>
                                        <div class="mt-2 space-y-4">
                                            <div class="flex items-center gap-x-4">
                                                <select name="new_translation_language_id"
                                                        class="block flex-1 border-0 bg-transparent py-1.5 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                                    <option value="">Select Language</option>
                                                    @foreach($languages as $language)
                                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="new_translation"
                                                       class="block flex-1 border-0 bg-transparent py-1.5 pl-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                       placeholder="New Translation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('words.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
