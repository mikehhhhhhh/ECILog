#!/bin/bash

#check to see if modem is pingable, if not add rules to router.
if ping -c1 192.168.168.168 > /dev/null;
then
	echo "Can ping it!";
else
	echo "Can't ping it :( ";
	expect_sh=$(expect -c "
                spawn ssh admin@10.1.7.1
                expect \"password:\"
                send \"insertpasswordhere\r\"
		expect \"#\"
		send \"ifconfig eth0 192.168.168.1 netmask 255.255.255.0\r\"
		expect \"#\"
		send \"/usr/sbin/iptables -I POSTROUTING -t nat -o eth0 -d 192.168.168.0/24 -j MASQUERADE\r\"
		expect \"#\"
		send \"exit\r\"
	")

	echo "$expect_sh"
	sleep 20
fi;

cd /home/mike/www/ECILog/app/utilities/
/usr/bin/php /home/mike/www/ECILog/app/utilities/getStats.php
