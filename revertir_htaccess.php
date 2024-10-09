<?php

// Ruta del archivo httpd.conf en XAMPP
$httpdConfPath = 'C:/xampp/apache/conf/httpd.conf';

// Lee el contenido del archivo
$httpdConf = file_get_contents($httpdConfPath);

// Deshabilitar el módulo mod_rewrite si está habilitado
if (strpos($httpdConf, 'LoadModule rewrite_module modules/mod_rewrite.so') !== false) {
    $httpdConf = str_replace('LoadModule rewrite_module modules/mod_rewrite.so', '#LoadModule rewrite_module modules/mod_rewrite.so', $httpdConf);
}

// Restaurar AllowOverride None en el directorio htdocs
$httpdConf = preg_replace(
    '/<Directory "C:\/xampp\/htdocs">(.|\n)*?AllowOverride All(.|\n)*?<\/Directory>/',
    '<Directory "C:/xampp/htdocs">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride None
    Require all granted
</Directory>',
    $httpdConf
);

// Escribir los cambios en el archivo httpd.conf
file_put_contents($httpdConfPath, $httpdConf);

echo "Los cambios han sido revertidos. Reinicia Apache para que los cambios surtan efecto.";

?>
