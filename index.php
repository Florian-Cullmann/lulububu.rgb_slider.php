<!doctype html>
<html lang="de">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet">
    <title>RGB Slider</title>
</head>
<body>
<div class="container">
    <h1 class="mt-2 text-center">RGB Slider Datenbank</h1>

    <form action="/" method="POST">

    </form>
    <input id="demo-input" type="text" value="rgb(255, 128, 0)" />

    <script src="//code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
    <script>
        $(function () {
            // Basic instantiation:
            $('#demo-input').colorpicker();

            // Example using an event, to change the color of the #demo div background:
            $('#demo-input').on('colorpickerChange', function(event) {
                $('#demo').css('background-color', event.color.toString());
            });
        });
    </script>
</body>
</html>