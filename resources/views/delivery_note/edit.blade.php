@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('delivery_note.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $note->id }}">

        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold">{{ $page_title }}</h4>
                <hr />
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Delivery Note*</label>
                            <textarea name="text" class="form-control editor" placeholder="Delivery Note*">@php echo old('text', $note->text); @endphp</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="for_type" class="select2 form-select">
                                <option @if(old('for_type', $note->for_type)=="Invoice" ) selected @endif value="Invoice">Invoice</option>
                                <option @if(old('for_type', $note->for_type)=="Quotation" ) selected @endif value="Quotation">Quotation</option>
                            </select>
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