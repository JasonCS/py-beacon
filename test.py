#
# by Taka Wang
#

from proximity import *

scanner = Scanner(loops=1)
while True:
    for beacon in scanner.scan():
	print beacon
        
