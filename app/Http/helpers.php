<?php
function status_html($num) {
    $color = [
        0 => 'rgb(102, 153, 0)',
        1 => 'green',
        2 => 'rgb(26, 174, 0)',
        3 => 'red',
        4 => 'rgb(6, 146, 255)',
        5 => 'rgb(153, 153, 153)',
        6 => 'rgb(255, 153, 0)',
        7 => 'rgb(255, 3, 250)',
        8 => 'blue',
        9 => 'rgb(187, 51, 143)',
        10 => 'rgb(187, 51, 143)',
        11 => 'rgb(187, 51, 143)',
        12 => 'rgb(187, 51, 143)',
        13 => 'rgb(187, 51, 143)',
        14 => 'rgb(187, 51, 143)',
    ];
    $status = config('soj.status');
    if($num > 4) $num /= 10000;
    return "<span style='color: $color[$num]'>$status[$num]</span>";
}

function status_select() {
    echo <<<EOF
<select class="form-control" name="status" id="status">
<option value='0'>All</option>
<option value='2'>Compilation error</option>
<option value='3'>Accepted</option>
<option value='6'>Wrong Answer</option>
<option value='7'>Memory Limit Exceeded</option>
<option value='8'>Output Limit Exceeded</option>
<option value='9'>Time Limit Exceeded</option>
<option value='10'>Presentation Error</option>
<option value='11'>Runtime Error</option>
</select>
EOF;
}

function lang_option() {
    echo <<<EOF
<option value="1">c</option>
<option value="2">c++</option>
<option value="3">java</option>
EOF;
}

function lang_html($num) {
    if(is_null($num) || $num <= 0 || $num >= 4) $num = 1;
    $lang = [
        1 => 'c',
        2 => 'c++',
        3 => 'java',
    ];
    return $lang[$num];
}