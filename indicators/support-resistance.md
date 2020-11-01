# Support and resistance

```
//@version=4
study(title="Camarilla Pivots - example", overlay=true)

// Input
range = input(title="Shaded area size (in ticks)", defval=10) * syminfo.mintick

// Get daily data
dayClose = security(syminfo.tickerid, "D", close[1])
dayHigh = security(syminfo.tickerid, "D", high[1])
dayLow = security(syminfo.tickerid, "D", low[1])

// Calculate pivots
r4 = dayClose + (dayHigh - dayLow) * 1.1 / 2
r3 = dayClose + (dayHigh - dayLow) * 1.1 / 4
r2 = dayClose + (dayHigh - dayLow) * 1.1 / 6
r1 = dayClose + (dayHigh - dayLow) * 1.1 / 12
s1 = dayClose - (dayHigh - dayLow) * 1.1 / 12
s2 = dayClose - (dayHigh - dayLow) * 1.1 / 6
s3 = dayClose - (dayHigh - dayLow) * 1.1 / 4
s4 = dayClose - (dayHigh - dayLow) * 1.1 / 2

// Plot Camarilla pivot points
plot(series=r2, color=color.gray, style=plot.style_circles)
plot(series=r1, color=color.gray, style=plot.style_circles)
plot(series=s1, color=color.gray, style=plot.style_circles)
plot(series=s2, color=color.gray, style=plot.style_circles)


// Shade the R4, R3, S3, and S4 levels
fill(plot1=plot(series=r4 + range, color=color.green), plot2=plot(series=r4 - range, color=color.green), color=color.green, transp=90)

fill(plot1=plot(series=r3 + range, color=color.red), plot2=plot(series=r3 - range, color=color.red), color=color.red, transp=90)

fill(plot1=plot(series=s3 + range, color=color.green), plot2=plot(series=s3 - range, color=color.green), color=color.green, transp=90)

fill(plot1=plot(series=s4 + range, color=color.red), plot2=plot(series=s4 - range, color=color.red), color=color.red, transp=90)
```
