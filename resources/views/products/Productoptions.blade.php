<x-app-layout>

    <div class="col-md-10">
        <div class="row">
            <form id="searchForm"action="{{ route('searchproducts') }}" method="POST">
                @csrf
                <div style="float: right">
                    <input type="text" name="search" id="search" placeholder="Search products...">
                    <button type="submit">Search</button>
                </div>

            </form>
        
            <x-nav-link :href="route('addProduct')" :active="request()->routeIs('addProduct')">
                {{ __('Add Product') }}
            </x-nav-link>
        
        </div>
        <div class="container">
            <!-- Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Released</th>
                        <th>Genre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all as $items)
                        <tr>
                            <td><a href="/catalogue/{{ $items->id }}"
                                    style="font-weight: bold;">{{ $items->name }}</a></td>
                            <td>
                                <img src="{{ asset($items->image) }}" alt="{{ $items->name }}"
                                    style="object-fit: cover; height: 80px;">
                            </td>
                            <td>${{ $items->price }}</td>
                            <td>{{ \Carbon\Carbon::parse($items->release_date)->format('Y') }}</td>
                            <td>
                                <?php
                                $genres = json_decode($items->genre);
                                ?>
                                @foreach ($genres as $genre)
                                    <p class="inline-flex items-center">
                                        <!-- Blue circle with a white dot -->
                                        <span class="w-2.5 h-2.5 bg-white rounded-full mr-2"></span>

                                        <!-- Genre Text with link -->
                                        <a href="/{{ $genre }}"
                                            class="text-blue-600 bg-blue-100 px-2 py-1 rounded-full hover:bg-blue-200">
                                            {{ $genre }}
                                        </a>
                                    </p>
                                @endforeach
                            </td>
                            <td>
                                <!-- Edit and Delete Buttons -->

                                {{-- edit modal design --}}
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#editModal{{ $items->id }}">
                                    Edit
                                </button>
                                <!-- Modal for Editing Product -->
                                <div class="modal fade" id="editModal{{ $items->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editModal{{ $items->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModal{{ $items->id }}">Distribute
                                                    Product</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form method="POST" action="{{route('updateproduct')}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')

                                                <div style="padding-left:10px;padding-right:10px;width:100%">
                                                    <input type="hidden" id="requestid" name="requestid"
                                                        value="{{ $items->id }}">

                                                    <!-- Product Name -->
                                                    <div class="mb-4">
                                                        <label for="name" class="block text-gray-700">Product
                                                            Name</label>
                                                        <input type="text" id="name" name="name"
                                                            value="{{ $items->name }}"
                                                            class="w-full px-4 py-2 border rounded-md text-gray-700">
                                                        @error('name')
                                                            <p style="color:red;font-size:13px">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="mb-4">
                                                        <label for="price" class="block text-gray-700">Price</label>
                                                        <input type="number" id="price" name="price"
                                                            value="{{ $items->price }}"
                                                            class="w-full px-4 py-2 border rounded-md text-gray-700"
                                                            step="0.01">
                                                        @error('price')
                                                            <p style="color:red;font-size:13px">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Genre -->
                                                    <div class="mb-4">
                                                        <label for="genre" class="block text-gray-700">Genre</label>
                                                        <input type="text" id="genre" name="genre"
                                                            value="{{ $items->genre }}"
                                                            class="w-full px-4 py-2 border rounded-md text-gray-700">
                                                        @error('genre')
                                                            <p style="color:red;font-size:13px">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Release Date -->
                                                    <div class="mb-4">
                                                        <label for="release_date" class="block text-gray-700">Release
                                                            Date</label>
                                                        <input type="date" id="release_date" name="release_date"
                                                            value="{{ $items->release_date }}"
                                                            class="w-full px-4 py-2 border rounded-md text-gray-700">
                                                        @error('release_date')
                                                            <p style="color:red;font-size:13px">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Product Image -->
                                                    <div class="mb-4">
                                                        <label for="image" class="block text-gray-700">Current
                                                            Product Image</label>
                                                        <!-- Display Current Image -->
                                                        <div>
                                                            <img src="{{ asset($items->image) }}" alt="Product Image"
                                                                style="object-fit: cover; width: 150px; height: 150px; border-radius: 8px;">
                                                        </div>
                                                        <label for="image" class="block text-gray-700 mt-2">New
                                                            Product Image (Optional)</label>
                                                            <input type="file" id="image" name="image" accept="image/*"
                                                            class="w-full px-4 py-2 border rounded-md text-gray-700">
                                                        @error('image')
                                                            <p style="color:red;font-size:13px">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="mb-4">
                                                        <label for="description"
                                                            class="block text-gray-700">Description</label>
                                                        <textarea id="description" name="description" class="w-full px-4 py-2 border rounded-md text-gray-700"
                                                            rows="5">{{ $items->description }}</textarea>
                                                        @error('description')
                                                            <p style="color:red;font-size:13px">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div class="text-center">
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm rounded-pill"
                                                            style="width: 100%; padding: 10px; font-size: 16px;">Update
                                                            Product</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Form -->
                                <form action="/catalogue/{{ $items->id }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill"
                                        onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>


</x-app-layout>
