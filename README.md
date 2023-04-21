# teamdev-2023-posse1-team3B

# Note

ソースの取得
※コマンドを実行したフォルダにコードがダウンロードされます

```bash
git clone git@github.com:posse-ap/teamdev-2023-posse1-team3B.git
```
### tailwindを導入したい場合
```bash
<link rel="stylesheet" href=".~~{任意のパス}~~/vendor/tailwind/tailwind.css">
```
を読み込んでから使ってね

## コンテナ起動

```bash
cd teamdev-2023-posse1-team3B.git 
docker-compose build --no-cache 
docker-compose up -d 
```

## 各ページ遷移ポート番号

### トップページ

```bash
http://localhost/8080
```

### phpMyAdmin

```bash
http://localhost/8081
```

### mailhog
```bash
http://localhost/8025
```

## データ初期化

### db接続方法
1.
```bash
docker compose exec -it db /bin/bash
```
2.
```bash
mysql -u root -p
```
3.
```bash
root
```
### データを初期化してinit.sql起動する場合
```bash
mysql -u root -p < docker-entrypoint-initdb.d/init.sql　
```
が実行され初期データが投入されます

developから切る、ここで切ったら死にます
