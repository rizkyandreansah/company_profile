<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Serasi Tunggal Mandiri</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('compro/assets/favicon.jpg') }}"/>

    @include('includes.compro.style')
    @yield('style')

    </head>
    <body id="page-top">
        
        <!-- Navigation-->
        @include('includes.compro.navbar')
        <!--End Of Navigation-->
      
        <!--content -->
        @yield('content')

        <!--footer-->
        @include('includes.compro.footer')
    
    @include('includes.compro.script')
    @yield('script')
    </body>
</html>