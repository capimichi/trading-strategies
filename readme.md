# Trading Strategies

## Take Profit / Stop Loss

```
stopLossPercentage = input(2.0, title='Stop Loss %') / 100
takeProfitPercentage = input(4.0, title='Take Profit %') / 100
buyStopLossLevel = strategy.position_avg_price * (1 - stopLossPercentage)
buyTakeProfitLevel = strategy.position_avg_price * (1 + takeProfitPercentage)
sellStopLossLevel = strategy.position_avg_price * (1 + stopLossPercentage)
sellTakeProfitLevel = strategy.position_avg_price * (1 - takeProfitPercentage)
```

## Bollinger Bands

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
