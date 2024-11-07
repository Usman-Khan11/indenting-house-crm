@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('customer.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $customer->id }}">
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold">{{ $page_title }}</h4>
                <hr />
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Name*</label>
                            <input name="name" type="text" class="form-control" value="{{ old('name', $customer->name) }}" placeholder="Name*" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input name="location" type="text" class="form-control" value="{{ old('location', $customer->location) }}" placeholder="Location" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Fax Number</label>
                            <input name="fax_number" type="number" class="form-control" value="{{ old('fax_number', $customer->fax_number) }}" placeholder="Fax Number" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email', $customer->email) }}" placeholder="Email" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email_2" type="email" class="form-control" value="{{ old('email_2', $customer->email_2) }}" placeholder="Email" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email_3" type="email" class="form-control" value="{{ old('email_3', $customer->email_3) }}" placeholder="Email" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Person</label>
                            <input name="person" type="text" class="form-control" value="{{ old('person', $customer->person) }}" placeholder="Person" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Person</label>
                            <input name="person_2" type="text" class="form-control" value="{{ old('person_2', $customer->person_2) }}" placeholder="Person" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Sales Person</label>
                            <input name="person_3" type="text" class="form-control" value="{{ old('person_3', $customer->person_3) }}" placeholder="Sales Person" />
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Address Office</label>
                            <textarea name="address_office" class="form-control" placeholder="Address Office">{{ old('address_office', $customer->address_office) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Address Factory</label>
                            <textarea name="address_factory" class="form-control" placeholder="Address Factory">{{ old('address_factory', $customer->address_factory) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Cell No</label>
                            <input name="cell_1" type="number" class="form-control" value="{{ old('cell_1', $customer->cell_1) }}" placeholder="Cell No" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Cell No</label>
                            <input name="cell_2" type="number" class="form-control" value="{{ old('cell_2', $customer->cell_2) }}" placeholder="Cell No" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Cell No</label>
                            <input name="cell_3" type="number" class="form-control" value="{{ old('cell_3', $customer->cell_3) }}" placeholder="Cell No" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input name="phone_1" type="number" class="form-control" value="{{ old('phone_1', $customer->phone_1) }}" placeholder="Phone" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input name="phone_2" type="number" class="form-control" value="{{ old('phone_2', $customer->phone_2) }}" placeholder="Phone" />
                        </div>
                    </div>

                    <div class="col-md-12 col-12 mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection