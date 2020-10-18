<?php
    require_once "../../../Server/Database/Crud/Bureau.php";

    use \Server\Database\Crud\Bureau;

    $bureau = new Bureau();

    /**
     *@var array $info [           - информация о людях и компаниях
     *  первый массив[0]           - сводка людей и компаний, внутри которого
     *                               массивы с индексами:  surname, name, year_of_birth,
     *                                                      gosreg_date, opf, title
     *  второй массив[1]              - "name" - имена пользователей
     *                                  "id"   - их id
     * ]
     *
     */

    $info = $bureau->index();
    $bureauInfo = $info[0];
    $persons    = $info[1];

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
                        <a class="nav-link" href="personsView.php">Пользователи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Компании</a>
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
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>Год рождения</th>
                                <th>Дата регистрации компании</th>
                                <th>ОПФ (ООО/ИП)</th>
                                <th>Наименование компании</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($bureauInfo as $info) { ?>
                                <tr id = "<?php echo $info["company_id"] ?>">
                                    <td>
                                        <input type="text" class = "form-control disable" value = "<?php echo $info["surname"] ?>" readonly>
                                    </td>

                                    <td>
                                        <input type="text" class = "form-control" value = "<?php echo $info["name"] ?>" readonly>
                                    </td>

                                    <td class = "text-right">
                                        <input type="text" class = "form-control" value = "<?php echo $info["year_of_birth"] ?>" readonly>
                                    </td>

                                    <td class = "text-right">
                                        <input type="text" class = "form-control" value="<?php echo $info["gosreg_date"] ?>" readonly>
                                    </td>

                                    <td>
                                        <input type="text" class = "form-control" value = "<?php echo $info["opf"] ?>" readonly>
                                    </td>

                                    <td>
                                        <input type="text" class = "form-control" value="<?php echo $info["title"] ?>" readonly>
                                    </td>

                                    <td>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-info edit" data-row="<?php echo $info["company_id"] ?>"></button>
                                                <button class="btn btn-success edit-complete d-none" data-row="<?php echo $info["company_id"] ?>"></button>
                                            </div>
                                            <div class="col-sm-6">
                                                <form method="post" action="../../../Server/Controllers/companyController.php">
                                                    <input type="hidden" name="action"       value="delete">
                                                    <input type="hidden" name="companyId" value = "<?php echo $info["company_id"] ?>">
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
                                <form method="post" action = "../../../Server/Controllers/companyController.php">
                                    <div class="form-group">
                                        <label for = "titleCompany">Наименование компании</label>
                                        <input name = "titleCompany"  id = "titleCompany"
                                               type="text" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label for = "opf">ОПФ</label>
                                        <select class="form-control form-control-sm" id="opf" name = "opf">
                                            <option value = "ООО">ООО</option>
                                            <option value = "ИП" >ИП</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for = "opf">Пользователь</label>
                                        <select class="form-control form-control-sm" id="personId" name = "personId">
                                            <?PHP foreach ($persons as $person) {?>
                                                <option value = "<?php echo $person["id"] ?>"><?php echo $person["name"] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for = "opf">Дата</label>
                                        <input type="date" class="form-control form-control-sm" name ="gosreg_date">
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
     *@var Object rowId        - id company, хранящееся в атрибуте поля, столбцы которого хранят информацию о компании и человеке
     *@var Object columns      - столбцы поля. Используется для предоставления пользователю
     *                           возможности редактирования содержимого данного поля путём
     *                           удаления атрибута readonly
     */

    $(".edit").on("click", function (el) {

        let rowId = el.target.getAttribute("data-row");
        let columns = $("#" + rowId)[0].children

        for (let i = 3; i < columns.length; i++) {
            columns[i].children[0].removeAttribute("readonly");
        }

        $(".edit-complete[data-row='" + rowId +"']").removeClass("d-none");
        $(".edit[data-row='" + rowId +"']").addClass("d-none");

    });

    /**
     * Обработка окончания редактирования поля
     * @var Object dataForEdit - новые данные компании,
     *               которые мы отправляем серверу для обновления
     *
     * После редактирования вновь запрещаем юзеру возможность редактировать
     * до тех пор, пока он не нажмёт на соответствующую кнопку
     */

    $('.edit-complete').on("click", function(el) {

        let rowId = el.target.getAttribute("data-row");
        let columns = $("#" + rowId)[0].children

        for (let i = 3; i < columns.length; i++) {
            columns[i].children[0].setAttribute("readonly", "");
            console.log(columns[i].children[0].value);
        }

        let dataForEdit = {
            companyId: rowId,
            gosreg_date: columns[3].children[0].value,
            opf: columns[4].children[0].value,
            title: columns[5].children[0].value,
            action: "edit"
        };

        $.ajax({
            url: "../../../Server/Controllers/companyController.php",
            type: "POST",
            data: dataForEdit,
            success: function(data) {
                // console.log(data);
            }
        });

        $(".edit[data-row='" + rowId +"']").removeClass("d-none");
        $(".edit-complete[data-row='" + rowId +"']").addClass("d-none");
    });
</script>
</body>
</html>
