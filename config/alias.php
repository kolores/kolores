
<?php
return [
	'hurdles' => [
		'YearIsCurrent' => App\Hurdles\YearIsCurrent::class,
        'Guest' => \Chibi\Hurdle\ShouldBeGuest::class,
        'Auth' => \Chibi\Hurdle\ShouldAuthenticate::class,
    ]
];