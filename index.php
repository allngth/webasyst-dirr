<?php

function getFiles($path, $conf) {
    $res = [];

    $files = array_diff(scandir($path), array('..', '.'));

    foreach ($files as $file) {
        if (is_dir($path.'/'.$file) && !isDirIgnored($file, $conf)) {
            $res[$file] = getFiles($path.'/'.$file, $conf);
        } elseif (!isFileIgnored($file, $conf)) {
            $res[] = $file;
        }
    }

    return $res;
}

function initCheck() {
    $conf = require __DIR__.'/'.'conf.php';

    $filesFrom = getFiles($conf['from'], $conf);
    $filesTo = getFiles($conf['to'], $conf);

    return compareDirs($filesFrom, $filesTo);
}

function compareDirs($from, $to) {
    $diff = [];

    foreach ($from as $key => $val) {
        if (is_array($val) && !isset($to[$key])) {
            $diff[$key] = $val;
        } elseif (is_array($val)) {
            $subDiff = compareDirs($val, $to[$key]);

            if (!empty($subDiff)) {
                $diff[$key] = $subDiff;
            }
        } elseif (!in_array($val, $to)) {
            $diff[$key] = $val;
        }
    }

    return $diff;
}

function isDirIgnored($dir, $conf) {
    $res = false;

    if (in_array($dir, $conf['ignoredDir'])) {
        $res = true;
    }

    return $res;
}

function isFileIgnored($file, $conf) {
    $res = false;

    if (in_array($file, $conf['ignoredFiles'])) {
        $res = true;
    }

    return $res;
}

$diff = initCheck();

print_r($diff);