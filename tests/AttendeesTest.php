<?php
class AttendeesTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new EventsForce\Client('client_slug', 'apikey');
    }

    public function testSetEventAssigningCorrectly()
    {
        $this->client->attendees->setEvent(2);
        $this->assertEquals(2, $this->client->attendees->getEventId());
    }

    /**
     * @expectedException EventsForce\Exceptions\EventsForceException
     */
    public function testNotAllowingYouToGetEventIdIfNoEventIdSet()
    {
        $this->client->attendees->getEventId();
    }

    /**
     * @expectedException EventsForce\Exceptions\InvalidArgumentException
     */
    public function testSetEventFailingOnEmptyInput()
    {
        $this->client->attendees->setEvent();
    }

    /**
     * @dataProvider invalidInputSetEventProvider
     * @expectedException EventsForce\Exceptions\InvalidArgumentException
     */
    public function testSetEventFailingOnStringInput($value)
    {
        $this->client->attendees->setEvent($value);
    }

    public function invalidInputSetEventProvider()
    {
        return array(
            array('Test'),
            array(false),
            array(true),
            array(array(1,2,3)),
            array(-1)
        );
    }

    public function testGenEndpointWithString()
    {
        $endpoint = $this->client->attendees->genEndpoint('test.json');

        $this->assertEquals('events/test.json', $endpoint);
    }

    public function testGenEndpointWithArray()
    {
        $endpoint = $this->client->attendees->genEndpoint([2, 'test.json']);

        $this->assertEquals('events/2/test.json', $endpoint);
    }

    /**
     * @expectedException EventsForce\Exceptions\InvalidArgumentException
     */
    public function testGenEndpointFailingOnBoolInput()
    {
        $this->client->attendees->genEndpoint(true);
    }

    /**
     * @dataProvider invalidQueryGetAllProvider
     * @expectedException \EventsForce\Exceptions\InvalidArgumentException
     */
    public function testInvalidQueryGetAll($value)
    {
        $this->client->attendees->getAll($value);
    }

    public function invalidQueryGetAllProvider()
    {
        return array(
            array(true),
            array(false),
            array(''),
            array('test')
        );
    }

    /**
     * @dataProvider invalidQueryGetProvider
     * @expectedException \EventsForce\Exceptions\InvalidArgumentException
     */
    public function testInvalidQueryGet($value)
    {
        $this->client->attendees->get($value);
    }

    public function invalidQueryGetProvider()
    {
        return array(
            array(true),
            array(false),
            array(''),
            array('test'),
            array(-1)
        );
    }

    /**
     * @expectedException \EventsForce\Exceptions\InvalidArgumentException
     */
    public function testEmptyParamsUpdate()
    {
        $this->client->attendees->update();
    }

    /**
     * @dataProvider invalidParamsUpdateProvider
     * @expectedException \EventsForce\Exceptions\InvalidArgumentException
     */
    public function testInvalidParamsUpdate($id, $data)
    {
        $this->client->attendees->update($id, $data);
    }

    public function invalidParamsUpdateProvider()
    {
        return array(
            array('', ''),
            array(1, ''),
            array(1, 1),
            array(array(), array()),
            array('', 1),
            array(array(), 1),
            array(array(), ''),
            array(-1, array())
        );
    }

    /**
     * @expectedException \EventsForce\Exceptions\InvalidArgumentException
     */
    public function testEmptyAuthParams()
    {
        $this->client->attendees->auth();
    }
    /**
     * @expectedException \EventsForce\Exceptions\InvalidArgumentException
     */
    public function testEmptyAuthPassword()
    {
        $this->client->attendees->auth('test');
    }
    /**
     * @dataProvider invalidParamsAuthProvider
     * @expectedException \EventsForce\Exceptions\InvalidArgumentException
     */
    public function testInvalidParamsAuth($user, $password)
    {
        $this->client->attendees->update($user, $password);
    }

    public function invalidParamsAuthProvider()
    {
        return array(
            array('', ''),
            array(1, ''),
            array('shshs', 1),
            array('adasd', array()),
            array('asdsad', true),
            array(false, 'asdada'),
            array(true, 'dasdasd')
        );
    }

    /**
     * @expectedException \EventsForce\Exceptions\EventsForceException
     */
    public function testNotSetEventIdGetAll()
    {
        $this->client->attendees->getAll();
    }
    /**
     * @expectedException \EventsForce\Exceptions\EventsForceException
     */
    public function testNotSetEventIdGet()
    {
        $this->client->attendees->get(2);
    }
    /**
     * @expectedException \EventsForce\Exceptions\EventsForceException
     */
    public function testNotSetEventIdUpdate()
    {
        $this->client->attendees->update(2);
    }
    /**
     * @expectedException \EventsForce\Exceptions\EventsForceException
     */
    public function testNotSetEventIdAuth()
    {
        $this->client->attendees->auth('test', 'test');
    }
}