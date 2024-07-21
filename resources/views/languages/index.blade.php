<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Languages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                          <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <a href="{{ route('languages.create') }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Add Language
                            </a>
                            <div class="overflow-hidden">
                              <table
                                class="min-w-full text-left text-sm font-light text-surface">
                                <thead
                                  class="border-b border-neutral-200 font-medium">
                                  <tr>
                                    <th scope="col" class="px-6 py-4">#</th>
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4"></th>
                                    <th scope="col" class="px-6 py-4"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach ($languages as $language)
                                  <tr class="border-b border-neutral-200">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="{{ route('languages.show', $language) }}">{{ $language->name }}</a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="{{ route('languages.edit', $language) }}">Edit</a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <form action="{{ route('languages.destroy', $language) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Delete</button>
                                        </form>
                                    </td>
                                  </tr>
                                @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
