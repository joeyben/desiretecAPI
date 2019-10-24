<div class="footer">
    <div class="container">
        <div class="col-md-12">
            <ul>
                <li>
                    © Copyright 2019 |
                </li>
                 @foreach (footers_by_whitelabel() as $footer)
                     <li>
                        <a href="{{ $footer->url }}" target="_blank">{{ $footer->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="uk-text-center">
            <!--<img uk-img data-src="<php echo URL_IMG;?>footer-logo.png" style="max-width:160px;">-->
            <span style="white-space: nowrap;"><span class="uk-text-middle uk-text-small uk-padding-remove">Mitglied im</span><a class="uk-padding-remove" href="https://v-i-r.de/" target="_blank" rel="nofollow"><img uk-img="" data-src="https://www.reise-rebellen.de/img/vir–weblogo–weiss.png" src="https://www.reise-rebellen.de/img/vir%E2%80%93weblogo%E2%80%93weiss.png"></a></span>
        </div>
    </div>
</div>
