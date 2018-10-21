<?php
echo "1";


$mass = [id => '1',
    name => 'odin',
    age => '12',
    email=> 'dsf@mail.ru',
    password=> 'sdf3rfs',
    birthday=>'01.12.31',
    ip=> '123.123.123.123',
    time=> '12.12',
    token =>  'sdfewfsfsdds',
    sourse => '23wewe3rwefge4ferge'
];
var_dump($mass);
echo ($mass['name']);

$template = [id=> '',
    name=> '',
    age=> '',
    email=> '',
    password=> '',
    birthday=> '',
    ip=> '',
    time=> '',
    token=> '',
    sourse=> ''];


var_dump(array_diff_key($template, $mass));


/*foreach ($template as $key => $value)
{
    print_r($mass[$value]);
    $result = array_search($mass, $value );
    print_r($result);
}*/



?>




