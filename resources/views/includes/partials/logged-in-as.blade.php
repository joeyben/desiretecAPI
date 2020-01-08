@if ($logged_in_user && session()->has("admin_user_id") && session()->has("temp_user_id"))
    <div class="alert alert-warning logged-in-as">
        You are currently logged in as {{ $logged_in_user->first_name }}. <a href="{{ route("frontend.auth.logout-as") }}">Re-Login as {{ session()->get("admin_user_name") }}</a>.
    </div><!--alert alert-warning logged-in-as-->
@endif

@if (session('reset_password_success') && session()->has("reset_password_success"))
    <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered col-md-12 offset-md-12">
        <button type="button" class="close" data-dismiss="alert"> <span>x</span><span class="sr-only"></span> </button>
        <strong>{{ session('reset_password_success') }}</strong>
    </div>
@endif
