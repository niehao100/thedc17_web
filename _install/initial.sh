PID=$(docker inspect --format "{{ .State.Pid }}" thedc17)
sudo nsenter --target $PID --mount --uts --ipc --net --pid
mysql -uthedc17 -p****** -e "drop database if exists thedc17;"
mysql -uthedc17 -p****** -e "create database thedc17;"
cd /var/www/html/_install/
mysql -uthedc17 -p****** -e "use thedc17;source thedc17.sql;"
exit
cd ~/mini/application/config/
grep -rl "root" *|xargs -i sed -i 's/root/thedc17/g' "{}"
grep -rl "toor" *|xargs -i sed -i 's/toor/******/g' "{}" 
cd ~/mini/public/js
#grep -rl "/thedc" *|xargs -i sed -i 's/thedc//g' "{}"
#把public/js/application.js 中的"/thedc"改为""
#还有header.php最下边的一行。。。。