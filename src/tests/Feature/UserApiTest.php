<?php


it('is unauthorized to list users', function () {
    $response = $this->getJson('http://localhost:8080/api/users');

    $response->assertStatus(401);
});

it('logs in successfully', function () {
    $response = $this->post('http://localhost:8080/api/login', ['email' => 'diegoaguiarc@gmail.com', 'password' => 'password']);

    $response->assertStatus(200);

    $response->assertJsonStructure(['token']);

});

describe('logged in user', function () {
    beforeEach(function () {
        $this->token = $this->postJson('/api/login', [
            'email' => 'diegoaguiarc@gmail.com',
            'password' => 'password'
        ])->json('token');
    });

    it('can list users', function () {
        $response = $this->withHeaders([
                        'Authorization' => 'Bearer ' . $this->token,
                    ])->getJson('http://localhost:8080/api/users');

        $response->assertStatus(200);
    });
});
