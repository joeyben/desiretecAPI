@extends('emails.layouts.app')

@section('content')
    <div class="content">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">

                        <p style="line-height: 24px; margin-bottom:15px;">
                            {{ trans('autooffer.email.header') }}
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">

                            {!! trans('autooffer.email.body', ['url' => $url]) !!}

                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
    </div>
@endsection
