$router->post('/gle/upload', 'LedgerController@upload');
$router->post('/gle/check', 'LedgerController@check');
$router->post('/gle/insert', 'LedgerController@insert');

$router->post('/gl-codes/upload', 'GLCodeController@upload');
$router->post('/gl-codes/preview', 'GLCodeController@preview');
$router->post('/gl-codes/insert', 'GLCodeController@insert');