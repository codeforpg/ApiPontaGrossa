<!DOCTYPE html>
<html lang="pt_BR">
    <head>

        <meta charset="utf-8" />
        <title>Post It</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/g/animatecss@3.4.0,rangeslider.js@2.0.4(rangeslider.css),colors.css@1.5.0,drop@1.4.0(css/drop-theme-arrows-bounce-dark.min.css),sweetalert@1.1.3(sweetalert.css)"  media="all">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.22.0/css/uikit.min.css"  media="all">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.22.0/css/uikit.gradient.min.css" media="all">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.22.0/css/components/notify.min.css" media="all">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:800,400' rel='stylesheet' type='text/css' media="all">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/g/uikit@2.22.0(css/components/slidenav.min.css)">
        <link rel="stylesheet" href="/assets/css/app.css" type="text/css" />
        @yield('styles')
    </head>
    <body >
        @yield('body')
        <script src="https://cdn.jsdelivr.net/g/jquery@3.0.0-alpha1,vue@1.0.7,uikit@2.22.0,uikit@2.22.0(js/components/notify.min.js),sweetalert@1.1.3"></script>
        <script type="text/javascript" src="/assets/js/app.js"></script>
        @yield('scripts')
    </body>
</html>
