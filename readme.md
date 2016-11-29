# Projekt PDT - Kam večer

##Popis
Projekt umožňuje zobraziť miesta kam by sme chceli ísť večer.
Na výber sú lokality ako kino, divadlo, krčma, bar, reštaurácia či kaviareň.
Tieto body možno filtrovať podľa vzdialenosti od pozície kliknutej na mape.
Ďalej možno filtrovať podľa mestských častí Bratislavy, ktoré sú znázornené
po výbere na mape. Toto zobrazenie možno vypnúť.
Je možné vybrať, či chceme ísť autom alebo MHD. Na základe toho sa zabrazia
buď najbližsie zastávky alebo parkoviská.
## Požiadavky
- PHP > 5.6
- composer
- PostgreSQL

## Inštalácia
- spustenie príkazov
```
$ composer install
$ sudo chmod -R 777 storage/
$ sudo chmod -R 777 bootstrap/cache/
$ cp .env.example .env
$ php artisan key:generate
```
- vytvorenie a import databázy
- nastavenie konfigurácie databázy v `.env` súbore
- spustenie servera
```
$ php artisan serve
```

## Zdroj dát
https://mapzen.com/data/metro-extracts/metro/bratislava_slovakia/
