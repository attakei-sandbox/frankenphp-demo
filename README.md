# FrankenPHP with aqua

[aqua](https://aquaproj.github.io)環境下で、FrankenPHPを利用したPHP実行環境を整備するデモプロジェクト。

## 概要

FrankenPHPがWindow上でも動作するようになったみたいなので、クロスプラットフォームなPHP実行環境をお試しで構築しています。

うまいこと出来れば、そのまま実プロジェクトのベースとすることも可能かもしれません。

## 前提

aquaをインストールする必要があります。

## セットアップ

このコマンドを一通り実行すると、`task composer`を通じてComposerを使用可能になります。
また、`task server`実行後に `http://localhost/phpinfo.php` へアクセスすると、いつものphpinfoを確認できます。

```
aqua policy allow
aqua i
task setup
```

## ライセンス

MIT License.
