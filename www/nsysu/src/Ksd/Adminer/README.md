# ksd-adminer

### Configuration
add in `confg/app.php`
```
'providers' => [
    Ksd\Adminer\Providers\MemberServiceProvider::class,
]
```

#### Aliases
```
'aliases' => [
    'Member' => Ksd\Adminer\Facades\Member::class,
]
```
