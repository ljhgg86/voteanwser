$answers=collect([
    '1'=>[2,3],
    '2'=>[1,2],
    '3'=>[1,3]
]);

$users=collect([
    '1'=>[2,3],
    '2'=>[1,2],
    '4'=>[1,3]
]);

$answers->map(function($item, $key){
    return collect($item)->implode(',');
})->diffAssoc($users->map(function($item, $key){
    return collect($item)->implode(',');
}));