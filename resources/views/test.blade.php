@use('Illuminate\Support\Facades\Vite')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['platform/modules/blog/resources/assets/css/blog.css', 'platform/modules/blog/resources/assets/js/blog.js'])
</head>
<body>
    <h1 class="blog">Blog {{ module_asset('base', '/base.png') }}</h1>
    <img src="{{ vite_module_asset('blog', '/assets/images/ipad.png') }}" alt="" width="100">
</body>
</html>