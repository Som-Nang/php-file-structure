<?php
use Core\Container;
test('it can resolve out of the container', function () {
    // arrange
        $container = new Container();

        $container->bind('fool', fn() => 'bar');
    //act
        $result = $container->resolve('fool');
    // expect
        expect($result)->toEqual('bar');
});
