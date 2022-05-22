<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'laravel/laravel';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'brick/math' => '0.9.3@ca57d18f028f84f777b2168cd1911b0dee2343ae',
  'coingate/coingate-php' => '3.0.5@c9e7f2c291cf8d5118c73028280aaa25a53c2302',
  'composer/ca-bundle' => '1.3.1@4c679186f2aca4ab6a0f1b0b9cf9252decb44d0b',
  'composer/package-versions-deprecated' => '1.11.99.5@b4f54f74ef3453349c24a845d22392cd31e65f1d',
  'dflydev/dot-access-data' => 'v3.0.1@0992cc19268b259a39e86f296da5f0677841f42c',
  'doctrine/inflector' => '2.0.4@8b7ff3e4b7de6b2c84da85637b59fd2880ecaa89',
  'doctrine/lexer' => '1.2.3@c268e882d4dbdd85e36e4ad69e02dc284f89d229',
  'dragonmantank/cron-expression' => 'v3.3.1@be85b3f05b46c39bbc0d95f6c071ddff669510fa',
  'egulias/email-validator' => '3.1.2@ee0db30118f661fb166bcffbf5d82032df484697',
  'ezyang/htmlpurifier' => 'v4.14.0@12ab42bd6e742c70c0a52f7b82477fcd44e64b75',
  'fruitcake/php-cors' => 'v1.2.0@58571acbaa5f9f462c9c77e911700ac66f446d4e',
  'graham-campbell/result-type' => 'v1.0.4@0690bde05318336c7221785f2a932467f98b64ca',
  'guzzlehttp/guzzle' => '7.4.2@ac1ec1cd9b5624694c3a40be801d94137afb12b4',
  'guzzlehttp/promises' => '1.5.1@fe752aedc9fd8fcca3fe7ad05d419d32998a06da',
  'guzzlehttp/psr7' => '2.2.1@c94a94f120803a18554c1805ef2e539f8285f9a2',
  'hamcrest/hamcrest-php' => 'v2.0.1@8c3d0a3f6af734494ad8f6fbbee0ba92422859f3',
  'intervention/image' => '2.7.1@744ebba495319501b873a4e48787759c72e3fb8c',
  'laminas/laminas-diactoros' => '2.9.2@07475df6b4bf6277ae8b9cbbc94d0ac6fee5e726',
  'laramin/utility' => 'dev-main@b81fb0bec0b3f77850ec75272292127a84981de0',
  'laravel/framework' => 'v9.10.1@93414b1c7c0a56081d96c060bb850ac192d3d323',
  'laravel/sanctum' => 'v2.15.1@31fbe6f85aee080c4dc2f9b03dc6dd5d0ee72473',
  'laravel/serializable-closure' => 'v1.1.1@9e4b005daa20b0c161f3845040046dc9ddc1d74e',
  'laravel/tinker' => 'v2.7.2@dff39b661e827dae6e092412f976658df82dbac5',
  'laravel/ui' => 'v3.4.5@f11d295de1508c5bb56206a620b00b6616de414c',
  'lcobucci/clock' => '2.2.0@fb533e093fd61321bfcbac08b131ce805fe183d3',
  'lcobucci/jwt' => '4.0.4@55564265fddf810504110bd68ca311932324b0e9',
  'league/commonmark' => '2.3.0@32a49eb2b38fe5e5c417ab748a45d0beaab97955',
  'league/config' => 'v1.1.1@a9d39eeeb6cc49d10a6e6c36f22c4c1f4a767f3e',
  'league/flysystem' => '3.0.18@c8e137e594948240b03372e012344b07c61b9193',
  'league/mime-type-detection' => '1.11.0@ff6248ea87a9f116e78edd6002e39e5128a0d4dd',
  'mailjet/mailjet-apiv3-php' => 'v1.5.5@c1c1931c76ebd1adb5cf2a76f60ddcaa61849aa2',
  'messagebird/php-rest-api' => 'v1.20.0@f7c7ae490b0b2d9d228bac61b5d855c4623f7fad',
  'mockery/mockery' => '1.5.0@c10a5f6e06fc2470ab1822fa13fa2a7380f8fbac',
  'mollie/laravel-mollie' => 'v2.19.0@c3191518ec790ec689ab9d42928e6a3db18f686e',
  'mollie/mollie-api-php' => 'v2.42.1@1ced5854c98af5cffca09b1093156ebdac277285',
  'monolog/monolog' => '2.5.0@4192345e260f1d51b365536199744b987e160edc',
  'nesbot/carbon' => '2.57.0@4a54375c21eea4811dbd1149fe6b246517554e78',
  'nette/schema' => 'v1.2.2@9a39cef03a5b34c7de64f551538cbba05c2be5df',
  'nette/utils' => 'v3.2.7@0af4e3de4df9f1543534beab255ccf459e7a2c99',
  'nikic/php-parser' => 'v4.13.2@210577fe3cf7badcc5814d99455df46564f3c077',
  'phpmailer/phpmailer' => 'v6.6.0@e43bac82edc26ca04b36143a48bde1c051cfd5b1',
  'phpoption/phpoption' => '1.8.1@eab7a0df01fe2344d172bff4cd6dbd3f8b84ad15',
  'psr/container' => '1.1.2@513e0666f7216c7459170d56df27dfcefe1689ea',
  'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0',
  'psr/http-client' => '1.0.1@2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.4@d49695b909c3b7628b6289db5479a1c204601f11',
  'psr/simple-cache' => '3.0.0@764e0b3939f5ca87cb904f570ef9be2d78a07865',
  'psy/psysh' => 'v0.11.2@7f7da640d68b9c9fec819caae7c744a213df6514',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/collection' => '1.2.2@cccc74ee5e328031b15640b51056ee8d3bb66c0a',
  'ramsey/uuid' => '4.3.1@8505afd4fea63b81a85d3b7b53ac3cb8dc347c28',
  'razorpay/razorpay' => 'v2.8.2@f36ad5ec74522d2930ffad3b160dddc454e42f4d',
  'rmccue/requests' => 'v1.8.0@afbe4790e4def03581c4a0963a1e8aa01f6030f1',
  'sendgrid/php-http-client' => '3.14.4@6d589564522be290c7d7c18e51bcd8b03aeaf0b6',
  'sendgrid/sendgrid' => '7.11.5@1d2fd3b72687fe82264853a8888b014f8f99e81f',
  'starkbank/ecdsa' => '0.0.5@484bedac47bac4012dc73df91da221f0a66845cb',
  'stella-maris/clock' => '0.1.4@8a0a967896df4c63417385dc69328a0aec84d9cf',
  'stripe/stripe-php' => 'v7.125.0@822c00aa380c10c2a3c55d105c5da72ad577b7c4',
  'symfony/console' => 'v6.0.8@0d00aa289215353aa8746a31d101f8e60826285c',
  'symfony/css-selector' => 'v6.0.3@1955d595c12c111629cc814d3f2a2ff13580508a',
  'symfony/deprecation-contracts' => 'v3.0.1@26954b3d62a6c5fd0ea8a2a00c0353a14978d05c',
  'symfony/error-handler' => 'v6.0.8@5e2795163acbd13b3cd46835c9f8f6c5d0a3a280',
  'symfony/event-dispatcher' => 'v6.0.3@6472ea2dd415e925b90ca82be64b8bc6157f3934',
  'symfony/event-dispatcher-contracts' => 'v3.0.1@7bc61cc2db649b4637d331240c5346dcc7708051',
  'symfony/finder' => 'v6.0.8@af7edab28d17caecd1f40a9219fc646ae751c21f',
  'symfony/http-foundation' => 'v6.0.8@c9c86b02d7ef6f44f3154acc7de42831518afe7c',
  'symfony/http-kernel' => 'v6.0.8@7aaf1cdc9cc2ad47e926f624efcb679883a39ca7',
  'symfony/mailer' => 'v6.0.8@706af6b3e99ebcbc639c9c664f5579aaa869409b',
  'symfony/mime' => 'v6.0.8@c1701e88ad0ca49fc6ad6cdf360bc0e1209fb5e1',
  'symfony/polyfill-ctype' => 'v1.25.0@30885182c981ab175d4d034db0f6f469898070ab',
  'symfony/polyfill-intl-grapheme' => 'v1.25.0@81b86b50cf841a64252b439e738e97f4a34e2783',
  'symfony/polyfill-intl-idn' => 'v1.25.0@749045c69efb97c70d25d7463abba812e91f3a44',
  'symfony/polyfill-intl-normalizer' => 'v1.25.0@8590a5f561694770bdcd3f9b5c69dde6945028e8',
  'symfony/polyfill-mbstring' => 'v1.25.0@0abb51d2f102e00a4eefcf46ba7fec406d245825',
  'symfony/polyfill-php72' => 'v1.25.0@9a142215a36a3888e30d0a9eeea9766764e96976',
  'symfony/polyfill-php80' => 'v1.25.0@4407588e0d3f1f52efb65fbe92babe41f37fe50c',
  'symfony/polyfill-php81' => 'v1.25.0@5de4ba2d41b15f9bd0e19b2ab9674135813ec98f',
  'symfony/process' => 'v6.0.8@d074154ea8b1443a96391f6e39f9e547b2dd01b9',
  'symfony/routing' => 'v6.0.8@74c40c9fc334acc601a32fcf4274e74fb3bac11e',
  'symfony/service-contracts' => 'v2.5.1@24d9dc654b83e91aa59f9d167b131bc3b5bea24c',
  'symfony/string' => 'v6.0.8@ac0aa5c2282e0de624c175b68d13f2c8f2e2649d',
  'symfony/translation' => 'v6.0.8@3d38cf8f8834148c4457681d539bc204de701501',
  'symfony/translation-contracts' => 'v3.0.1@c4183fc3ef0f0510893cbeedc7718fb5cafc9ac9',
  'symfony/var-dumper' => 'v6.0.8@fa61dfb4bd3068df2492013dc65f3190e9f550c0',
  'textmagic/sdk' => 'dev-master@b81cd04df7ab6fd21f0ddd75bf987cf3f65fe9c6',
  'tijsverkoyen/css-to-inline-styles' => '2.2.4@da444caae6aca7a19c0c140f68c6182e337d5b1c',
  'twilio/sdk' => '6.36.1@68aa5dd58450d3b449c83138567ecfca93955ed9',
  'vlucas/phpdotenv' => 'v5.4.1@264dce589e7ce37a7ba99cb901eed8249fbec92f',
  'voku/portable-ascii' => '2.0.1@b56450eed252f6801410d810c8e1727224ae0743',
  'vonage/client' => '2.4.0@29f23e317d658ec1c3e55cf778992353492741d7',
  'vonage/client-core' => '2.10.1@0e5c6bf4af22cae60a3f1098b75c25d70bac242f',
  'vonage/nexmo-bridge' => '0.1.1@36490dcc5915f12abeaa233c6098e0dce14bbb0a',
  'webmozart/assert' => '1.10.0@6964c76c7804814a842473e0c8fd15bab0f18e25',
  'laravel/laravel' => '1.0.0+no-version-set@',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!self::composer2ApiUsable()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (self::composer2ApiUsable()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }

    private static function composer2ApiUsable(): bool
    {
        if (!class_exists(InstalledVersions::class, false)) {
            return false;
        }

        if (method_exists(InstalledVersions::class, 'getAllRawData')) {
            $rawData = InstalledVersions::getAllRawData();
            if (count($rawData) === 1 && count($rawData[0]) === 0) {
                return false;
            }
        } else {
            $rawData = InstalledVersions::getRawData();
            if ($rawData === null || $rawData === []) {
                return false;
            }
        }

        return true;
    }
}