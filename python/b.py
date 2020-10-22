from os import listdir
from os.path import isfile, join

if __name__ == "__main__":
    directoryPath = '/var/www/html/data/log/roadview_log/'

    files = [f for f in listdir(directoryPath) if isfile(join(directoryPath, f))]

    for i in files:
        print(i)