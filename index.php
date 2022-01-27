<?php require_once(__DIR__.'/core/db_config.php'); ?>
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

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new_modal">
        Neuer Eintrag
    </button>

    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Farbe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Coole Farbe</td>
                <td style="background-color:rgb(80, 120, 0);"></td>
            </tr>
        </tbody>
    </table>


    <!-- New Entry -->
    <div class="modal fade" id="new_modal" tabindex="-1" aria-labelledby="new_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new_modal_label">Neuer Eintrag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="/_actions.php" method="POST">
                        <div class="mb-3">
                            <label for="insert_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="insert_name" name="insert_name">
                        </div>

                        <div class="mb-3">
                            <label for="insert_name" class="form-label">Farbe</label>
                            <input class="form-control" id="demo-input" type="text" value="rgb(0, 0, 0)" />
                        </div>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                    <button type="button" class="btn btn-primary">Speichern</button>
                </div>
            </div>
        </div>
    </div>

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