<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** Signed-out visitors are sent to the login page. */
    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect();
    }
}
