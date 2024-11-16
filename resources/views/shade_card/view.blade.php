@extends('layout.app')

@push('style')
    <style>
        .table th {
            background: #efefef;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h4 class="card-title m-0">{{ $page_title }}</h4>
                    </div>
                </div>
                <hr />
            </div>
            <div class="card-body">
                <h5 class="mb-2 fw-bold">Card Status:</h5>
                <div class="responsive">
                    <table class="table table-bordered text-dark">
                        <tbody>
                            <tr>
                                <th width="15%">Card #</th>
                                <td width="35%">{{ $card->card_no }}</td>
                                <th width="15%">Date</th>
                                <td width="35%">{{ date('d-M-Y', strtotime($card->date)) }}</td>
                            </tr>
                            <tr>
                                <th width="15%">Customer</th>
                                <td width="35%">{{ @$card->customer->name }}</td>
                                <th width="15%">Supplier</th>
                                <td width="35%">{{ @$card->supplier->name }}</td>
                            </tr>
                            <tr>
                                <th width="15%">Product</th>
                                <td width="35%">{{ @$card->item->name }}</td>
                                <th width="15%">Size</th>
                                <td width="35%">{{ @$card->size->name }}</td>
                            </tr>
                            <tr>
                                <th width="15%">Front Color</th>
                                <td width="35%">{{ $card->front_color }}</td>
                                <th width="15%">Front Code</th>
                                <td width="35%">{{ $card->front_code }}</td>
                            </tr>
                            <tr>
                                <th width="15%">Back Color</th>
                                <td width="35%">{{ $card->back_color }}</td>
                                <th width="15%">Back Code</th>
                                <td width="35%">{{ $card->back_code }}</td>
                            </tr>
                            <tr>
                                <th width="15%">Ingredient</th>
                                <td width="35%">{{ $card->ingredient }}</td>
                                <th width="15%">Status</th>
                                <td width="35%">
                                    @if ($card->status == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif ($card->status == 2)
                                        <span class="badge bg-info">Pending at Supplier</span>
                                    @elseif ($card->status == 3)
                                        <span class="badge bg-warning">Pending at Customer</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="15%">Image</th>
                                <td width="35%">
                                    <a href="{{ asset($card->image) }}" target="_blank">
                                        <img src="{{ asset($card->image) }}" alt="" loading="lazy"
                                            width="100px" />
                                    </a>
                                </td>
                                <th width="15%">Ref Code</th>
                                <td width="35%">{{ $card->ref_code }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="mb-2 mt-4 fw-bold">Artwork Status:</h5>
                <div class="responsive">
                    <table class="table table-bordered text-dark">
                        <tbody>
                            <tr>
                                <th width="15%">Artwork #</th>
                                <td width="35%">{{ $artwork->artwork_no }}</td>
                                <th width="15%">Date</th>
                                <td width="35%">{{ date('d-M-Y', strtotime($card->date)) }}</td>
                            </tr>
                            <tr>
                                <th width="15%">Front Print</th>
                                <td width="35%">{{ $artwork->front_print }}</td>
                                <th width="15%">Front Print Color</th>
                                <td width="35%">{{ $artwork->front_print_color }}</td>
                            </tr>
                            <tr>
                                <th width="15%">Back Print</th>
                                <td width="35%">{{ $artwork->back_print }}</td>
                                <th width="15%">Back Print Color</th>
                                <td width="35%">{{ $artwork->back_print_color }}</td>
                            </tr>
                            <tr>
                                <th width="15%">Remarks</th>
                                <td width="35%">{{ $artwork->remarks }}</td>
                                <th width="15%">Status</th>
                                <td width="35%">
                                    @if ($artwork->status == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif ($artwork->status == 2)
                                        <span class="badge bg-info">Pending at Supplier</span>
                                    @elseif ($artwork->status == 3)
                                        <span class="badge bg-warning">Pending at Customer</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="15%">Image</th>
                                <td width="35%">
                                    <a href="{{ asset($artwork->image) }}" target="_blank">
                                        <img src="{{ asset($artwork->image) }}" alt="" loading="lazy"
                                            width="100px" />
                                    </a>
                                </td>
                                <th width="15%">Print Style</th>
                                <td width="35%">
                                    @if ($artwork->print_style == 1)
                                        <span class="badge bg-danger">Axial Not Rectified</span>
                                    @elseif ($artwork->print_style == 2)
                                        <span class="badge bg-danger">Radial Not Rectified</span>
                                    @elseif ($artwork->print_style == 3)
                                        <span class="badge bg-warning">Not Known</span>
                                    @elseif ($artwork->print_style == 4)
                                        <span class="badge bg-success">Axial Rectified</span>
                                    @elseif ($artwork->print_style == 5)
                                        <span class="badge bg-success">Radial Rectified</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
