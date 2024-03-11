<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <!-- File input button -->
        <form id="fileInputForm" method="POST" class="mb-4" action="{{ route('files.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" id="fileInput" class="hidden" name="file">
            <label for="fileInput" class="block w-full text-center bg-gray-200 hover:bg-gray-300 cursor-pointer py-2 px-4 rounded-md text-lg font-bold">
                Choose File
            </label>
        </form>
        <!-- Display uploaded files -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Uploaded Files</h2>
            @foreach ($files as $file)
                <div class="mb-4">
                    <a href="{{ Storage::url($file->path) }}" class="text-blue-500 hover:underline text-lg">{{ $file->filename }}</a>
                    <form action="{{ route('files.download', $file->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">Download</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('fileInput');
        const fileDisplay = document.getElementById('fileDisplay');
        const fileNameSpan = document.getElementById('fileName');
        const removeFileBtn = document.getElementById('removeFile');

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                fileNameSpan.textContent = file.name;
                fileDisplay.classList.remove('hidden');
                // Automatically submit the form after file selection
                document.getElementById('fileInputForm').submit();
            }
        });

        removeFileBtn.addEventListener('click', function () {
            fileInput.value = ''; // Clear the file input
            fileDisplay.classList.add('hidden');
        });
    });
</script>
