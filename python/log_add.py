import os

def search_log_file(dir):
    print(os.walk(dir))


if __name__ == "__main__":
    search_log_file("/var/www/html/data/log/")