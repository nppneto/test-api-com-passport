## API com autentica��o Laravel/Passport

- composer require laravel/passport;
- Fazer refer�ncia a biblioteca do Passport no arquivo config/app.php [Laravel/Passport/PassportServiceProvider::class];
- php artisan migrate
- php artisan passport:install
- Fazer refer�ncia da biblioteca do Passport no model User.php [Laravel\Passport\HasApiTokens];
- Em app/Providers/AuthServiceProvider.php, descomentar 'App\Model' => 'App\Policies\ModelPolicy';
- Ainda em app/Providers/AuthServiceProvider.php, adicionar ao m�todo 'boot' a chamada das rotas do Passport [Passport::routes()];
- Em config/auth.php, adicione ao bloco 'guards' o array de configura��o: 'api' => array('driver' => 'passport', 'provider' => 'users');
- Para finalizar, crie o controller para User e crie as rotas;