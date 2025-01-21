<x-app-layout>
    <form action="{{route('storeproduct')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Product Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                class="w-full px-4 py-2 border rounded-md text-gray-700">
            @error('name')
                <p style="color:red;size:13px">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label for="price" class="block text-gray-700">Price</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}"
                class="w-full px-4 py-2 border rounded-md text-gray-700" step="0.01">
            @error('price')
                <p style="color:red;size:13px">{{ $message }}</p>
            @enderror
        </div>

        <!-- Genre -->
        <div class="mb-4">
            <label for="genre" class="block text-gray-700">Genre</label>
                <select id="genre" name="genre[]" class="form-control" multiple>
                    @foreach($genres as $genre)
                    <option value="{{$genre->genre}}">{{$genre->genre}}</option>
                    @endforeach
                </select>
            @error('genre')
                <p style="color:red;size:13px">{{ $message }}</p>
            @enderror
        </div>

        <!-- Release Date -->
        <div class="mb-4">
            <label for="release_date" class="block text-gray-700">Release Date</label>
            <input type="date" id="release_date" name="release_date" value="{{ old('release_date') }}"
                class="w-full px-4 py-2 border rounded-md text-gray-700">
            @error('release_date')
                <p style="color:red;size:13px">{{ $message }}</p>
            @enderror
        </div>

        <!-- Product Image -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Product Image</label>
            <input type="file" id="image" name="image" accept="image/*"
                class="w-full px-4 py-2 border rounded-md text-gray-700">
            @error('image')
                <p style="color:red;size:13px">{{ $message }}</p>
            @enderror

        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea id="description" name="description" class="w-full px-4 py-2 border rounded-md text-gray-700" rows="5"
                required>{{ old('description') }}</textarea>
            @error('description')
                <p style="color:red;size:13px">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600">
                Create Product
            </button>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('#genre').select2({
                tags: true, // Allow adding custom items
                placeholder: "Select or add items",
                width: '100%' // Make it responsive
            });
        });
    </script>
</x-app-layout>
