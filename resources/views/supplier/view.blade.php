@extends('layout.app')

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
            <div class="responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="18%">ID</th>
                            <td width="82%">{{ $supplier->id }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Name</th>
                            <td width="82%">{{ $supplier->name }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Fax Number</th>
                            <td width="82%">{{ $supplier->fax_number }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Phone</th>
                            <td width="82%">{{ $supplier->phone }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Email</th>
                            <td width="82%">{{ $supplier->email }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Person</th>
                            <td width="82%">{{ $supplier->person }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Email 2</th>
                            <td width="82%">{{ $supplier->email_2 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Person 2</th>
                            <td width="82%">{{ $supplier->person_2 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Email 3</th>
                            <td width="82%">{{ $supplier->email_3 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Person 3</th>
                            <td width="82%">{{ $supplier->person_3 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Address</th>
                            <td width="82%">{{ $supplier->address }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Origin</th>
                            <td width="82%">{{ $supplier->origin }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Band Details</th>
                            <td width="82%">{{ $supplier->band_detail }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Swift Code</th>
                            <td width="82%">{{ $supplier->swift_code }}</td>
                        </tr>
                        @if($supplier->products)
                        <tr>
                            <th width="18%">Products</th>
                            <td width="82%">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Mapped At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supplier->products as $product)
                                        <tr>
                                            <td>{{ @$product->product->name }}</td>
                                            <td>{{ date("F d, Y h:i a", strtotime($product->created_at)) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endpush