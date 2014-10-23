# -*- coding: utf-8 -*-
"""
Created on Thu Oct 23 07:21:28 2014

@author: Freddy
"""
import matplotlib.pyplot as plt
import numpy as np
import pylab


results_hidde = [0 for y in xrange(100)]
file="fileHidde.txt" 
file_object = open(file, "r")
body = file_object.read().split('\n')
file_object.close()


i = 0

for r in body:
  if r == "relevant":
    results_hidde[i] = "R"
  if r == "niet relevant":
    results_hidde[i] = "N"
  if r == "next":
    i = i - 1
  i = i + 1
  
results_hidde[0] = "R"

results_freddy = [0 for y in xrange(100)]
file="fileFreddy.txt" 
file_object = open(file, "r")
body = file_object.read().split('\n')
file_object.close()



i = 0

for r in body:
  if r == "relevant":
    results_freddy[i] = "R"
  if r == "niet relevant":
    results_freddy[i] = "N"
  if r == "next":
    i = i - 1
  i = i + 1

results_freddy[0] = "R"



X1 = 0
X2 = 0
Y1 = 0
Y2 = 0
i = 0
for i in range(0,50):
  if results_hidde[i]==results_freddy[i]:
    if results_hidde[i]=="R":
      X1 = X1 + 1
    if results_hidde[i]=="N":
      Y2 = Y2 + 1
  elif results_hidde[i] == "N":
    X2 = X2 + 1
  elif results_hidde[i] == "R":
    Y1 = Y1 + 1
  
      
      
print X1,X2
print Y1,Y2

agree = (X1 + Y2)/50.0 * 100.0
print "Kans",agree


kansX = (X1 + X2) * (X1+Y1) / 50.0
kansY = (Y1 + Y2) * (X2+Y2) / 50.0
kansTotaal = kansX + kansY
reken = 100 - kansTotaal
final = (agree - kansTotaal)/reken

print "kappa is:", final

p1Judge = (X1 + X2 + Y1)/.50
p2Judge = X1/.50
print "Precision considered one of the judges agree", p1Judge
print "Precision considered two of the judges agree", p2Judge
X1 = 0
X2 = 0
Y1 = 0
Y2 = 0
i = 0
for i in range(50,100):
  if results_hidde[i]==results_freddy[i]:
    if results_hidde[i]=="R":
      X1 = X1 + 1
    if results_hidde[i]=="N":
      Y2 = Y2 + 1
  elif results_hidde[i] == "N":
    X2 = X2 + 1
  elif results_hidde[i] == "R":
    Y1 = Y1 + 1
Y2 = Y2 + 1
print X1,X2
print Y1,Y2

agree = (X1 + Y2)/50.0 * 100.0
print "Kans",agree


kansX = (X1 + X2) * (X1+Y1) / 50.0
kansY = (Y1 + Y2) * (X2+Y2) / 50.0
kansTotaal = kansX + kansY
reken = 100 - kansTotaal
final = (agree - kansTotaal)/reken

print "kappa is:", final
p1Judge = (X1 + X2 + Y1)/.50
p2Judge = X1/.50
print "Precision considered one of the judges agree", p1Judge
print "Precision considered two of the judges agree", p2Judge

good = 0
precision_hidde = [0 for y in xrange(10)]
precision_freddy = [0 for y in xrange(10)]
#plot everything
for i in range(0,10):
  begin = i * 10
  end = begin + 10
  good = 0
  
  for j in range (begin,end):
    if results_hidde[j] == "R":
      good = good + 1.0
    number = j - begin
    precision = good/(number + 1)
   
    precision_hidde[j%10] = precision
    
  x = np.linspace(0,9, 10)
  y = precision_hidde
  good = 0
  #plt.close('all')
  for j in range (begin,end):
    if results_freddy[j] == "R":
      good = good + 1.0
    number = j - begin
    precision = good/(number + 1)
   
    precision_freddy[j%10] = precision
    
  x2 = np.linspace(0,9, 10)
  y2 = precision_freddy
  
  # Just a figure and one subplot
  f, ax = plt.subplots()
  #ax.get_xaxis().set_visible(False)
  #ax.get_yaxis().set_visible(False)
  ax.set_xlabel("Documents")
  ax.set_ylabel("Precision")
  ax.plot(x, y,'r--', x2, y2, 'bs')
  pylab.ylim([-0.1,1.1])
  ax.set_title('Plot' + str(i+1))
  plt.savefig('Plot'+ str(i+1) + '.png')