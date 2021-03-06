<?php

namespace EventsForce\Resources;
use EventsForce\Exceptions\InvalidArgumentException;

/**
 * Class for handling the attendees resource on the Events Force API: http://docs.eventsforce.apiary.io/#reference/attendees
 *
 * @package EventsForce\Resources
 */
class Attendees extends EventBasedResource
{
    /**
     * Method to get all Attendees for an event
     * Api Docs: http://docs.eventsforce.apiary.io/#reference/attendees/eventseventidattendeesjsonlastmodifiedafterpaymentstatuscategoryregistrationstatus/get
     *
     * @param array $query
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws InvalidArgumentException
     */
    public function getAll($query = [])
    {
        if (!is_array($query)) {
            throw new InvalidArgumentException('If passing $query, it must be an array');
        }

        $request = $this->client->request([
            'endpoint' => $this->genEndpoint([$this->getEventId(), 'attendees.json'])
        ]);

        $request->setQuery($query);

        return $request->send();
    }

    /**
     * Method to get a single attendee for an event
     * Api Docs: http://docs.eventsforce.apiary.io/#reference/attendees/eventseventidattendeespersonidjson/get
     *
     * @param bool|int $attendee_id
     * @return \Psr\Http\Message\StreamInterface
     * @throws \EventsForce\Exceptions\EmptyResponseException
     */
    public function get($attendee_id = false)
    {
        if (!is_numeric($attendee_id) || $attendee_id < 0) {
            throw new InvalidArgumentException('You need to pass a positive numeric value as an attendee id');
        }

        $request = $this->client->request([
            'endpoint' => $this->genEndpoint([$this->getEventId(), 'attendees', $attendee_id . '.json'])
        ]);

        return $request->send();
    }

    /**
     * Method to update an attendee with a passed in set of data
     * Api docs: http://docs.eventsforce.apiary.io/#reference/attendees/eventseventidattendeespersonidjsonhttpmethodpatch/post
     * NOTE: NEEDS TESTING WITH FULL ACCESS API
     *
     * @param bool $attendee_id
     * @param array $data
     * @return \Psr\Http\Message\StreamInterface
     * @throws \EventsForce\Exceptions\EmptyResponseException
     */
    public function update($attendee_id = false, $data = [])
    {
        if (!is_numeric($attendee_id) || $attendee_id < 0) {
            throw new InvalidArgumentException('You need to pass a positive numeric value as an attendee id');
        }

        if (!is_array($data) || empty($data)) {
            throw new InvalidArgumentException('You need to pass a not empty array for data to update the attendee with');
        }

        $request = $this->client->request([
            'endpoint' => $this->genEndpoint([$this->getEventId(), 'attendees', $attendee_id . '.json'])
        ]);

        $request
            ->setQuery([
                '_Http_Method' => 'PATCH'
            ])
            ->setMethod('POST')
            ->setJson($data);

        return $request->send();
    }

    /**
     * Method to authenticate a user
     * API Docs - http://docs.eventsforce.apiary.io/#reference/attendees/eventseventidattendeesauthenticatejson/post
     *
     * @param bool $user_id
     * @param bool $password
     * @return \Psr\Http\Message\StreamInterface
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function auth($user_id = false, $password = false)
    {
        if ((!is_string($user_id) && !is_numeric($user_id)) || empty($user_id)) {
            throw new InvalidArgumentException('You must pass a user_id to authenticate an attendee - the required value is dependant on the attendeeIdMode set for an event');
        }

        if (!is_string($password) || empty($password)) {
            throw new InvalidArgumentException('You must pass a string non empty password in order to authenticate an attendee');
        }

        $request = $this->client->request([
            'endpoint' => $this->genEndpoint([$this->getEventId(), 'attendees', 'authenticate.json'])
        ]);

        $request
            ->setMethod('POST')
            ->setJson([
                'userID' => $user_id,
                'password' => $password
            ]);

        return $request->send();
    }
}