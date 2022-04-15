<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>Laravel Twitter</title>
</head>
<body>

    <div id="app">

        <my-header-component></my-header-component>
        
        @yield('content')
        
    </div>
    
</body>
</html>