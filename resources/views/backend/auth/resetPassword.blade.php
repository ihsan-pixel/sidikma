@include('backend.layout.headerFront')
@include('sweetalert::alert')

<!-- Content -->
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <img src="{{ asset('') }}storage/images/logo/{{ Helper::apk()->logo }}" alt=""
                            style="width: 30%;">
                    </div>
                    <!-- /Logo -->

                    <h4 class="mb-2">Reset Password 🔒</h4>
                    <p class="mb-4">for <span class="fw-bold">{{$email}}</span></p>
                    <form id="formAuthentication" class="mb-3" action="/resetPassword/action" method="POST">
                        @csrf
                        <input type="text" name="email" id="" value="{{$email}}" hidden>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">New Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="confirm-password">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="confirm-password" class="form-control confirm-password"
                                    name="confirm-password" 
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                       
                        <button class="btn btn-primary d-grid w-100 mb-3">
                            Set new password
                        </button>
                        <div class="text-center">
                            <a href="/login">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </form>            
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>
<!--/ Content -->

@include('backend.layout.footerFront')
