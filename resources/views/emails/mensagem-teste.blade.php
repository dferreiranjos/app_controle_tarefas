<x-mail::message>
# Introdução

Corpo da mensagem.

-Opção 1
-Opção 2
-Opção 3

<x-mail::button :url="''">
Botão de texto 1
</x-mail::button>

<x-mail::button :url="''">
Botão de texto 2
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
