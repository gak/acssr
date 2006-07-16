#!/usr/bin/python
import os
import glob
import time

os.chdir('/home/httpd/html/acssr.slowchop.com/graphs/')
files = glob.glob('*png');
c = 0
for file in files:
	age = time.time() - os.stat(file)[9]
	if age > 60:
		os.remove(file)
		c += 1



