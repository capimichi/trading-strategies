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

if(strategy.position_size > 0)
    strategy.exit("close", "buy", stop = buyStopLossLevel, limit = buyTakeProfitLevel)
if(strategy.position_size < 0)
    strategy.exit("close", "sell", stop = sellStopLossLevel, limit = sellTakeProfitLevel)
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

## Full Strategy

### Kangaroo Tail

```
//Based on "How Naked Trading Works" video by Walter Peters: https://youtu.be/t-pD3fap25c?t=1m21s
//@version=4
study(title = "Naked Forex - Kangaroo Tail & Big Shadow Indicator", overlay = true)

roomToTheLeftPeriod = input(title="RoomToLeft Candles", defval=14, minval=2, maxval=30)
bodyRelativeSize= input(title="Body range", defval=3, minval=2, maxval=20000)


//  kangaroo tails
rangePrev1=high[1] - low[1]
rangePrev2=high[2] - low[2]
range=high - low
body=abs(close - open)
topthird = high - range/3.0
lowthird = low + range/3.0
withinPrevCandleRange = close >= low[1] and close <= high[1]

roomToTheHi  = rising(high, roomToTheLeftPeriod) 
roomToTheLo  = falling(low, roomToTheLeftPeriod)

// kangaroo tails
kangarootail1 =range > rangePrev1 and withinPrevCandleRange and  body*bodyRelativeSize <= range and close >= topthird and open >= topthird and low<low[1] and low<low[2] and low<low[3] and low<low[4] and low<low[5] and low<low[6] and low<low[7]
kangarootail2 =range > rangePrev1 and withinPrevCandleRange and body*bodyRelativeSize <= range and close < lowthird and open <= lowthird and high>high[1] and high>high[2] and high>high[3]and high>high[4]and high>high[5]and high>high[6]and high>high[7]
plotshape(kangarootail1, title= "Kangaroo tail",location=location.belowbar, color=color.green, style=shape.arrowup, text="Kangaroo tail")

plotshape(kangarootail2, title= "Kangaroo tail", color=color.red, style=shape.arrowdown, text="Kangaroo tail")
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
