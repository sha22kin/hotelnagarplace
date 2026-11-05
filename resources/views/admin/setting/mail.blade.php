@extends(adminTheme().'layouts.app') 
@section('title')
<title>{{websiteTitle(ucfirst($type).' Setting')}}</title>
@endsection 
@push('css')
<style type="text/css"></style>
@endpush 
@section('contents')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">{{ucfirst($type)}} Setting</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard </a></li>
                    <li class="breadcrumb-item active">{{ucfirst($type)}} Setting</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


@include(adminTheme().'alerts')
@php
    $mailReady = $general->mail_status && $general->mail_from_address && ($general->mail_driver == 'sendmail' || $general->mail_host);
@endphp
<div class="alert {{ $mailReady ? 'alert-success' : 'alert-warning' }}" role="alert">
    @if($mailReady)
    <i class="fa-solid fa-circle-check"></i> Mail is <b>ON</b>. Use <b>Send Test Mail</b> below to make sure it really arrives.
    @elseif(!$general->mail_status)
    <i class="fa-solid fa-triangle-exclamation"></i> Mail is <b>OFF</b> &mdash; the website sends no emails (no order invoices, no password reset codes). Fill in the settings, tick <b>Active</b> and save.
    @else
    <i class="fa-solid fa-triangle-exclamation"></i> Mail is ON but not complete &mdash; "Mail From Address" and "Mail Host" are required.
    @endif
</div>
<form action="{{route('admin.settingUpdate',$type)}}" method="post" enctype="multipart/form-data">
    @csrf
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Mail Setting</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_from_address">Mail From Address <small>(e.g. info@yourdomain.com)</small></label>
                    <input type="text" name="mail_from_address" value="{{ $general->mail_from_address }}" placeholder="Mail From Address" class="form-control  {{$errors->has('mail_from_address')?'error':''}}" />
                    @if ($errors->has('mail_from_address'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_from_address') }}</p>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_from_name">Mail From Name</label>
                    <input type="text" name="mail_from_name" value="{{ $general->mail_from_name }}" placeholder="Mail From Name" class="form-control  {{$errors->has('mail_from_name')?'error':''}}" />
                    @if ($errors->has('mail_from_name'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_from_name') }}</p>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_driver">Mail Driver</label>
                    <select name="mail_driver" class="form-control  {{$errors->has('mail_driver')?'error':''}}">
                        <option value="smtp" {{$general->mail_driver!='sendmail'?'selected':''}}>SMTP</option>
                        <option value="sendmail" {{$general->mail_driver=='sendmail'?'selected':''}}>Sendmail (server mail, no host needed)</option>
                    </select>
                    @if ($errors->has('mail_driver'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_driver') }}</p>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_host">Mail Host</label>
                    <input type="text" name="mail_host" value="{{ $general->mail_host }}" placeholder="Mail Host" class="form-control  {{$errors->has('mail_host')?'error':''}}" />
                    @if ($errors->has('mail_host'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_host') }}</p>
                    @endif
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_port">Mail Port</label>
                    <input type="number" name="mail_port" value="{{ old('mail_port', $general->mail_port) }}" placeholder="465 (SSL) or 587 (TLS)" class="form-control  {{$errors->has('mail_port')?'error':''}}" />
                    @if ($errors->has('mail_port'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_port') }}</p>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_encryption">Mail Encryption</label>
                    <select name="mail_encryption" class="form-control  {{$errors->has('mail_encryption')?'error':''}}">
                        <option value="ssl" {{$general->mail_encryption=='ssl'?'selected':''}}>SSL (port 465)</option>
                        <option value="tls" {{$general->mail_encryption=='tls'?'selected':''}}>TLS (port 587)</option>
                        <option value="" {{$general->mail_encryption==null?'selected':''}}>None</option>
                    </select>
                    @if ($errors->has('mail_encryption'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_encryption') }}</p>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_username">Mail Username</label>
                    <input type="text" name="mail_username" value="{{ $general->mail_username }}" placeholder="Mail Username  " class="form-control  {{$errors->has('mail_username')?'error':''}}" />
                    @if ($errors->has('mail_username'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_username') }}</p>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_password">Mail Password</label>
                    <div class="input-group">
                        <input type="password" name="mail_password" value="" autocomplete="new-password" placeholder="{{ $general->mail_password ? 'Saved - leave empty to keep it' : 'Mail Password' }}" class="form-control  password {{$errors->has('mail_password')?'error':''}}" />
                        <div class="input-group-append">
                            <span class="input-group-text showPassword"><i class="fa fa-eye-slash"></i></span>
                        </div>
                    </div>
                    @if ($errors->has('mail_password'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_password') }}</p>
                    @endif
                </div>
                
                @if($general->mail_password)
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="remove_mail_password" id="remove_mail_password" />
                        <label class="custom-control-label" for="remove_mail_password">Remove saved password</label>
                    </div>
                </div>
                @endif

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="admin_mails">Admin Mails <small>(get a copy of every order, contact &amp; enquiry form &mdash; one per line)</small></label>
                    <textarea name="admin_mails" rows="3" placeholder="{{ $general->mail_from_address ?: 'owner@example.com' }}" class="form-control  {{$errors->has('admin_mails')?'error':''}}">{{ old('admin_mails', $general->admin_mails) }}</textarea>
                    <small>Empty = copies go to the "Mail From Address".</small>
                    @if ($errors->has('admin_mails'))
                    <p style="color: red; margin: 0;">{{ $errors->first('admin_mails') }}</p>
                    @endif
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mail_status">Mail Status</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="mail_status" id="mail_status" {{$general->mail_status?'checked':''}}/>
                        <label class="custom-control-label" for="mail_status">Active <small>(Mail System Active)</small></label>
                    </div>
                    @if ($errors->has('mail_status'))
                    <p style="color: red; margin: 0;">{{ $errors->first('mail_status') }}</p>
                    @endif
                </div>
                {{--
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Action For</th>
                                <th>Status <small>(Send Mail status)</small></th>
                            </tr>
                            <tr>
                                <th>Registration</th>
                                <td>
                                    <label style="cursor: pointer;"> <input type="checkbox" name="register_mail_user" {{$general->register_mail_user?'checked':''}} /> User </label>
                                    <label style="cursor: pointer;"> <input type="checkbox" name="register_mail_author" {{$general->register_mail_author?'checked':''}} /> Author </label>
                                    <b> Account Create After Send Mail </b>
                                </td>
                            </tr>
                            <tr>
                                <th>Registration Verify</th>
                                <td>
                                    <label style="cursor: pointer;"> <input type="checkbox" name="register_verify_mail_user" {{$general->register_verify_mail_user?'checked':''}} /> User </label>
                                    <b> Registration Verify Request After Send Mail </b>
                                </td>
                            </tr>
                            <tr>
                                <th>Forget Password</th>
                                <td>
                                    <label style="cursor: pointer;"> <input type="checkbox" name="forget_password_mail_user" {{$general->forget_password_mail_user?'checked':''}} /> User </label>
                                    <b> Forget Password Request After Send Mail </b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                --}}
                <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="padding: 15px; border: 2px solid #ff7e93;">
                        <h4>Instruction</h4>
                        <p class="text-danger">
                            A wrong setting does not break the website any more, but emails will not arrive. After saving, always use <b>Send Test Mail</b>. If it fails, the error is shown and also written to <code>storage/logs/laravel.log</code>.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <p>For SSL (recommended for cPanel)</p>
                    <table class="table table-bordered table-striped table-responsive">
                        <tbody>
                            <tr><td>Mail Host: <b>mail.yourdomain.com</b> (cPanel &rarr; Email Accounts &rarr; Connect Devices)</td></tr>
                            <tr><td>Mail Port: <b>465</b>, Mail Encryption: <b>SSL</b></td></tr>
                            <tr><td>Mail Username: the full email address, Mail Password: that email's password</td></tr>
                            <tr><td>Mail From Address: the same email address</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <p>For TLS / Gmail</p>
                    <table class="table table-bordered table-striped table-responsive">
                        <tbody>
                            <tr><td>Mail Port: <b>587</b>, Mail Encryption: <b>TLS</b></td></tr>
                            <tr><td>Gmail: Host <b>smtp.gmail.com</b>, password = a Google <b>App Password</b> (not the normal password)</td></tr>
                            <tr><td>If SMTP does not work on your server, choose Mail Driver <b>Sendmail</b></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<form action="{{route('admin.settingUpdate','mail-test')}}" method="post">
    @csrf
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Send Test Mail</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 col-lg-8 col-md-12 form-group">
                    <label for="test_email">Send a test email to</label>
                    <div class="input-group">
                        <input type="email" name="test_email" value="{{ old('test_email', Auth::user()->email) }}" placeholder="you@example.com" class="form-control {{$errors->has('test_email')?'error':''}}" required />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Send Test Mail</button>
                        </div>
                    </div>
                    <small>Save the settings first. The test uses the saved settings, even if "Mail Status" is off.</small>
                    @if ($errors->has('test_email'))
                    <p style="color: red; margin: 0;">{{ $errors->first('test_email') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</form>


@endsection
@push('js') 
@endpush
