CHARSET utf8mb4;

-- パスワードで認証できるように認証設定を変更
ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'root';
