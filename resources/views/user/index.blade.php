@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-md-8 text-md-start text-center">
          <h4 class="fw-bold">{{ $page_title }}</h4>
        </div>
        <div class="col-md-4 text-md-end text-center">
          <a href="/user/create" class="btn btn-primary">Add New User</a>
        </div>
      </div>
      <hr />
    </div>
    <div class="card-body">
      <div class="responsive text-nowrap">
        <table class="table table-sm" id="my_table"></table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
  $(document).ready(function() {
    var datatable = $("#my_table").DataTable({
      select: {
        style: "api",
      },
      processing: true,
      searching: true,
      serverSide: true,
      lengthChange: false,
      pageLength: 15,
      scrollX: true,
      ajax: {
        url: "{{ route('user') }}",
        type: "get",
        data: function(d) {},
      },
      columns: [{
          data: "DT_RowIndex",
          title: "Sr No",
        },
        {
          data: "name",
          title: "Name",
        },
        {
          data: "email",
          title: "Email",
        },
        {
          data: "username",
          title: "username",
        },
        {
          data: "role_id",
          title: "Role",
          render: function(data, type, full, meta) {
            if (full.role) {
              return full.role.name;
            } else {
              return '-';
            }
          }
        },
        {
          title: "Options",
          render: function(data, type, full, meta) {
            let button = '';

            button += `<a href="/user/edit/${full.id}" class="btn btn-warning btn-sm">Edit</a> `;
            button += `<a onclick="return checkDelete()" href="/user/delete/${full.id}" class="btn btn-danger btn-sm">Delete</a> `;

            return button;
          },
        }
      ],
      rowCallback: function(row, data) {},
    });
  });
</script>
@endpush