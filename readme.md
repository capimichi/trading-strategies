# Trading Strategies

## Snippets

### Take Profit / Stop Loss Formula

```
stopLossPercentage = input(2.0, title='Stop Loss %') / 100
takeProfitPercentage = input(4.0, title='Take Profit %') / 100
buyStopLossLevel = strategy.position_avg_price * (1 - stopLossPercentage)
buyTakeProfitLevel = strategy.position_avg_price * (1 + takeProfitPercentage)
sellStopLossLevel = strategy.position_avg_price * (1 + stopLossPercentage)
sellTakeProfitLevel = strategy.position_avg_price * (1 - takeProfitPercentage)
```

### Bollinger Bands Formula

```
length = input(20, minval=1)
src = input(close, title="Source")
mult = input(2.0, minval=0.001, maxval=50, title="StdDev")
basis = sma(src, length)
dev = mult * stdev(src, length)
upper = basis + dev
lower = basis - dev
offset = input(0, "Offset", type = input.integer, minval = -500, maxval = 500)
plot(basis, "Basis", color=#872323, offset = offset)
p1 = plot(upper, "Upper", color=color.teal, offset = offset)
p2 = plot(lower, "Lower", color=color.teal, offset = offset)
```

### Stop Loss Trailing

```
stopLossPercentage = input(2.0, title='Stop Loss %') / 100
longStopPrice = 0.0

longStopPrice := if (strategy.position_size > 0)
    stopValue = close * (1 - longTrailPerc)
    max(stopValue, longStopPrice[1])
else
    0

shortStopPrice = 0.0

shortStopPrice := if (strategy.position_size < 0)
    stopValue = close * (1 + shortTrailPerc)
    min(stopValue, shortStopPrice[1])
else
    999999
    
if (strategy.position_size > 0)
    strategy.exit(id="XL TRL STP", stop=longStopPrice)

if (strategy.position_size < 0)
    strategy.exit(id="XS TRL STP", stop=shortStopPrice)
```

## Full Study

### Support and resistance

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
