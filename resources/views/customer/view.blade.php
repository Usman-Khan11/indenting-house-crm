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
                            <td width="82%">{{ $customer->id }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Name</th>
                            <td width="82%">{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Location</th>
                            <td width="82%">{{ $customer->location }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Fax Number</th>
                            <td width="82%">{{ $customer->fax_number }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Email</th>
                            <td width="82%">{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Person</th>
                            <td width="82%">{{ $customer->person }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Email 2</th>
                            <td width="82%">{{ $customer->email_2 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Person 2</th>
                            <td width="82%">{{ $customer->person_2 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Email 3</th>
                            <td width="82%">{{ $customer->email_3 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Person 3</th>
                            <td width="82%">{{ $customer->person_3 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Office Address</th>
                            <td width="82%">{{ $customer->address_office }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Factory Address</th>
                            <td width="82%">{{ $customer->address_factory }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Cell no</th>
                            <td width="82%">{{ $customer->cell_1 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Cell no</th>
                            <td width="82%">{{ $customer->cell_2 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Cell no</th>
                            <td width="82%">{{ $customer->cell_3 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Phone</th>
                            <td width="82%">{{ $customer->phone_1 }}</td>
                        </tr>
                        <tr>
                            <th width="18%">Phone</th>
                            <td width="82%">{{ $customer->phone_2 }}</td>
                        </tr>
                        @if($customer->products)
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
                                        @foreach($customer->products as $product)
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