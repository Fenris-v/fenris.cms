<?php

use App\Model\AdminPage;
use App\Model\Permission;

/** @noinspection PhpUndefinedVariableInspection */
if (count($params) < 2) {
    redirectOnPage($_SERVER['REQUEST_URI'] . '/list');
}

$page = new AdminPage();
$pageId = $page::all()->where('uri', $params[0])->first()->id;

try {
    includeView('layout.header', ['title' => $page->getTitle($params[0])]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

    <div class="adminContainer container-fluid">
        <div class="row">

            <?php
            try {
                includeView('render.sideAdminMenu', $page->getPagesForRole());
            } catch (Exception $exception) {
                echo $exception->getMessage() . ' ' . $exception->getCode();
            } ?>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <?php
                if (
                Permission::all()
                    ->where('admin_page_id', $pageId)
                    ->where('role_id', $_SESSION['role'])
                    ->first()
                ) {
                    try {
                        $templateName = getTemplateName('admin', $params);
                        includeView($templateName, [$params[array_key_last($params)]]);
                    } catch (Exception $exception) {
                        echo $exception->getMessage() . ' ' . $exception->getCode();
                    }
                } else { ?>
                    <h1 class="text-danger">Недостаточно прав!</h1>
                <?php
                } ?>
            </main>
        </div>
    </div>

<?php
try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}
