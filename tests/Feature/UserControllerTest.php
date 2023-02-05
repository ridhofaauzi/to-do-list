<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "ridho"
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "ridho",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "ridho");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "ridho"
        ])->post('/login', [
            "user" => "ridho",
            "password" => "rahasia"
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "wrong",
            "password" => "wrong",
        ])->assertSeeText("Login is not successfully");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "ridho"
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
