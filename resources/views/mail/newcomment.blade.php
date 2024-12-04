<x-mail::message>
    <x-mail::panel>
        # Добавлен новый комментарий к статье
        Название статьи: "{{ $article_name }}"
        Текст комментария: "{{ $text_comment }}"
    </x-mail::panel>
    <x-mail::button :url="$url">
        Просмотреть статью
    </x-mail::button>
    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>