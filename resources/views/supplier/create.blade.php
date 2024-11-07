@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('supplier.store') }}" enctype="multipart/form-data">
        @csrf
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
                            <input name="name" type="text" class="form-control" value="{{ old('name') }}" placeholder="Name*" />
                        </div>
                    </div>

                    <div class="col-md-8 col-12">
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" placeholder="Address">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Origin</label>
                            <input name="origin" type="text" class="form-control" value="{{ old('origin') }}" placeholder="Origin" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Fax Number</label>
                            <input name="fax_number" type="number" class="form-control" value="{{ old('fax_number') }}" placeholder="Fax Number" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input name="phone" type="number" class="form-control" value="{{ old('phone') }}" placeholder="Phone" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email') }}" placeholder="Email" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email_2" type="email" class="form-control" value="{{ old('email_2') }}" placeholder="Email" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email_3" type="email" class="form-control" value="{{ old('email_3') }}" placeholder="Email" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Person</label>
                            <input name="person" type="text" class="form-control" value="{{ old('person') }}" placeholder="Person" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Person</label>
                            <input name="person_2" type="text" class="form-control" value="{{ old('person_2') }}" placeholder="Person" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Sourcing Person</label>
                            <input name="person_3" type="text" class="form-control" value="{{ old('person_3') }}" placeholder="Sourcing Person" />
                        </div>
                    </div>

                    <div class="col-md-8 col-12">
                        <div class="mb-3">
                            <label class="form-label">Bank Details</label>
                            <textarea name="band_detail" class="form-control" placeholder="Bank Details">{{ old('band_detail') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Swift Code</label>
                            <input name="swift_code" type="text" class="form-control" value="{{ old('swift_code') }}" placeholder="Swift Code" />
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