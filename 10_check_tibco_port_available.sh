IFS=$'\n'
port=$1

for i in `egrep "mptib|vtibas" ~/.bashrc | grep -v "#" | awk -F' ' '{print $2" "$3}' | sed 's/\"//g;s/=ssh / /g'`; do

        con=`echo ${i} | awk -F' ' '{print $2}'`
        Hostnama=`echo ${i} | awk -F' ' '{print $1}'`	
#echo ${i}
#echo $con
#echo $Hostnama

	#echo "=======$user@$ip========="
	#pid=`ssh -o connecttimeout=5 -q ${con} "sudo netstat -anp | grep ':$port ' | grep LISTEN | grep tcp | head -1" 2> /dev/null | awk -F' ' '{print $7}' | awk -F'/' '{print $1}'`
	pid=`ssh -o connecttimeout=5 -q ${con} "netstat -anp | grep ':$port ' | grep LISTEN | grep tcp | head -1" 2> /dev/null | awk -F' ' '{print $7}' | awk -F'/' '{print $1}'`
	#echo "PID="$pid
	if [ "$pid" != "" ]; then
		pname=`ssh -o connecttimeout=5 -q ${con} "ps -ef | grep -w '$pid' | grep -v grep" | awk -F' ' '{print $12}'`
		echo "$Hostnama|$con|$port|$pname"
	else
		echo "$Hostnama|$con|NA|NA"
	fi
done
