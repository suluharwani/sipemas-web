

<!-- admin.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Admin List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <!-- admin/create.php -->

<h1>Buat Admin</h1>

<form action="<?= base_url('admin/create') ?>" method="post">
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <button type="submit">Create</button>
    </div>
</form>
    <h1>Admin List</h1>
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
        </tr>
        <?php foreach ($admins as $admin) : ?>
            <tr>
                <td><?php echo $admin['username']; ?></td>
                <td><?php echo $admin['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h1>Laporan List</h1>
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
        </tr>
        <?php foreach ($laporan as $lap) : ?>
            <tr>
                <td><?php echo $lap['nama']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

