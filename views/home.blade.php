<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <div id="app">
			<flash message="Hi There!"></flash>
        <example-component></example-component>
        </div>
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
                
    </body>
</html>
