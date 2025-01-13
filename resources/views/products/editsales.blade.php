<x-app-layout>
    <div class="container mt-5">

        <h2>Price Changes</h2>

        <form action="" method="POST">
            @csrf
            {{-- edit modal design --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsalesModal">
                Add
            </button>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Game ID</th>
                        <th>Old Price</th>
                        <th>New Price</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($sales as $priceChange)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $priceChange->name }}</td>
                            <td>{{ $priceChange->game_id }}</td>
                            <td>${{ number_format($priceChange->old_price, 2) }}</td>
                            <td>${{ number_format($priceChange->new_price, 2) }}</td>
                            <td>
                                <!-- Checkbox for delete -->
                                <input type="checkbox" name="delete_ids[]" value="{{ $priceChange->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-danger">Delete Selected</button>
        </form>
    </div>

    <!-- Modal for Editing Product -->
    <div class="modal fade" id="addsalesModal" tabindex="-1" role="dialog" aria-labelledby="addsalesModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addsalesModal">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('addtosales') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="container mt-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-8 col-sm-10">
                                <!-- Game Selection -->
                                <div class="mb-3">
                                    <label for="game_name" class="form-label">Select Game</label>
                                    <select name="game_name" id="game_name" class="form-select" onchange="autofill()"
                                        required>
                                        <option></option>
                                        @foreach ($all as $games)
                                            <option value="{{ $games->name }}" data-game_id="{{ $games->id }}">
                                                {{ $games->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input id="game_id" name="game_id" readonly hidden>
                                <!-- Old Price -->
                                <div class="mb-3">
                                    <label for="old_price" class="form-label">Old Price</label>
                                    <input type="number" step="0.01" name="old_price" id="old_price"
                                        class="form-control" required placeholder="Enter the old price">
                                </div>

                                <!-- New Price -->
                                <div class="mb-3">
                                    <label for="new_price" class="form-label">New Price</label>
                                    <input type="number" step="0.01" name="new_price" id="new_price"
                                        class="form-control" required placeholder="Enter the new price">
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">New Price</label>
                                    <input type="file" step="0.01" name="image" id="image"
                                        class="form-control" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-lg w-100">Update
                                        Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        function autofill() {
            const dropdown = document.getElementById("game_name");
            const selectedOption = dropdown.options[dropdown.selectedIndex];
            const itemNumber = selectedOption.getAttribute("data-game_id");
            const autofillField = document.getElementById("game_id");
            // Set the autofill field based on the selected option's data
            autofillField.value = itemNumber || "";
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#game_name').on('change', function() {
                const selectedValue = $(this).val();

                $.ajax({
                    url: '{{ route('getprices') }}', // Route to fetch price data
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        game_id: selectedValue
                    },
                    success: function(data) {
                        $('#old_price').val(data.price);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                    }
                });
            });
        });
    </script>
</x-app-layout>
