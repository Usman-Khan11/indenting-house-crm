@extends('layout.app')

@push('style')
    <style>
        .form-group.row{
            margin-bottom: 15px !important;
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
            <form action="{{ route('email.setting') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-md-2">
                        <label class="font-weight-bold">@lang('Sending Method')</label>
                    </div>
                    <div class="col-md-10">
                        <select name="email_method" class="form-select" >
                            <option value="php" @if(@$general_setting->mail_config->name == 'php') selected @endif>@lang('PHP Mail')</option>
                            <option value="smtp" @if(@$general_setting->mail_config->name == 'smtp') selected @endif>@lang('SMTP')</option>
                            <option value="sendgrid" @if(@$general_setting->mail_config->name == 'sendgrid') selected @endif>@lang('SendGrid API')</option>
                            <option value="mailjet" @if(@$general_setting->mail_config->name == 'mailjet') selected @endif>@lang('Mailjet API')</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-none configForm" id="smtp"></div>
                <div class="mt-4 d-none configForm" id="sendgrid"> </div>
                <div class="mt-4 d-none configForm" id="mailjet"></div>

                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";
        (function ($) {
            var method = $('select[name=email_method]').val();
            config(method);
            $('select[name=email_method]').on('change', function() {
                config($(this).val());
            });

            function config(method){
                $('.configForm').hide('300');
                $('.configForm').html('');

                if(method=='smtp'){
                    $(`#sendgrid`).html('');
                    $(`#mailjet`).html('');
                    $(`#${method}`).html(`<h4 class="border-bottom pb-2 mb-4">@lang('Configuration')</h4>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">@lang('Host')</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="@lang('e.g. smtp.googlemail.com')" name="host" value="{{ $general_setting->mail_config->host ?? '' }}" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">@lang('Port')</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="@lang('Available port')" name="port" value="{{ $general_setting->mail_config->port ?? '' }}" required/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold" for="enc">@lang('Encryption')</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-select" name="enc" id="enc">
                                        <option null selected>@lang('Select one')</option>
                                        <option value="ssl" {{ @$general_setting->mail_config->enc == 'ssl'?'selected':'' }}>@lang('SSL')</option>
                                        <option value="tls" {{ @$general_setting->mail_config->enc == 'tls'?'selected':'' }}>@lang('TLS')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">@lang('Username')</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="@lang('May be your email address')" name="username" value="{{ $general_setting->mail_config->username ?? '' }}" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="font-weight-bold">@lang('Password')</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="@lang('May be your email password')" name="password" value="{{ $general_setting->mail_config->password ?? '' }}" required/>
                                </div>
                            </div>`)
                    $(`#${method}`).removeClass('d-none').hide().show(300);

                }

                if(method=='sendgrid'){
                    $(`#smtp`).html('');
                    $(`#mailjet`).html('');
                    $(`#${method}`).removeClass('d-none');
                    $(`#${method}`).html(`<h4 class="border-bottom pb-2 mb-4">@lang('Configuration')</h4>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label class="font-weight-bold">@lang('APP KEY')</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="@lang('SendGrid app key')" name="appkey" value="{{ $general_setting->mail_config->appkey ?? '' }}" required/>
                                                </div>
                                            </div>
                                        `);
                    $(`#${method}`).removeClass('d-none').hide().show(300);
                }
                if(method=='mailjet'){
                    $(`#smtp`).html('');
                    $(`#sendgrid`).html('');

                    $(`#${method}`).html(` <h4 class="border-bottom pb-2 mb-4">@lang('Configuration')</h4>
                                                <div class="form-group row">
                                                    <div class="col-md-2">
                                                        <label class="font-weight-bold">@lang('API PUBLIC KEY')</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" placeholder="@lang('Mailjet API PUBLIC KEY')" name="public_key" value="{{ $general_setting->mail_config->public_key ?? '' }}" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-2">
                                                        <label class="font-weight-bold">@lang('API SECRET KEY')</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" placeholder="@lang('Mailjet API SECRET KEY')" name="secret_key" value="{{ $general_setting->mail_config->secret_key ?? '' }}" required/>
                                                    </div>
                                                </div>`
                                            );

                    $(`#${method}`).removeClass('d-none').hide().show(300);
                }
            }
        })(jQuery);
    </script>
@endpush