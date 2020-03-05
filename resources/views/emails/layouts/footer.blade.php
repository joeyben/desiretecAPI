<hr style="background: #e7e7e7;border: none;height: 1px;margin-top: 30px;">
<p style="
            line-height: 24px;
            font-size: 12px;
            color: #000;
            width:100%;">
    @if(isset($whitelabelId) && !is_old_whitelabel())
        {!! wl_email_signature($whitelabelId) !!}
    @else
        {!! Lang::get('email.email_signature') !!}
    @endif
</p>
<hr style="background: #e7e7e7;border: none;height: 1px;">
