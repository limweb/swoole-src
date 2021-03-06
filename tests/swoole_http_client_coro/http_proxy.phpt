--TEST--
swoole_http_client_coro: http client with http_proxy
--SKIPIF--
<?php
require __DIR__ . '/../include/skipif.inc';
skip_if_no_http_proxy();
?>
--FILE--
<?php
require __DIR__ . '/../include/bootstrap.php';
go(function () {
    $domain = 'www.qq.com';
    $cli = new Swoole\Coroutine\Http\Client($domain, 443, true);
    // $cli->setHeaders(['Host' => $domain]); // without host header it can also work well
    $cli->set([
        'timeout' => 5,
        'http_proxy_host' => HTTP_PROXY_HOST,
        'http_proxy_port' => HTTP_PROXY_PORT
    ]);
    $result = $cli->get('/');
    assert($result);
    assert(stripos($cli->body, 'tencent') !== false);
    echo "DONE\n";
});
?>
--EXPECT--
DONE
