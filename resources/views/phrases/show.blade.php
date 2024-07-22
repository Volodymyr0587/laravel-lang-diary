<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Phrase Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h1 class="text-2xl font-bold mb-4">{{ $phrase->phrase }}</h1>

                    <h3 class="text-xl font-semibold mb-2">Translations:</h3>

                    @if ($translations->isEmpty())
                        <p>No translations available.</p>
                    @else
                        <ul class="list-disc pl-5">
                            @foreach ($translations as $translation)
                                <li>
                                    <strong>{{ $translation->language->name }}:</strong>
                                    {{ $translation->translation }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

