<!-- resources/views/emails/no_closure.blade.php -->

@component('mail::message')
# Merhaba {{ $customerName }},

<b>{{$date}}</b> dönemi içerisinde onaylanan başvurularınız için henüz ay kapama işlemi yapılmamıştır. Lütfen işlemlerinizi tamamlamanızı rica ederiz.

<a href="{{env('APP_URL')}}" target="_blank">Satış Sonrası Portalı</a>'nda yer alan "Ay Kapama" menüsünden işlemlerinizi tamamlayabilirsiniz.

Eğer herhangi bir sorunuz varsa lütfen bizimle iletişime geçiniz.

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
