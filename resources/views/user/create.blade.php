@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
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
                                <input name="name" type="text" class="form-control" placeholder="Name*"
                                    value="{{ old('name') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Email*</label>
                                <input name="email" type="email" class="form-control" placeholder="Email*"
                                    value="{{ old('email') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Role*</label>
                                <select class="form-select" name="role_id">
                                    @foreach ($roles as $role)
                                        <option @if (old('role_id') == $role->id) selected @endif
                                            value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input name="phone" type="number" class="form-control" placeholder="Phone"
                                    value="{{ old('phone') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input name="address" type="text" class="form-control" placeholder="Address"
                                    value="{{ old('address') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Designation</label>
                                <input name="designation" type="text" class="form-control" placeholder="Designation"
                                    value="{{ old('designation') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Username*</label>
                                <input name="username" type="text" class="form-control" placeholder="Username*"
                                    value="{{ old('username') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Password*</label>
                                <input name="password" type="password" class="form-control" placeholder="Password*"
                                    autocomplete="off" />
                            </div>
                        </div>

                        <div class="col-12 border-bottom my-3">
                            <h5 class="mb-1 fw-bold">IMAP Setting:</h5>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">IMAP Host</label>
                                <input name="imap_host" type="text" class="form-control" placeholder="IMAP Host"
                                    value="{{ old('imap_host') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">IMAP Username</label>
                                <input name="imap_username" type="text" class="form-control" placeholder="IMAP Username"
                                    value="{{ old('imap_username') }}" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">IMAP Password</label>
                                <input name="imap_password" type="text" class="form-control" placeholder="IMAP Password"
                                    value="{{ old('imap_password') }}" />
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
