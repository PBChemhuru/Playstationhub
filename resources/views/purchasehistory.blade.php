<x-app-layout>
    <style>
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
    <div style="margin: 20pt">
        @foreach ($phis as $his)
            <div class="comment-card">
                <div class="comment-header">
                    <div class="comment-author">
                        <i class="fas fa-user-alt"></i>
                        <span class="author-name">Inovice {{ $his->id }}</span>
                    </div>
                    <div class="comment-rating">
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#invoicemodal{{ $his->id }}"><i class="fas fa-eye"> View Purchase</i>
                        </button>
                    </div>
                </div>
                <div class="comment-body">
                    <p>Total :${{ $his->invoice_total }}</p>
                </div>
                <div class="comment-footer">
                    <span class="comment-date">Purchased on:
                        {{ $his->created_at->format('F j, Y') }}</span>
                </div>
            </div>

            <!-- Transaction Details Modal -->
            <div class="modal fade" id="invoicemodal{{ $his->id }}" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content dark:bg-gray-800">
                        <div class="modal-header bg-green-600 text-black d-flex justify-content-between align-items-center">
                            <h5 class="modal-title">Transaction Details - ID {{ $his->id }}</h5>
                            <p class="mb-0" style="margin-left: auto;">Purchased on:{{ $his->created_at }}</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="modal-body">
                            @php

                                $details = json_decode($his->item_details, true); // Decode JSON data
                            @endphp
                            @if (is_array($details))
                                <div class="table-responsive">
                                    <div class="container mt-4">
                                        <div class="row">
                                            @foreach ($details as $detail)
                                                <div class="col-md-4 mb-4">
                                                    <div class="card h-100">
                                                        <div class="card-body d-flex flex-column">
                                                            <h5 class="card-title">
                                                                {{ $detail['productName'] }}
                                                            </h5>
                                                            <div class="flex-grow-1">
                                                                <p><strong>Quantity:</strong>
                                                                    {{ $detail['productQuantity'] }}
                                                                </p>
                                                                <p><strong>Price:</strong>
                                                                    {{ $detail['price'] }}

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        Total :{{ $his->invoice_total }}
                                    </div>
                                </div>
                            @else
                                nothing here
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
</x-app-layout>
