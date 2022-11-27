

<form id="forgot-password-form" class="sign-in-cont" method="post">
    <div class="form-item">
        <input type="email" minlength=5 maxlength=50 name="recoverEmail" class="email" value=""
               required>
        <span class="form-pl not-empty">mail</span>
    </div>
    <div class="form-submit-buttons">

        <button class="btn primary-btn" type="submit">
            <span>reset password</span>
        </button>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/re-password.js') }}"></script>

