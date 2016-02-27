<!DOCTYPE html>
<html lang="pt_BR">
    <head>

        <meta charset="utf-8" />
        <title>Post It</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/g/animatecss@3.4.0,rangeslider.js@2.0.4(rangeslider.css),colors.css@1.5.0,drop@1.4.0(css/drop-theme-arrows-bounce-dark.min.css),sweetalert@1.1.3(sweetalert.css)"  media="all">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.22.0/css/uikit.min.css"  media="all">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.22.0/css/uikit.gradient.min.css" media="all">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.22.0/css/components/notify.min.css" media="all">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:800,400' rel='stylesheet' type='text/css' media="all">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/g/uikit@2.22.0(css/components/slidenav.min.css)">
        <link href="//cdn.muicss.com/mui-0.4.4/css/mui.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/assets/css/app.css" type="text/css" />
        @yield('styles')
    </head>
    <body>
        <header class="uk-panel uk-panel-box uk-margin-bottom">
            <nav class="uk-container uk-container-center">
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-hidden-small">
                        <strong>Post It</strong>
                    </div>
                    <div class="uk-width-medium-2-3 uk-width-small-1-1 uk-text-right">
                        <a href="http://www.minhapg.com.br" class="uk-button">Minha PG</a>
                        <a href="#novo" class="uk-button uk-button-primary">Novo PostIt</a>
                    </div>
                </div>
            </nav>
        </header>
        @yield('body')
        <footer>
            <div class="uk-container uk-container-center uk-text-contrast">
                <ul class="uk-list">
                    <li><a href="http://www.minhapg.com.br">MinhaPG</a></li>
                    <li><a href="https://www.facebook.com/Code-For-Ponta-Grossa-1663271337246663/?fref=ts">Code For PG</a></li>
                    <li><a href="http://github.com/codeforpg">GitHub</a></li>
                </ul>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/g/jquery@3.0.0-alpha1,vue@1.0.7,uikit@2.22.0,uikit@2.22.0(js/components/notify.min.js),sweetalert@1.1.3"></script>
        <script src="//cdn.muicss.com/mui-0.4.4/js/mui.min.js"></script>
        <script src="https://raw.githubusercontent.com/morr/jquery.appear/master/jquery.appear.js"></script>
        <script type="text/javascript" src="/assets/js/app.js"></script>
        @yield('scripts')
    </body>
</html>
