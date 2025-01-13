<x-app-layout>
    <div class="container" style="margin-top: 10pt;">
        <div class="row">
            <!--fitler list-->
            <div class="col-md-2">
                <form id="filterForm">
                    @csrf
                    <div>
                        <h4>Filter by Genre:</h4>
                        @foreach ($genre as $genres => $name)
                            <label>
                                <input type="checkbox" name="genres[]" value="{{ $genres }}">
                                <a href="/{{ $genres }}"
                                    style="text-decoration: none; color: inherit;">{{ $genres }}</a>
                            </label><br>
                        @endforeach

                    </div>
                    <div>
                        <h4>Filter by year:</h4>
                        @foreach ($year as $item)
                            <label>
                                <input type="checkbox" name="years[]" value="{{ $item->year }}">
                                <a href="/{{ $item->year }}"
                                    style="text-decoration: none; color: inherit;">{{ $item->year }}</a>
                            </label>
                        @endforeach

                    </div>

                </form>

            </div>


            <div class="col-md-10">
                <div class="row">
                    <form id="searchForm"action="{{route('searchcatalogue')}}" method="POST">
                        @csrf
                        <div style="float: right">
                            <input type="text" name="search" id="search" placeholder="Search products...">
                            <button type="submit">Search</button>
                        </div>

                    </form>
                </div>
                <div class="row">
                    <div id="catalogue">
                        <div class="row">
                            @foreach ($all as $items)
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body d-flex flex-column">
                                            <a class="card-title" href="/catalogue/{{ $items->id }}"
                                                style="font-weight: bold;">{{ $items->name }}</a>
                                            <img src="{{ asset($items->image) }}" class="card-img-top"
                                                alt="{{ $items->name }}" style="object-fit: cover; height: 200px;">
                                            <div class="mt-auto">
                                                <p class="card-text">Price: ${{ $items->price }}</p>
                                                <p class="card-text">Released:
                                                    {{ \Carbon\Carbon::parse($items->release_date)->format('Y') }}</p>
                                                <a href="/{{ $items->genre }}"
                                                    class="btn btn-primary rounded-pill">{{ $items->genre }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filterForm input[type="checkbox"]').on('change', function() {
                $.ajax({
                    url: '{{ route('filtercata') }}',
                    method: 'POST',
                    data: $('#filterForm').serialize(),
                    success: function(data) {
                        $('#catalogue').html(data);

                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                    }

                });
            });
        });
    </script>
    <script>
         $(document).ready(function() {
            $('#searchForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                const formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: '{{ route('searchcatalogue') }}', // Your route to fetch data
                    method: 'POST',
                    data: formData,
                    success: function(data) {
                        console.log(data);
                        $('#catalogue').html(data); // Update HTML with returned data
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('An error occurred while fetching data.');
                    }
                });
            });
        });
    </script>
</x-app-layout>
