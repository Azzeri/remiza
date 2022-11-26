<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/093e387b29.js" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
            <script src="http://localhost:8080/js/bundle.js"></script>
        @endenv
         <!-- BEGIN PLERDY CODE -->
        <script type="text/javascript" defer data-plerdy_code='1'>
            var _protocol="https:"==document.location.protocol?" https://":" http://";
            _site_hash_code = "a99594ff4d81f21031e4049a89f4d2d5",_suid=32469, plerdyScript=document.createElement("script");
            plerdyScript.setAttribute("defer",""),plerdyScript.dataset.plerdymainscript="plerdymainscript",
            plerdyScript.src="https://a.plerdy.com/public/js/click/main.js?v="+Math.random();
            var plerdymainscript=document.querySelector("[data-plerdymainscript='plerdymainscript']");
            plerdymainscript&&plerdymainscript.parentNode.removeChild(plerdymainscript);
            try{document.head.appendChild(plerdyScript)}catch(t){console.log(t,"unable add script tag")}
        </script>
        <!-- END PLERDY CODE -->

    </body>
</html>
