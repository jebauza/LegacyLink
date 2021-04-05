@component('emails.message')
# Querido cliente {{ $client->fullName }}.

El siguiente enlace le permite la administración de la web de {{ $profile->fullName }}.

@component('mail::button', ['url' => config('albia.web_client_url') . '/admin?token=' . $token, 'color' => 'success'])
{{ 'administrar' }}
@endcomponent

Saludos, y que estés bien !
@endcomponent
