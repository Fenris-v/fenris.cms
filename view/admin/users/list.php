<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">Имя</th>
        <th scope="col">Логин</th>
        <th scope="col">Email</th>
        <th scope="col">Роль</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <?php
    try {
        includeView('render.usersList');
    } catch (Exception $exception) {
        echo $exception->getMessage() . ' ' . $exception->getCode();
    }
    ?>
</table>
