<div class="footer">
    <div class="container">
        <div class="col-md-12">
            <ul class="list-inline">
                @foreach (footers_by_whitelabel() as $footer)
                    <li class="list-inline-item">
                        <a href="{{ $footer->url }}" target="_blank">{{ $footer->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
