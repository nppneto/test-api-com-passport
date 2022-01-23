## API com autenticação Laravel/Passport

- composer require laravel/passport;
- Fazer referência a biblioteca do Passport no arquivo config/app.php [Laravel/Passport/PassportServiceProvider::class];
- php artisan migrate
- php artisan passport:install
- Fazer referência da biblioteca do Passport no model User.php [Laravel\Passport\HasApiTokens];
- Em app/Providers/AuthServiceProvider.php, descomentar 'App\Model' => 'App\Policies\ModelPolicy';
- Ainda em app/Providers/AuthServiceProvider.php, adicionar ao método 'boot' a chamada das rotas do Passport [Passport::routes()];
- Em config/auth.php, adicione ao bloco 'guards' o array de configuração: 'api' => array('driver' => 'passport', 'provider' => 'users');
- Para finalizar, crie o controller para User e crie as rotas;