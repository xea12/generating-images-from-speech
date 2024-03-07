<?php
/*
 *
 * dodanie nazwy drukarki
 * lpadmin -p C5710 -v "ipps://EPSON%20WF-C5710%20Series._ipps._tcp.local/" -E -m everywhere
 */

// Wywołanie polecenia lpstat do wylistowania drukarek
$command = 'lpstat -s';
$output = shell_exec($command);

// Wyświetlenie wyników
echo "<pre>$output</pre>";