<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- File input button -->
        <form id="fileInputForm" method="POST" class="mb-4" action="{{ route('files.store') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="file" id="fileInput" class="hidden" name="file">
            <label for="fileInput"
                class="block w-full text-center bg-gray-200 hover:bg-gray-300 cursor-pointer py-2 px-4 rounded-md text-lg font-bold">
                Choose File
            </label>
        </form>

        <!-- Display uploaded files -->
        <div class="mt-8 ">
            <h2 class="text-2xl font-bold mb-4">Uploaded Files</h2>
            @foreach ($files as $file)
                <div class="flex items-center justify-between mb-4">
                    <div class="">

                        <a href="{{ Storage::url($file->path) }}"
                            class="text-blue-500 hover:underline text-lg">{{ $file->filename }}</a>
                        </div>
                    <div class="">

                        <form action="{{ route('files.download', $file->id) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Download</button>
                        </form>
                        <form action="{{ route('files.destroy', $file->id) }}" method="POST" class="inline ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
