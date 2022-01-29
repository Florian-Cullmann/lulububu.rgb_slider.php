<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://lulububu.fcullmann.com/api/");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, 'lulububu:qYgenu*rJPo_WVuuQDUr2R');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['scope' => 'get']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$colors = json_decode(curl_exec($ch));
curl_close($ch);

$table_output = '';
foreach ($colors as $color) {
    $table_output .= '
        <tr id="'.$color->id.'">
            <td>'.$color->id.'</td>
            <td>'.$color->name.'</td>
            <td style="background-color:rgb('.implode(", ", [$color->r, $color->g, $color->b]).');"></td>
            <td class="text-end"><a class="btn btn-danger btn-sm" onClick="delete_color('.$color->id.');">x</a></td>
        </tr>
    ';
}
?>
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

    <table id="color_table" class="table table-hover mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Farbe</th>
            </tr>
        </thead>
        <tbody>
            <?= $table_output ?>
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
                            <input class="form-control" id="demo-input" name="insert_color" type="text" value="rgb(0, 0, 0)" />
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                    <button type="button" class="btn btn-primary" id="add_color_btn">Speichern</button>
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

        function delete_color(id) {
            $.ajax
            ({
                type: "POST",
                url: "api/",
                dataType: 'json',
                headers: {"Authorization": "Basic " + btoa('lulububu:qYgenu*rJPo_WVuuQDUr2R')},
                data: '{ "scope":"delete_color", "id":' + id + ' }',
                success: function (response){
                    var row = document.getElementById(id);
                    row.parentNode.removeChild(row);
                }
            });
        }

        $('#add_color_btn').click(function(){
            var name = $('#insert_name').val();
            var color = $('#demo-input').val();
            color = color.substring(4, color.length -1).split(', ');
            $.ajax
            ({
                type: "POST",
                url: "api/",
                dataType: 'json',
                headers: {"Authorization": "Basic " + btoa('lulububu:qYgenu*rJPo_WVuuQDUr2R')},
                data: '{ "scope":"add_color", "data":{"name":"' + name + '", "r":"' + color[0] + '", "g":"' + color[1] + '", "b":"' + color[2] + '"}}',
                success: function (response){
                    console.log(response);
                    console.log(color.join(', '));
                    var color_table = document.getElementById('color_table');
                    var row = color_table.insertRow(1);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    cell1.innerHTML = response.inserted_id;
                    cell2.innerHTML = name;
                    cell3.style.backgroundColor = 'rgb(' + color.join(', ') + ')';
                    cell4.classList.add('text-end');
                    cell4.innerHTML = '<a class="btn btn-danger btn-sm" onclick="delete_color(' + response.inserted_id + ');">x</a>';
                    $('#new_modal').modal('hide');
                }
            });
        });
    </script>
</body>
</html>