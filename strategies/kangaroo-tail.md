# Kangaroo Tail Strategy

- Kangaroo Tail
- Take profit %
- Stop loss % (trail)

```
//Based on "How Naked Trading Works" video by Walter Peters: https://youtu.be/t-pD3fap25c?t=1m21s
//@version=4
strategy(title = "Naked Forex - Kangaroo Tail & Big Shadow Indicator", overlay = true)

smaSize = input(title="Sma Size", defval=20)
sma = sma(close, smaSize)

roomToTheLeftPeriod = input(title="RoomToLeft Candles", defval=14, minval=2, maxval=100)
bodyRelativeSize= input(title="Body range", defval=3, minval=2, maxval=20000)
//stopLossPercentage = input(2.0, title='Stop Loss %') / 100
takeProfitPercentage = input(4.0, title='Take Profit %') / 100

stopLossPercentage = input(2.0, title='Stop Loss %') / 100
longStopPrice = 0.0

longStopPrice := if (strategy.position_size > 0)
    stopValue = close * (1 - stopLossPercentage)
    max(stopValue, longStopPrice[1])
else
    0

shortStopPrice = 0.0

shortStopPrice := if (strategy.position_size < 0)
    stopValue = close * (1 + stopLossPercentage)
    min(stopValue, shortStopPrice[1])
else
    999999

buyStopLossLevel = strategy.position_avg_price * (1 - stopLossPercentage)
buyTakeProfitLevel = strategy.position_avg_price * (1 + takeProfitPercentage)
sellStopLossLevel = strategy.position_avg_price * (1 + stopLossPercentage)
sellTakeProfitLevel = strategy.position_avg_price * (1 - takeProfitPercentage)

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
//plotshape(kangarootail1, title= "Kangaroo tail",location=location.belowbar, color=color.green, style=shape.arrowup, text="Kangaroo tail")
//plotshape(kangarootail2, title= "Kangaroo tail", color=color.red, style=shape.arrowdown, text="Kangaroo tail")
plot(sma)

if(kangarootail1 and (close > sma))
    strategy.entry("buy", strategy.long)

if(kangarootail2 and (close < sma))
    strategy.entry("sell", strategy.short)

if(strategy.position_size > 0)
    strategy.exit("stop", "buy", stop = longStopPrice, limit = buyTakeProfitLevel)

if(strategy.position_size < 0)
    strategy.exit("stop", "sell", stop = shortStopPrice, limit = sellTakeProfitLevel)
```
