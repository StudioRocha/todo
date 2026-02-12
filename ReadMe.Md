# Todo アプリ

## 画面一覧

| 画面名 | URL | 説明 |
|--------|-----|------|
| Todo 一覧 | `/` | Todo の一覧表示・追加・編集・削除・検索（キーワード・カテゴリ） |
| カテゴリ一覧 | `/categories` | カテゴリの一覧表示・追加・編集・削除 |

※ ヘッダーの「Todo」「カテゴリ一覧」から各画面へ遷移できます。

## データベーステーブル仕様

本アプリ（Todo アプリ）で使用するテーブルは **categories** と **todos** の2つです。

### categories テーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key | 説明 |
|---------|-----|------------|------------|----------|-------------|------|
| id | bigint | ● | | ● | | カテゴリID |
| name | varchar(10) | | ● | ● | | カテゴリ名（10文字以内・ユニーク） |
| created_at | timestamp | | | | | 作成日時 |
| updated_at | timestamp | | | | | 更新日時 |

### todos テーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key | 説明 |
|---------|-----|------------|------------|----------|-------------|------|
| id | bigint | ● | | ● | | Todo ID |
| category_id | bigint | | | ● | ● (categories.id) CASCADE | カテゴリID（カテゴリ削除時は紐づくTodoも削除） |
| content | varchar(255) | | | ● | | Todo 本文（255文字以内） |
| created_at | timestamp | | | | | 作成日時 |
| updated_at | timestamp | | | | | 更新日時 |

## ER 図

<img src="docs/ER.svg" width="800" alt="ER図">

ソース（編集用）: [docs/ER.dio]

<div style="border: 3px solid #333; background-color: #f5f5f5; padding: 15px; margin: 20px 0; border-radius: 5px;">
<h2 style="color: #333; font-weight: bold; margin-top: 0; border-bottom: 2px solid #333; padding-bottom: 10px;">🐳 Docker ビルド</h2>
</div>

1. `git@github.com:StudioRocha/ProTest_mock_case1.git`
2. `docker-compose up -d --build`

※補足: MySQL は OS によって起動しない場合があるため、各 PC に合わせて docker-compose.yml を編集してください。

<div style="border: 3px solid #333; background-color: #f5f5f5; padding: 15px; margin: 20px 0; border-radius: 5px;">
<h2 style="color: #333; font-weight: bold; margin-top: 0; border-bottom: 2px solid #333; padding-bottom: 10px;">🚀 Laravel 環境構築</h2>
</div>

1. コマンドライン上 PHPコンテ内に入る

```bash
 docker-compose exec php bash
```

2. PHP コンテナ上

```bash
 composer install
```

3. .env.example をcopyして.envにリネーム

4. .env に以下の環境変数を設定、又は追加
   <BR>


```text
# ===========================================
# データベース設定
# ===========================================
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

```

5. アプリケーションキーの作成
   <BR> PHP コンテナ上

```bash
php artisan key:generate
```

6. マイグレーションの実行
   <BR> PHP コンテナ上

```bash
php artisan migrate
```

7. 全キャッシュクリア（一括）任意
   <BR> PHP コンテナ上

```bash
php artisan optimize:clear

```

8. ブラウザで開発環境に接続

http://localhost/

もし接続時に UnexpectedValueException ページエラーが出た場合。<BR>
![Warning](https://img.shields.io/badge/Warning-Permission%20denied-red)

Windows WSL 環境で http://localhost/　接続時にファイル権限のエラーが出る場合があります。
"Permission denied"というエラーが発生した場合は、
このプロジェクトの root ディレクトリで下記のコマンドを実行してパーミッションを変更後に再接続。

```bash
sudo chmod -R 777 src/*
```

9. シーディングの実行(指定されたダミーデータの一括生成)

```bash
 php artisan db:seed
```

### 生成されるデータ

`php artisan db:seed` は **CategorySeeder** → **TodoSeeder** の順で実行されます。

#### カテゴリデータ

-   **テーブル**: `categories`
-   **データ数**: 4 件
-   **内容**:
    -   未分類
    -   仕事
    -   プライベート
    -   買い物
-   **補足**: `firstOrCreate` のため、同名カテゴリが既にあれば追加されません。

#### Todo データ

-   **テーブル**: `todos`
-   **データ数**: 7 件
-   **内容**（カテゴリ別）:
    -   **仕事**: メール返信、報告書作成
    -   **プライベート**: ジムに行く、本を読む
    -   **買い物**: 牛乳を買う、洗剤を買う
    -   **未分類**: その他タスク
-   **補足**: TodoSeeder は CategorySeeder の実行後に必要です。単体で `php artisan db:seed --class=TodoSeeder` を実行する場合は、事前に `CategorySeeder` を実行してください。


## 使用技術（実行環境）

-   PHP 8.1-fpm
-   Laravel 8.x
-   nginx 1.21.1
-   MySQL 8.0.26
-   phpMyAdmin（DB 管理用）


## URL

-   アプリ: http://localhost/
-   phpMyAdmin: http://localhost:8080/
