<?php

// error_exception.php - digunakan untuk menampilkan error saat CLI dijalankan
function cli_error($message, $file, $line)
{
    fwrite(STDERR, "Error: {$message} in {$file} on line {$line}\n");
}

set_error_handler('cli_error');
