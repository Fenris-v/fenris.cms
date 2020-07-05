<?php

use App\Model\User;

?>
<tbody>
<?php
foreach (User::all() as $user): ?>
    <tr>
        <td><?=
            $user->getOriginal('name') ?></td>
        <td><?=
            $user->getOriginal('login')
            ?></td>
        <td><?=
            $user->getOriginal('mail')
            ?></td>
        <td><?=
            $user->getRoleName($user->getOriginal('id'))
            ?></td>
        <td>
            <a href="<?=
            '/admin/users/edit/' . $user->getOriginal('id')
            ?>">Изменить</a>
        </td>
    </tr>

<?php
endforeach; ?>
</tbody>
