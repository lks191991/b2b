<?php

return [
   // 'source'      => ['app', 'database', 'routes'], 
	'source'      => ['app','routes'],// Path(s) to encrypt
    'destination' => 'encrypted', // Destination path
    'key_length'  => 6, // Encryption key length
];
