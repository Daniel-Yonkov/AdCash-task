<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style2.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
      <div class="row">
		@yield('content')
      </div>  
    </div>
</body>
<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
	@yield('footer');
</script>
</html>