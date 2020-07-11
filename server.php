<?php
ini_set("soap.wsdl_cache_enabled", 0);
require_once __DIR__ . '/vendor/autoload.php';

class Hello
{
    /**
     * Say hello.
     *
     * @param string $firstName
     * @return string $greetings
     */
    public function sayHello($firstName)
    {
        return 'Hello ' . $firstName;
    }

    /**
     * Hi hello.
     *
     * @param string $firstName
     * @param string $lastName
     * @return string $greetings
     */
    public function hiHello($firstName, $lastName)
    {
        return 'Hi ' . $firstName . ' ' . $lastName;
    }

    /**
     * Say good bye.
     *
     * @param string $name
     * @return array $greetings
     */
    public function sayGoodbye($name)
    {
        return [
            'name' => $name,
            'greeting' => 'Good bye',
            'message' => 'Good bye, ' . $name,
        ];
    }

    /**
     * Say good bye.
     *
     * @return array $greetings
     */
    public function memberList()
    {
        $obj1 = new \stdClass;
        $obj1->id = 1;
        $obj1->name = 'Angga';

        $obj2 = new \stdClass;
        $obj2->id = 2;
        $obj2->name = 'Ari';

        return [
            $obj1, $obj2
        ];

        /*
        return [
            (object)[
                'id' => 1,
                'name' => 'Angga',
            ],
            (object)[
                'id' => 2,
                'name' => 'Ari',
            ],
            (object)[
                'id' => 3,
                'name' => 'Wijaya',
            ],
        ];
        */
    }
}

class MyService
{
    /**
     * Add
     *
     * @param int $x
     * @param int $y
     * @return int
     */
    public function add($x, $y)
    {
        return $x + $y;
    }
}

$serverUrl = "http://localhost/soap/server.php";
$server = new Zend\Soap\Server(null, [
    'uri' => $serverUrl,
    'cache_wsdl' => WSDL_CACHE_NONE
]);
//$server->setClass('Hello');
//$server->handle();

if (isset($_GET['wsdl'])) {
    $soapAutoDiscover = new \Zend\Soap\AutoDiscover(new \Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeSequence());
    $soapAutoDiscover->setBindingStyle(array('style' => 'document'))
        ->setOperationBodyStyle(array('use' => 'literal'))
        ->setClass('Hello')
        ->setUri($serverUrl);
    $wsdl = $soapAutoDiscover->generate();
    $wsdl->dump("service.wsdl");

    header("Content-Type: text/xml");
    echo $wsdl->toXml();
} else {
    $soap = new \Zend\Soap\Server($serverUrl . '?wsdl');
    $soap->setObject(new \Zend\Soap\Server\DocumentLiteralWrapper(new Hello()));
    $soap->handle();
}