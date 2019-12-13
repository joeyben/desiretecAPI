<div class="kwp-content kwp-completed-master">
    <h1><i class="master-icon--check"></i>Vielen Dank, Ihr Reisewunsch wurde versandt.</h1>
    <p>
       @if ($is_auto)
           {{ trans('layer.autooffer.created') }}
       @else
            Ein Berater aus dem Reisebüro nimmt sich Ihrer Wünsche an.<br>
            Wenn Sie Ihren Reisewunsch noch einmal überprüfen oder ändern möchten, <a  href="{{ route('bild.wish.details', [$id, $token]) }}" target="_blank">klicken Sie bitte hier.</a>
       @endif
    </p>
</div>
