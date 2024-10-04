<?php
it('validates a string', function(){
    expect(\Core\Validation::string('foobar'))->toBeTrue();
    expect(\Core\Validation::string(false))->toBeFalse();
    expect(\Core\Validation::string(''))->toBeFalse();
});


it('validates a string with minimum length', function(){
    expect(\Core\Validation::string('foobar', 20))->toBeFalse();
});

it('validates a email', function(){
    expect(\Core\Validation::email('foobar'))->toBeFalse();
    expect(\Core\Validation::email('foobar@gmail.com'))->toBeTrue();
});

//it('validates a number is greater than a given number', function(){
//    expect(\Core\Validation::greaterThan('foobar'))->toBeFalse();
//    expect(\Core\Validation::email('foobar@gmaiol.com'))->toBeTrue();
//});