FROM mysql:5.7

# Windowsのファイルシステムの問題により、マウント後に読み取り専用の権限へ変更する
# <https://qiita.com/koyo-miyamura/items/4d1430b9086c5d4a58a5>
ADD ./etc-mysql.cnf /etc/mysql/conf.d/etc-mysql.cnf

RUN apt-get update

RUN apt-get install -y tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    chmod 644 /etc/mysql/conf.d/etc-mysql.cnf
