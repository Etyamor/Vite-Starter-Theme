<!DOCTYPE html>
<html @langattributes>
<head>
    <meta charset="{{ get_bloginfo('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @wphead
</head>
<body @bodyclass>
@wpbodyopen

@yield('content')

@wpfooter
</body>
</html>
