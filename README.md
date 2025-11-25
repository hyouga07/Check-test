Docker ビルド
・git clone https://github.com/hyouga07/Check-test.git
・docker-compose up -d --build

Laravel 環境構築
・docker-compose exec php bash
・composer install
・cp .env.example .env、開発変数を適宜変更
・php artisan key:generate
・php artisan migrate
・php artisan db:seed

URL
・お問い合わせ画面: http://localhost/
・ユーザー登録: http://localhost/register
・phpMyAdmin: http://localhost:8080/

使用技術(実行環境)
・PHP 8.x
・Laravel 9.x
・Composer 2.x
・MySQL8.0.26
・Nginx1.21.1

ER 図
![ER図](ER.png)
※透過で見えないかもしれないので元の ER 作成元の.drawio.pug もファイルに入れています
Draw.io Extension for VSCode を VSCode 内にインストールして確認してください
