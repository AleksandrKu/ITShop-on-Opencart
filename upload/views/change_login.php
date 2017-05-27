<?php
require_once(__DIR__ . '/../../upload/bd_pdo.php');
$pdo = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database'], $opt);
$sql = "SELECT  id_supplier, login, password, supplier FROM login_password_to_suppliers  ORDER BY id_supplier ASC";
$stm = $pdo->getConnection()->query($sql);
?>
    <div class="panel panel-default" style=" text-align: center; border-radius:  8px ">
        <!-- Default panel contents -->
        <table class="table">
            <tr>
                <td>№</td>
                <td>Login</td>
                <td>Password</td>
                <td>Supplier</td>
                <td></td>
            </tr>
			<?php

			while ($row = $stm->fetch()) {
				?>
                <tr>
                    <td><input class="background" size="2" type="text" value="<?= $row['id_supplier'] ?>" readonly
                               id="id_supplier"></td>
                    <td><input class="background" size="20" type="text" value="<?= $row['login'] ?>" readonly id="login"></td>
                    <td><input class="background" size="40" type="text" value="<?= $row['password'] ?>" readonly id="password"></td>
                    <td><input class="background" size="30" type="text" value="<?= $row['supplier'] ?>" readonly id="supplier"></td>
                    <td>
                        <button class="btn btn-warning" id="edit"> Edit</button>
                        <button class="btn btn-success hidden" id="save"> Save</button>
                    </td>
                </tr>
				<?php
			}
			?>
        </table>

    </div>
<?php
/*$login_password_to_suppliers = [
'id_supplier' => '10',
'login' => 'homox@mail.ru',
'password' => '',
'supplier' => 'https://brain.com.ua/login'];
$pdo->insert('brain', $login_password_to_suppliers);*/