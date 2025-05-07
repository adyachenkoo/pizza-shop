<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            background-color: #222;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Спасибо за заказ!</h1>
</div>
<div class="content">
    <p>Здравствуйте, {{ $order->user->name }}!</p>
    <p>Ваш заказ #{{ $order->id }} был успешно оформлен.</p>
    <p>Адрес доставки: {{ $order->address }}</p>
    <p>Время доставки: {{ $order->delivery_time }}</p>
    <p>Мы скоро с вами свяжемся.</p>
</div>
</body>
</html>
