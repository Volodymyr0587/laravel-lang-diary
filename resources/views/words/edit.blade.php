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
                    {{-- <form method="POST" action="{{ route('words.update', $word) }}">
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
                    </form> --}}

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

                        <!-- Поле для додавання нових перекладів -->
                        <div id="new-translations">
                            <!-- Тут можна додати JavaScript для динамічного додавання полів -->
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Update Word</button>
                        </div>
                    </form>

                    <!-- JavaScript для додавання нових полів -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const newTranslationsContainer = document.getElementById('new-translations');
                            const translations = @json($word->translations);
                            const languages = @json($languages);

                            function createTranslationField(index, existing = false) {
                                const container = document.createElement('div');
                                container.classList.add('mb-4');

                                const translationLabel = document.createElement('label');
                                translationLabel.setAttribute('for', `translations[${index}][translation]`);
                                translationLabel.classList.add('block', 'text-gray-700');
                                translationLabel.textContent = 'Translation';
                                container.appendChild(translationLabel);

                                const translationInput = document.createElement('input');
                                translationInput.setAttribute('type', 'text');
                                translationInput.setAttribute('id', `translations[${index}][translation]`);
                                translationInput.setAttribute('name', `translations[${index}][translation]`);
                                translationInput.classList.add('form-input', 'mt-1', 'block', 'w-full');
                                if (existing) {
                                    translationInput.value = translations[index].translation;
                                }
                                container.appendChild(translationInput);

                                const languageLabel = document.createElement('label');
                                languageLabel.setAttribute('for', `translations[${index}][language_id]`);
                                languageLabel.classList.add('block', 'text-gray-700', 'mt-2');
                                languageLabel.textContent = 'Language';
                                container.appendChild(languageLabel);

                                const languageSelect = document.createElement('select');
                                languageSelect.setAttribute('id', `translations[${index}][language_id]`);
                                languageSelect.setAttribute('name', `translations[${index}][language_id]`);
                                languageSelect.classList.add('form-select', 'mt-1', 'block', 'w-full');

                                languages.forEach(language => {
                                    const option = document.createElement('option');
                                    option.setAttribute('value', language.id);
                                    option.textContent = language.name;
                                    if (existing && language.id == translations[index].language_id) {
                                        option.setAttribute('selected', 'selected');
                                    }
                                    languageSelect.appendChild(option);
                                });

                                container.appendChild(languageSelect);
                                newTranslationsContainer.appendChild(container);
                            }

                            // Додати всі наявні переклади
                            translations.forEach((translation, index) => {
                                createTranslationField(index, true);
                            });

                            // Додати можливість додавання нових полів
                            const addButton = document.createElement('button');
                            addButton.textContent = 'Add Translation';
                            addButton.classList.add('btn', 'btn-secondary', 'mt-4');
                            addButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const index = newTranslationsContainer.children.length;
                                createTranslationField(index);
                            });
                            newTranslationsContainer.appendChild(addButton);
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
