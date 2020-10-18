<?php
    require_once "../../../Server/Database/Crud/Persons.php";

    use \Server\Database\Crud\Persons;

    $persons = new Persons();

    /**
     *@var array $personsInfo [           - информация о людях
     *      id, name, surname, year_of_birth
     *]
     */

    $personsInfo = $persons->index();

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Таблица</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <style>
            .edit, .edit-complete, .delete {
                width:36px;
                height: 36px;
            }
            .edit {
                background: url('../../../src/icons/edit-icon.svg') no-repeat center;
            }
            .edit-complete {
                background: url('../../../src/icons/success.svg') no-repeat center;
            }
            .delete {
                background: url('../../../src/icons/delete-icon.svg') no-repeat center;
            }
        </style>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-3">
                <nav>
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Пользователи</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="companyView.php">Компании</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-9">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Фамилия</th>
                                    <th>Год рождения</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($personsInfo as $person) { ?>
                                    <tr id = "<?php echo $person["id"] ?>">
                                        <td>
                                            <input type="text" class = "form-control disable" value = "<?php echo $person["name"] ?>" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class = "form-control" value = "<?php echo $person["surname"] ?>" readonly>
                                        </td>

                                        <td class = "text-right">
                                            <input type="text" class = "form-control" value = "<?php echo $person["year_of_birth"] ?>" readonly>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button class="btn btn-info edit" data-row="<?php echo $person["id"] ?>"></button>
                                                    <button class="btn btn-success edit-complete d-none" data-row="<?php echo $person["id"] ?>"></button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <form method="post" action="../../../Server/Controllers/personsController.php">
                                                        <input type="hidden" name="action"   value="delete">
                                                        <input type="hidden" name="personId" value = "<?php echo $person["id"] ?>">
                                                        <input type="submit" class="btn btn-sm btn-warning delete" value = "">
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-4">
                                    <form method="post" action = "../../../Server/Controllers/personsController.php">
                                        <div class="form-group">
                                            <label for = "name">Имя: </label>
                                            <input name = "name"  id = "name"
                                                   type="text" class="form-control form-control-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for = "surname">Фамилия</label>
                                            <input name = "surname"  id = "surname"
                                                   type="text" class="form-control form-control-sm">
                                        </div>
                                        <div class="form-group">
                                            <label for = "year_of_birth">Год рождения</label>
                                            <input name = " year_of_birth"  id = " year_of_birth"
                                                   type="text" class="form-control form-control-sm"
                                                   maxlength=4>
                                        </div>
                                        <input type="hidden" name = "action" value = "create">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success" value = "Сохранить">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!--jquery-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>

        /**
         * Обработка события нажатия на клавишу редактирования
         *  @var Object rowId        - id person, хранящееся в атрибуте поля, столбцы которого хранят информацию о пользователе
         *  @var Object columns      - столбцы поля. Используется для предоставления пользователю
         *                           возможности редактирования содержимого данного поля путём
         *                           удаления атрибута readonly
         */

        $(".edit").on("click", function (el) {

            let rowId = el.target.getAttribute("data-row");
            let columns = $("#" + rowId)[0].children

            console.log(rowId, columns);

            for (let i = 0; i < columns.length; i++) {
                columns[i].children[0].removeAttribute("readonly");
            }

            $(".edit-complete[data-row='" + rowId +"']").removeClass("d-none");
            $(".edit[data-row='" + rowId +"']").addClass("d-none");

        });

        /**
         * Обработка окончания редактирования поля
         * @var Object dataForEdit - новые данные пользователя,
         *               которые мы отправляем серверу для обновления
         *
         * После редактирования вновь запрещаем юзеру возможность редактировать
         * до тех пор, пока он не нажмёт на соответствующую кнопку
         */

        $('.edit-complete').on("click", function(el) {

            let rowId = el.target.getAttribute("data-row");
            let columns = $("#" + rowId)[0].children

            for (let i = 0; i < columns.length; i++) {
                columns[i].children[0].setAttribute("readonly", "");
                console.log(columns[i].children[0].value);
            }

            let dataForEdit = {
                personId: rowId,
                name: columns[0].children[0].value,
                surname: columns[1].children[0].value,
                year_of_birth: columns[2].children[0].value,
                action: "edit"
            };

            $.ajax({
                url: "../../../Server/Controllers/personsController.php",
                type: "POST",
                data: dataForEdit,
                success: function(data) {
                    console.log(data);
                }
            });

            $(".edit[data-row='" + rowId +"']").removeClass("d-none");
            $(".edit-complete[data-row='" + rowId +"']").addClass("d-none");
        });
    </script>
    </body>
</html>
