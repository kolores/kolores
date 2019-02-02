<?php

use App\Constraints\UserName;
use Chibi\App;
use Chibi\Auth\Auth;
use Chibi\Request;
use Chibi\Validation\Rule;
use Chibi\Validation\Validator;

$router->get('/user', 'App\Controllers\HomeController@views')->named('customers');

$router->get('/configs', 'App\Controllers\HomeController@testConfig');

$router->get('/guest', function (){
})->allow("YearIsCurrent");

$router->get('/', function (){
    return 'Sorry You are connected';
})->allow('Guest')->named('home');

$router->get('/test', function() {

    dd(Auth::against('users')->canLogin('inanielhoussain@gmail.com', '123456', function ($user){
        return $user->state == 1;
    }));
    die();
    //Auth::against('users')->loginWith(1); // force login

    Auth::against('users')->user(); // Get the connected user



    dump(App::getInstance()->getContainer()->auth);
    $om = App::getInstance()->getContainer()->om;
    /* @var $om Chibi\ObjectManager\ObjectManager */
    $dispatcher = $om->resolve(\Chibi\Events\Dispatcher::class);
    $name = "Houssain";
    $dispatcher->addListeners("EntredLinkEvent", $om->resolve(\App\Listeners\SayHello::class));
    $dispatcher->addListeners("EntredLinkEvent", $om->resolve(\App\Listeners\SaveMeAsUser::class));
    $dispatcher->dispatch($om->create(\App\Events\EntredLinkEvent::class, [$name]));
})->named('test');

$router->get('/hola/{name}', function($name, $h) {
    echo route('customers', [
        $name, 'two'
    ]);
})->named('Hola');

/*$router->get('/katana', function () {
    dump(\App\Friend::all());
    die();
    return view('token');
});*/

$router->get('/katana', function () {
    $data = [
        'name' => 'Inani',
        'age' => 20,
        'username' => 'Houssa_in'
    ];

    $validator = new Validator($data);

    $validator
        ->addRule(
        (
            new Rule('name'))->required()->max(10)->min(2)
        )
        ->addRule(
            (new Rule('age'))->required()->number()
        )->addRule(
            (new Rule('username'))->inject( new UserName())
        );

    dump($validator->check(), $validator->getErrors());
})->named('test_csrf');

$router->get('/ageNotOk', function (){
    return "Age NOT OK";
})->named('not_ok_age');