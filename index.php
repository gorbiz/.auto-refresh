<?php

function find_file() {
    foreach (scandir('../') as $file) {
        if ($file[0] == '.') continue;
        if (strtolower($file) == 'index.html' || strtolower($file) == 'index.php') {
            return $file;
        }
    }
    foreach (scandir('../') as $file) {
        if ($file[0] == '.') continue;
        if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), array('php', 'html'))) {
            return $file;
        }
    }
    return false;
}

if (isset($_GET['f']) && !empty($_GET['f'])) {
    $file = $_GET['f'];
} else {
    $file = find_file();
}

$absolute_file = '..' . DIRECTORY_SEPARATOR . $file;

if (!$file || !file_exists($absolute_file)) {
    echo "Can't find file.";
    die;
}

if (isset($_GET['modified'])) {
    $current_modified = filemtime($absolute_file);
    $last_modified = ($_GET['modified'] > 0 ? $_GET['modified'] : $current_modified);
    while ($current_modified <= $last_modified) {
        usleep(10000);
        clearstatcache();
        $current_modified = filemtime($absolute_file);
    }
    echo json_encode(array("modified" => $current_modified));
    die;
}

?><!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="utf-8" />
    
    <?php if (isset($_GET['m'])) : ?>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <?php endif; ?>
    
    <title>.auto-refresh</title>

    <script src="http://code.jquery.com/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script type="text/javascript">

        var file = '<?php echo $file; ?>';

        var modified = 0;
        function updateIfModified() {
            url = '?f=' + file + '&modified=' + modified;
            console.log(url);
            $.ajax({
                url: url,
                dataType: 'json',
                success: function(data) {
                    modified = data['modified'];
                    var x = $("#iframe").attr('src');
                    x += (x.indexOf('?') != -1) ? '&' : '?';
                    $("#iframe").attr('src', x + 'r=' + (new Date()).getTime());
                    setTimeout(updateIfModified, 100);
                },
                error: function() {
                    setTimeout(updateIfModified, 1000);
                }
            });
        }

        $(document).ready(function() {
            updateIfModified();
            $("#iframe").attr('src', '../' + file);
        });

    </script>
</head>

<body style="height: 100%; margin: 0; padding:0; margin:0;">
    <iframe src="http://hak.alkoholisten.se/dev/map/" id="iframe" style="position:absolute; top:0px; left:0px; border: 0; width: 100%; height: 100%"></iframe>
</body>
</html>
