@component('mail::message')
# Nova senha do aplicativo {{ config('app.name') }}

Verificamos sua solicitação de nova senha ao aplicativo {{ config('app.name') }} às {{now()->format('d/m/Y H:i')}} .

Nova senha  {{ $senha  }}

Mensagem enviada automaticamente.



Obrigado,<br>
{{ config('app.name') }}
@endcomponent
