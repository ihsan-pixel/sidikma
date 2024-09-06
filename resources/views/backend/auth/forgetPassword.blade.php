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
                    
                    <h4 class="mb-2">Forgot Password? 🔒</h4>
                    <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                    <form id="formAuthentication" class="mb-3" action="/forgetPassword/action" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email" autofocus>
                        </div>
                        <button class="btn btn-primary d-grid w-100">Send Reset Link</button>
                    </form>
                    <div class="text-center">
                        <a href="/login" class="d-flex align-items-center justify-content-center">
                            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                            Back to login
                        </a>
                    </div>


                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>
<!--/ Content -->
@include('backend.layout.footerFront')
