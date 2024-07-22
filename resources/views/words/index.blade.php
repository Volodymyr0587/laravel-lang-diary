<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Words') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                          <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <a href="{{ route('words.create') }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Add Word
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
                                @foreach ($words as $word)
                                  <tr class="border-b border-neutral-200">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="{{ route('words.show', $word) }}" class="font-bold text-lg underline hover:text-indigo-600">{{ $word->word }}</a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="{{ route('words.edit', $word) }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Edit</a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <form action="{{ route('words.destroy', $word) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?');" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Delete</button>
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
