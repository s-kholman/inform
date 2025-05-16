<?php

namespace Tests\Feature;

use Tests\TestCase;

class LimitSmsInTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this
            ->post('/sms_in',
                [
                    'phone' => '+79026223673'
                ])
            ->assertStatus(302)
           ;

        $this
            ->post('/sms_in',
                [
                    'phone' => '+79026223673'
                ])
            ->assertStatus(302)
        ;


        $this
            ->post('/sms_in',
                [
                    'phone' => '+79026223672'
                ])
            ->assertStatus(302)
            ->assertHeader('X-Ratelimit-Limit', 1)
        ;

        $this
            ->post('/sms_in',
                [
                    'phone' => '+79026223672'
                ])
            ->assertStatus(200);
    }
}
