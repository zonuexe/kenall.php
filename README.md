# Kenall.php - ケンオール非公式APIクライアント

![Packagist Version](https://img.shields.io/packagist/v/zonuexe/kenall?style=flat-square)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/zonuexe/kenall?style=flat-square)
![Packagist License](https://img.shields.io/packagist/l/zonuexe/kenall?style=flat-square)

PHP向けの[ケンオール 📮 郵便番号・住所検索API](https://kenall.jp/)の非公式クライアントです。このパッケージは個人によって開発されており、[Open Collector, Inc.](https://opencollector.co.jp/)が提供するものではありません。

このパッケージは開発の初期段階であり、現状有姿・無保証として提供されます。通常の用途で利用するための基本的な機能は実装していますが、エラーハンドリングなどは未実装です。機能追加などのPull Requestを歓迎します。

このパッケージを利用して郵便番号検索するには[ケンオール ホーム](https://kenall.jp/home)からAPIキーを取得する必要があります。

## Install

[Composer](https://getcomposer.org/)を利用します。

```php
composer require zonuexe/kenall
```

このパッケージでは[php-http/discovery](https://github.com/php-http/discovery)を用いてインストール済みのPSR-HTTPパッケージを利用します。

使用時に以下のようなエラーが発生する場合はパッケージが不足しています。

```
PHP Fatal error:  Uncaught Http\Discovery\Exception\DiscoveryFailedException: Could not find resource using any discovery strategy. Find more information at http://docs.php-http.org/en/latest/discovery.html#common-errors
 - Puli Factory is not available
 - No valid candidate found using strategy "Http\Discovery\Strategy\CommonClassesStrategy". We tested the following candidates: Nyholm\Psr7\Factory\HttplugFactory, Http\Message\MessageFactory\GuzzleMessageFactory, Http\Message\MessageFactory\DiactorosMessageFactory, Http\Message\MessageFactory\SlimMessageFactory.
 - No valid candidate found using strategy "Http\Discovery\Strategy\CommonPsr17ClassesStrategy". We tested the following candidates: .
```

以下の仮想パッケージからそれぞれ好きな組み合わせをComposerでインストールしてください。

 * [`psr/http-factory-implementation`](https://packagist.org/providers/psr/http-factory-implementation)
 * [`psr/http-client-implementation`](https://packagist.org/providers/psr/http-client-implementation)

もしGuzzleを利用しているなら以下のようなコマンドで最新版にアップデートできるかもしれません。

```php
composer require guzzlehttp/guzzle guzzlehttp/psr7
```

## API

### `function find(string $postal_code): PostalCodeResponse`

難しいことを考えずに郵便番号検索したいひと向けの関数です。

関数を呼び出す前に環境変数 `'KENALL_AUTHORIZATION_TOKEN'` をセットする必要があります。また、内部的には後述する `create_client()` の結果をキャッシュしています。

引数の `string $postal_code` は文字列型で7桁の数字である必要があります。

### `function create_client(string $api_key): KenallClient`

APIクライアントのインスタンスを取得し、オブジェクト指向的に操作したい人向けの関数です。

内部では[php-http/discovery](https://github.com/php-http/discovery)を用いてPSR-18 Http Client および、PSR-17 Http Factory の実装クラスを探索して自動検出します。

### `class KenallClient`

ケンオールへのAPIリクエストを行なうクライアントクラスです。

 * `findPostalCode(string $postal_code): PostalCodeResponse`
   * ケンオールの `GET /postalcode/:郵便番号` APIに対応します
   * 引数の `string $postal_code` は文字列型で7桁の数字である必要があります。

### `class PostalCodeResponse`

ケンオールの `GET /postalcode/:郵便番号` APIから返される値に対応したオブジェクトです。

```
echo $response->version, PHP_EOL;
// => "2021-01-29"
```

このオブジェクトは `ArrayAccess` およびイテレータを実装しており、配列や `foreach` でのデータの取り出しに対応しています。これらの方法で `Area` を取得することができます。

### `class Area` (郵便区画レコード)

一般的な意味での「住所」に相当するクラスです。プロパティは[ケンオールのドキュメント](https://www.notion.so/API-47ab1a425d9e48aaad5b34b4f703c718)に準じています。

## 使用のためのヒント

### 初心者向け

[ケンオール](https://kenall.jp/home)から取得できるAPIキーを環境変数 `KENALL_AUTHORIZATION_TOKEN` としてセットしておいてください。

```php
setenv('KENALL_AUTHORIZATION_TOKEN', YOUR_API_KEY);

$postal_code = '1000001';
$area = zonuexe\Kenall\find('1000001')[0];
// => 東京都千代田区千代田
```

### 中級者向け


この方法で利用する場合、トークンは環境変数にセットする必要はありません。

```php
$client = zonuexe\Kenall\create_client(getenv('KENALL_AUTHORIZATION_TOKEN'));

$postal_code = '1000001';
foreach ($client->findPostalCode($postal_code) as $area) {
    printf("%s%s%s\n", $area->prefecture, $area->city, $area->town);
}
// => 東京都千代田区千代田
```

### 上級者向け

上記の方法をそのままコードに組み込んだ場合、ユニットテストなどでケンオールAPIにリクエストしてしまうリスクがあります。PSR-18対応のHTTPクライアントクラスを注入することでテスト時のHTTPクライアントを差し替えることができます。

```php
$http_client = new Your\Http\MockCloent()
$client = zonuexe\Kenall\create_client($api_key, $http_client);
```

あるいは[PHP-HTTP Discoveryのドキュメント](https://php-http.readthedocs.io/en/latest/discovery.html)を参考にMockClientをセットすることで実装コードに手を入れずにHTTPクライアントを避けることも可能です。

## Copyright

> Copyright 2021 USAMI Kenta
>
> Licensed under the Apache License, Version 2.0 (the "License");
> you may not use this file except in compliance with the License.
> You may obtain a copy of the License at
>
>     http://www.apache.org/licenses/LICENSE-2.0
>
> Unless required by applicable law or agreed to in writing, software
> distributed under the License is distributed on an "AS IS" BASIS,
> WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
> See the License for the specific language governing permissions and
> limitations under the License.
