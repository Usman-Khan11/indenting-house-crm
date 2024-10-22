@extends('layout.app')

@section('content')

@php
$per = [];
$permission = get_user_permission($role->id);

foreach($permission as $data){
$per[] = $data->nav_key_id;
}

$Get_Sidebar = Get_Sidebar();
@endphp

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-md-8 text-md-start text-center">
          <h4 class="fw-bold">Role:- <b>{{$role->name}}</h4>
        </div>
      </div>
      <hr />
    </div>
    <div class="card-body">
      <form class="col-12" method="post" action="{{route('add_permissions')}}">
        @csrf
        <input type="hidden" name="user_id" value="{{$role->id}}" />
        @foreach($Get_Sidebar as $sidebar)
        <div class="col-12 mt-1">
          <h4 class=" fw-bolder mb-1">{{$sidebar->name}}</h4>
          <div class="d-flex align-items-center flex-wrap">
            @php
            $navkeys = Get_Navkeys($sidebar->id);
            foreach ($navkeys as $keys) {
            $checked = "";
            if (in_array($keys->id, $per)) {
            $checked = "checked";
            }
            @endphp
            <div class="form-check form-check-inline">
              <input {{$checked}} class="form-check-input" type="checkbox" name="perm[]" id="key_{{$keys->id}}" value="{{$sidebar->id}}-{{$keys->id}}">
              <label class="form-check-label col-form-label-lg pt-0" for="key_{{$keys->id}}">{{$keys->key}}</label>
            </div>
            @php
            }
            @endphp
          </div>
        </div>
        <hr />
        @endforeach
        <div>
          <button type="submit" name="Btn" class="btn btn-primary box-shadow1 mt-3">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection