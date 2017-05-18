import numpy as np
import cv2
import sys
import time

class circle:
	radius=0.0
	center = None
	prev_center = None
	updated = 0

class datasheet:
  	date_time = time.ctime()
  	Bus_route = "XYZ"
  	Location = "XYZ"
  	no_of_person_going_in = 0
  	no_of_person_coming_out = 0
  	no_of_person_in = 0

def Distance(a,b):
	c = (a[0]-b[0])**2 + (a[1]-b[1])**2
	return c**0.5 

frame_count=0
if(len(sys.argv)>1): cap = cv2.VideoCapture(sys.argv[1])
else: cap = cv2.VideoCapture(0)
fgbg = cv2.BackgroundSubtractorMOG(200,5,0.6,0)
distance =0
#prev_distance=0
# pts = []
incount=0
outcount=0
#prev_center = None

circles=[]
data = datasheet() #data = []
#perv_location = '' 
ret, firstFrame = cap.read()
grayFirst = cv2.cvtColor(firstFrame, cv2.COLOR_BGR2GRAY)
while(1):
	# if(frame_count==302):continue
	ret, frame = cap.read()
	frame_count=frame_count+1
	if(frame is None): break
	#print len(frame[0])
	#frame = frame[100:400,0:720]
	framecopy = frame.copy()
	gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
	#fgmask = fgbg.apply(frame.copy())#,learningRate=0.001)
	frameDelta = cv2.absdiff(grayFirst, gray)
	fgmask = cv2.threshold(frameDelta, 25, 255, cv2.THRESH_BINARY)[1]
	#fgbg.nmixtures= 3
	#fgbg.detectShadows = 1 
	kernel = np.ones((5,5),np.uint8)
	fgmask = cv2.erode(fgmask,kernel,iterations= 3)
	#fgmask = cv2.dilate(fgmask,kernel,iterations= 2)
	#fgmask = cv2.morphologyEx(fgmask, cv2.MORPH_OPEN, None)
	fgmask = cv2.GaussianBlur(fgmask,(5,5),0)
	#fgmask = cv2.dilate(fgmask,np.ones((5,5),np.uint8),iterations= 2)
	cnts = cv2.findContours(fgmask.copy(), cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_SIMPLE)[-2]
	center = None
	# cv2.line(frame, (0,160), (640,160), (0, 0, 255), 4)
	cv2.line(frame, (0,100), (320,100), (0, 0, 255), 2)
	# if(frame_count>795 and frame_count<805):
	# for i in range(5000): 
	# 	print i
	for c in cnts:
	# cv2.line(frame, (0,320), (640,320), (0, 0, 255), 4)
		((x, y), radius) = cv2.minEnclosingCircle(c)
		M = cv2.moments(c)
		if(M["m00"]!=0):center = (int(M["m10"] / M["m00"]), int(M["m01"] / M["m00"]))
		else: center=(0,0)
		flag=True
		if(radius > 10 ):#and cv2.contourArea(c)>2750):
			if(len(circles)==0 ):
					# print cv2.contourArea(c)
					cir = circle()
					cir.radius = radius
					cir.center = center
					cir.prev_center = center
					cir.updated = 1
					circles.append(cir)

			else:	
				for i in range (len(circles)-1,-1,-1):
					
					# if(Distance(circles[i].center,center)==0): print center
					if ((Distance(circles[i].center,center)<20) and (circles[i].updated)!=2):  #circles[i].radius
						circles[i].center = center
						if(radius<120):circles[i].radius = radius
						else: circles[i].radius = 120
						circles[i].updated = 2
						flag=False
						break

							
				if (flag):
					cir = circle()
					cir.radius = radius
					cir.center = center
					cir.prev_center = center
					cir.updated = 1
					circles.append(cir) 
	

	for i in range(len(circles)-1,-1,-1):
		
		if(circles[i].updated):
			
			cv2.circle(frame, circles[i].center, int(circles[i].radius),
				(0, 255, 255), 2)
			cv2.circle(frame, circles[i].center, 5, (0, 0, 255), -1)
		
			#if(circles[i].prev_center is None):
				#circles[i].prev_center = circles[i].center
			if (frame_count ):#> 500 ):#and frame_count<500):
				for j in range(1,1000000):
					x =1
			 	#print str(i)+str(circles[i].center) + str(circles[i].prev_center)+str(circles[i].radius)+"  "+str(outcount) + "   "+str(incount)

			cv2.circle(frame, circles[i].prev_center, 5, (0, 255, 0), -1)
			distance = circles[i].center[1]-60

			
			if(distance>0 and (circles[i].prev_center[1]-60)<0):
				outcount=outcount+1
				data.date_time = time.ctime()
				data.no_of_person_coming_out = data.no_of_person_coming_out +1
				data.no_of_person_in = incount - outcount
				print "outcount incremented for i: " + str(i) +" in frame: " + str(frame_count) + " at center: " + str(center)
				print outcount
				circles[i].prev_center = circles[i].center 
		    	
		    	
			elif(distance<0 and (circles[i].prev_center[1]-60)>0):
				incount=incount+1
				data.date_time = time.ctime()
				data.no_of_person_going_in = data.no_of_person_going_in +1
				data.no_of_person_in = incount - outcount
				print "incount incremented for i: " + str(i) +" in frame: " + str(frame_count) + " at center: " + str(center)
				print incount
				circles[i].prev_center = circles[i].center
			circles[i].updated = 0
		else: del circles[i]
	#return frame, incount , outcount	

	# circles = list(circles)
	
	# cv2.line(frame, (320,0), (320,480), (0, 255, 0), 2)
	# cv2.line(frame, (0,260), (640,260), (0, 0, 255), 4)
	# cv2.line(frame, (0,320), (640,320), (0, 0, 255), 2)
	    # if(distance<-1 and prev_distance>1):
	    	# cv2.line(frame, (0,260), (640,260), (0, 255, 0), 4)
	    # if(distance>1 and prev_distance<-1):
	    # if(distance==0):
	    	# cv2.line(frame, (0,260), (640,260), (0, 255, 0), 4)

	# if(len(circles)>0):print len(circles)
	# cv2.putText(frame,'Incount: '+str(incount), (15,80), cv2.FONT_HERSHEY_COMPLEX_SMALL, 1, 255)
	# cv2.putText(frame,'Outcount: '+str(outcount), (15,160), cv2.FONT_HERSHEY_COMPLEX_SMALL, 1, 255)
	
	cv2.imshow('fgmask',fgmask)
	cv2.imshow('frame',frame)
	cv2.imshow('gray',gray)
	k = cv2.waitKey(30) & 0xff
	if k == 27:
		break

cap.release()
cv2.destroyAllWindows()