<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');

        $this->get('/login')
            ->assertOk()
            ->assertSee('SiAkad-003')
            ->assertDontSee('Akun demo')
            ->assertDontSee('25k30003 / admin123')
            ->assertDontSee('dosen01 / dosen123')
            ->assertDontSee('mahasiswa123');
    }
}
