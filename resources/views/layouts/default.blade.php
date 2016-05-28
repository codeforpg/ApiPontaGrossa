<!DOCTYPE html>
<html lang="pt_BR">
    <head>

        <meta charset="utf-8" />
        <title>Post It</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//cdn.muicss.com/mui-0.5.3/css/mui.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/app.css" type="text/css" />
        @yield('styles')
    </head>
    <body>
        <header class="mui-appbar mui--z1">
            <div class="mui-container">
                <table width="100%">
                    <tr class="mui--appbar-height">
                        <td class="mui--text-title">Post It :: Code for Ponta Grossa</td>
                    </tr>
                </table>
            </div>
        </header>
        <div class="mui-container-fluid">
            <div class="mui--appbar-height"></div>
            <div class="mui-container">
            @yield('body')
            </div>
        </div>
        <footer>
            <div class="mui-container mui--text-center">
                Criado por <a href="https://www.github.com/codeforpg">Code For PG</a>
            </div>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/react/15.0.1/react.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/react/15.0.1/react-dom.min.js"></script>
        <script src="//cdn.muicss.com/mui-0.5.3/react/mui-react.js"></script>
        <script type="text/javascript" src="/assets/js/app.js"></script>
        @yield('scripts')
    </body>
</html>
