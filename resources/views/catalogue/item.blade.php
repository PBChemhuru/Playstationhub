<x-app-layout>
    <?php
    $things = $item->genre;
    $genres = explode(',', $things);
    ?>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .feedback-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .rating {
            margin-bottom: 20px;
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 24px;
            cursor: pointer;
        }

        .rating label:hover,
        .rating label:hover~label {
            color: orange;
        }

        .rating input:checked~label {
            color: orange;
        }

        .comment {
            margin-bottom: 20px;
        }

        .comment textarea {
            width: 100%;
            height: 100px;
            resize: none;
        }

        .submit-btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .comment-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .comment-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .author-name {
            font-weight: bold;
            color: #333;
        }

        .comment-rating {
            display: flex;
            align-items: center;
        }

        .star {
            font-size: 18px;
            color: gold;
            margin-right: 2px;
        }

        .comment-body {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .comment-footer {
            font-size: 12px;
            color: #777;
            text-align: right;
        }
    </style>
    <div class="container" style="margin-top: 10pt;">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset($item->image) }}" class="card-img-top" alt="Product Name"
                        style="object-fit: cover; height: 200px;">
                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p>
                            @php
                                $roundedRating = round($rating * 2) / 2; // Round to the nearest half
                                $fullStars = floor($roundedRating); // Full stars
                                $halfStar = $roundedRating - $fullStars >= 0.5; // Check for a half star
                                $emptyStars = 5 - ceil($roundedRating); // Remaining stars
                            @endphp
                            <!-- Full stars -->
                            @for ($i = 0; $i < $fullStars; $i++)
                                <span style="color: orange;">&#9733;</span>
                            @endfor
                            <!-- Half star -->
                            @if ($halfStar)
                                <span style="color: orange;">&#9734;</span>
                            @endif
                            <!-- Empty stars -->
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <span style="color: lightgray;">&#9734;</span>
                            @endfor
                            {{number_format($rating, 2)}}
                        </p>
                        <p class="card-text">{{ $item->description }}</p>

                        <?php
                        $onsale = DB::table('sales')
                            ->where('game_id', $item->id)
                            ->first();
                        ?>
                        @if (empty($onsale))
                            <p class="card-text font-weight-bold">{{ $item->price }}</p>
                        @else
                            <p class="card-text font-weight-bold">{{ $onsale->new_price }}</p>
                        @endif
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

                        <form action="{{ route('addcart') }}" method="POST">
                            @csrf
                            <input value="{{ $item->id }}" hidden id="game_id" name="game_id">
                            <button type="button" class="bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-l-md p-2"
                                onclick="updateQuantity('decrease')">
                                <span class="font-semibold text-lg">-</span>
                            </button>

                            <!-- Quantity Input Field -->
                            <input type="number" id="quantity" name="quantity" value="1"
                                class="w-16 text-center bg-gray-100 text-gray-800 border border-gray-300 rounded-md"
                                min="1" readonly>

                            <!-- Increase Button -->
                            <button type="button" class="bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-r-md p-2"
                                onclick="updateQuantity('increase')">
                                <span class="font-semibold text-lg">+</span>
                            </button>
                            <button class="btn btn-success"type="submit">Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="feedback-form">
                            <h2>Leave a Review</h2>
                            <form action="{{ route('postReview') }}" method="POST" id="feedbackForm">
                                @csrf
                                <!-- Star Rating -->
                                <div class="rating">
                                    <input type="radio" id="star5" name="rating" value="5">
                                    <label for="star5">&#9733;</label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4">&#9733;</label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3">&#9733;</label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2">&#9733;</label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1">&#9733;</label>
                                </div>

                                <!-- Comment Input -->
                                <div class="comment">
                                    <label for="comment">Tell us more:</label><br>
                                    <textarea id="comment" name="comment" required></textarea>
                                </div>

                                <!-- Hidden Field for Product ID -->
                                <input type="hidden" name="product_id" value="{{ $item->id }}">

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                    @foreach ($reviews as $review)
                        <div class="comment-card">
                            <div class="comment-header">
                                <div class="comment-author">
                                    <i class="fas fa-user-alt"></i>
                                    <span class="author-name">{{ $review->uuid }}</span>
                                </div>
                                <div class="comment-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <span class="star">&#9733;</span>
                                        @else
                                            <span class="star">&#9734;</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="comment-body">
                                <p>{{ $review->comment }}</p>
                            </div>
                            <div class="comment-footer">
                                <span class="comment-date">Posted on:
                                    {{ $review->created_at->format('F j, Y') }}</span>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>


        </div>
    </div>
    <script>
        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            const ratingSelected = document.querySelector('input[name="rating"]:checked');
            if (!ratingSelected) {
                alert('Please select a rating before submitting.');
                event.preventDefault();
            }
        });

        function updateQuantity(action) {
            let quantityInput = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityInput.value);

            if (action === 'increase') {
                quantityInput.value = currentQuantity + 1;
            } else if (action === 'decrease' && currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
            }
        }
    </script>

</x-app-layout>
