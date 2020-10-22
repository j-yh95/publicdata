if __name__ == "__main__":
    f = open('/var/www/html/data/log/roadview_log/20201008total_gps.log', 'r')
    w = open('./20201008total_gps.log', 'w')
    f = f.readlines()
    temp = []
    for gps in f:
        gps = gps.replace('\n', '').split(',')
        if gps[0] == '1':
            temp.append(gps[0] + ',' + gps[1] + ',' + gps[2])

        elif gps[0] == '2':
            temp.append(gps[0] + ',' + gps[1] + ',' + gps[2])
        else:
            temp.append('1' + ',' + gps[0] + ',' + gps[1])


    idx = 0

    for i in temp:
        idx = idx + 1
        if idx != len(temp):
            i = i + '\n'
            w.write(i)
        else:
            w.write(i)