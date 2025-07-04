<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Desabilita verificação CSRF para testes
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }
}
