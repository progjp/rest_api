<?php

namespace tests;

use App\User;

class APITest extends \TestCase
{
    /**
     * A basic integration test.
     *
     * @return void
     */
    public function testComplex()
    {
        $users = factory(User::class, 5)->create();

        \Auth::login($users[0]);
        $this->visit('/api/social/friend')->seeJsonEquals([]);
        $this->post('/api/social/people/' . $users[1]->id . '/add');

        \Auth::login($users[1]);
        $this->visit('/api/social/request')->seeJsonContains(['_id' => $users[0]->id]);
        $this->post('/api/social/request/' . $users[0]->id . '/confirm');

        \Auth::login($users[0]);
        $this->visit('/api/social/friend')->seeJsonContains(['_id' => $users[1]->id]);
    }
}
